@extends('front.layouts.app')
@push('title', 'İletişime Geç')
@section('content')
    <section id="contact" class="contact bg-light py-3">
        <div class="container">
            <div class="page-header">
                <h2 class="page-title">İletişim</h2>
            </div>
            <div class="row justify-content-center mb-3">
                <div class="col-lg-12">
                    <div class="info-wrap bg-white">
                        <div class="row">
                            <div class="col-lg-4 info"> <i class="bi bi-geo-alt"></i>
                                <h4>Adres:</h4>
                                <p>{{ Cache::get('contact_address') }}</p>
                            </div>
                            <div class="col-lg-4 info mt-4 mt-lg-0"> <i class="bi bi-envelope"></i>
                                <h4>Email:</h4>
                                <p><a target="_blank" href="mailto:{{ Cache::get('contact_email') }}">{{ Cache::get('contact_email') }}</a></p>
                            </div>
                            <div class="col-lg-4 info mt-4 mt-lg-0"> <i class="bi bi-phone"></i>
                                <h4>Ara:</h4>
                                <p><a target="_blank" href="tel:+90{{ Cache::get('contact_phone') }}">{{Cache::get('contact_phone') }}</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                @if ($errors->any())
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>

                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <div class="col-lg-12">
                    <form action="{{ route('contact.post') }}" method="post" role="form" class="php-email-form"
                        id="contact-form">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6 form-group"> <input type="text" name="name" class="form-control"
                                    id="name" placeholder="Adınız gerekli" required=""></div>
                            <div class="col-md-6 form-group"> <input type="email" class="form-control" name="email"
                                    id="email" placeholder="E-Mail Adresin" required=""></div>
                        </div>
                        <div class="form-group "> <input type="text" class="form-control" name="subject" id="subject"
                                placeholder="Konu" required=""></div>
                        <div class="form-group ">
                            <textarea class="form-control" name="message" rows="5" placeholder="Mesaj" required="" minlength="10"></textarea>
                        </div>
                        <div class="my-3">
                            <div class="loading">Loading</div>
                            <div class="error-message"></div>
                            <div class="sent-message">Your message has been sent. Thank you!</div>
                        </div>
                        <div class="text-center">
                            <button class="btn btn-primary" >
                                <i class="bi bi-envelope"></i>
                                Mesajımı Gönder
                            </button>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <section class="py-4" id="sss">
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
@endsection
