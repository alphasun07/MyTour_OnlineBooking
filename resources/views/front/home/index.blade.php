@php
use App\Models\DtbRegisterInformation;
@endphp
@extends('front.common.app', ['active' => 'index'])
@section("content")

<img src="content/image/banner.jpg" class="img-fluid" style="width: 100%;" alt="Responsive image">

<hr>

<div class="mr-auto ml-auto" style="max-width: 1300px">

    <!-- content -->
    <!--Slick Carousel Slider-->
    <br>
    <br>
    <br>
    <p class="m-2" style="color:#282365; font-size:xx-large; font-weight: 600;">Các tour mới nhất</p>
    <div class="items justify-content-center" style="width: 100%">
        @foreach ($tour as $t)
            <div class="m-2"><a href="#"><img src="{{ $t['image_1'] ?? '' }}"
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
    @foreach ($tour_type as $type)
        <div class="row" id="box-search">
            <div class="thumbnail text-center">
            <div class="m-4 mr-5"><a href="#"><img src="{{ $type['image'] ?? '' }}"
                    style="width: 100%; border-radius: 10px;"></a></div>
            <div class="caption">
                <p class="ml-2" style="color:white; font-size: large; font-weight: 600; "><br>Tour {{ $type['type_name'] ?? '' }}</p>
            </div>
            </div>
        </div>
    @endforeach
    </div>


    <p class="m-2" style="color:#282365; font-size:xx-large; font-weight: 600;">Các tour được yêu thích</p>

    <div class="card-deck">
    @foreach ($tour as $t)
        <div class="card uu-dai">
            <div class="h-card-container">
                <a href="#">
                <img src="{{ $t['image_1'] ?? '' }}" class="card-img-top h-latest-tour-image" alt="...">
                </a>
                <div class="h-card-rank">{{ $t['rank_name'] ?? '' }}</div>
            </div>
            <div class="card-body">
                <p class="card-text mb-1"><small class="text-muted">28/10/2021 - {{ $t['day_count'] ?? '' }} ngày</small></p>
                <a href="#"><h5 class="card-title pr-2 mb-1" style="color: #282365; font-size: medium;">{{ $t['tour_name'] }}</h5></a>
                <p class="card-text"><b style="font-size: large; color:#FD5056;">{{ $price }}đ</b><small class="text-muted">/người</small></p>
                <a href="#" @if(!isset($_SESSION["user_id"])) onclick="return check_login()" @endif class="btn btn-danger" style="font-size: small; background-color: #D74449;"><i class="fas fa-shopping-cart"></i>&#160;Đặt ngay</a>
                <a href="#" class="btn btn-light" style="font-size: small; background-color: #ffffff; float: right; border: 1px solid #2f24a7; color: #2f24a7;">Xem chi tiết</a>
            </div>
        </div>
    @endforeach
    </div>
    <br>
    <button type="button" class="btn btn-light pl-4 pr-4" style="float: right; background-color: white; border: 1px solid rgb(202, 200, 194); color: #282365; font-weight: 600;">Xemtất cả&#160;&#160;<i class="fas fa-long-arrow-alt-right"></i></button>

    <!-- Gói ưu đãi đặc biệt -->
    <br>
    <br>
    <br>
    <p class="m-2" style="color:#282365; font-size:xx-large; font-weight: 600;">Tour ưu đãi đặc biệt</p>

    @foreach ($tour as $t)
        <div class="uu-dai card mb-3" style="max-width: 1300px;">
            <div class="row no-gutters">
                <div class="col-lg-3 col-12">
                <a href="#"><img src="{{ $t['image_1'] ?? '' }}" class="card-img" alt="..."></a>
                </div>
                <div class="col-lg-6 col-12">
                    <div class="card-body">
                        <a href="#" class="btn btn-secondary mb-2 disabled" style="font-size: small; background-color:#2D4271;">Vé máy bay + Khách sạn</a>
                        <a href="#"><h5 class="card-title pr-2 mb-1" style="color: #282365; font-size: medium;">{{ $t['tour_name'] ?? '' }}</h5></a>
                        <p class="card-text"><small class="text-muted">{{ $t['tour_desc'] ?? '' }}</small></p>
                    </div>
                </div>
                <div class="verticalLine col-lg-3 col-12">
                    <div style="float: right;">
                        <p class="card-text mr-3"><b style="font-size: large; color:#FD5056;">{{ $price ?? '' }}đ</b><small
                            class="text-muted">/khách</small></p>
                    </div>
                    <div style="float: right;">
                        <p class="card-text mb-3 mr-3"><small class="text-muted">Giá chỉ áp dụng khi mua kèm vé máy bay</small></p>
                    </div>
                    <div style="float: right;">
                        <a href="#" class="btn btn-danger mb-2 mr-3" style="font-size: small; background-color: #D74449;"><i class="fas fa-shopping-cart"></i>&#160;Đặt ngay</a>
                    </div>
                    <div style="float: right;">
                        <p href="#" class="btn btn-danger m-3 p-1" style="font-size:15px; background-color:#4D4AEF;">{{ $t['rank_desc'] ?? '' }}</p>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <button type="button" class="btn btn-light pl-4 pr-4" style="float: right; background-color: white; border: 1px solid rgb(202, 200, 194); color: #282365; font-weight: 600;">
        <a href="danhsach.php?rank=7" class="a">Xem tất cả&#160;&#160;<i class="fas fa-long-arrow-alt-right"></i></a>
    </button>
    <!-- Điểm đến yêu thích -->
    <br>
    <br>
    <br>
    <p class="m-2" style="color:#282365; font-size:xx-large; font-weight: 600;">Điểm đến yêu thích</p>
    <br>
    <div class="card-deck">
    @foreach ($tour[0] as $t)
        <div class="card" style="border: transparent;">
            <a href="#"><img src="{{ $t['image'] ?? '' }}" class="card-img-top pb-0 h-fav-tour-image" alt="..." style="border-radius: 10px;"></a>
            <div class="card-body p-0">
            <a href="#"><h5 class="card-title p-2 pb-0 mb-0" style="color: #282365;">{{ $t['city_name'] ?? '' }}</h5></a>
            <small class="p-2 pt-0" style="color:#282365;">Đã có {{ $t['count'] ?? '' }} lượt khách</small>
            </div>
        </div>
    @endforeach
    </div>
    <div class="card-deck">
    @foreach ($tour[1] as $t) {
        <div class="card" style="border: transparent;">
            <a href="#"><img src="{{ $t['image'] ?? '' }}" class="card-img-top pb-0 h-fav-tour-image" alt="..." style="border-radius: 10px;"></a>
            <div class="card-body p-0">
                <a href="#"><h5 class="card-title p-2 pb-0 mb-0" style="color: #282365;">{{ $t['city_name'] ?? '' }}</h5></a>
                <small class="p-2 pt-0" style="color:#282365;">Đã có {{ $t['count'] ?? '' }} lượt khách</small>
            </div>
        </div>
    @endforeach
    </div>

</div>

@endsection
