<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <!-- Gentelella -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>

    <!-- Styles -->
    {{-- <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet"> --}}

    <!-- Gentelella Bootstrap core CSS -->
    <link href="{{ asset('gentelella-master/vendors/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('gentelella-master/vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('gentelella-master/vendors/nprogress/nprogress.css') }}" rel="stylesheet">
    <link href="{{ asset('gentelella-master/vendors/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.min.css') }}" rel="stylesheet">
    <link href="{{ asset('gentelella-master/build/css/custom.min.css') }}" rel="stylesheet">
    <link href="{{ asset('gentelella-master/vendors/animate.css/animate.min.css') }}" rel="stylesheet">
    <!-- Styles -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <!-- js -->
    {{-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script> --}}
    <script src="{{ asset('js/caleandar.js') }}" defer></script>
    <script src="{{ asset('js/custom.js') }}" defer></script>
    <script src="{{ asset('gentelella-master/vendors/jquery/dist/jquery.min.js') }}"></script>

</head>
<body class="back-color nav-md">
    <div class="container body" id="app">
        @isset($authgroup)
        <div class="main_container">
            <div class="col-md-3 left_col menu_fixed mCustomScrollbar _mCS_1 mCS-autoHide" style="overflow: visible;">
                <div id="mCSB_1" class="mCustomScrollBox mCS-minimal mCSB_vertical mCSB_outside" style="max-height: none;" tabindex="0">
                    <div id="mCSB_1_container" class="mCSB_container" style="position:relative; top:0; left:0;" dir="ltr">
                        <div class="left_col scroll-view o-background__white">
                            <div class="navbar nav_title o-background__white" style="border: 0;">
                                <a href="#" class="site_title"><i class="fa fa-paw"></i> <span>サイトロゴ</span></a>
                            </div>
                            <div class="clearfix">
                            </div>
                            <br>
                            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                                <div class="menu_section active mb-0">
                                    <ul class="nav side-menu" style="color: black;">
                                        <li><a class="pr-3 pl-3 bd-highlight text-dark border-bottom" href="{{ route('admin.site_setting.index') }}"><span class="text-dark">サイト基本設定</span></a></li>
                                        <li><a class="pr-3 pl-3 bd-highlight text-dark border-bottom" href="{{ route('admin.management.list') }}"><span class="text-dark">運営者管理</span></a></li>
                                        <li><a class="text-dark border-bottom"><span class="text-dark">商品管理</span><span class="fa fa-chevron-down text-dark"></span></a>
                                            <ul class="nav child_menu">
                                                <li><a class="dropdown-item text-wrap text-dark" href="{{ route('admin.product_all.index') }}">商品一覧</a></li>
                                                <li><a class="dropdown-item text-wrap text-dark" href="{{ route('admin.category.list') }}">商品カテゴリー一覧</a></li>
                                                <li><a class="dropdown-item text-wrap text-dark" href="{{ route('admin.category.add') }}">商品カテゴリー登録</a></li>
                                                <li><a class="dropdown-item text-wrap text-dark" href="{{ action('AdminController@product_class_info') }}">商品画像一括アップロード</a></li>
                                            </ul>
                                        </li>
                                        <li><a class="pr-3 pl-3 bd-highlight text-dark border-bottom" href="{{ route('admin.coupon.index') }}"><span class="text-dark">クーポン除外設定</span></a></li>
                                        <li><a class="text-dark d-flex flex-row border-bottom"><span class="text-dark">おすすめ・ランキング商品管理</span><span class="fa fa-chevron-down text-dark"></span></a>
                                            <ul class="nav child_menu">
                                                <li><a class="dropdown-item text-wrap text-dark" href="">総合トップおすすめ商品管理</a></li>
                                                <li><a class="dropdown-item text-wrap text-dark" href="">ジャンルトップおすすめ商品管理</a></li>
                                                <li><a class="dropdown-item text-wrap text-dark" href="">タイトルトップおすすめ商品管理</a></li>
                                                <li><a class="dropdown-item text-wrap text-dark" href="{{ action('AdminController@recommend_data') }}">おすすめ商品データアップロード</a></li>
                                                <li><a class="dropdown-item text-wrap" href="#">ランキング管理</a></li>
                                            </ul>
                                        </li>
                                        <li><a class="pr-3 pl-3 bd-highlight text-dark border-bottom" href="#"><span class="text-dark">送料・手数料設定</span></a></li>
                                        <li><a class="text-dark border-bottom"><span class="text-dark">メール設定管理</span><span class="fa fa-chevron-down text-dark"></span></a>
                                            <ul class="nav child_menu">
                                                <li><a class="dropdown-item text-wrap text-dark" href="{{ route('admin.mail-template.index') }}">顧客メールテンプレート設定</a></li>
                                            </ul>
                                        </li>
                                        <li><a class="pr-3 pl-3 bd-highlight text-dark border-bottom" href="{{ route('admin.order.index') }}"><span class="text-dark">受注管理</span></a></li>
                                        <li><a class="pr-3 pl-3 bd-highlight text-dark border-bottom" href="{{ route('admin.reserve.index') }}"><span class="text-dark">予約管理</span></a></li>
                                        <li><a class="pr-3 pl-3 bd-highlight text-dark border-bottom" href="{{ route('admin.customer.list') }}"><span class="text-dark">会員管理</span></a></li>
                                        <li><a class="pr-3 pl-3 bd-highlight text-dark border-bottom" href="{{ route('admin.shipping.index') }}"><span class="text-dark">出荷管理</span></a></li>
                                        <li><a class="pr-3 pl-3 bd-highlight text-dark border-bottom" href="#"><span class="text-dark">送料・手数料設定</span></a></li>
                                        <li><a class="text-dark border-bottom"><span class="text-dark">ポイント・クーポン管理</span><span class="fa fa-chevron-down text-dark"></span></a>
                                            <ul class="nav child_menu">
                                                <li><a class="dropdown-item text-wrap text-dark" href="{{ action('AdminController@point_coupon') }}">共通クーポン</a></li>
                                            </ul>
                                        </li>
                                        <li><a class="text-dark border-bottom"><span class="text-dark">お知らせ・バナー管理</span><span class="fa fa-chevron-down text-dark"></span></a>
                                            <ul class="nav child_menu">
                                                <li><a class="dropdown-item text-wrap text-dark" href="{{ route('admin.information.list') }}">お知らせ管理</a></li>
                                                <li><a class="dropdown-item text-wrap text-dark" href="{{ route('admin.slide.list') }}">スライダー管理</a></li>
                                                <li><a class="dropdown-item text-wrap text-dark" href="{{ route('admin.pick_up.list') }}">ピックアップ特集管理</a></li>
                                                <li><a class="dropdown-item text-wrap" href="#">カート内告知エリア管理</a></li>
                                            </ul>
                                        </li>
                                        <li><a class="text-dark border-bottom"><span class="text-dark">コンテンツ管理</span><span class="fa fa-chevron-down text-dark"></span></a>
                                            <ul class="nav child_menu">
                                                <li><a class="dropdown-item text-wrap text-dark" href="{{ route('admin.content_all.index', ['title' => '総合トップ']) }}">総合トップ</a></li>
                                                <li><a class="dropdown-item text-wrap text-dark" href="{{ route('admin.content_genre.index', ['title' => 'ジャンルトップ']) }}">ジャンルトップ</a></li>
                                                <li><a class="dropdown-item text-wrap text-dark" href="{{ route('admin.content_title.index', ['title' => 'タイトルトップ']) }}">タイトルトップ</a></li>
                                                <li><a class="dropdown-item text-wrap" href="#">カート内告知エリア管理</a></li>
                                            </ul>
                                        </li>
                                        <li><a class="pr-3 pl-3 bd-highlight text-dark border-bottom" href="{{ route('admin.freepage') }}"><span class="text-dark">フリーページ管理</span></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="top_nav">
                <div class="nav_menu text-white o-backColor__black">
                    <div class="nav toggle">
                        <a id="menu_toggle" style="padding-top: 10px;"><i class="fa fa-bars"></i></a>
                    </div>
                    <nav class="nav navbar-nav">
                        <ul class=" navbar-right align-items-center">
                            <li class="nav-item mr-sm-5 text-light">
                                <a class="text-light" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                                    ログアウト
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                            <li class="nav-item mr-sm-5 text-light">
                            </li>
                            <li class="nav-item mr-sm-5 text-light">
                                ユーザー状態:マスター権限
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
            <div class="right_col" role="main" style="min-height: 777px;">
                @yield('content')
            </div>
        </div>
        {{-- <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm navbar-fixed-top">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav align-items-center">
                    <li class="nav-item mr-sm-5 text-light">
                        ユーザー状態:マスター権限
                    </li>
                    <li class="nav-item mr-sm-5 text-light">
                        {{ Auth::guard($authgroup)->user()->name }}
                    </li>
                    <li class="nav-item mr-sm-5 text-light">
                        <a class="text-light" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                            ログアウト
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
        </nav> --}}

        {{-- <div class="row">
            <!-- サイドバーコンテンツ -->
            <div class="col-3">
                <div class="sidebar_fixed">
                    <div class="d-flex flex-column bd-highlight mb-3">
                        <a class="p-3 bd-highlight text-dark border-bottom" href="{{ action('AdminController@site_setting') }}">サイト基本設定</a>
                        <a class="p-3 bd-highlight text-dark border-bottom" href="{{ route('admin.management.list') }}">運営者管理</a>

                        <a href='#productMenuButton' class='nav-link border-bottom text-dark' data-toggle='collapse' data-target='#productMenuButton' aria-controls='productMenuButton' onclick="arrow_product()">
                            <span class="d-flex flex-row justify-content-between">
                                商品管理
                                <div class="arrow_u icon-right" id="product_u"></div>
                                <div class="arrow_o icon-right display-no" id="product_o"></div>
                            </span>
                        </a>
                        <div class="collapse list-unstyled text-dark" id="productMenuButton">
                            <a class="dropdown-item text-wrap" href="{{ route('admin.product_all.index') }}">商品一覧</a>
                            <a class="dropdown-item text-wrap" href="{{ route('admin.category.list') }}">商品カテゴリー一覧</a>
                            <a class="dropdown-item text-wrap" href="{{ route('admin.category.add') }}">商品カテゴリー登録</a>
                            <a class="dropdown-item text-wrap" href="{{ action('AdminController@product_class_info') }}">商品画像一括アップロード</a>
                        </div>

                        <a class="p-3 bd-highlight text-dark border-bottom" href="{{ action('AdminController@coupon') }}">クーポン除外設定</a>

                        <a href='#recommendMenuButton' class='nav-link border-bottom text-dark' data-toggle='collapse' data-target='#recommendMenuButton' aria-controls='recommendMenuButton' onclick="arrow_recommend()">
                            <span class="d-flex flex-row justify-content-between">
                                おすすめ・ランキング商品管理
                                <div class="arrow_u icon-right" id="recommend_u"></div>
                                <div class="arrow_o icon-right display-no" id="recommend_o"></div>
                            </span>
                        </a>
                        <div class="collapse list-unstyled text-dark" id="recommendMenuButton">
                            <a class="dropdown-item text-wrap" href="{{ action('AdminController@recommend', ['type' => '総合トップ']) }}">総合トップおすすめ商品管理</a>
                            <a class="dropdown-item text-wrap" href="{{ action('AdminController@recommend', ['type' => 'ジャンルトップ']) }}">ジャンルトップおすすめ商品管理</a>
                            <a class="dropdown-item text-wrap" href="{{ action('AdminController@recommend', ['type' => 'タイトルトップ']) }}">タイトルトップおすすめ商品管理</a>
                            <a class="dropdown-item text-wrap" href="{{ action('AdminController@recommend_data') }}">おすすめ商品データアップロード</a>
                            <a class="dropdown-item text-wrap" href="#">ランキング管理</a>
                        </div>

                        <a class="p-3 bd-highlight text-dark border-bottom" href="#">送料・手数料設定</a>

                        <a href='#mailMenuButton' class='nav-link border-bottom text-dark' data-toggle='collapse' data-target='#mailMenuButton' aria-controls='mailMenuButton' onclick="arrow_mail()">
                            <span class="d-flex flex-row justify-content-between">
                                メール設定管理
                                <div class="arrow_u icon-right" id="mail_u"></div>
                                <div class="arrow_o icon-right display-no" id="mail_o"></div>
                            </span>
                        </a>
                        <div class="collapse list-unstyled text-dark" id="mailMenuButton">
                            <a class="dropdown-item text-wrap" href="{{ action('AdminController@mail_template') }}">顧客メールテンプレート設定</a>
                        </div>

                        <a class="p-3 bd-highlight text-dark border-bottom" href="{{ action('AdminController@order_all') }}">受注管理</a>
                        <a class="p-3 bd-highlight text-dark border-bottom" href="{{ route('admin.reserve.index') }}">予約管理</a>
                        <a class="p-3 bd-highlight text-dark border-bottom" href="{{ route('admin.customer.list') }}">会員管理</a>
                        <a class="p-3 bd-highlight text-dark border-bottom" href="{{ route('admin.shipping.index') }}">出荷管理</a>
                        <a class="p-3 bd-highlight text-dark border-bottom" href="#">送料・手数料設定</a>

                        <a href='#couponMenuButton' class='nav-link border-bottom text-dark' data-toggle='collapse' data-target='#couponMenuButton' aria-controls='couponMenuButton' onclick="arrow_coupon()">
                            <span class="d-flex flex-row justify-content-between">
                                ポイント・クーポン管理
                                <div class="arrow_u icon-right" id="coupon_u"></div>
                                <div class="arrow_o icon-right display-no" id="coupon_o"></div>
                            </span>
                        </a>
                        <div class="collapse list-unstyled text-dark" id="couponMenuButton">
                            <a class="dropdown-item text-wrap" href="{{ action('AdminController@point_coupon') }}">共通クーポン</a>
                        </div>

                        <a href='#newsMenuButton' class='nav-link border-bottom text-dark' data-toggle='collapse' data-target='#newsMenuButton' aria-controls='newsMenuButton' onclick="arrow_news()">
                            <span class="d-flex flex-row justify-content-between">
                                お知らせ・バナー管理
                                <div class="arrow_u icon-right" id="news_u"></div>
                                <div class="arrow_o icon-right display-no" id="news_o"></div>
                            </span>
                        </a>
                        <div class="collapse list-unstyled text-dark" id="newsMenuButton">
                            <a class="dropdown-item text-wrap" href="{{ route('admin.information.list') }}">お知らせ管理</a>
                            <a class="dropdown-item text-wrap" href="{{ route('admin.slide.list') }}">スライダー管理</a>
                            <a class="dropdown-item text-wrap" href="{{ route('admin.pick_up.list') }}">ピックアップ特集管理</a>
                            <a class="dropdown-item text-wrap" href="#">カート内告知エリア管理</a>
                        </div>

                        <a href='#contentMenuButton' class='nav-link border-bottom text-dark' data-toggle='collapse' data-target='#contentMenuButton' aria-controls='contentMenuButton' onclick="arrow_content()">
                            <span class="d-flex flex-row justify-content-between">
                                コンテンツ管理
                                <div class="arrow_u icon-right" id="content_u"></div>
                                <div class="arrow_o icon-right display-no" id="content_o"></div>
                            </span>
                        </a>
                        <div class="collapse list-unstyled text-dark" id="contentMenuButton">
                            <a class="dropdown-item text-wrap" href="{{ route('admin.content_all.index', ['title' => '総合トップ']) }}">総合トップ</a>
                            <a class="dropdown-item text-wrap" href="{{ route('admin.content_genre.index', ['title' => 'ジャンルトップ']) }}">ジャンルトップ</a>
                            <a class="dropdown-item text-wrap" href="{{ route('admin.content_title.index', ['title' => 'タイトルトップ']) }}">タイトルトップ</a>
                        </div>
                        <a class="p-3 bd-highlight text-dark border-bottom" href="{{ route('admin.freepage') }}">フリーページ管理</a>
                    </div>
                </div>
            </div>
            <!-- メインコンテンツ -->
            <div class="col">
                @yield('content')
            </div>
        </div>
        <div id="footer" class="text-white bg-dark p-3 bd-highlight footer-top">
            <a href="#" class="text-white">管理画面トップへ</a>
        </div> --}}
        @else
        @endif
    </div>
    <!-- Gentelella js -->
    
    <script src="{{ asset('gentelella-master/vendors/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('gentelella-master/vendors/fastclick/lib/fastclick.js') }}"></script>
    <script src="{{ asset('gentelella-master/vendors/nprogress/nprogress.js') }}"></script>
    <script src="{{ asset('gentelella-master/vendors/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js') }}"></script>
    <script src="{{ asset('gentelella-master/build/js/custom.min.js') }}"></script>
</body>
</html>
