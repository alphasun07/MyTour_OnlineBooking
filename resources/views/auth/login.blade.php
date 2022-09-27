<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('css/admin/style.css') }}">
        <link href="{{ asset('css/admin/custom.css') }}" rel="stylesheet">
        <title>login</title>
    </head>
    <body class="body-login">
        <div class="container">
            <div class="row justify-content-center">
                <div class="login-form col-md-4">
                    <div class="card">
                        <div class="card card-container">
                            @isset($authgroup)
                            <form class="form-signin o-formWidth" method="POST" action="{{ url("$authgroup/login") }}">
                            @else
                            <form class="form-signin o-formWidth" method="POST" action="{{ route('login') }}">
                            @endisset
                                @csrf
                                @if (session('error_message'))
                                <div class="alert alert-danger" role="alert">
                                    {{ session('error_message') }}
                                </div>
                                @endif
                                @isset($authgroup)
                                    <div class="row mb-3 flex-column">
                                        <label for="login_id" class="col-lg-7 col-form-label text-md-end">Login ID</label>

                                        <div class="col-lg-12">
                                            <input id="login_id" type="text" class="form-control @error('login_id') is-invalid @enderror" name="login_id" value="{{ old('login_id') }}" required autocomplete="login_id" autofocus>

                                            @error('login_id')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                @else
                                    <div class="row mb-3 flex-column">
                                        <label for="email" class="col-lg-7 col-form-label text-md-end">Email</label>

                                        <div class="col-lg-12">
                                            <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                @endif
                                <div class="row mb-4 flex-column">
                                    <label for="password" class="col-lg-7 col-form-label text-md-end">Password</label>

                                    <div class="col-lg-12">
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <button type="submit" class="btn btn-dark btn-lg btn-block">
                                            Login
                                        </button>

                                            {{-- @if (Route::has(isset($authgroup) ? $authgroup.'.password.request' : 'password.request'))
                                                <a class="btn btn-link" href="{{ route(isset($authgroup) ? $authgroup.'.password.request' : 'password.request') }}">
                                                    {{ __('Forgot Your Password?') }}
                                                </a>
                                            @endif --}}
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>