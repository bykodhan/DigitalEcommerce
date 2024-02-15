<!-- Paymax Iframe Modal -->
<div class="modal fade" id="iframeModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="ratio ratio-1x1 h-100">
                <iframe id="payment_iframe" src="" allowfullscreen></iframe>
            </div>
        </div>
    </div>
</div>
@push('scripts')
    <script>
        var iframe_modal = new bootstrap.Modal(document.getElementById('iframeModal'));
        document.querySelector('#payment_iframe').src = "{{ Session::get('paytr_iframe_url') }}";
        iframe_modal.show();
    </script>
@endpush
