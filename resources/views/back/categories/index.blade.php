@extends('back.layouts.app')
@push('title', 'Kategoriler')
@section('content')
    <div class="row mb-3">
        <div class="col-lg-7 mb-3">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white">
                    <i class="fas fa-list"></i> Kategoriler
                </div>
                <div class="card-body m-1 p-1">
                    @foreach ($categories as $category)
                        <div class=" p-1 rounded-3 mb-2 d-flex align-items-center">
                            <img width="40" src="{{ asset($category['img']) }}" class="img-fluid me-2">
                            #{{ $category['id'] }} <strong class="ms-1">{{ $category['title'] }}</strong>
                            <div class="ms-auto">
                                <button type="button" class="btn btn-sm btn-outline-primary border-0"
                                    data-bs-toggle="modal" data-bs-target="#edit_modal" data-bs-id="{{ $category['id'] }}"
                                    data-bs-title="{{ $category['title'] }}" data-bs-slug="{{ $category['slug'] }}"
                                    data-bs-description="{{ $category['description'] }}"
                                    data-bs-sortable="{{ $category['sortable'] }}"
                                    data-bs-img="{{ asset($category['img']) }}" >
                                    <i class="fas fa-edit" data-bs-toggle="tooltip" data-bs-placement="top" title="Kategoriyi Düzenle"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-danger border-0"
                                    onclick="delete_form({{ $category['id'] }})" data-bs-toggle="tooltip" data-bs-placement="top" title="Kategoriyi Sil">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white">
                    <i class="fas fa-plus"></i> Kategori Ekle
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <label>Adı* (meta title)</label>
                        <div class="input-group mb-3">
                            <input required type="text" class="form-control" name="title" max="255"
                                onchange="document.getElementById('input_slug').value = slugify(this.value)" required>
                        </div>
                        <label>Seo Url*</label>
                        <div class="input-group mb-3">
                            <input id="input_slug" type="text" class="form-control" name="slug" max="300"
                                required>
                        </div>
                        <label>Açıklama (meta description)</label>
                        <div class="input-group mb-3">
                            <textarea class="form-control" name="description" rows="1" max="255"></textarea>
                        </div>
                        <label>Görsel* (Boyut: 100x100)</label>
                        <input class="form-control mb-3"
                            onchange="document.getElementById('img').src = window.URL.createObjectURL(this.files[0])"
                            name="img" type="file" id="formFile" accept=".png, .jpg, .jpeg, .webp, .gif">
                        <img id="img" width="48" class="img-fluid mb-3" src="">
                        <div class="d-flex justfiy-content-between align-items-center mb-3">
                            <div class="input-group">
                                <span class="input-group-text bg-white">Sıra</span>
                                <input type="number" class="form-control" name="sortable" value="1">
                            </div>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary "><i class="fas fa-plus"></i>
                                Kategoriyi Ekle</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="edit_modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Düzenle</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.categories.update') }}" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" name="id" id="id">
                        <label>Adı* (meta title)</label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" name="title"
                                onchange="document.getElementById('modal_input_slug').value =slugify(this.value)"
                                max="255">
                        </div>
                        <label>Seo Url*</label>
                        <div class="input-group mb-3">
                            <input id="modal_input_slug" type="text" class="form-control" name="slug"
                                value="" max="300">
                        </div>
                        <label>Açıklama (meta description)</label>
                        <div class="input-group mb-3">
                            <textarea class="form-control" name="description" rows="1" max="255"></textarea>
                        </div>

                        <label>Görsel* (Boyut: 100x100)</label>
                        <input class="form-control mb-3"
                            onchange="document.getElementById('img2').src = window.URL.createObjectURL(this.files[0])"
                            name="img" type="file" id="formFile" accept=".png, .jpg, .jpeg, .webp, .gif">

                        <img width="48" id="img2" class="img-fluid mb-3" src="">
                        <div class="d-flex justfiy-content-between align-items-center mb-3">
                            <div class="input-group">
                                <span class="input-group-text bg-white">Sıra</span>
                                <input type="number" class="form-control" name="sortable" value="1">
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i
                                class="fas fa-times"></i>
                            İptal</button>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Kaydet</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <form method="POST" action="{{ route('admin.categories.delete') }}" id="admin_categories_delete">
        @csrf
        <input type="hidden" id="input_id" value="" name="id">
    </form>
@endsection
@push('scripts')
    <script>
        const edit_modal = document.getElementById('edit_modal')
        edit_modal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget
            const id = button.getAttribute('data-bs-id')
            const title = button.getAttribute('data-bs-title')
            const slug = button.getAttribute('data-bs-slug')
            const description = button.getAttribute('data-bs-description')
            const img = button.getAttribute('data-bs-img')
            const sortable = button.getAttribute('data-bs-sortable')

            edit_modal.querySelector('.modal-body input[name="id"]').value = id
            edit_modal.querySelector('.modal-body input[name="title"]').value = title

            edit_modal.querySelector('.modal-body input[name="slug"]').value = slug
            edit_modal.querySelector('.modal-body textarea[name="description"]').value = description
            edit_modal.querySelector('.modal-body input[name="sortable"]').value = sortable
            edit_modal.querySelector('.modal-body #img2').src = img

            var selectobject = document.querySelector('.modal-body select[name="parent_id"]');

            for (var i = 0; i < selectobject.length; i++) {
                if (selectobject.options[i].value == id)
                    selectobject.remove(i);
            }


        });

        function delete_form(id) {
            Swal.fire({
                title: 'Kategoriyi silmek istediğinize emin misiniz? Bağlı tüm ürünlerde silinecektir! Bu işlem geri alınamaz!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Eminim Sil!',
                cancelButtonText: 'İptal'

            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('input_id').value = id
                    document.getElementById('admin_categories_delete').submit()
                }
            })
        }
    </script>
@endpush
