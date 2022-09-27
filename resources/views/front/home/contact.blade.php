@extends('front.common.app', ['active' =>  'contact_us'])
@section('title')
Contact us
@endsection
@section("content")
    <section class="wrapper" style="margin-top: 80px;">
        <div class="container mt-2 mb-5 pt-3">
            <div class="post-list-container mt-2 row">
                <div class="col-12 col-lg-12 mx-auto">

                    <div class="filter-nav registerform">
                        <h2 class="title mb-2" style="color:#0DA0F2">
                            {{ trans('home.contact_us') }}
                        </h2>
                        @include('front.common.alert')
                        <form action="{{ route('home.contact.store') }}" method="post" role="form" class="">
                            @csrf
                            <div class="form-group mt-3">
                                <div class="row mb-4">
                                    <div class="form-floating px-0">
                                        <input type="text" class="form-control rounded-5" id="name" name="name" value="{{ old('name', Auth::check() ? Auth::user()->name : '') }}" placeholder="Name">
                                        <label for="name">Name<span class="text-danger"> * </span></label>
                                        @error('name')
                                            <div class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <div class="form-floating px-0">
                                        <input type="email" class="form-control rounded-5" id="email" name="email" value="{{ old('email', Auth::check() ? Auth::user()->email : '') }}" placeholder="Email">
                                        <label for="email">Email<span class="text-danger"> * </span></label>
                                        @error('email')
                                            <div class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <div class="form-floating px-0">
                                        <input type="text" class="form-control rounded-5" id="subject" name="subject" value="{{ old('subject') }}" placeholder="Subject">
                                        <label for="subject">Subject<span class="text-danger"> * </span></label>
                                        @error('subject')
                                            <div class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <div class="form-floating px-0">
                                        <textarea class="form-control" placeholder="Leave a message here" name="message" id="message" style="height: 200px">{{ old('message') }}</textarea>
                                        <label for="message"> Message<span class="text-danger"> * </span></label>
                                        @error('message')
                                            <div class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="text-center mt-5 "><button type="submit" style="background: #0DA0F2">{{ trans('home.confirm_information') }}</button></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

