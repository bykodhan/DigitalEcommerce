@extends('front.layouts.app')
@push('title', 'Satın Al')
@section('content')
    <section class="py-4 bg-light">
        <div class="container">
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
            <form id="form" class="form-inline-block" method="POST" action="{{ route('order.step_2') }}">
                @csrf
                @honeypot
                <input hidden name="qty" value="{{ $request->qty ?? 1 }}">
                <input hidden value="{{ $product->id }}" name="product_id">
                <div class="row g-1">
                    <div class="col-lg-7">
                        <div class="card">
                            <div class="card-body">
                                <div class="row g-1">
                                    <div class="col-sm-6 mb-3">
                                        <label for="firstName" class="form-label">Adınız*</label>
                                        <input name="name" type="text" class="form-control" id="firstName"
                                            placeholder="Adınız.." value="{{ old('name') }}" required="">
                                    </div>

                                    <div class="col-sm-6 mb-3">
                                        <label for="lastName" class="form-label">Soyadınız*</label>
                                        <input name="surname" type="text" class="form-control" id="lastName"
                                            placeholder="Soyadınız.." value="{{ old('surname') }}" required="">
                                    </div>
                                    <div class="col-sm-6 mb-3">
                                        <label for="email" class="form-label">Email* </label>
                                        <input name="email" type="email" class="form-control" id="email"
                                            placeholder="Sipariş Sorgulama için gerekli!" required
                                            value="{{ old('email') }}">
                                        <small class="fw-bold text-danger">
                                            Sipariş Sorgulama için gerekli!
                                        </small>
                                    </div>

                                    <div class="col-sm-6 mb-3">
                                        <label for="phone" class="form-label">Cep Telefon*</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white">+90</span>
                                            <input name="phone" type="text" class="form-control" id="phone"
                                                placeholder="54xxxxxxxx" value="" required="" min="10"
                                                max="10" value="{{ old('phone') }}">
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label>varsa Satıcıya Notunuz</label>
                                        <textarea name="note" maxlength="255" class="form-control" rows="3"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="card mb-1">
                            <div class="card-body">
                                <h5 class="card-title text-center">Sipariş Özet</h5>
                                <hr>
                                <div class="d-flex justify-content-between">
                                    <strong>{{ $request->qty }} adet "{{ $product->title }}"</strong>
                                    @if ($option)
                                        <span>{{ $product->price }} ₺</span>
                                    @endif
                                </div>
                                @if ($option)
                                    <input hidden name="option_id" value="{{ $option->id }}">
                                    <div class="d-flex justify-content-between">
                                        <strong>{{ $option->title }}</strong>
                                        <span>{{ $option->price }} ₺</span>
                                    </div>
                                @endif
                                @if ($request->customer_answers)
                                    @foreach ($request->customer_answers as $key => $answer)
                                        <input type="hidden" name="customer_fields[]"
                                            value="{{ $request->customer_fields[$key] }}">
                                        <input type="hidden" name="customer_answers[]" value="{{ $answer }}">

                                        <div class="d-flex justify-content-between align-items-center">
                                            <span>{{ $request->customer_fields[$key] }} :</span>
                                            <span>{{ $answer }}</span>
                                        </div>
                                    @endforeach
                                @endif
                                <hr>
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0">Ödenecek Tutar :</h6>
                                    <h5 id="total_html" class="fw-bold text-danger mb-0">
                                        {!! money($total_price) !!} <sup>₺</sup>
                                    </h5>
                                </div>
                                <hr>
                                <div class="input-group input-group-sm p-1 border rounded-4 mb-3">
                                    <input type="text" id="coupon_code_input" class="form-control border-0"
                                        placeholder="varsa Kupon Kodunuz">
                                    <button onclick="submitCoupon()" class="btn btn-outline-primary ms-1 rounded"
                                        type="button">
                                        <i class="bi bi-gift-fill"></i> Uygula
                                    </button>
                                </div>
                                <div id="coupon_div" class="d-none">
                                    <div class="input-group border-0 input-group-sm mb-2">
                                        <span class="input-group-text border-0">Kullanılan Kupon:</span>
                                        <input type="text" id="coupon_code_input2"
                                            class="form-control border-0" readonly>
                                    </div>
                                    <input type="hidden" name="coupon_code" id="coupon_code_input3">
                                    <div class="px-2">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h6 class="mb-0">Kupon İndirimi :</h6>
                                            <h5 id="coupon_discount_html" class="fw-bold text-danger mb-0">
                                                <sup>₺</sup>
                                            </h5>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h6 class="mb-0">Toplam Tutar :</h6>
                                            <h5 id="total_price_html" class="fw-bold text-danger mb-0">
                                                <sup>₺</sup>
                                            </h5>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="col-lg-12">
                                    <small>
                                        Tüm bilgilerimin doğruluğunu ve
                                        <a class="text-secondary" href="{{route('page.detail',['slug'=>'sartlar-ve-kosullar'])}}" target="_blank"> Şartlar ve Koşullar
                                        </a>
                                        sayfasını onayladığımı kabul ediyorum.
                                    </small>
                                </div>
                                <div class="d-grid mb-3">
                                    <button type="submit" class="btn btn-danger">
                                        <i class="bi bi-bag-check"></i> Siparişi Onayla
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script> <!-- axios Silme -->

    <script>
        function submitCoupon() {
            axios.post('{{ route('coupon.check') }}', {
                    product_id: {{ $product->id }},
                    @if ($option)
                        option_id: '{{ $option->id }}',
                    @endif
                    coupon_code: document.getElementById('coupon_code_input').value,
                    qty: {{ $request->qty }},
                    _token: '{{ csrf_token() }}'
                })
                .then(function(response) {
                    console.log(response);
                    if (response.data.success == true) {
                        document.querySelector('#coupon_div').classList.remove('d-none');
                        document.querySelector('#coupon_code_input2').value = response.data.coupon_code;
                        document.querySelector('#coupon_code_input3').value = response.data.coupon_code;

                        document.querySelector('#coupon_discount_html').innerHTML = response.data.coupon_discount +
                            ' <sup>₺</sup>';
                        document.querySelector('#total_price_html').innerHTML = response.data.total_price +
                            '<sup>₺</sup>';

                    } else {
                        alert(response.data.error);
                    }
                })
                .catch(function(error) {
                    console.log(error);
                });

        }
    </script>
@endpush
