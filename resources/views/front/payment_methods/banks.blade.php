  <!-- Havele/Eft Modal -->
  <div class="modal fade" id="eftModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header border-0">
                  <h5 class="modal-title" id="exampleModalLabel">Banka IBAN Bilgilerimiz</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                    <p>
                        {!! nl2br(Cache::get('havale_eft_info')) !!}
                    </p>
              </div>
          </div>
      </div>
  </div>
  @push('scripts')
  <script>
      var eft_modal = new bootstrap.Modal(document.getElementById('eftModal'));
      eft_modal.show()
  </script>
@endpush
