@extends('back.layouts.app')
@push('title', 'Modüller')
@section('content')
    <div class="row g-3">
        <h3>Modüller</h3>
        <div class="col-lg-4">
            <div class="card mb-3">
                <a class="d-grid card-header bg-white link-dark" role="button" data-bs-toggle="collapse"
                    data-bs-target="#havale_eft">
                    Havale/Eft Ödeme
                </a>
                <div class="collapse" id="havale_eft">
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.modules.update') }}">
                            @csrf
                            <input hidden type="text" name="module_name" value="havale_eft">
                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" id="havale_eft_active"
                                        name="havale_eft_active" value="1"
                                        @if (Cache::get('havale_eft_active') == 1) checked @endif>
                                    <label class="form-check-label" for="havale_eft_active">Havale/Eft Ödeme Aktif</label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Banka Bilgileriniz:</label>
                                <textarea class="form-control" name="havale_eft_info" rows="5">{{ Cache::get('havale_eft_info') }}</textarea>
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
                    data-bs-target="#papara_card">
                    Papara Ödeme
                </a>
                <div class="collapse" id="papara_card">
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.modules.update') }}">
                            @csrf
                            <input hidden type="text" name="module_name" value="papara">
                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch"
                                        id="flexSwitchCheckChecked1" name="papara_active" value="1"
                                        @if (Cache::get('papara_active') == 1) checked @endif>
                                    <label class="form-check-label" for="flexSwitchCheckChecked1">Papara Ödeme Aktif</label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Hesap No:</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white"><i
                                            class="fas fa-pencil-alt text-secondary"></i></span>
                                    <input type="text" class="form-control" name="papara_account_number"
                                        value="{{ Cache::get('papara_account_number') }}">
                                </div>
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
                    data-bs-target="#paytr_card">
                    PayTR Ödeme
                </a>
                <div class="collapse" id="paytr_card">
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.modules.update') }}">
                            @csrf
                            <input hidden type="text" name="module_name" value="paytr">
                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch"
                                        id="paytr_active" name="paytr_active" value="1"
                                        @if (Cache::get('paytr_active') == 1) checked @endif>
                                    <label class="form-check-label" for="paytr_active">PayTR Ödeme Aktif</label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">
                                    Mağaza No (merchant_id)
                                </label>
                                <input type="text" class="form-control" name="paytr_merchant_id"
                                    value="{{ Cache::get('paytr_merchant_id') }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">
                                    Mağaza Parola (merchant_key)
                                </label>
                                <input type="text" class="form-control" name="paytr_merchant_key"
                                    value="{{ Cache::get('paytr_merchant_key') }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">
                                    Mağaza Gizli Anahtar (merchant_salt)
                                </label>
                                <input type="text" class="form-control" name="paytr_merchant_salt"
                                    value="{{ Cache::get('paytr_merchant_salt') }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">
                                    Bildirim Url
                                </label>
                                <input type="text" class="form-control" value="{{ route('paytr.callback') }}"
                                    readonly>
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
                    data-bs-target="#paymax_card">
                    Paymax Ödeme
                </a>
                <div class="collapse" id="paymax_card">
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.modules.update') }}">
                            @csrf
                            <input hidden type="text" name="module_name" value="paymax">
                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch"
                                        id="flexSwitchCheckChecked2" name="paymax_active" value="1"
                                        @if (Cache::get('paymax_active') == 1) checked @endif>
                                    <label class="form-check-label" for="flexSwitchCheckChecked2">Paymax Ödeme
                                        Aktif</label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">
                                    API User
                                </label>
                                <input type="text" class="form-control" name="paymax_api_user"
                                    value="{{ Cache::get('paymax_api_user') }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">
                                    API Mağaza Kodu
                                </label>
                                <input type="text" class="form-control" name="paymax_api_merchant"
                                    value="{{ Cache::get('paymax_api_merchant') }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">
                                    API Key
                                </label>
                                <input type="text" class="form-control" name="paymax_api_key"
                                    value="{{ Cache::get('paymax_api_key') }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">
                                    API Hash Anahtarı
                                </label>
                                <input type="text" class="form-control" name="paymax_api_hash"
                                    value="{{ Cache::get('paymax_api_hash') }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">
                                    API URL
                                </label>
                                <input type="text" class="form-control" name="paymax_api_url"
                                    value="{{ Cache::get('paymax_api_url') }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">
                                    Geri Dönüş Url (Callback Url)
                                </label>
                                <input type="text" class="form-control" value="{{ route('paymax.callback') }}"
                                    readonly>
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
                    data-bs-target="#flash_news">
                    En Üstte Kayan Yazılar
                </a>
                <div class="collapse" id="flash_news">
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.modules.update') }}">
                            @csrf
                            <input hidden type="text" name="module_name" value="flash_news">
                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch"
                                        id="flexSwitchCheckChecked3" name="flash_news_active" value="1"
                                        @if (Cache::get('flash_news_active') == 1) checked @endif>
                                    <label class="form-check-label" for="flexSwitchCheckChecked3">En Üst Kayan Yazı(link)
                                        Aktif</label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">1. Yazı: Başlık</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white"><i
                                            class="fas fa-pencil-alt text-secondary"></i></span>
                                    <input type="text" class="form-control" name="flash_news_title1"
                                        value="{{ Cache::get('flash_news_title1') }}">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">1. Yazı: varsa Link(URL)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white"><i
                                            class="fas fa-link text-secondary"></i></span>
                                    <input type="text" class="form-control" name="flash_news_link1"
                                        value="{{ Cache::get('flash_news_link1') }}">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">2. Yazı: Başlık</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white"><i
                                            class="fas fa-pencil-alt text-secondary"></i></span>
                                    <input type="text" class="form-control" name="flash_news_title2"
                                        value="{{ Cache::get('flash_news_title2') }}">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">2. Yazı: varsa Link(URL)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white"><i
                                            class="fas fa-link text-secondary"></i></span>
                                    <input type="text" class="form-control" name="flash_news_link2"
                                        value="{{ Cache::get('flash_news_link2') }}">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">3. Yazı: Başlık</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white"><i
                                            class="fas fa-pencil-alt text-secondary"></i></span>
                                    <input type="text" class="form-control" name="flash_news_title3"
                                        value="{{ Cache::get('flash_news_title3') }}">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">3. Yazı: varsa Link(URL)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white"><i
                                            class="fas fa-link text-secondary"></i></span>
                                    <input type="text" class="form-control" name="flash_news_link3"
                                        value="{{ Cache::get('flash_news_link3') }}">
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
                    data-bs-target="#telegram_bot">
                    Telegram Bot Sipariş Bildirim
                </a>
                <div class="collapse" id="telegram_bot">
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.modules.update') }}">
                            @csrf
                            <input hidden type="text" name="module_name" value="telegram_bot">
                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch"
                                        id="telegram_bot_active" name="telegram_bot_active" value="1"
                                        @if (Cache::get('telegram_bot_active') == 1) checked @endif>
                                    <label class="form-check-label" for="telegram_bot_active">Telegram Bot Sipariş
                                        Bildirim Aktif</label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Bot Token</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white"><i
                                            class="fas fa-pencil-alt text-secondary"></i></span>
                                    <input type="text" class="form-control" name="telegram_bot_token"
                                        value="{{ Cache::get('telegram_bot_token') }}">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Chat ID</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white"><i
                                            class="fas fa-pencil-alt text-secondary"></i></span>
                                    <input type="text" class="form-control" name="telegram_bot_chat_id"
                                        value="{{ Cache::get('telegram_bot_chat_id') }}">
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

    </div>
@endsection
