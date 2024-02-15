<section class="shadow-sm sticky-top bg-white" id="autohide">
    @if (Cache::get('flash_news_active') == 1)
        <div class="topbar-slider text-center bg-light py-1">
            <div>
                <a class="btn btn-outline-dark border-0 rounded-1"
                    @if (Cache::get('flash_news_link1')) href="{{ Cache::get('flash_news_link1') }}" @endif>
                    <i class="bi bi-bell"></i> {{ Cache::get('flash_news_title1') }}
                </a>
            </div>
            <div class="">
                <a class="btn btn-outline-dark border-0 rounded-1"
                    @if (Cache::get('flash_news_link2')) href="{{ Cache::get('flash_news_link2') }}" @endif>
                    <i class="bi bi-bell"></i> {{ Cache::get('flash_news_title2') }}
                </a>
            </div>
            <div class="">
                <a class="btn btn-outline-dark border-0 rounded-1"
                    @if (Cache::get('flash_news_link3')) href="{{ Cache::get('flash_news_link3') }}" @endif>
                    <i class="bi bi-bell"></i> {{ Cache::get('flash_news_title3') }}
                </a>
            </div>
        </div>
    @endif
    <div class="container-fluid py-2">
        <div class="row">
            <div class="d-flex justify-content-between align-items-center">
                <div class="p-1 me-auto">
                    <a href="{{ route('index') }}">
                        <img class="img-fluid" style="max-height: 30px" src="{{ asset(Cache::get('logo_img')) }}" alt="logo"
                            loading="lazy">
                    </a>
                </div>
                <div class="p-1 d-md-inline-block d-none mx-auto">
                    <form action="{{ route('product.search') }}">
                        <div class="input-group border rounded-3">
                            <span class="input-group-text bg-white border-0">
                                <i class="bi bi-search"></i>
                            </span>
                            <input name="search" id="autoComplete" size="36" class="form-control border-0"
                                type="search" dir="ltr" spellcheck=false autocorrect="off" autocomplete="off"
                                autocapitalize="off" maxlength="2048" tabindex="1" placeholder="Ürün ara ..">

                        </div>
                    </form>
                </div>
                <div class="p-1 d-flex align-items-center justify-content-between">
                    <a href="{{ route('page.detail',['slug'=>'iletisim']) }}" type="button" class="btn btn-light hvr-glow rounded-4 me-2">
                        <i class="bi bi-envelope-fill"></i>
                        <span class="d-md-inline-block d-none">İletişime Geç</span>

                    </a>
                    <a type="button" class="btn btn-primary  hvr-glow rounded-4 me-2" data-bs-toggle="modal"
                        data-bs-target="#orderCheckModal">
                        <i class="bi bi-bag-check"></i>
                        <span class="d-md-inline-block d-none">Sipariş Sorgula</span>
                        <span class="d-md-none d-inline-block">Sorgula</span>
                    </a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="nav-scroller mt-3">
                <nav class="nav d-flex justify-content-start">
                    @if ($products_count > 0)
                        <a class="me-4 link-dark d-flex align-items-center hvr-forward"
                            href="{{ route('products') }}">
                            <i class="bi bi-grid fs-4 me-2"></i>
                            <span>Tüm Ürünler ({{ $products_count }})</span>
                        </a>
                    @endif
                    @if ($categories->count() > 0)
                        @foreach ($categories as $category)
                            <a class="me-4 link-dark d-flex align-items-center hvr-forward" href="{{route('category',['slug'=>$category->slug])}}">
                                <img loading="lazy" width="32" height="32" class="rounded-circle me-2"
                                    src="{{ asset($category->img) }}" alt="{{ $category->title }}">
                                <span>{{ $category->title }} ({{ $category->products->count() }})</span>
                            </a>
                        @endforeach
                    @endif
                </nav>
            </div>
        </div>
    </div>
</section>
