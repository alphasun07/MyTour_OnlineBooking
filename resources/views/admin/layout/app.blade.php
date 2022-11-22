<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <!-- Gentelella -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon Icon -->
    <link rel="shortcut icon" href="{{ asset('/favicon.ico') }}">
    <title>
        @hasSection('title')
        @yield('title')
        @else
        {{ config('app.name', 'Laravel') }}
        @endif
    </title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />

    <!-- Gentelella Bootstrap core CSS -->
    <link href="{{ asset('gentelella-master/vendors/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('gentelella-master/vendors/nprogress/nprogress.css') }}" rel="stylesheet">
    <link href="{{ asset('gentelella-master/vendors/dropzone/dist/min/dropzone.min.css') }}" rel="stylesheet">
    <link href="{{ asset('gentelella-master/vendors/bootstrap-chosen/chosen.min.css') }}" rel="stylesheet">
    <link href="{{ asset('gentelella-master/vendors/iCheck/skins/flat/green.css') }}" rel="stylesheet">
    <link href="{{ asset('gentelella-master/vendors/google-code-prettify/bin/prettify.min.css') }}" rel="stylesheet">
    <link href="{{ asset('gentelella-master/vendors/select2/dist/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('gentelella-master/vendors/switchery/dist/switchery.min.css') }}" rel="stylesheet">
    <link href="{{ asset('gentelella-master/vendors/starrr/dist/starrr.css') }}" rel="stylesheet">
    <link href="{{ asset('gentelella-master/vendors/bootstrap-daterangepicker/daterangepicker.css') }}" rel="stylesheet">
    <link href="{{ asset('gentelella-master/vendors/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css') }}" rel="stylesheet">
    <link href="{{ asset('gentelella-master/vendors/normalize-css/normalize.css') }}" rel="stylesheet">
    <link href="{{ asset('gentelella-master/vendors/ion.rangeSlider/css/ion.rangeSlider.skinFlat.css') }}" rel="stylesheet">
    <link href="{{ asset('gentelella-master/vendors/mjolnic-bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css') }}" rel="stylesheet">
    <link href="{{ asset('gentelella-master/vendors/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.min.css') }}" rel="stylesheet">
    <link href="{{ asset('gentelella-master/vendors/cropper/dist/cropper.min.css') }}" rel="stylesheet">
    <link href="{{ asset('gentelella-master/build/css/custom.min.css') }}" rel="stylesheet">
    <link href="{{ asset('gentelella-master/vendors/animate.css/animate.min.css') }}" rel="stylesheet">
    <!-- Styles -->
    <link href="{{ asset('css/admin/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin/custom.css') }}" rel="stylesheet">

    @yield('head')

</head>

