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
        My Tour
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

    @yield('head')

</head>


<body>
    <div class="d-flex" id="wrapper">
        <!-- Sidebar -->
        <div class="bg-white" id="sidebar-wrapper">
            <div class="sidebar-heading text-center py-4 primary-text fs-4 fw-bold text-uppercase border-bottom"><i
                    class="fas fa-user-secret me-2"></i>Admin</div>
            <div class="list-group list-group-flush my-3">
                <a href="index.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold <?php if($_SESSION["nav"] == "tours") echo "active"; ?>"><i
                        class="fas fa-tachometer-alt me-2"></i>Quản lý tour</a>
                <a href="QLNhanVien.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold <?php if($_SESSION["nav"] == "staff") echo "active"; ?>"><i
                        class="fas fa-project-diagram me-2"></i>Quản lý nhân viên</a> 
                <a href="QLDDTour.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold <?php if($_SESSION["nav"] == "orders") echo "active"; ?>"><i
                        class="fas fa-paperclip me-2"></i>Quản lý đơn đặt tour</a>  
                <a href="QLND.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold <?php if($_SESSION["nav"] == "customers") echo "active"; ?>"><i
                        class="fas fa-shopping-cart me-2"></i>Quản lý khách hàng</a>         
              
                <a href="logout.php" class="list-group-item list-group-item-action bg-transparent text-danger fw-bold"><i
                        class="fas fa-power-off me-2"></i>Đăng xuất</a>
            </div>
        </div>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <nav class="navbar navbar-expand-lg navbar-light bg-transparent py-4 px-4">
                <div class="d-flex align-items-center">
                    <i class="fas fa-align-left primary-text fs-4 me-3" id="menu-toggle"></i>
                </div>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle second-text fw-bold" href="#" id="navbarDropdown"
                                role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <?php
                                  // $sql = "select user_name from customers where customer_id = ?";
                                  // $abcd = simpleQuery($sql, 1, [$_SESSION["user_id"]])[0];
                                  echo '<i class="fas fa-user me-2"></i>';
                                  // echo $abcd["user_name"]; 

                                ?>
                            </a>
                            <ul class="dropdown-menu" style="right: 0; left: auto;" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="#">Trang cá nhân</a></li>
                                <li><a class="dropdown-item" href="../index.php"> Trang guess</a></li>
                                <li><a class="dropdown-item" href="logout.php">Đăng xuất</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
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
