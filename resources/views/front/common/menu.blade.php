@php
use App\Models\Option;
@endphp
<nav class="navbar navbar-expand-lg navbar-light bg-light p-1 pb-0 pt-0 ">
    <a class="navbar-brand m-0" href="{{ route('front.home') }}"><img src="{{ asset('images/image/logo.png') }}" class="img-fluid ml-2" alt="Responsive image" style="max-width: 70%"></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">

        <li class="nav-item dropdown active p-2">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="font-weight: 500; font-size:small;">
            Du lịch
            </a>
            <ul class="dropdown-menu">
            <li>
                <div class="row-fluid" style="min-width: 992px">
                <ul class="unstyled span4 m-4" style="float: left; list-style-type: none;">
                    <li class="mt-2 mb-2"><a href="#" style="color: #282365; font-size: small;" class="font-weight-bold">TOUR MIỀN BẮC</a></li>
                    <li class="mt-2 mb-2"><a href="#" style="color: #282365; font-size: small;">Du lịch Hà Nội</a></li>
                    <li class="mt-2 mb-2"><a href="#" style="color: #282365; font-size: small;">Du lịch Hải Phòng</a></li>
                    <li class="mt-2 mb-2"><a href="#" style="color: #282365; font-size: small;">Du lịch Hạ Long</a></li>
                    <li class="mt-2 mb-2"><a href="#" style="color: #282365; font-size: small;">Du lịch Bắc Ninh</a></li>
                    <li class="mt-2 mb-2"><a href="#" style="color: #282365; font-size: small;">Du lịch Phú Thọ</a></li>
                    <li class="mt-2 mb-2"><u><a href="#" style="color: #282365; font-size: small;" class="font-weight-bold">Xem tất cả</a></u></li>
                </ul>
                <ul class="unstyled span4 m-4" style="float: left; list-style-type: none;">
                    <li class="mt-2 mb-2"><a href="#" style="color: #282365; font-size: small;" class="font-weight-bold">TOUR Miền Trung</a></li>
                    <li class="mt-2 mb-2"><a href="#" style="color: #282365; font-size: small;">Du lịch Huế</a></li>
                    <li class="mt-2 mb-2"><a href="#" style="color: #282365; font-size: small;">Du lịch Quảng Trị</a></li>
                    <li class="mt-2 mb-2"><a href="#" style="color: #282365; font-size: small;">Du lịch Quảng Bình</a>
                    </li>
                    <li class="mt-2 mb-2"><a href="#" style="color: #282365; font-size: small;">Du lịch Đà Nẵng</a></li>
                    <li class="mt-2 mb-2"><a href="#" style="color: #282365; font-size: small;">Du lịch Quảng Nam</a></li>
                    <li class="mt-2 mb-2"><u><a href="#" style="color: #282365; font-size: small;" class="font-weight-bold">Xem tất cả</a></u></li>
                </ul>
                <ul class="unstyled span4 m-4" style="float: left; list-style-type: none;">
                    <li class="mt-2 mb-2"><a href="#" style="color: #282365; font-size: small;" class="font-weight-bold">TOUR MIỀN TÂY NAM BỘ</a></li>
                    <li class="mt-2 mb-2"><a href="#" style="color: #282365; font-size: small;">Du lịch Phú Quốc</a></li>
                    <li class="mt-2 mb-2"><a href="#" style="color: #282365; font-size: small;">Du lịch Tiền Giang</a>
                    </li>
                    <li class="mt-2 mb-2"><a href="#" style="color: #282365; font-size: small;">Du lịch Cần Thơ</a></li>
                    <li class="mt-2 mb-2"><a href="#" style="color: #282365; font-size: small;">Du lịch Vĩnh Long</a></li>
                    <li class="mt-2 mb-2"><a href="#" style="color: #282365; font-size: small;">Du lịch Sóc Trăng</a></li>
                    <li class="mt-2 mb-2"><u><a href="#" style="color: #282365; font-size: small;" class="font-weight-bold">Xem tất cả</a></u></li>
                </ul>
                <ul class="unstyled span4 m-4" style="float: left; list-style-type: none;">
                    <li class="mt-2 mb-2"><a href="#" style="color: #282365; font-size: small;" class="font-weight-bold">TOUR MIỀN ĐÔNG NAM BỘ</a></li>
                    <li class="mt-2 mb-2"><a href="#" style="color: #282365; font-size: small;">Du lịch Bà Rịa - Vũng
                        Tàu</a></li>
                    <li class="mt-2 mb-2"><a href="#" style="color: #282365; font-size: small;">Du lịch Côn Đảo</a></li>
                    <li class="mt-2 mb-2"><a href="#" style="color: #282365; font-size: small;">Du lịch TP.Hồ Chí Minh</a>
                    </li>
                    <li class="mt-2 mb-2"><a href="#" style="color: #282365; font-size: small;">Du lịch Tây Ninh</a></li>
                    <li class="mt-2 mb-2"><a href="#" style="color: #282365; font-size: small;">Du lịch Bình Dương</a>
                    </li>
                    <li class="mt-2 mb-2"><u><a href="#" style="color: #282365; font-size: small;" class="font-weight-bold">Xem tất cả</a></u></li>
                </ul>
                </div>
            </li>
            </ul>
        </li>

        <li class="nav-item dropdown active p-2">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="font-weight: 500; font-size:small;">
            Vận chuyển
            </a>
        </li>

        <li class="nav-item dropdown active p-2">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="font-weight: 500; font-size:small;">
            Tin tức
            </a>
        </li>

        <li class="nav-item dropdown active p-2">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="font-weight: 500; font-size:small;">
            Khuyến mãi
            </a>
        </li>

        <li class="nav-item active p-2" id="navbarDropdown">
            <a class="nav-link disabled" style="font-weight: 500; font-size:small;" href="#">VietravelPlus</a>
        </li>

        <li class="nav-item active p-2 " id="navbarDropdown">
            <a class="nav-link disabled" style="font-weight: 500; font-size:small;" href="#">Liên hệ</a>
        </li>

        </ul>

        <!--  Tìm kiếm trong thanh menu  -->

        <form class="form-inline my-2 my-lg-0" method="GET" action="listtour.php">
        <input class="form-control mr-1 sm-2 border-warning" type="text" name="search" placeholder="Bắt đầu tìm kiếm..." aria-label="Search">
        <button class="btn btn-outline my-2 my-sm-0 mr-1" type="submit"><i class="fas fa-search"></i></button>
        </form>
        @if (Auth::check())
        <div class="dropdown show mr-5">
            <a class="btn btn-secondary dropdown-toggle"  style="background: #ffffff;" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                <i class="fas fa-user" style="color: black;"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-end" role="menu" aria-labelledby="dropdownMenuLink" >
            <a class="dropdown-item" href="#">Quản lý</a>
            <a class="dropdown-item" href="#">Thông tin</a>
            <a class="dropdown-item" href="#">Lịch sử</a>
            <a class="dropdown-item" href="{{ route('user.logout') }}">Đăng xuất</a>
            </div>
        </div>
        @else
        <button type="button" class="btn btn-light"><a href="{{ route('user.showLoginForm') }}"><i class="fas fa-user" style="color: black;"></i></a></button>
        @endif
    </div>

</nav>


