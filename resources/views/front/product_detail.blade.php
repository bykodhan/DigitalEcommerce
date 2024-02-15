@php
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Cache-Control: post-check=0, pre-check=0', false);
header('Pragma: no-cache');
@endphp
@extends('front.layouts.app')
@push('title', $product->title)
@push('description', $product->description)
@push('og_image',asset($product->img))
@push('head')
    @if ($product_detail->slider)
        <!-- Link to the file hosted on your server, -->
        <link rel="stylesheet" href="{{ asset('vendor/splide.min.css') }}">
        <style>
            .my-slider-progress {
                background: #ccc;
            }

            .my-slider-progress-bar {
                background: rgb(162, 0, 255);
                height: 2px;
                transition: width 400ms ease;
                width: 0;
            }
        </style>
    @endif
@endpush
@section('content')
    <section class="py-3">
        <div class="container">
            <div class="page-header d-flex align-items-center justify-content-between flex-wrap">
                <h1 class="page-title mb-0">
                    {{ $product->title }}
                </h1>
                <div class="nav-scroller pt-lg-0 ">
                    <ol class="breadcrumb nav mb-0">
                        <li class="breadcrumb-item"><a href="/">Anasayfa</a></li>

                        <li class="breadcrumb-item"><a class="" href="{{ route('category',['slug'=>$product->category->slug]) }}">{{$product->category->title}}</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $product->title }}</li>
                    </ol>
                </div>
            </div>
            <div class="icon-bar d-none d-lg-block mt-5">
                <a title="Anasayfaya Git" href="/" class="bg-dark"><i class="bi bi-house"></i></a>
                <a target="_blank" title="E-Mail Gönder" href="mailto:?subject={{$product->title}}&body={{ URL::current() }}" class="bg-secondary"><i class="bi bi-envelope"></i></a>
                <a target="_blank" title="Telegramda Paylaş" href="https://t.me/share/url?url={{ URL::current() }}&text={{$product->title}}" class="telegram"><i class="bi bi-telegram"></i></a>
                <a target="_blank" title="Whatsappta Paylaş" href="https://api.whatsapp.com/send?text={{ URL::current() }}" class="whatsapp"><i class="bi bi-whatsapp"></i></a>
                <a target="_blank" title="Facebookta Paylaş" href="https://www.facebook.com/sharer.php?u={{ urlencode(URL::current()) }}" class="facebook"><i class="bi bi-facebook"></i></a>
                <a target="_blank" title="Twitterda Paylaş"  href="https://twitter.com/intent/tweet?url={{ URL::current() }}" class="twitter"><i class="bi bi-twitter"></i></a>
                <a target="_blank" title="Linkedin Paylaş"   href="https://www.linkedin.com/shareArticle?mini=true&url={{ URL::current() }}" class="linkedin"><i class="bi bi-linkedin"></i></a>
                <a target="_blank" title="Pintereste Kaydet" href="https://www.pinterest.com/pin/create/button/?url={{ URL::current() }}&media={{asset($product->img)}}&description={{urlencode($product->title)}}" class="pinterest"><i class="bi bi-pinterest"></i></a>
              </div>
        </div>
    </section>
    <section class="py-3 bg-light">
        <div class="container">
            <div class="row g-3">
                <div class="col-lg-7 mx-auto order-2 order-lg-1 mb-3">
                    <div class="card shadow-sm rounded-4 border-0">
                        @if ($product_detail->slider)
                            <div class="splide m-lg-3 ">
                                <div class="splide__track">
                                    <ul class="splide__list">
                                        <li class="splide__slide">
                                            <img class="img-fluid rounded" loading="lazy" src="{{ asset($product->img) }}"
                                                alt="{{ $product->title }}">
                                        </li>
                                        @foreach (explode(',', $product_detail->slider) as $slider)
                                            <li class="splide__slide">
                                                <img loading="lazy"class="img-fluid rounded" src="{{ asset($slider) }}"
                                                    alt="{{ $product->title }}">
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>

                                <!-- Add the progress bar element -->
                                <div class="my-slider-progress mt-1">
                                    <div class="my-slider-progress-bar"></div>
                                </div>
                            </div>
                        @else
                            <img class="mx-auto m-3 mb-3 img-fluid" loading="lazy" src="{{ asset($product->img) }}"
                                alt="{{ $product->title }}">
                        @endif
                        <div class="card-body d-flex flex-column mt-0 pt-0">
                            <div class="d-flex flex-row justify-content-around w-100 align-items-center d-lg-none d-block mb-3">
                                <strong class="mr-2">Paylaş :</strong>
                                <a target="_blank" title="Telegramda Paylaş" href="https://t.me/share/url?url={{ URL::current() }}&text={{$product->title}}" class="btn btn-sm btn-outline-light text-dark"><i class="bi bi-telegram"></i></a>
                                <a target="_blank" title="Whatsappta Paylaş" href="https://api.whatsapp.com/send?text={{ URL::current() }}" class="btn btn-sm btn-outline-light text-dark"><i class="bi bi-whatsapp"></i></a>
                                <a target="_blank" title="Facebookta Paylaş" href="https://www.facebook.com/sharer.php?u={{ URL::current() }}" class="btn btn-sm btn-outline-light text-dark"><i class="bi bi-facebook"></i></a>
                                <a target="_blank" title="Twitterda Paylaş"  href="https://twitter.com/intent/tweet?url={{ URL::current() }}" class="btn btn-sm btn-outline-light text-dark"><i class="bi bi-twitter"></i></a>
                                <a target="_blank" title="Linkedin Paylaş"   href="https://www.linkedin.com/shareArticle?mini=true&url={{ URL::current() }}" class="btn btn-sm btn-outline-light text-dark"><i class="bi bi-linkedin"></i></a>
                                <a target="_blank" title="Pintereste Kaydet" href="https://www.pinterest.com/pin/create/button/?url={{ URL::current() }}&media={{asset($product->img)}}&description={{urlencode($product->title)}}" class="btn btn-sm btn-outline-light text-dark"><i class="bi bi-pinterest"></i></a>
                            </div>
                            <div class="d-flex align-items-center flex-wrap ">
                                @if ($product->accept_features)
                                    @foreach (explode(',', $product->accept_features) as $value)
                                        <span class="me-3 mb-3">
                                            <i class="bi bi-check-circle-fill text-success"></i>
                                            {{ $value }}
                                        </span>
                                    @endforeach
                                @endif
                                @if ($product->unaccept_features)
                                    @foreach (explode(',', $product->unaccept_features) as $value)
                                        <span class="me-3 mb-3"><i class="bi bi-x-lg text-danger"></i>
                                            {{ $value }}</span>
                                    @endforeach
                                @endif
                            </div>

                            <nav>
                                <div class="nav nav-pills nav-justified rounded-4 mb-3" id="nav-tab" role="tablist">
                                    <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab"
                                        data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home"
                                        aria-selected="true">Ürün Açıklaması</button>
                                </div>
                            </nav>
                            <div class="tab-content" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="nav-home" role="tabpanel"
                                    aria-labelledby="nav-home-tab">
                                    {!! $product_detail->content !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 me-auto order-1 order-lg-2 mb-3">
                        <div class="card shadow-sm rounded-3 shadow-hover mb-3 border-0">
                            <div class="card-body ">
                                <div
                                    class="d-flex align-items-center justify-content-center mb-4 p-1 bg-light rounded-3  position-relative">
                                    @if ($product->discount)
                                        <small title="İndirim Oranı : {{ $product->discount }}"
                                            class="position-absolute  top-0 start-50  translate-middle badge border-0 rounded-pill bg-danger">
                                            %{{ $product->discount }} İndirim Mevcut. KAÇIRMA!
                                        </small>
                                    @endif
                                    @if ($product->discount)
                                        <small title="Eski Fiyatı : {{ $product->price }}"
                                            class="text-decoration-line-through text-secondary">
                                            {!! money($product->price) !!} <sup>₺</sup>
                                        </small>
                                        <h4 id="price_html" title="Fiyat : {{ $product->discount_price }}"
                                            class="p-2 mb-0 text-danger fw-bold">
                                            {!! money($product->discount_price) !!} <sup>₺</sup>
                                        </h4>
                                    @else
                                        <h4 id="price_html" title="Fiyat : {{ $product->price }}"
                                            class="p-2 mb-0 text-danger fw-bold">
                                            {!! money($product->price) !!} <sup>₺</sup>
                                        </h4>
                                    @endif

                                    @if ($product_detail->stock_type == 3)
                                        <span class="badge bg-secondary rounded-pill border-0 px-3" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="Kalan Stok : {{ $product->stocks->count() }}"
                                            style="position: absolute;left: 0%;bottom: -8px;">
                                            <i class="bi bi-box"></i>
                                            Kalan Stok : {{ $product->stocks->count() }}
                                        </span>
                                    @endif
                                    <span class="badge rounded bg-secondary rounded-pill border-0 px-3" data-bs-toggle="tooltip"
                                        data-bs-placement="top" title="{{ $product->lead_time }}"
                                        style="position: absolute;right: 0%;bottom: -8px;">
                                        <i class="bi bi-box2-heart"></i>
                                        {{ $product->lead_time }}
                                    </span>
                                </div>
                                <hr class="text-secondary">
                                <form class="form-inline" action="{{ route('order.step_1') }}" method="get">
                                    @honeypot
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    @if ($options->count() > 0)
                                        <div class="mb-3">
                                            <div class="list-group list-group-radio d-grid gap-2 border-0 w-auto">
                                                <div class="position-relative">
                                                    <input class="form-check-input position-absolute top-50 start-0 ms-3 fs-5"
                                                        type="radio" name="option_id" id="option_id" value="" checked
                                                        onchange="document.querySelector('#price_html').innerHTML = '@if($product->discount_price) {{ money($product->discount_price) }} @else {{ money($product->price) }} @endif <sup>₺</sup>';">
                                                    <label class="list-group-item py-3 ps-5 d-flex align-items-center"
                                                        for="option_id" style="max-width: fit-content;">
                                                        <strong class="fw-semibold me-auto">Sadece Ürün</strong>

                                                    </label>

                                                </div>
                                                @foreach ($options as $option)
                                                    <div class="position-relative">
                                                        <input
                                                            class="form-check-input position-absolute top-50 start-0 ms-3 fs-5"
                                                            type="radio" name="option_id"
                                                            id="option_id_{{ $option->id }}" value="{{ $option->id }}"
                                                            onchange="document.querySelector('#price_html').innerHTML = '{{ money($option->price) }} <sup>₺</sup>';">
                                                        <label class="list-group-item py-3 ps-5 d-flex align-items-center flex-wrap"
                                                            for="option_id_{{ $option->id }}" style="max-width: fit-content;">
                                                            <strong class="fw-semibold me-3">
                                                                {{ $option->title }}
                                                            </strong>
                                                            <span
                                                                class="badge bg-danger rounded-pill border-0">{{ money($option->price) }}
                                                                <sup>₺</sup>
                                                            </span>
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                    @if ($product_detail->customer_infos)
                                        @foreach (explode(',', $product_detail->customer_infos) as $field)
                                            <div class="form-floating mb-3">
                                                <input type="hidden" name="customer_fields[]" value="{{ $field }}">
                                                <input type="text" class="form-control " name="customer_answers[]"
                                                    placeholder="{{ $field }}" required>
                                                <label>{{ $field }}*</label>
                                            </div>
                                        @endforeach
                                    @endif

                                    <div class=" d-flex align-items-center mb-3 gap-1">
                                        @if ($product_detail->one_piece == 1)
                                            <div class="col-5">
                                                <!--
                                                <div class="input-group border rounded-3">
                                                    <button class="btn btn-white text-dark border-0" type="button"
                                                        onclick="let qty = document.querySelector('#input_qty'); if(parseInt(qty.value)>1) qty.value = parseInt(qty.value) - 1;">
                                                        <i class="bi bi-dash-lg"></i>
                                                    </button>
                                                    <input type="text" class="form-control text-center border-0"
                                                        placeholder="" aria-label="Example text with button addon"
                                                        aria-describedby="button-addon1" name="qty" value="1"
                                                        id="input_qty">
                                                    <button class="btn btn-white text-dark border-0" type="button"
                                                        id="button-addon1"
                                                        onclick="let qty = document.querySelector('#input_qty'); qty.value = parseInt(qty.value) + 1">
                                                        <i class="bi bi-plus-lg"></i>
                                                    </button>
                                                 </div>
                                                -->
                                            </div>
                                        @else
                                            <input type="hidden" name="qty" value="1">
                                        @endif
                                        <div class="col">
                                            @if ($product_detail->stock_type == 3 && $product->stocks->count() == 0)
                                                <div class="d-grid">
                                                    <button class="btn btn-danger btn-block" disabled>
                                                        Stokta Yok
                                                    </button>
                                                </div>
                                            @else
                                                <div class="d-grid">
                                                    <button type="submit" class="btn btn-danger border-0 rounded-1">
                                                        <i class="bi bi-cart3 float-start"></i>
                                                        <span>Satın Al</span>
                                                    </button>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </form>
                                @if ($product_detail->wp)
                                    <div class="d-grid px-4">
                                        <a href="https://wa.me/90{{ $product_detail->wp }}/?text={{ route('product.detail', ['id' => $product->id, 'slug' => $product->slug]) }}"
                                            class="btn btn-sm btn-success border-0"><i class="bi bi-whatsapp float-start"></i>
                                            Whatsapp
                                            ile satın al</a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @if ($product_detail->buttons)
                        <div class="card shadow-sm rounded-3 shadow-hover mb-3 border-0 ">
                            <div class="card-body">
                                <div class="row g-2">
                                    @foreach (json_decode($product_detail->buttons, true) as $button)
                                        <div class="col-lg-12">
                                            <div class="d-grid">
                                                <a @if ($button['target'] == 1) target="_blank" @endif
                                                    href="{{ $button['href'] }}"
                                                    class="btn btn-sm {!! $button['style'] !!}">
                                                    {{ $button['title'] }}
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    @if ($product_detail->slider)
        <script src="{{ asset('vendor/splide.min.js') }}"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var splide = new Splide('.splide');
                var bar = splide.root.querySelector('.my-slider-progress-bar');

                // Update the bar width:
                splide.on('mounted move', function() {
                    var end = splide.Components.Controller.getEnd() + 1;
                    bar.style.width = String(100 * (splide.index + 1) / end) + '%';
                });

                splide.mount();
            });
        </script>
    @endif
@endpush
