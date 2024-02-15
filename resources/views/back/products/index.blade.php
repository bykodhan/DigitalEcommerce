@extends('back.layouts.app')
@push('title', 'Ürünler')
@push('head')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/css/bootstrap.min.css">
@endpush
@section('content')
    <div class="row">
        <div class="col-lg-12 mb-3">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-header d-flex align-items-center justify-content-between bg-white">
                    <span><i class="fas fa-box"></i> Ürünler</span>
                    <a href="{{ route('admin.products.create') }}" class="btn btn-outline-secondary btn-sm"><i
                            class="fas fa-plus"></i> Yeni Ürün Ekle</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="dataTable" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th scope="col">#ID</th>
                                    <th scope="col">Adı</th>
                                    <th scope="col">Kategori Adı</th>
                                    <th scope="col">Fiyat</th>
                                    <th scope="col">İndirim</th>
                                    <th scope="col">İndirimliFiyat</th>
                                    <th scope="col">İşlem</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                    <tr>
                                        <td>{{ $product->id }}</td>
                                        <td>{{ $product->title }}</td>
                                        <td>{{ $product->category->title }}</td>
                                        <td>{{ money($product->price) }} ₺</td>
                                        <td>
                                            {{ $product->discount ? $product->discount : '-' }}
                                        </td>
                                        <td>
                                            {{ $product->discount_price ? $product->discount_price : '-' }}
                                        </td>
                                        <td>
                                            <a target="_blank" href="{{ route('product.detail', ['id' => $product->id]) }}"
                                                class="btn btn-outline-dark border-0 btn-sm" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="Ürünü Gör">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.products.edit', ['id' => $product->id]) }}"
                                                data-bs-toggle="tooltip" data-bs-placement="top" title="Ürünü Düzenle"
                                                class="btn btn-outline-primary border-0 btn-sm"><i class="fas fa-edit"></i>
                                            </a>
                                            <a title="Sil" onclick="delete_form({{ $product->id }})"
                                                data-bs-toggle="tooltip" data-bs-placement="top" title="Ürünü Sil"
                                                class="btn btn-outline-danger border-0 btn-sm">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th scope="col">#ID</th>
                                    <th scope="col">Adı</th>
                                    <th scope="col">Kategori Adı</th>
                                    <th scope="col">Fiyat</th>
                                    <th scope="col">İndirim</th>
                                    <th scope="col">İndirimliFiyat</th>
                                    <th scope="col">İşlem</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12 ">
            {{ $products->links() }}
        </div>
    </div>
    <form method="POST" action="{{ route('admin.products.delete') }}" id="admin_products_delete">
        @csrf
        <input type="hidden" id="input_id" value="" name="id">
    </form>
@endsection
@push('scripts')
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable({
                "pageLength": 100,
                "paging": false,
                "order": [],
                "scrollY": '80vh',
                "scrollCollapse": true,
                "scrollX": true,
                "language": {
                    "emptyTable": "Veri Bulunamadı",
                    "info": "Toplam _TOTAL_ Kayıttan _START_ - _END_ Arası",
                    "infoEmpty": "Kayıt Yok",
                    "infoFiltered": "(_MAX_ Kayıt İçerisinden Bulunan)",
                    "lengthMenu": "Sayfada _MENU_ Kayıt Gösteriliyor",
                    "paginate": {
                        "first": "İlk",
                        "last": "Son",
                        "next": "Sonraki",
                        "previous": "Önceki"
                    },
                    "search": "Bul:",
                    "zeroRecords": "Eşleşen Kayıt Bulunmadı"
                }
            });
        });
    </script>
    <script>
        function delete_form(id) {
            Swal.fire({
                title: 'Ürünü silmek istediğinize emin misiniz? Bu işlem geri alınamaz!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Eminim Sil!',
                cancelButtonText: 'İptal'

            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('input_id').value = id
                    document.getElementById('admin_products_delete').submit()
                }
            })
        }
    </script>
@endpush
