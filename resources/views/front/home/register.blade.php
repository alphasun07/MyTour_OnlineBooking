@php
use App\Models\PcmMember as User;
@endphp
@extends('front.common.app')
@section('title')
PCM Donation - Register / Login
@endsection
@section("content")
<section id="appointment" class="appointment section-bg">
    <div class="container">

        <div class="w-100 m-auto" style="margin-top:120px !important;">
            <div class="row">
                <div class="col-12 col-xl-8 mb-2">
                    <form method="POST" action="{{ route('user.register') }}" class="registerform">
                        @csrf

                        <div class="form-group">
                            <h4 class="border-bottom p-2 mb-4 fw-normal fs-4">User Registration</h4>
                            <div class="row mb-4">
                                <label class="col-md-3 col-form-label text-md-end text-start">{{ trans('home.name') }}<span class="text-danger"> * </span> </label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control rounded" id="name" name="name" placeholder="{{ trans('home.name') }}" value="{{ old('name') }}" style="padding:12px;">
                                    @error('name')
                                    <div class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-4">
                                <label class="col-md-3 col-form-label text-md-end text-start"> {{ trans('home.password') }}<span class="text-danger"> * </span> </label>
                                <div class="col-md-9">
                                    <input type="password" class="form-control rounded" id="password" name="password" placeholder="password" value="{{ old('password', '') }}" style="padding:12px;">
                                    @error('password')
                                    <div class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-4">
                                <label class="col-md-3 pt-0 col-form-label text-md-end text-start"> Confirm Password<span class="text-danger"> * </span> </label>
                                <div class="col-md-9">
                                    <input type="password" class="form-control rounded" id="password_confirmation" name="password_confirmation" placeholder=" Confirm password" value="{{ old('password_confirmation', '') }}" style="padding:12px;">
                                    @error('password_confirmation')
                                    <div class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-4">
                                <label class="col-md-3 col-form-label text-md-end text-start">Email Address<span class="text-danger"> * </span> </label>
                                <div class="col-md-9">
                                    <input type="email" class="form-control rounded" id="email" name="email" placeholder="email@example.com" value="{{ old('email', '') }}" style="padding:12px;">
                                    @error('email')
                                    <div class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-4">
                                <label class="col-md-3 pt-0 col-form-label text-md-end text-start"> Confirm Email Address<span class="text-danger"> * </span> </label>
                                <div class="col-md-9">
                                    <input type="email" class="form-control rounded" id="email_confirm" name="email_confirm" placeholder="email@example.com" value="{{ old('email_confirm', '') }}" style="padding:12px;">
                                    @error('email_confirm')
                                    <div class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <!-- Google reCaptcha -->
                            <div class="row mb-4">
                                <label class="col-md-3 pt-0 col-form-label text-md-end text-start">&nbsp;</label>
                                <div class="col-md-9">
                                    <div class="g-recaptcha d-flex" id="feedback-recaptcha" data-sitekey="{{ config('app.GOOGLE_RECAPTCHA_KEY')  }}"></div>
                                    @error('g-recaptcha-response')
                                    <div class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <!-- End Google reCaptcha -->
                        </div>
                        <div class="text-center mt-5"><button type="submit">{{ trans('home.register') }}</button></div>
                    </form>
                </div>

                <div class="col-12 col-xl-4">
                    <form action="{{ route('login') }}" method="POST" class="registerform form-label-left input_mask">
                        @csrf
                        <div class="form-group">
                            <h4 class="border-bottom p-2 mb-4 fw-normal fs-4">User Login</h4>
                            @if (Session::has('error_message'))
                            <div class="text-center mb-2">
                                <span class="text-danger">{{ Session::get('error_message') }}</span>
                            </div>
                            @endif
                            <div class="row mb-4">
                                <div class="col-md-12 col-sm-12  form-group has-feedback">
                                    <input type="email" class="form-control has-feedback-left" id="email_login" name="email_login" id="inputSuccess2" placeholder="{{ trans('home.email') }}" value="{{ old('email_login') }}">
                                    <span class="fa fa-envelope form-control-feedback left" aria-hidden="true"></span>
                                </div>
                                @error('email_login')
                                <div class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-12 col-sm-12  form-group has-feedback">
                                    <input type="password" class="form-control has-feedback-left" id="password_login" name="password_login" id="inputSuccess2" placeholder="{{ trans('home.password') }}" value="{{ old('password_login') }}">
                                    <span class="fa fa-key form-control-feedback left" aria-hidden="true"></span>
                                </div>
                                @error('password_login')
                                <div class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                            </div>
                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="pe-0 form-check-label" for="remember">Remember Me</label>
                                </div>
                            </div>
                            <div class="text-left mb-2">
                                <button type="submit">{{ trans('home.login') }}</button>
                            </div>
                            <div class="text-start">
                                <a href="{{ route('user.showRegisterForm') }} " class="a-link">Create an account</a><br>
                                <a href="{{ route('password.request') }}" class="a-link">Forgot your password?</a><br>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('scripts')
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
@endsection