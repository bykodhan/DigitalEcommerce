@extends('back.layouts.app')
@push('title', 'Başlangıç')
@section('content')
    <div class="row g-3 mb-3">
        <div class="col-lg-3 col-12">
            <div class="card border-left-primary border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <p class="text-truncate font-size-14 mb-2">Toplam Kazanç</p>
                            <h4 class="mb-2">{{ money($total_amount_paid) }}₺</h4>
                        </div>
                        <div class="avatar-sm">
                            <span class="avatar-title bg-light text-primary rounded-3">
                                <i class="fa-solid fa-wallet fa-lg text-gray-600"></i>
                            </span>
                        </div>
                    </div>
                </div><!-- end cardbody -->
            </div><!-- end card -->
        </div>
        <div class="col-lg-3 col-12">
            <div class="card border-left-primary border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <p class="text-truncate font-size-14 mb-2">Tamamlanan Sipariş</p>
                            <h4 class="mb-2">{{ $ok_orders_count }}</h4>

                        </div>
                        <div class="avatar-sm">
                            <span class="avatar-title bg-light text-primary rounded-3">
                                <i class="fa-solid fa-check-double fa-lg text-success-600"></i>
                            </span>
                        </div>
                    </div>
                </div><!-- end cardbody -->
            </div><!-- end card -->
        </div>
        <div class="col-lg-3 col-12">
            <div class="card border-left-primary border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <p class="text-truncate font-size-14 mb-2">Stok Bekleyenler</p>
                            <h4 class="mb-2">{{ $pending_stock_count }}</h4>

                        </div>
                        <div class="avatar-sm">
                            <span class="avatar-title bg-light text-primary rounded-3">
                                <i class="fa-solid fa-arrows-rotate fa-lg text-info"></i>
                            </span>
                        </div>
                    </div>
                </div><!-- end cardbody -->
            </div><!-- end card -->
        </div>
        <div class="col-lg-3 col-12">
            <div class="card border-left-primary border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <p class="text-truncate font-size-14 mb-2">Ödeme Bekleyenler</p>
                            <h4 class="mb-2">{{ $pending_paid }}</h4>
                        </div>
                        <div class="avatar-sm">
                            <span class="avatar-title bg-light text-primary rounded-3">
                                <i class="fa-solid fa-credit-card fa-lg text-warning"></i>
                            </span>
                        </div>
                    </div>
                </div><!-- end cardbody -->
            </div><!-- end card -->
        </div>
    </div>

    <form method="POST" action="{{ route('admin.orders.cancel') }}" id="admin_orders_cancel">
        @csrf
        <input type="hidden" id="input_id_cancel" name="id" value="">
    </form>
    <form method="POST" action="{{ route('admin.orders.delete') }}" id="admin_orders_delete">
        @csrf
        <input type="hidden" id="input_id" name="id" value="">
    </form>
@endsection
@push('scripts')
    <script>
        function delete_form(id) {
            Swal.fire({
                title: 'Siparişi silmek istediğinize emin misiniz? Stok varsa stoklar tekrar ürüne yüklenir! Bu işlem geri alınamaz!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Eminim Sil!',
                cancelButtonText: 'İptal'

            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('input_id').value = id
                    document.getElementById('admin_orders_delete').submit()
                }
            })
        }

        function cancel_form(id) {
            Swal.fire({
                title: 'Siparişi iptal etmek istediğinize misiniz? Stok varsa stoklar tekrar ürüne yüklenir! Bu işlem geri alınamaz!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Eminim İptal Et!',
                cancelButtonText: 'Etme'

            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('input_id_cancel').value = id
                    document.getElementById('admin_orders_cancel').submit()
                }
            })
        }
    </script>
@endpush
