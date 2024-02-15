@extends('front.layouts.app')
@push('title', Cache::get('site_index_title'))
@push('description', Cache::get('site_index_description'))
@section('content')
    <section class="bg-light2 py-4">
        <div class="container">
            <div class="row  d-flex align-items-center">
                <div class="col-lg-7 text-center mb-3">
                    <h1 class="display-5 fw-bold mb-4">
                        {{ Cache::get('index_slogan') }}
                    </h1>
                    <p>
                        {{ Cache::get('index_slogan_description') }}
                    </p>
                </div>
                <div class="col-lg-5 d-md-block d-none ">
                    <img loading="lazy" class="img-fluid mx-auto p-1" src="{{ asset(Cache::get('slogan_img')) }}"
                        alt="{{ Cache::get('site_name') }}">
                </div>
            </div>
        </div>
    </section>
    <section class="" style="position: relative;margin-top: -45px;">
        <div class="container ">
            <div class="row ">
                <div class="card border-0 shadow-sm hvr-grow ">
                    <div class="card-body">
                        <div class="row g-2">
                            <div class="col-lg-3">
                                <div class="form-floating">
                                    <select class="form-select border-0" id="select_categories">
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->title }}</option>
                                        @endforeach
                                    </select>
                                    <label for="select_categories">Kategoriler</label>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-floating">
                                    <select class="form-select border-0" id="select_products">
                                        @foreach ($products as $item)
                                            <option value="{{ $item->id }}">{{ $item->title }}</option>
                                        @endforeach
                                    </select>
                                    <label for="select_products">Ürün</label>
                                </div>
                            </div>

                            <div class="col-lg-3 d-grid">
                                <button
                                    onclick="window.location.href = '/urun/'+document.querySelector('#select_products').value "
                                    class="btn btn-danger">
                                    <i class="bi bi-bag-plus"></i> Hızlı Satın Al
                                </button>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="bg-light py-5" style="margin-top: -45px;">
        <div class="container ">
            <div class="page-header">
                <h2 class="page-title h3 mb-0"><i class="bi bi-stars"></i>Sizin için seçtiklerimiz</h2>
            </div>
            <div class="row g-3 mb-3">
                @foreach ($products as $product)
                    <div class="col-lg-4 ">
                        @include('front.partials.product_card')
                    </div>
                @endforeach
            </div>
            <div class="row">
                <div class="col-lg-6 mx-auto d-grid ">
                    <a href="{{ route('products') }}" class="btn btn-secondary shadow-sm">
                        <i class="bi bi-arrow-right"></i>
                        Tüm Ürünleri Gör
                    </a>
                </div>
            </div>
        </div>
    </section>
    <section class="py-4">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <div class="working-process">
                        <span class="process-img">
                            <img src="{{ asset('uploads/site/order.png') }}" class="img-fluid" alt="Sipariş Ver"
                                width="80">
                            <span class="process-num">01</span>
                        </span>
                        <h4>Sipariş Ver</h4>
                        <p>Üyelik derdin olmadan kolay ve hızlı şekilde sipariş oluştur.</p>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="working-process">
                        <span class="process-img">
                            <img src="{{ asset('uploads/site/pencil.png') }}" class="img-fluid"
                                alt="Sipariş No'yu Kaydet" width="80">
                            <span class="process-num">02</span>
                        </span>
                        <h4>Sipariş No'yu Kaydet</h4>
                        <p>Sistem tarafından oluşturulan sipariş numaranı unutmayacak şekilde kaydet.</p>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="working-process">
                        <span class="process-img">
                            <img src="{{ asset('uploads/site/email.png') }}" class="img-fluid"
                                alt="Sipariş Mail Adresine Gelsin" width="80">
                            <span class="process-num">03</span>
                        </span>
                        <h4>Mail Adresine Gönderildi</h4>
                        <p>Sipariş No ile sipariş durumun hakkında bilgi alabilirsin.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-4">
        <div class="container">
            <div class="page-header">
                <h2 class="page-title h3 mb-0">
                    <i class="bi bi-patch-question-fill"></i>
                    Sıkça Sorulan Sorular
                </h2>
            </div>
            <div class="row g-3">
                <div class="col-lg-4">
                    <img loading="lazy" class="img-fluid rounded-4" src="{{ asset(Cache::get('faq_img')) }}"
                        alt="Sıkça Sorulan Sorular" width="256">
                </div>
                <div class="col-lg-8 mb-3">
                    <div class="accordion accordion-flush" id="accordionFlushExample">
                        @foreach ($faqs as $faq)
                            <div class="accordion-item border rounded-3">
                                <h2 class="accordion-header" id="flush-headingOne">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#flush-collapseOne_{{ $faq->id }}" aria-expanded="false"
                                        aria-controls="flush-collapseOne_{{ $faq->id }}">
                                        {{ $faq->title }}
                                    </button>
                                </h2>
                                <div id="flush-collapseOne_{{ $faq->id }}" class="accordion-collapse collapse"
                                    aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                    <div class="accordion-body">
                                        {!! $faq->content !!}
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="py-4 bg-light blog">
        <div class="container">
            <div class="page-header">
                <h2 class="page-title h3 mb-0">
                    <i class="bi bi-newspaper"></i> Son Yazılar
                </h2>
            </div>
            <div class="row g-3 mb-3">
                @foreach ($articles as $article)
                    <div class="col-md-4 d-flex align-items-stretch">
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
                                    <a
                                        href="{{ route('article.detail', ['id' => $article->id, 'slug' => $article->slug]) }}">
                                        <i class="bi bi-arrow-right"></i> Devamını Oku
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="row">
                <div class="col-lg-6 mx-auto d-grid ">
                    <a href="{{ route('blog') }}" class="btn btn-secondary shadow-sm">
                        <i class="bi bi-newspaper"></i>
                        Tüm Blog Yazılarını Gör
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script> <!-- axios Silme -->

    <script>
        let select_categories = document.querySelector('#select_categories');
        let default_category = select_categories.value;
        axios.get('/ajax/categories/' + default_category)
            .then(function(response) {
                // handle success
                let data = response.data.products;
                document.querySelector('#select_products').innerHTML = '';
                for (x in data) {
                    let option = document.createElement("option");
                    option.value = data[x].id;
                    option.text = data[x].title;
                    document.querySelector('#select_products').appendChild(option);
                }
            })
            .catch(function(error) {
                // handle error
                console.log(error);
            })
            .then(function() {
                // always executed
            });
        select_categories.addEventListener('change', function(e) {
            let value = e.target.value;
            axios.get('/ajax/categories/' + value)
                .then(function(response) {
                    // handle success
                    let data = response.data.products;
                    document.querySelector('#select_products').innerHTML = '';
                    for (x in data) {
                        let option = document.createElement("option");
                        option.value = data[x].id;
                        option.text = data[x].title;
                        document.querySelector('#select_products').appendChild(option);
                    }
                })
                .catch(function(error) {
                    // handle error
                    console.log(error);
                })
                .then(function() {
                    // always executed
                });
        });
    </script>
@endpush
