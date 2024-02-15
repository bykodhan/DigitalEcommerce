@extends('back.layouts.app')
@push('title', 'Site Ayarlar')
@section('content')
    <div class="row g-3">
        <h3>Site Ayarlar</h3>
        <div class="col-lg-4">
            <div class="card mb-3">
                <a class="d-grid card-header bg-white link-dark" role="button" data-bs-toggle="collapse"
                    data-bs-target="#index_info">
                    Anasayfa Bilgiler
                </a>
                <div class="collapse" id="index_info">
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.site.settings.update') }}">
                            @csrf
                            <input hidden type="text" name="setting_name" value="index_info">
                            <div class="mb-3">
                                <label class="form-label">Slogan</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="index_slogan"
                                        value="{{ Cache::get('index_slogan') }}">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Slogan Altı</label>
                                <textarea class="form-control" name="index_slogan_description" rows="3">{{ Cache::get('index_slogan_description') }}</textarea>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Kaydet</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="card mb-3">
                <a class="d-grid card-header bg-white link-dark" role="button" data-bs-toggle="collapse"
                    data-bs-target="#basic_info">
                    SEO Meta Bilgiler
                </a>
                <div class="collapse" id="basic_info">
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.site.settings.update') }}">
                            @csrf
                            <input hidden type="text" name="setting_name" value="basic">
                            <div class="mb-3">
                                <label class="form-label">Site Adı</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="site_name"
                                        value="{{ Cache::get('site_name') }}">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Anasayfa Başlık(meta title)</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="site_index_title"
                                        value="{{ Cache::get('site_index_title') }}">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Anasayfa Açıklama(meta description)</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="site_index_description"
                                        value="{{ Cache::get('site_index_description') }}">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Anahtar Kelimeler(meta keywords)</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="site_keywords"
                                        value="{{ Cache::get('site_keywords') }}">
                                </div>
                                <small>Anahtar Kelimeleri virgül ile ayırınız</small>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i>
                                    Kaydet</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="card mb-3">
                <a class="d-grid card-header bg-white link-dark" role="button" data-bs-toggle="collapse"
                    data-bs-target="#contact">
                    İletişim Sayfası Bilgileri
                </a>
                <div class="collapse" id="contact">
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.site.settings.update') }}">
                            @csrf
                            <input hidden type="text" name="setting_name" value="contact">
                            <div class="mb-3">
                                <label>Adres Konum</label>
                                <input type="text" class="form-control" name="contact_address"
                                    value="{{ Cache::Get('contact_address') }}">
                            </div>
                            <div class="mb-3">
                                <label>E-Mail Adresi</label>
                                <input type="text" class="form-control" name="contact_email"
                                    value="{{ Cache::Get('contact_email') }}">
                            </div>
                            <div class="mb-3">
                                <label>Telefon</label>
                                <input type="text" class="form-control" name="contact_phone"
                                    value="{{ Cache::Get('contact_phone') }}">
                            </div>
                            <div class="mb-3">
                                <label>Mesajların Gideceği E-Mail</label>
                                <input type="text" class="form-control" name="contact_mail_from_adress"
                                    value="{{ Cache::Get('contact_mail_from_adress') }}">
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i>
                                    Kaydet</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card mb-3">
                <a class="d-grid card-header bg-white link-dark" role="button" data-bs-toggle="collapse"
                    data-bs-target="#smtp_mail">
                    SMTP E-Mail Ayarları
                </a>
                <div class="collapse" id="smtp_mail">
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.site.settings.update') }}">
                            @csrf
                            <input hidden type="text" name="setting_name" value="smtp_mail">
                            <div class="mb-3">
                                <label class="form-label">Gönderen Mail Adresi</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="mail_from_adress"
                                        value="{{ Cache::get('mail_from_adress') }}">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Gönderilen Mail Adı</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="mail_from_name"
                                        value="{{ Cache::get('mail_from_name') }}">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Mail Host</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="mail_host"
                                        value="{{ Cache::get('mail_host') }}">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Mail Port</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="mail_port"
                                        value="{{ Cache::get('mail_port') }}">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Mail Username</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="mail_username"
                                        value="{{ Cache::get('mail_username') }}">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Mail Password</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="mail_password"
                                        value="{{ Cache::get('mail_password') }}">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Mail Secure</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="mail_secure"
                                        value="{{ Cache::get('mail_secure') }}">
                                </div>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i>
                                    Kaydet</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="card mb-3">
                <a class="d-grid card-header bg-white link-dark" role="button" data-bs-toggle="collapse"
                    data-bs-target="#social_media">
                    Sosyal Medya Adresleri
                </a>
                <div class="collapse" id="social_media">
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.site.settings.update') }}">
                            @csrf
                            <input hidden type="text" name="setting_name" value="social_media">
                            <div class="mb-3">
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fab fa-whatsapp"></i>WP
                                        +90</span>
                                    <input type="text" class="form-control" name="wp"
                                        value="{{ Cache::Get('wp') }}" placeholder="54xxxxxxxx">
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fab fa-whatsapp"></i>Skype</span>
                                    <input type="text" class="form-control" name="skype"
                                        value="{{ Cache::Get('skype') }}">
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fab fa-facebook"></i>Facebook</span>
                                    <input type="text" class="form-control" name="fb"
                                        value="{{ Cache::Get('fb') }}">
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i
                                            class="fab fa-instagram"></i>İnstagram</span>
                                    <input type="text" class="form-control" name="ig"
                                        value="{{ Cache::Get('ig') }}">
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fab fa-twitter"></i>Twitter</span>
                                    <input type="text" class="form-control" name="tw"
                                        value="{{ Cache::Get('tw') }}">
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fab fa-youtube"></i>Youtube</span>
                                    <input type="text" class="form-control" name="yt"
                                        value="{{ Cache::Get('yt') }}">
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i
                                            class="fab fa-pinterest"></i>Pinterest</span>
                                    <input type="text" class="form-control" name="pin"
                                        value="{{ Cache::Get('pin') }}">
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fab fa-linkedin"></i>Linkedin</span>
                                    <input type="text" class="form-control" name="in"
                                        value="{{ Cache::Get('in') }}">
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fab fa-github"></i>Github</span>
                                    <input type="text" class="form-control" name="git"
                                        value="{{ Cache::Get('git') }}">
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i
                                            class="fab fa-telegram-plane"></i>Telegram</span>
                                    <input type="text" class="form-control" name="tg"
                                        value="{{ Cache::Get('tg') }}">
                                </div>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i>
                                    Kaydet</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card mb-3">
                <a class="d-grid card-header bg-white link-dark" role="button" data-bs-toggle="collapse"
                    data-bs-target="#logo_favicon">
                    Logo&Favicon Ayarları
                </a>
                <div class="collapse" id="logo_favicon">
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.site.settings.update') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <input hidden type="text" name="setting_name" value="logo_favicon">
                            <div class="mb-3 text-center d-flex flex-column align-items-center">
                                <img width="100" id="img_src" class="img-fluid mb-3"
                                    src="{{ asset(Cache::get('logo_img')) }}">
                                <input type="file" name="logo_img" hidden
                                    onchange="document.getElementById('img_src').src = window.URL.createObjectURL(this.files[0])"
                                    accept=".png, .jpg, .jpeg, .gif, .webp" id="input_file">
                                <button onclick="document.getElementById('input_file').click()" type="button"
                                    class="btn btn-sm btn-light"><i class="fas fa-camera"></i> Logo Seç
                                </button>
                            </div>
                            <div class="mb-3 text-center d-flex flex-column align-items-center">
                                <img width="24" id="img_src2" class="img-fluid mb-3"
                                    src="{{ asset(Cache::get('favicon_img')) }}">
                                <input type="file" name="favicon_img" hidden
                                    onchange="document.getElementById('img_src2').src = window.URL.createObjectURL(this.files[0])"
                                    accept=".png, .jpg, .jpeg, .gif, .webp" id="input_file2">
                                <button onclick="document.getElementById('input_file2').click()" type="button"
                                    class="btn btn-sm btn-light"><i class="fas fa-camera"></i> Favicon Seç
                                </button>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i>
                                    Kaydet</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="card mb-3">
                <a class="d-grid card-header bg-white link-dark" role="button" data-bs-toggle="collapse"
                    data-bs-target="#index_images">
                     Görsel Ayarlar
                </a>
                <div class="collapse" id="index_images">
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.site.settings.update') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <input hidden type="text" name="setting_name" value="index_images">
                            <div class="mb-3 text-center d-flex flex-column align-items-center">
                                <img width="100" id="img_src3" class="img-fluid mb-3"
                                    src="{{ asset(Cache::get('slogan_img')) }}">
                                <input type="file" name="slogan_img" hidden
                                    onchange="document.getElementById('img_src3').src = window.URL.createObjectURL(this.files[0])"
                                    accept=".png, .jpg, .jpeg, .gif, .webp" id="input_file3">
                                <button onclick="document.getElementById('input_file3').click()" type="button"
                                    class="btn btn-sm btn-light"><i class="fas fa-camera"></i>
                                    Slogan Görseli
                                </button>
                            </div>
                            <div class="mb-3 text-center d-flex flex-column align-items-center">
                                <img width="100" id="img_src4" class="img-fluid mb-3"
                                    src="{{ asset(Cache::get('faq_img')) }}">
                                <input type="file" name="faq_img" hidden
                                    onchange="document.getElementById('img_src4').src = window.URL.createObjectURL(this.files[0])"
                                    accept=".png, .jpg, .jpeg, .gif, .webp" id="input_file4">
                                <button onclick="document.getElementById('input_file4').click()" type="button"
                                    class="btn btn-sm btn-light"><i class="fas fa-camera"></i> Sıkça Sorulan Sorular
                                    Görseli
                                </button>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i>
                                    Kaydet</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="card">
                <a class="d-grid card-header bg-white link-dark" role="button" data-bs-toggle="collapse"
                    data-bs-target="#extra_code">
                    Ekstra Header & Javascript Kodları
                </a>
                <div class="collapse" id="extra_code">
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.site.settings.update') }}">
                            @csrf
                            <input hidden type="text" name="setting_name" value="extra_code">
                            <div class="mb-3">
                                <label class="form-label">Ekstra ({{ 'buraya </head>' }})</label>
                                <textarea class="form-control" name="extra_header"rows="10">{{ Cache::get('extra_header') }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Ekstra ({{ 'buraya </body>' }})</label>
                                <textarea class="form-control" name="extra_javascript"rows="10">{{ Cache::get('extra_javascript') }}</textarea>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Kaydet</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
