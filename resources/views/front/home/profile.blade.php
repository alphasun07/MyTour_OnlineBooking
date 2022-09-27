@php
use App\Models\PcmUser;
use App\Models\PcmDmsCategory;
use Carbon\Carbon;
$authUser = Auth::User() ?? '';
Carbon::setLocale(config('app.locale'));
@endphp
@extends('front.common.app')
@section('title')
{{ $user->name ?? 'User profile' }}
@endsection
@section('head')
<style>
    .about-text h3 {
        font-size: 45px;
        font-weight: 700;
        margin: 0 0 6px;
    }
    @media (max-width: 767px) {
        .about-text h3 {
            font-size: 35px;
        }
    }
    .about-text h6 {
        font-weight: 600;
        margin-bottom: 15px;
    }
    @media (max-width: 767px) {
        .about-text h6 {
            font-size: 18px;
        }
    }
    .about-text p {
        font-size: 18px;
        max-width: 450px;
    }
    .about-text p mark {
        font-weight: 600;
        color: #20247b;
    }

    .about-list {
        padding-top: 10px;
    }
    .about-list .media {
        padding: 5px 0;
        display: flex;
    }
    .about-list label {
        color: #20247b;
        font-weight: 600;
        width: 88px;
        margin: 0;
        position: relative;
    }
    .about-list label:after {
        content: "";
        position: absolute;
        top: 0;
        bottom: 0;
        right: 6px;
        width: 1px;
        height: 12px;
        background: #20247b;
        -moz-transform: rotate(15deg);
        -o-transform: rotate(15deg);
        -ms-transform: rotate(15deg);
        -webkit-transform: rotate(15deg);
        transform: rotate(15deg);
        margin: auto;
        opacity: 0.5;
    }
    .about-list p {
        margin: 0;
        font-size: 15px;
    }
    @media (max-width: 991px) {
        .about-avatar {
            margin-top: 30px;
        }
    }

    .about-section .counter {
        padding: 22px 20px;
        background: #ffffff;
        border-radius: 10px;
        box-shadow: 0 0 30px rgba(31, 45, 61, 0.125);
    }
    .about-section .counter .count-data {
        margin-top: 10px;
        margin-bottom: 10px;
    }
    .about-section .counter .count {
        font-weight: 700;
        color: #20247b;
        margin: 0 0 5px;
    }
    .about-section .counter p {
        font-weight: 600;
        margin: 0;
    }
    mark {
        background-image: linear-gradient(rgba(252, 83, 86, 0.6), rgba(252, 83, 86, 0.6));
        background-size: 100% 3px;
        background-repeat: no-repeat;
        background-position: 0 bottom;
        background-color: transparent;
        padding: 0;
        color: currentColor;
    }
    .theme-color {
        color: #fc5356;
    }
    .dark-color {
        color: #20247b;
    }
