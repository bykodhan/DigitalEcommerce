<!doctype html>
<html class="h-100" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/webp" href="{{ asset(Cache::get('favicon_img')) }}">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="{{ Cache::get('site_index_description') }}" />
    <meta name="keywords" content="{{ Cache::get('site_keywords') }}" />
    <title>@stack('title') | {{ config('app.name') }}</title>
    <meta property="og:title" content="@stack('title') - {{ config('app.name') }}" />
    <meta property="og:description" content="@stack('description')" />
    <meta property="og:url" content="{{ Request::url() }}" />
    <meta property="og:site_name" content="{{ config('app.name') }}" />
    <meta property="og:image" content="@stack('og_image', asset(Cache::get('site_social_image')))" />

    <meta name="twitter:card" content="summary" />
    <meta name="twitter:description" content="@stack('description')" />
    <meta name="twitter:title" content="@stack('title') - {{ config('app.name') }}" />
    <meta name="twitter:image" content="@stack('og_image', asset(Cache::get('site_social_image')))" />

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('vendor/bs5/bootstrap.min.css') }}">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <!-- Styles -->
    <link href="{{ asset('front/style.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/hover-min.css') }}" rel="stylesheet">
    @if (Cache::get('flash_news_active') == 1)
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.4/tiny-slider.css">
    @endif
    @stack('head')
    {!! Cache::get('extra_header') !!}
</head>

<body class="d-flex flex-column h-100">
    <main class="flex-shrink-0">
        @include('front.layouts.topbar')
        @yield('content')
    </main>
    <div class="modal fade" id="orderCheckModal" tabindex="-1" role="dialog" aria-labelledby="orderCheckModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="orderCheckModalLabel">Sipariş Sorgula</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Siparişiniz hakkında bilgi edinmek için lütfen aşağıda bulunan alana
                        sipariş numaranızı ve sipariş verdiğiniz email adresinizi girin.</p>
                    <form action="{{ route('order.check') }}" method="POST">
                        @csrf
                        @honeypot
                        <div class="input-group border border-3 rounded-4 mb-2">
                            <input type="email" name="email" class="form-control border-0"
                            placeholder="E-posta adresiniz" required>
                        </div>
                        <div class="input-group border border-3 rounded-4 mb-2">
                            <input type="text" name="order_id" class="form-control border-0"
                                placeholder="Sipariş no" required>
                        </div>
                        <div class="d-grid">
                            <button class="btn btn-outline-dark  rounded-4" type="submit">
                                <i class="bi bi-search"></i> Sorgula
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    @include('front.layouts.footer')
    <!-- Order Check Modal -->

    <script src="{{ asset('vendor/bs5/bootstrap.bundle.min.js') }}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/tarekraafat-autocomplete.js/10.2.7/autoComplete.min.js"></script>

    <script src="{{ asset('vendor/sweetalert/sweetalert.min.js') }}"></script>
    {!! Cache::get('extra_javascript') !!}
    <script>
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    </script>
    @if (Session::has('success'))
        <script>
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: '{{ Session::get('success') }}',
                showConfirmButton: false,
                timer: 2000
            })
        </script>
    @endif
    @if (Session::has('error'))
        <script>
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'error',
                title: '{{ Session::get('error') }}',
                showConfirmButton: false,
                timer: 2000
            })
        </script>
    @endif

    <script>
        var prevScrollpos = window.pageYOffset;
        window.onscroll = function() {
            var currentScrollPos = window.pageYOffset;
            if (prevScrollpos > currentScrollPos) {
                document.getElementById("autohide").style.top = "0";
            } else {
                document.getElementById("autohide").style.top = "-150px";
            }
            prevScrollpos = currentScrollPos;
        }
    </script>
    <script>
        window.addEventListener('DOMContentLoaded', (event) => {
            const autoCompleteJS = new autoComplete({
                placeHolder: "Ürün ara ..",
                selector: "#autoComplete",
                trigger: false,
                data: {
                    src: async (query) => {
                        try {
                            // Fetch Data from external Source
                            const source = await fetch(`/ara?search=${query}`);
                            // Data is array of `Objects` | `Strings`
                            console.log(source);
                            const data = await source.json();
                            console.log(data);
                            return data;
                        } catch (error) {
                            console.log(error);
                            return error;
                        }
                    },
                    // Data 'Object' key to be searched
                    keys: ["title"],
                },
                resultsList: {
                    element: (list, data) => {
                        const info = document.createElement("div");
                        info.classList.add("m-1");
                        if (data.results.length) {
                            info.classList.remove("m-1");
                        } else {
                            info.innerHTML =
                                `<strong>"${data.query}"</strong> bulunamadı.`;
                        }
                        list.prepend(info);
                    },
                    noResults: true,
                    maxResults: 15,
                    tabSelect: true,
                },
                resultItem: {
                    highlight: true
                },
                events: {
                    input: {
                        selection: (event) => {
                            const selection = event.detail.selection.value;
                            console.log(selection.title);
                            window.location.href = "/urun/" + selection.id + "/" + selection.slug;
                        }
                    }
                }
            });
        });
    </script>
    @if (Cache::get('flash_news_active') == 1)
        <script src="https://cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.2/min/tiny-slider.js"></script>

        <script>
            var slider = tns({
                container: '.topbar-slider',
                items: 1,
                lazyload: true,
                autoplay: true,
                arrowKeys: false,
                nav: false,
                controls: false,
                autoplayButtonOutput: false,

            });
        </script>
    @endif
    @stack('scripts')
</body>

</html>
