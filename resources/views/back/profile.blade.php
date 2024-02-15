@extends('back.layouts.app')
@push('title', 'Profil')
@section('content')
<div class="row">
    <div class="col-lg-5 mb-3">
        <div class="card">
            <div class="card-header bg-white">
                <i class="fas fa-user-cog"></i> Profilimi Düzenle
            </div>
            <div class="card-body">
                <form method="POST" action="{{ Route('admin.profile.update.info') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="mb-3 text-center">
                                <img style="height: 70px;width:70px" id="img_src"
                                    class="img-profile rounded-circle mb-3" src="{{ asset(Auth::user()->img) }}">
                                <input type="file" name="img" id="input_img" hidden
                                    onchange="document.getElementById('img_src').src = window.URL.createObjectURL(this.files[0])"
                                    accept="image/*">
                                <button onclick="document.getElementById('input_img').click()" type="button"
                                    class="btn btn-sm btn-primary"><i class="fas fa-camera"></i>
                                    Değiştir
                                    (70x70)</button>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="mb-3">
                                <label class="form-label">Adınız</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white"><i
                                            class="fas fa-pencil-alt text-secondary"></i></span>
                                    <input type="text" class="form-control" name="name"
                                        value="{{ Auth::user()->name }}">
                                </div>

                            </div>
                            <div class="mb-3">
                                <label class="form-label">E-Mail Adresiniz</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white"><i
                                            class="fas fa-envelope text-secondary"></i></span>
                                    <input type="text" class="form-control" name="email"
                                        value="{{ Auth::user()->email }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Bilgileri
                            Kaydet</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="card">
            <div class="card-header bg-white">
                <i class="fas fa-user-lock"></i> Parola Değiştir
            </div>
            <div class="card-body">
                <form method="POST" action="{{ Route('admin.profile.update.password') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Eski Parola</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text bg-white"><i
                                    class="fas fa-user-lock text-secondary"></i></span>
                            <input id="old_password" type="password" class="form-control" name="old_password">
                            <button
                                onclick="input = document.getElementById('old_password');if(input.type == 'password') input.type = 'text'; else input.type = 'password';"
                                class="btn btn-outline-secondary" type="button">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Yeni Parola</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text bg-white"><i class="fas fa-key text-secondary"></i></span>
                            <input id="new_password" type="password" class="form-control" name="new_password">
                            <button
                                onclick="input = document.getElementById('new_password');if(input.type == 'password') input.type = 'text'; else input.type = 'password';"
                                class="btn btn-outline-secondary" type="button">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Yeni Parola Tekrar</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text bg-white"><i class="fas fa-key text-secondary"></i></span>
                            <input id="new_password_confirmation" type="password" class="form-control"
                                name="new_password_confirmation">
                            <button
                                onclick="input = document.getElementById('new_password_confirmation');if(input.type == 'password') input.type = 'text'; else input.type = 'password';"
                                class="btn btn-outline-secondary" type="button">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                    <div class="d-grid">
                        <button type="submit" name="btn_password_change" value="1" class="btn btn-primary"><i
                                class="fas fa-save"></i> Parola Değiştir
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection
