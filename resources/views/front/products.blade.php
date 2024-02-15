@extends('front.layouts.app')
@isset($category)
    @push('title', $category->title . ' - ' . $title)
    @push('description', $category->description)
@else
    @push('title', 'Ürünler' . ' - ' . $title)
    @push('description', 'Ürünler')
@endisset
@section('content')
    <section class="bg-light py-3">
        <div class="container">
            <div class="row mb-3">
                <div class="col-lg-12">
                    <div class="bg-white rounded-4 p-lg-3 p-1 shadow-sm">
                        <div class="d-flex align-items-center justify-content-between page-header p-1 m-0">
                            @isset($category)
                                <div class="d-flex flex-column">
                                    <div class="d-flex align-items-center ">
                                        <img class="rounded-circle me-2" width="40" src="{{ asset($category->img) }}"
                                            loading="lazy" alt="">
                                        <h1 class="page-title h3 mb-0">{{ $category->title }}</h1>
                                    </div>
                                    <small>
                                        {{ $title }}
                                    </small>
                                </div>
                            @else
                                <div class="d-flex flex-column">
                                    <h1 class="page-title h3 mb-0">Tüm Ürünler</h1>
                                    <small>
                                        {{ $title }}
                                    </small>
                                </div>
                            @endisset
                            <div class="form-floating">
                                <select class="form-select bg-light border-0"
                                    onchange="window.location.href = @isset($category) '/kategori/{{ $category->slug }}/' @else '/urunler/' @endisset + this.value ">
                                    <option value="en-son-eklenenler" @if (request()->sort == 'en-son-eklenenler') selected @endif>En
                                        son
                                        eklenenler</option>
                                    <option value="dusukten-yuksege" @if (request()->sort == 'dusukten-yuksege') selected @endif>Düşük
                                        fiyattan
                                        yükseğe</option>
                                    <option value="yuksekten-dusuge" @if (request()->sort == 'yuksekten-dusuge') selected @endif>
                                        Yüksek fiyattan
                                        düşüğe</option>
                                    <option value="indirim-orani" @if (request()->sort == 'indirim-orani') selected @endif>
                                        İndirim oranına göre
                                        </option>
                                </select>
                                <label for="floatingSelect">Sıralama</label>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            {{$products}}
            <div class="row g-3 row-products mb-3">
                @foreach ($products as $product)
                    <div class="col-lg-4 product-card">
                        @include('front.partials.product_card')
                    </div>
                @endforeach
            </div>
            @if ($products->nextPageUrl())
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
                    <a class="pagination__next" href="{{ $products->nextPageUrl() }}"></a>
                </div>
                <div class="row">
                    <div class="col-lg-6 mx-auto d-grid">
                        <button class="btn btn-secondary shadow-sm view-more-button">
                            <i class="bi bi-cloud-arrow-down-fill"></i>
                            Daha Fazla Ürün Göster
                        </button>
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection
@if ($products->nextPageUrl())
    @push('scripts')
        <script src="https://unpkg.com/infinite-scroll@4/dist/infinite-scroll.pkgd.min.js"></script>
        <script>
            let elem = document.querySelector('.row-products');

            let infScroll = new InfiniteScroll(elem, {
                // options
                path: '.pagination__next',
                append: '.product-card',
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
