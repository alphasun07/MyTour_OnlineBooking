@php
use App\Models\User;
@endphp
@extends('front.common.app')
@section('title')
PCM Donation - Login
@endsection
@section("content")
<section id="appointment" class="appointment section-bg" style="min-height:80vh;">
    <div class="container">
        <div class="row">

            <div class="col-lg-6 col-12 m-auto">

                <div class="w-75 m-auto">
                    <form action="{{ route('login') }}" method="POST" class="registerform login-form-container p-5 py-5">
                        @csrf

                        <div class="form-group mt-3">
                            <h3 class="border-bottom p-2 mb-4 fw-bold fs-4 text-center">Login</h3>
                            @if (Session::has('error_message'))
                                <div class="text-center mb-2">
                                    <span class="text-danger">{{ Session::get('error_message') }}</span>
                                </div>
                            @endif
                            <div class="row mb-4">
                                <label class="col-md-3 col-form-label">{{ trans('home.email') }}: </label>
                                <div class="col-md-9">
                                    <input type="email" class="form-control rounded" id="email_login" name="email_login" placeholder="{{ trans('home.email') }}" value="{{ old('email_login') }}">
                                    @error('email_login')
                                        <div class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-4">
                                <label class="col-md-3 col-form-label">{{ trans('home.password') }}: </label>
                                <div class="col-md-9">
                                    <input type="password" class="form-control rounded" id="password_login" name="password_login" placeholder="{{ trans('home.password') }}" value="{{ old('password_login') }}">
                                    @error('password_login')
                                        <div class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-xxl-6 col-12 text-start"><a href="{{ route('password.request') }}" class="a-link">Forgot your password?</a><br></div>
                            <div class="col-xxl-6 col-12 text-start text-xxl-end"><a href="{{ route('user.showRegisterForm') }} " class="a-link">Create an account <i class="fa fa-caret-right"></i></a></div>
                        </div>

                        <div class="text-center"><button type="submit">{{ trans('home.login') }}</button></div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</section>
@endsection
