@php
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Cache-Control: post-check=0, pre-check=0', false);
header('Pragma: no-cache');
@endphp
@extends('front.layouts.app')
@push('title', 'Ödeme Yap')
@section('content')
    <section class="py-3 bg-light">
        <div class="container">
            <div class="row">
                <div class="card shadow border-0 text-center">
                    <div class="card-body">
                        <span class="badge text-bg-warning p-1">
                            10 dakika içerisinde ödeme yapmadığınız takdirde siparişiniz iptal edilecektir.
                        </span>
                        <br>
                        <strong class="bg-warning text-white rounded-4 px-3 fs-2">Sipariş NO: {{ $order->order_id }}</strong>
                        <br>
                        Sayın {{ $order->name }}; ödeme yaparken açıklama kısmına <strong>
                            "{{ $order->order_id }}"</strong> sipariş noyu yazmayı unutmayınız!
                        <p>
                            Ödeme Yapılacak Tutar: <strong class="text-danger">{{ money($order->amount_paid) }}
                                <sup>₺</sup></strong>
                        </p>
                        <hr>
                        <h5>Ödeme Yöntemleri</h5>
                        <form class="form-inline-block" method="POST" action="{{ route('order.payment') }}">
                            @csrf
                            <input type="hidden" name="order_id" value="{{ $order->order_id }}">
                            <div class="d-flex justify-content-center">
                                @if (Cache::get('papara_active') == 1)
                                    <div class="p-1 d-grid">
                                        <button name="payment_method" value="papara" type="submit"
                                            class="btn btn-outline-light text-dark shadow-sm">
                                            <img width="64" class="img-fluid"
                                                src="https://cdn.papara.com/web/logo/papara.svg" alt="">
                                            ile Ödeme
                                        </button>
                                    </div>
                                @endif
                                @if (Cache::get('paytr_active') == 1)
                                    <div class="p-1 d-grid">
                                        <button type="submit" name="payment_method" value="paytr"
                                            class="btn btn-outline-light text-dark shadow-sm">
                                            <i class="bi bi-credit-card-2-back-fill"></i>
                                            Kredi Kartı İle Ödeme(PAYTR)
                                        </button>
                                    </div>
                                @endif
                                @if (Cache::get('paymax_active') == 1)
                                    <div class="p-1 d-grid">
                                        <button type="submit" name="payment_method" value="paymax"
                                            class="btn btn-outline-light text-dark shadow-sm">
                                            <i class="bi bi-credit-card-2-back-fill"></i>
                                            Kredi Kartı İle Ödeme(Paymax)
                                        </button>
                                    </div>
                                @endif
                                @if (Cache::get('havale_eft_active') == 1)
                                    <div class="p-1 d-grid">
                                        <button type="submit" name="payment_method" value="havale_eft"
                                            class="btn btn-outline-light text-dark shadow-sm">
                                            <i class="bi bi-bank"></i>
                                            Havale/Eft
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @if (Session::has('havale_eft'))
        @include('front.payment_methods.banks')
    @endif
    @if (Session::has('papara_account'))
        @include('front.payment_methods.papara')
    @endif
    @if (Session::has('paymax_iframe_url'))
        @include('front.payment_methods.paymax')
    @endif
    @if (Session::has('paytr_iframe_url'))
    @include('front.payment_methods.paytr')
@endif
@endsection