<body class="o-backColor__gray--thick nav-md flex-wrap">
    <div class="container body" id="app">
        <div class="main_container">
            <div class="col-md-3 left_col menu_fixed mCustomScrollbar _mCS_1 mCS-autoHide" style="overflow: visible;">
                <div id="mCSB_1" class="mCustomScrollBox mCS-minimal mCSB_vertical mCSB_outside" style="max-height: none;" tabindex="0">
                    <div id="mCSB_1_container" class="mCSB_container" style="position:relative; top:0; left:0;" dir="ltr">
                        <div class="left_col scroll-view">
                            <div class="navbar nav_title" style="border: 0;">
                                <a href="{{ route('admin.dms.dashboard') }}" class="site_title">
                                    MYTOUR.VN
                                </a>
                            </div>
                            <div class="clearfix">
                            </div>
                            <br>
                            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                                <div class="menu_section">
                                    <ul class="nav side-menu">
                                        <li>
                                            <a class="md-flex"><i class="far fa-plus-hexagon"></i><span class="parent_menu ml-3">Điều hành</span></a>
                                            <ul class="nav child_menu">
                                                <li><a href="{{ route('admin.tour.list') }}">Tour</a></li>
                                                <li><a href="{{ route('admin.place.list') }}">Địa điểm</a></li>
                                                <li><a href="{{ route('admin.category.list') }}">Loại</a></li>
                                                <li><a href="#">Hóa đơn</a></li>
                                                <li><a href="#">Khuyến mãi</a></li>
                                                <li><a href="{{ route('admin.service.list') }}">Dịch vụ</a></li>
                                                <li><a href="{{ route('admin.post.list') }}">Tin tức</a></li>
                                                <li><a href="{{ route('admin.member.list') }}">Khách hàng</a></li>
                                            </ul>
                                        </li>
                                        <li>
                                            <a class="md-flex"><i class="fal fa-clipboard-user"></i><span class="parent_menu ml-3">Nhân sự</span></a>
                                            <ul class="nav child_menu">
                                                <li><a href="#">Lương</a></li>
                                                <li><a href="{{ route('admin.list') }}">Admin</a></li>
                                            </ul>
                                        </li>
                                        <li>
                                            <a class="md-flex"><i class="fas fa-chart-bar"></i></i><span class="parent_menu ml-3">Kế toán</span></a>
                                            <ul class="nav child_menu">
                                                <li><a href="#">Quản lý doanh thu</a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="top_nav">
                <div class="nav_menu">
                    <div class="nav toggle">
                        <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                    </div>
                    <nav class="nav navbar-nav">
                        <ul class=" navbar-right">
                            <li class="nav-item dropdown open" style="padding-left: 15px;">
                                <a href="javascript:;" class="user-profile dropdown-toggle" aria-haspopup="true" id="navbarDropdown" data-toggle="dropdown" aria-expanded="false">TEST</a>
                                <div class="dropdown-menu dropdown-usermenu pull-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();"><i class="fa fa-power-off pull-right"></i>Logout</a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
            <div class="right_col" role="main" style="min-height: 777px;">
                @yield('pageTitle')
                @include('admin.common.alert')
                @yield('content')
            </div>
        </div>
    </div>
    <!-- Gentelella js -->
    <script src="{{ asset('gentelella-master/vendors/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('gentelella-master/vendors/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('gentelella-master/vendors/fastclick/lib/fastclick.js') }}"></script>
    <script src="{{ asset('gentelella-master/vendors/nprogress/nprogress.js') }}"></script>
    <script src="{{ asset('gentelella-master/vendors/dropzone/dist/min/dropzone.min.js') }}"></script>
    <script src="{{ asset('gentelella-master/vendors/bootstrap-chosen/chosen.jquery.min.js') }}"></script>
    <script src="{{ asset('gentelella-master/vendors/bootstrap-chosen/chosen.proto.min.js') }}"></script>
    <script src="{{ asset('gentelella-master/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js') }}"></script>
    <script src="{{ asset('gentelella-master/vendors/iCheck/icheck.min.js') }}"></script>
    <script src="{{ asset('gentelella-master/vendors/moment/min/moment.min.js') }}"></script>
    <script src="{{ asset('gentelella-master/vendors/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('gentelella-master/vendors/bootstrap-wysiwyg/js/bootstrap-wysiwyg.min.js') }}"></script>
    <script src="{{ asset('gentelella-master/vendors/jquery.hotkeys/jquery.hotkeys.js') }}"></script>
    <script src="{{ asset('gentelella-master/vendors/ion.rangeSlider/js/ion.rangeSlider.min.js') }}"></script>
    <script src="{{ asset('gentelella-master/vendors/mjolnic-bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js') }}"></script>
    <script src="{{ asset('gentelella-master/vendors/jquery.inputmask/dist/min/jquery.inputmask.bundle.min.js') }}"></script>
    <script src="{{ asset('gentelella-master/vendors/jquery-knob/dist/jquery.knob.min.js') }}"></script>
    <script src="{{ asset('gentelella-master/vendors/google-code-prettify/src/prettify.js') }}"></script>
    <script src="{{ asset('gentelella-master/vendors/jquery.tagsinput/src/jquery.tagsinput.js') }}"></script>
    <script src="{{ asset('gentelella-master/vendors/switchery/dist/switchery.min.js') }}"></script>
    <script src="{{ asset('gentelella-master/vendors/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('gentelella-master/vendors/autosize/dist/autosize.min.js') }}"></script>
    <script src="{{ asset('gentelella-master/vendors/devbridge-autocomplete/dist/jquery.autocomplete.min.js') }}"></script>
    <script src="{{ asset('gentelella-master/vendors/starrr/dist/starrr.js') }}"></script>
    <script src="{{ asset('gentelella-master/vendors/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js') }}"></script>
    <script src="{{ asset('gentelella-master/vendors/cropper/dist/cropper.min.js') }}"></script>
    @yield('scripts')
    <script src="{{ asset('gentelella-master/build/js/custom.min.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}" defer></script>
</body>

</html>
