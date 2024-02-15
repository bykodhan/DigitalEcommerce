@extends('back.layouts.app')
@push('title', 'Yazılar')
@push('head')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/css/bootstrap.min.css">
@endpush
@section('content')
    <div class="row">
        <div class="col-lg-12 mb-3">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-header d-flex align-items-center justify-content-between bg-white">
                    <span><i class="fas fa-newspaper"></i> Yazılar</span>
                    <a href="{{ route('admin.blog.create') }}" class="btn btn-outline-secondary btn-sm"><i
                            class="fas fa-plus"></i> Yeni Yazı Oluştur</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="dataTable" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th scope="col">#ID</th>
                                    <th scope="col">Adı</th>
                                    <th scope="col">Açıklama</th>
                                    <th scope="col">URL</th>
                                    <th scope="col">İşlem</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($articles as $article)
                                    <tr>
                                        <td>{{ $article->id }}</td>
                                        <td>{{ $article->title }}</td>
                                        <td>{{ $article->description}}</td>
                                        <td>{{ URL('blog/'.$article->slug) }}</td>
                                        <td>
                                            <a target="_blank" href="" class="btn btn-outline-dark border-0 btn-sm"
                                                data-bs-toggle="tooltip" data-bs-placement="top" title="Yazıyı Gör">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.blog.edit', $article->id) }}"
                                                data-bs-toggle="tooltip" data-bs-placement="top" title="Yazıyı Düzenle"
                                                class="btn btn-outline-primary border-0 btn-sm"><i class="fas fa-edit"></i>
                                            </a>
                                            <a title="Sil" onclick="delete_form({{ $article->id }})"
                                                data-bs-toggle="tooltip" data-bs-placement="top" title="Yazıyı Sil"
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
                                    <th scope="col">Açıklama</th>
                                    <th scope="col">URL</th>
                                    <th scope="col">İşlem</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            {{ $articles->links() }}
        </div>
    </div>
    <form method="POST" action="{{ route('admin.blog.delete') }}" id="admin_blog_delete">
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
                title: 'Yazıyı silmek istediğinize emin misiniz? Bu işlem geri alınamaz!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Eminim Sil!',
                cancelButtonText: 'İptal'

            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('input_id').value = id
                    document.getElementById('admin_blog_delete').submit()
                }
            })
        }
    </script>
@endpush
