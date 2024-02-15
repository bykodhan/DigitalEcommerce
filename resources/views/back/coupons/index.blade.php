@extends('back.layouts.app')
@push('title', 'Kuponlar')
@push('head')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/css/bootstrap.min.css">
@endpush
@section('content')
    <div class="row mb-3">
        <div class="col-lg-8 mb-3">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white">
                    <i class="fas fa-list"></i> Kuponlar
                </div>
                <div class="card-body m-1 p-1">
                    <div class="table-responsive">
                        <table id="datatable" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th scope="col">#ID</th>
                                    <th scope="col">Kod</th>
                                    <th scope="col">Kullanılan</th>
                                    <th scope="col">En Fazla</th>
                                    <th scope="col">Min Fiyat</th>
                                    <th scope="col">İndirim</th>
                                    <th scope="col">Sil</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($coupons as $coupon)
                                    <tr>
                                        <td>{{ $coupon->id }}</td>
                                        <td>{{ $coupon->code }}</td>
                                        <td>{{ $coupon->usage_count }}</td>
                                        <td>{{ $coupon->max_count }}</td>
                                        <td>{{ money($coupon->min_price) }} ₺</td>
                                        <td>{{ money($coupon->price) }} ₺</td>
                                        <td>
                                            <a title="Sil" onclick="delete_form({{ $coupon->id }})"
                                                data-bs-toggle="tooltip" data-bs-placement="top" title="Kupon Kodunu Sil"
                                                class="btn btn-outline-danger border-0 btn-sm">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white">
                    <i class="fas fa-plus"></i> Kupon Ekle
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.coupons.store') }}" method="POST">
                        @csrf
                        <label>Kupon Kodu*</label>
                        <div class="input-group mb-3">
                            <input required type="text" class="form-control" name="code" max="100">
                        </div>
                        <label>En Fazla Kullanma Sayısı*</label>
                        <div class="input-group mb-3">
                            <input class="form-control" type="number" name="max_count" value="1" min="1">
                        </div>
                        <label>İndirim*</label>
                        <div class="input-group mb-3">
                            <input class="form-control" type="number" name="price" value="1" min="1">
                            <span class="input-group-text bg-white">₺</span>
                        </div>
                        <label>Min Fiyat Limiti*</label>
                        <div class="input-group mb-3">
                            <input class="form-control" type="number" name="min_price" value="1" min="1">
                            <span class="input-group-text bg-white">₺</span>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-plus"></i>
                                Kupon Ekle
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.coupons.delete') }}" id="admin_coupons_delete">
        @csrf
        <input type="hidden" id="input_id" value="" name="id">
    </form>
@endsection
@push('scripts')
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#datatable').DataTable({
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Turkish.json"
                },
            });
        });
    </script>
    <script>
        function delete_form(id) {
            Swal.fire({
                title: 'Kuponu silmek istediğinize emin misiniz? Bu işlem geri alınamaz!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Eminim Sil!',
                cancelButtonText: 'İptal'

            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('input_id').value = id
                    document.getElementById('admin_coupons_delete').submit()
                }
            })
        }
    </script>
@endpush
