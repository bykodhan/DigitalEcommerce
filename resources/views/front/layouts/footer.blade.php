<footer id="footer" class="footer mt-auto py-3 bg-light" style="background: linear-gradient(45deg, rgba(86, 58, 250, 0.9) 0%, rgba(116, 15, 214, 0.9) 100%),background:url('{{asset('uploads/site/hero-bg.jpg')}}') center center no-repeat ">
    <div class="container">
        <div class="row text-center ">
            <div class="col-lg-12 d-flex justify-content-center flex-wrap gap-3 py-4">
                @foreach ($footer_links as $link)
                    <a href="{{ $link->url }}" @if($link->target == 1) target="_blank" @endif>{{ $link->title }}</a>
                @endforeach

            </div>
            <div class="col-lg-12 mb-3">
                <div class="social-links d-flex flex-wrap justify-content-center gap-1 pt-3 pt-md-0">
                    @if (Cache::get('wp'))
                        <a target="_blank" href="https://wa.me/90{{ Cache::get('wp') }}" class="social-link"><i
                                class="bi bi-whatsapp"></i></a>
                    @endif
                    @if (Cache::get('tg'))
                        <a target="_blank" href="{{ Cache::get('tg') }}" class="social-link"><i
                                class="bi bi-telegram"></i></a>
                    @endif
                    @if (Cache::get('tw'))
                        <a target="_blank" href="{{ Cache::get('tw') }}" class="twitter"><i
                                class="bi bi-twitter"></i></a>
                    @endif
                    @if (Cache::get('fb'))
                        <a target="_blank" href="{{ Cache::get('fb') }}" class="facebook"><i
                                class="bi bi-facebook"></i></a>
                    @endif
                    @if (Cache::get('ig'))
                        <a target="_blank" href="{{ Cache::get('ig') }}" class="instagram"><i
                                class="bi bi-instagram"></i></a>
                    @endif
                    @if (Cache::get('skype'))
                        <a target="_blank" href="{{ Cache::get('skype') }}" class="google-plus"><i
                                class="bi bi-skype"></i></a>
                    @endif
                    @if (Cache::get('in'))
                        <a target="_blank" href="{{ Cache::get('in') }}" class="linkedin"><i
                                class="bi bi-linkedin"></i></a>
                    @endif
                    @if (Cache::get('yt'))
                        <a target="_blank" href="{{ Cache::get('yt') }}" class="youtube"><i
                                class="bi bi-youtube"></i></a>
                    @endif
                    @if (Cache::get('pin'))
                        <a target="_blank" href="{{ Cache::get('pin') }}" class="pinterest"><i
                                class="bi bi-pinterest"></i></a>
                    @endif
                    @if (Cache::get('git'))
                        <a target="_blank" href="{{ Cache::get('git') }}" class="github"><i
                                class="bi bi-github"></i></a>
                    @endif

                </div>
            </div>
            <div class="col-lg-2 mx-auto">
                <img loading="lazy" class="img-fluid" src="{{asset('uploads/site/3d.webp')}}" alt="Güvenli Alışveriş">
            </div>
        </div>
    </div>
</footer>
