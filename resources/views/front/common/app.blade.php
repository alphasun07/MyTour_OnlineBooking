<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>
    @hasSection('title')
      @yield('title')
    @else
      PCM Donation
    @endif
  </title>
  <meta content="" name="description">
  <meta content="" name="keywords">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- Favicons -->
  <link href="/css/icons/global.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{ asset('Medilab/assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
  <link href="{{ asset('Medilab/assets/vendor/animate.css/animate.min.css') }}" rel="stylesheet">
  <link href="{{ asset('Medilab/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('Medilab/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('Medilab/assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
  <link href="{{ asset('Medilab/assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
  <link href="{{ asset('Medilab/assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
  <link href="{{ asset('Medilab/assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="{{ asset('css/style.css') }}" rel="stylesheet">
  <link href="{{ asset('css/front/custom.css') }}" rel="stylesheet">
  <link href="{{ asset('css/front/custom-new.css') }}" rel="stylesheet">
  @yield('head')

</head>

<body>
    @include("front.common.top")
    @include("front.common.menu")
    @yield("content")
    @include("front.common.footer")

  <div id="preloader"></div>
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="{{ asset('Medilab/assets/vendor/purecounter/purecounter.js') }}"></script>
  <script src="{{ asset('Medilab/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('Medilab/assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
  <script src="{{ asset('Medilab/assets/vendor/swiper/swiper-bundle.min.js') }}"></script>

  <!-- Template Main JS File -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script src="{{ asset('Medilab/assets/js/main.js') }}"></script>
  <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
  <script>
      CKEDITOR.replace('contents', {
          language: 'vn'
      });
  </script>
  @yield('scripts')
</body>

</html>