</style>
@endsection
@section("content")
<section class="section about-section gray-bg" id="about">
    <div class="container" style="margin-top:120px;">
        <div class="row align-items-center flex-row-reverse mb-4">
            <div class="col-lg-8">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                <div class="about-text go-to">
                    <h3 class="dark-color">{{ $user->name ?? trans('home.none') }}</h3>
                    <div class="row about-list">
                        <div class="col-md-6">
                            <div class="media">
                                <label>{{ trans('home.birthdate') }}</label>
                                <p>{{ $user->birthdate ?? trans('home.none') }}</p>
                            </div>
                            <div class="media">
                                <label>{{ trans('home.age') }}</label>
                                <p>{{ $user->birthdate ? Carbon::parse($user->birthdate)->diff(Carbon::now())->y : trans('home.none') }}</p>
                            </div>
                            <div class="media">
                                <label>{{ trans('home.address') }}</label>
                                <p>{{ $user->address ?? trans('home.none') }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="media">
                                <label>{{ trans('home.email') }}</label>
                                <p>{{ $user->email ?? trans('home.none') }}</p>
                            </div>
                            <div class="media">
                                <label>{{ trans('home.phone') }}</label>
                                <p>{{ $user->phone_number ?? trans('home.none') }}</p>
                            </div>
                            <div class="media">
                                <label>{{ trans('home.gender') }}</label>
                                <p>{{ $user->gender_id != 0 ? PcmUser::GENDER[$user->gender_id] : '' }}</p>
                            </div>
                        </div>
                    </div>
                    @if( $user && $authUser && $user->id == $authUser->id )
                        <div class="text-center w-75">
                            <div class="btn btn-search w-25 position-relative" data-bs-toggle="modal" data-bs-target="#editProfile">{{ trans('admin.edit') }}</div>
                        </div>
                        <!-- Modal edit profile -->
                        <div class="modal fade" id="editProfile" tabindex="-1" aria-labelledby="editProfileLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                            <div class="modal-content">
                                <form action="{{ route('home.profile.update') }}" method="post">
                                    @csrf
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editProfileLabel">{{ trans('admin.edit') }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3 row">
                                            <label for="name" class="col-3 col-form-label">{{ trans('home.name') }}</label>
                                            <div class="col-9">
                                                <input name="name" type="text" class="form-control-plaintext ps-2" id="name" placeholder="{{ trans('home.name') }}" value="{{ old('name', $authUser->name ?? '') }}">
                                                @error('name')
                                                    <div class="text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="birthdate" class="col-3 col-form-label">{{ trans('home.birthdate') }}</label>
                                            <div class="col-9">
                                                <input name="birthdate" type="date" class="form-control-plaintext ps-2" placeholder="{{ trans('birthdate') }}" value="{{ old('birthdate', $authUser->birthdate ?? '') }}">
                                                @error('birthdate')
                                                    <div class="text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="address" class="col-3 col-form-label">{{ trans('home.address') }}</label>
                                            <div class="col-9">
                                                <input name="address" type="text" class="form-control-plaintext ps-2" id="address" placeholder="{{ trans('home.address') }}" value="{{ old('address', $authUser->address ?? '') }}">
                                                @error('address')
                                                    <div class="text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="phone_number" class="col-3 col-form-label">{{ trans('home.phone_number') }}</label>
                                            <div class="col-9">
                                                <input name="phone_number" type="text" class="form-control-plaintext ps-2" id="phone_number" placeholder="{{ trans('home.phone_number') }}" value="{{ old('phone_number', $authUser->phone_number ?? '') }}">
                                                @error('phone_number')
                                                    <div class="text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="gender_id" class="col-3 col-form-label">Gender</label>
                                            <div class="col-9">
                                                <select class="form-control-plaintext ps-2" name="gender_id" id="gender_id">
                                                    @foreach (PcmUser::GENDER as $key => $value )
                                                        <option value="{{ $key }}" {{ isset($authUser->gender_id) && $key == $authUser->gender_id ? 'selected' : '' }}>{{ $value }}</option>
                                                    @endforeach
                                                </select>
                                                @error('gender_id')
                                                    <div class="text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <div class="row w-100">
                                            <div class="col-4 text-start">
                                                <div id="submit_reset_password" class="btn btn-primary">Reset Password</div>
                                            </div>
                                            <div class="col-8 text-end">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ trans('admin.close') }}</button>
                                                <button type="submit" class="btn btn-primary">{{ trans('admin.save') }}</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <form action="{{ route('password.email') }}" name="submit_reset_password" method="POST">
                                    @csrf
                                    <input id="email" type="hidden" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ isset($authUser->email) ? $authUser->email : '' }}" required autocomplete="email" autofocus>
                                </form>
                            </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            <div class="col-lg-4">
                <div class="about-avatar">
                    <img src="/css/icons/profile_ava.jpg" width="315px" title="" alt="profile_ava.jpg">
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('scripts')
<script>
    $(document).ready(function() {
        $('#submit_reset_password').on('click', function(){
            $('[name="submit_reset_password"]').submit();
        })
    });
</script>
@endsection