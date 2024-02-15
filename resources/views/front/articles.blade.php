@extends('front.layouts.app')
@push('title', 'Blog')
@section('content')
    <section class="py-4 bg-light blog">
        <div class="container">
            <div class="page-header">
                <h2 class="page-title h3 mb-0">
                    <i class="bi bi-newspaper"></i> Blog
                </h2>
            </div>
            <div class="row g-3 row-articles">
                @foreach ($articles as $article)
                    <div class="col-md-4 d-flex align-items-stretch article-card ">
                        <div class="card" style="background-image: url('{{ asset($article->img) }}'); background-size:cover;">
                            <div class="card-body">
                                <h5 class="card-title">
                                    <a
                                        href="{{ route('article.detail', ['id' => $article->id, 'slug' => $article->slug]) }}">
                                        {{ $article->title }}
                                    </a>
                                </h5>
                                <p class="card-text">
                                    {{ $article->description }}
                                </p>
                                <div class="read-more">
                                    <a href="{{ route('article.detail', ['id' => $article->id, 'slug' => $article->slug]) }}">
                                        <i class="bi bi-arrow-right"></i> Devamını Oku
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                @if ($articles->nextPageUrl())
                    <div class="row">
                        <!-- status elements -->
                        <div class="page-load-status">
                            <div class="loader-ellips infinite-scroll-request">
                                <span class="loader-ellips__dot"></span>
                                <span class="loader-ellips__dot"></span>
                                <span class="loader-ellips__dot"></span>
                                <span class="loader-ellips__dot"></span>
                            </div>
                            <p class="infinite-scroll-last">End of content</p>
                            <p class="infinite-scroll-error">No more pages to load</p>
                        </div>
                        <!-- hide pagination with infinite scroll enabled -->
                        <div class="pagination">
                            <a class="pagination__next" href="{{ $articles->nextPageUrl() }}"></a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 mx-auto d-grid ">
                            <button class="btn btn-secondary shadow-sm view-more-button">
                                <i class="bi bi-cloud-arrow-down-fill"></i>
                                Daha Fazla Ürün Göster
                            </button>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection
@if ($articles->nextPageUrl())
    @push('scripts')
        <script src="https://unpkg.com/infinite-scroll@4/dist/infinite-scroll.pkgd.min.js"></script>
        <script>
            let elem = document.querySelector('.row-articles');

            let infScroll = new InfiniteScroll(elem, {
                // options
                path: '.pagination__next',
                append: '.article-card',
                button: '.view-more-button',
                hideNav: '.pagination',
                scrollThreshold: false,
                status: '.page-status',
                // using button, disable loading on scroll
                history: false,
            });
        </script>
    @endpush
@endif
