@extends('auth.app')
@push('title', 'Giriş Yap')
@push('head')
    <style>
        .login {
            min-height: 100vh;
        }

        .bg-image {
            background-image: url('{{ asset('uploads/site/login-bg.jpg') }}');
            background-size: cover;
            background-position: center;
        }

        .login-heading {
            font-weight: 300;
        }

        .btn-login {
            font-size: 0.9rem;
            letter-spacing: 0.05rem;
            padding: 0.75rem 1rem;
        }
    </style>
@endpush
@section('content')
    <div class="container-fluid ps-md-0">
        <div class="row g-0">
            <div class="d-none d-md-flex col-md-4 col-lg-6 bg-image"></div>
            <div class="col-md-8 col-lg-6">
                <div class="login d-flex align-items-center py-5">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-9 col-lg-8 mx-auto">
                                <h3 class="login-heading mb-4">Hoşgeldin!</h3>

                                <!-- Sign In Form -->
                                <form method="POST" action="{{ route('login') }}">
                                    @csrf
                                    <div class="form-floating mb-3">
                                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                                            id="floatingInput" placeholder="name@example.com" name="email"
                                            autocomplete="email" autofocus value="{{ old('email') }}">
                                        <label for="floatingInput">Email Adresi</label>
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-floating mb-3">
                                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                                            id="floatingPassword" placeholder="Parola" name="password" required
                                            autocomplete="current-password">
                                        <label for="floatingPassword">Parola</label>
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" id="rememberPasswordCheck"
                                            name="remember" {{ old('remember') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="rememberPasswordCheck">
                                            Beni Hatırla
                                        </label>
                                    </div>

                                    <div class="d-grid">
                                        <button class="btn btn-lg btn-primary btn-login text-uppercase fw-bold mb-2"
                                            type="submit">Giriş Yap</button>
                                    </div>
                                </form>
                                <div class="text-center">
                                    @if (Route::has('password.request'))
                                        <a class="btn btn-link text-decoration-none link-secondary"
                                            href="{{ route('password.request') }}">
                                            Parolanızı mı Unuttunuz?
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
