@extends('front.layouts.app')
@push('title', 'Sipariş Detayı')
@section('content')
    <section class="py-4 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h2 class="fw-bold mb-3">{{ $order->order_id }} no'lu sipariş detayı</h2>
                    <div class="table-responsive mb-5">
                        <table class="table table-hover table-bordered align-middle bg-white">
                            <thead>
                                <tr>
                                    <td>Tahmini Teslimat</td>
                                    <td>Stok Bilgiler</td>
                                    <td>Ürün Adı</td>
                                    <td>Adet</td>
                                    <td>Sipariş Durumu</td>
                                    <td>Fiyat</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{$order->lead_time}}</td>
                                    <td>
                                        @if ($order->order_status == 0)
                                            Onay Bekliyor
                                        @elseif($order->order_status == 1)
                                            Stok Bekleyenlerde
                                            @if ($order->stock_content)
                                                <form method="POST" action="{{ route('order.send.txt') }}">
                                                    @csrf
                                                    <input type="hidden" name="email" value="{{$order->email}}">
                                                    <input type="text" name="order_id" hidden
                                                        value="{{ $order->order_id }}">
                                                    <button type="submit" class="btn btn-primary">
                                                        .txt dosyası olarak indir
                                                    </button>
                                                </form>
                                            @else
                                                <span class="text-success">Stok Bilgisi yok</span>
                                            @endif
                                        @elseif($order->order_status == 2)
                                            <form method="POST" action="{{ route('order.send.txt') }}">
                                                @csrf
                                                <input type="hidden" name="email" value="{{$order->email}}">
                                                <input type="text" name="order_id" hidden
                                                    value="{{ $order->order_id }}">
                                                <button type="submit" class="btn btn-primary">
                                                    .txt dosyası olarak indir
                                                </button>
                                            </form>
                                        @elseif($order->order_status == 3)
                                            İptal Edildi
                                        @endif

                                    </td>
                                    <td>
                                        {{ $order->product_title }} : {{ money($order->product_price) }}
                                        @if ($order->option_name)
                                            <br>
                                            {{ $order->option_name . ':' }}

                                            {{ money($order->option_price) }}
                                            <sup>₺</sup>
                                        @endif
                                        @if ($order->customer_answers)
                                            <br>
                                            @foreach (json_decode($order->customer_answers) as $answer)
                                                {{ $answer->field . ':' . $answer->answer }}
                                                <br>
                                            @endforeach
                                        @endif
                                    </td>
                                    <td>
                                        {{ $order->qty }}
                                    </td>
                                    <td>
                                        @if ($order->order_status == 0)
                                            Onay Bekliyor
                                        @elseif($order->order_status == 1)
                                            Stok Bekleyenlerde
                                        @elseif($order->order_status == 2)
                                            Onaylandı
                                        @elseif($order->order_status == 3)
                                            İptal Edildi
                                        @endif
                                    </td>

                                    <td>
                                        {{ money($order->amount_paid) }} <sup>₺</sup>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
