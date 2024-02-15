@extends('back.layouts.app')
@push('title', 'Footer Links')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between bg-white">
                    Footer Linkler
                    <a data-bs-toggle="modal" data-bs-target="#addModal" class="btn btn-outline-secondary btn-sm"><i
                            class="fas fa-plus"></i> Yeni Link Ekle</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Başlık</th>
                                    <th>Link</th>
                                    <th>Yeni Sekmede Aç</th>
                                    <th>Sil</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($footer_links as $footer_link)
                                    <tr>
                                        <td>{{ $footer_link->id }}</td>
                                        <td>{{ $footer_link->title }}</td>
                                        <td>{{ $footer_link->url }}</td>
                                        <td>
                                            @if ($footer_link->target == 1)
                                                Evet
                                            @else
                                                Hayır
                                            @endif
                                        </td>
                                        <td>
                                            <form action="{{ route('admin.site.settings.footer_links.delete') }}"
                                                method="POST">
                                                @csrf
                                                <input type="hidden" name="id" value="{{$footer_link->id}}">
                                                <button class="btn btn-sm btn-outline-danger border-0"><i
                                                        class="fas fa-trash"></i> Sil</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="modal" id="addModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Yeni Link Ekle</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.site.settings.footer_links.store') }}" method="post">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Başlık</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white"><i
                                        class="fas fa-pencil-alt text-secondary"></i></span>
                                <input type="text" class="form-control" name="title" value="">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Link(URL)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white"><i class="fas fa-link text-secondary"></i></span>
                                <input type="text" class="form-control" name="url" value="">
                            </div>
                        </div>
                        <div class="mb-3">
                            <select class="form-select" name="target">
                                <option value="0">Yeni Sekmede Açılmasın</option>
                                <option value="1">Yeni Sekmede Açılsın</option>

                            </select>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-plus"></i> Footera Linki
                                Ekle</button>

                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection
