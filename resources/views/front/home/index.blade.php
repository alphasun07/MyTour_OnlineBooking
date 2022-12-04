@php
@endphp
@extends('front.common.app', ['active' => 'index'])
@section("content")

<img src="{{asset('images/image/banner.jpg')}}" class="img-fluid" style="width: 100%;" alt="Responsive image">

<hr>

<div class="mr-auto ml-auto" style="max-width: 1300px">

    <!-- content -->
    <!--Slick Carousel Slider-->
    <br>
    <br>
    <br>
    <p class="m-2" style="color:#282365; font-size:xx-large; font-weight: 600;">Các tour mới nhất</p>
    <div class="items justify-content-center" style="width: 100%">
        @foreach ($newTours as $newTour)
            <div class="m-2"><a href="{{ route('home.tour.show', ['id' => $newTour->id]) }}"><img src="{{ (asset('storage/tours/' . ($newTour->thumbnail))) }}"
            style="width: 100%; border-radius: 5px;" class="h-latest-tour-image"></a></div>
        @endforeach
    </div>


    <!-- Khám phá tour du lịch -->

    <br>
    <br>
    <br>
    <p class="m-2" style="color:#282365; font-size:xx-large; font-weight: 600;">Khám phá các loại tour du lịch</p>
    <!-- <p class="m-2" style="color:#282365; font-size:larger; font-weight: 600;">TOUR ĐẶC TRƯNG</p> -->
    <div class="items2 justify-content-center" style="width: 100%">
    @foreach ($categories as $category)
        <div class="row" id="box-search">
            <div class="thumbnail text-center">
            <div class="m-4 mr-5"><a href="{{ route('home.tour.list', ['category_id' => $category->id]) }}"><img src="{{ (asset('storage/categories/' . ($category->category_thumb))) }}"
                    style="width: 100%; border-radius: 10px;"></a></div>
            <div class="caption">
                <p class="ml-2" style="color:white; font-size: large; font-weight: 600; "><br>Tour {{ $category->name ?? '' }}</p>
            </div>
            </div>
        </div>
    @endforeach
    </div>

    <p class="m-2" style="color:#282365; font-size:xx-large; font-weight: 600;">Các tour được yêu thích</p>

    <div class="card-deck">
    @foreach ($fTours as $ft)
        <div class="card uu-dai">
            <div class="h-card-container">
                <a href="{{ route('home.tour.show', ['id' => $ft->id]) }}">
                <img src="{{ (asset('storage/tours/' . ($ft->thumbnail))) }}" class="card-img-top h-latest-tour-image" alt="...">
                </a>
                <div class="h-card-rank">{{ $ft['rank_name'] ?? '' }}</div>
            </div>
            <div class="card-body">
                <p class="card-text mb-1"><small class="text-muted">28/10/2022 - {{ $ft->tour_time ?? '' }} ngày</small></p>
                <a href="{{ route('home.tour.show', ['id' => $ft->id]) }}"><h5 class="card-title pr-2 mb-1" style="color: #282365; font-size: medium;">{{ $ft->name ?? '' }}</h5></a>
                <p class="card-text"><b style="font-size: large; color:#FD5056;">{{ number_format(($ft->price_per_person ?? 0), 0, "", ",") }}đ</b><small class="text-muted">/người</small></p>
                <a href="{{ route('home.tour.book', ['id' => $ft->id]) }}" @if(!Auth::check()) onclick="return check_login()" @endif class="btn btn-danger" style="font-size: small; background-color: #D74449;"><i class="fas fa-shopping-cart"></i>&#160;Đặt ngay</a>
                <a href="{{ route('home.tour.show', ['id' => $ft->id]) }}" class="btn btn-light" style="font-size: small; background-color: #ffffff; float: right; border: 1px solid #2f24a7; color: #2f24a7;">Xem chi tiết</a>
            </div>
        </div>
    @endforeach
    </div>
    <br>
    <button type="button" class="btn btn-light pl-4 pr-4" style="float: right; background-color: white; border: 1px solid rgb(202, 200, 194); color: #282365; font-weight: 600;">Xemtất cả&#160;&#160;<i class="fas fa-long-arrow-alt-right"></i></button>

    <!-- Điểm đến yêu thích -->
    <br>
    <br>
    <br>
    <p class="m-2" style="color:#282365; font-size:xx-large; font-weight: 600;">Điểm đến yêu thích</p>
    <br>
    <div class="card-deck">
    @foreach ($mTours1 as $mTour)
        <div class="card" style="border: transparent;">
            <a href="{{ route('home.tour.show', ['id' => $mTour->id]) }}"><img src="{{ asset('storage/tours/'.$mTour->thumbnail) ?? '' }}" class="card-img-top pb-0 h-fav-tour-image" alt="..." style="border-radius: 10px;"></a>
            <div class="card-body p-0">
            <small class="p-2 pt-0" style="color:#282365;">Đã có {{ $mTour->count_order ?? '' }} lượt đặt</small>
            </div>
        </div>
    @endforeach
    </div>
    <div class="card-deck">
    @foreach ($mTours2 as $mTour) {
        <div class="card" style="border: transparent;">
            <a href="{{ route('home.tour.show', ['id' => $mTour->id]) }}"><img src="{{ asset('storage/tours/'.$mTour->thumbnail) ?? '' }}" class="card-img-top pb-0 h-fav-tour-image" alt="..." style="border-radius: 10px;"></a>
            <div class="card-body p-0">
            <small class="p-2 pt-0" style="color:#282365;">Đã có {{ $mTour->count_order ?? '' }} lượt đặt</small>
            </div>
        </div>
    @endforeach
    </div>

</div>

@endsection
