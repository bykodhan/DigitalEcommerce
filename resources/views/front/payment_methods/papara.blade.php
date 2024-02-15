<!-- Papara Modal -->
<div class="modal fade" id="paparaModal" tabindex="-1" aria-labelledby="paparaModalLAbel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <img width="64" class="img-fluid me-3" src="https://cdn.papara.com/web/logo/papara.svg">
                <h5 id="papara_modal_title" class="modal-title" id="paparaModalLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body ">
                <div class="d-flex flex-column align-items-center justify-content-center">
                    <div class="img-fluid mb-3" id="qrcode"></div>
                    <a href="" target="_blank" id="papara_link" class="btn btn-secondary mb-2">QR Kodu okumadıysa!
                        Ödeme
                        Sayfasına Git
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
    <script src="{{ asset('vendor/qrcode.min.js') }}"></script>
    <script>
        var papara_modal = new bootstrap.Modal(document.getElementById('paparaModal'));
        const qrcode = document.getElementById("qrcode");
        const qr = new QRCode(qrcode);
        document.querySelector('#papara_modal_title').innerHTML = "{{ Session::get('amount') }}" + ' ₺ Ödeme';
        const url =
            "https://www.papara.com/personal/qr?accountNumber={{ Session::get('papara_account') }}&amount={{ Session::get('amount') }}&description={{ Session::get('order_id') }}";
        qr.clear()
        qr.makeCode(url);
        document.querySelector('#papara_link').href = url;
        papara_modal.show()
    </script>
@endpush
