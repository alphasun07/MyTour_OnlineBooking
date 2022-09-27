@php
use App\Models\PcmDmsCategory;
use App\Models\Option;

$categories = (new PcmDmsCategory())->getListCategoryShowOnMenu();
@endphp
<header id="header" class="fixed-top header-scrolled" style="height: fit-content;">
    <div class="container d-flex align-items-center">
      <a href="{{ route('front.home') }}" class="logo me-auto">
          <div class="row" style="width: 132%">
            <div class="col-3 ">
                {{-- <img  height="100%" width="55.74" style="border-radius: 50%;-moz-border-radius:50%;-webkit-border-radius: 50%;" src="{{ asset('storage/setting/' . (new Option)->getValueOptionTable('site_logo')->value ?? '') }}"> --}}
            </div>
            <img src="{{asset('images/pcmdonationlogo.png')}}" alt="Los Angeles" class="d-block w-100">
          </div>
      </a>
      <nav id="navbar" class="navbar order-last order-lg-0">
        <ul class="menu-nav">
          <li class="{{ Route::getCurrentRoute()->category_id == '' ? 'active' : '' }}"><a class="nav-link scrollto" href="{{ route('front.home') }}">{{ trans('home.home') }}</a></li>
          @foreach ($categories as $category)
            <li class="{{ Route::getCurrentRoute()->category_id == $category->id ? 'active' : '' }} dropdown">
              <a class="nav-link scrollto" href="{{ route('home.category.show', $category->id) }}">
                {{ $category->name }}
                <i class="bi bi-chevron-down"></i>
              </a>
              <ul>
                <li class='dropdown'>
                  ooo
                  <i class="bi bi-chevron-right"></i>
                  <ul>
                    <li>111</li>
                    <li>222</li>
                    <li>333</li>
                  </ul>
                </li>
                <li>ppp</li>
                <li>qqq</li>
              </ul>
            </li>
          @endforeach
          @if (!Auth::check())
          <li class="d-lg-none d-flex">
            <a href="{{ route('user.showRegisterForm') }}"><span>{{ trans('home.register') }}</span></a>
          </li>
          <li class="d-lg-none d-flex">
            <a href="{{ route('user.showLoginForm') }}"><span>{{ trans('home.login') }}</span></a>
          </li>
          @else
          <li class="d-lg-none d-flex">
            <a href="" ><span
            onclick="event.preventDefault();document.getElementById('logout-form').submit();">{{ trans('home.logout') }}</span></a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
              @csrf
            </form>
          </li>
          <li class="d-lg-none d-flex">
            <a href="{{ route('home.profile.show', auth('web')->id() ?? '' ) }}"><span><i class="fa fa-user" aria-hidden="true"></i> {{ Auth::User()->name }}</span></a>
          </li>
          @endif
        </ul>
        <i class="bi mobile-nav-toggle bi-list"></i>
      </nav><!-- .navbar -->
      @if (!Auth::check())
        <a style="border-radius: 100px; margin-left: auto;color:#0DA0F2;border-color: #0DA0F2;overflow: hidden;text-overflow: ellipsis;max-height: 38px" href="{{ route('user.showRegisterForm') }}" class="d-none d-md-inline btn btn-outline-primary register"><span>Login / Register</span></a>
      @else
        <a style="border-radius: 100px; margin-left: auto;color:#0DA0F2;border-color: #0DA0F2;overflow: hidden;text-overflow: ellipsis;max-height: 38px" href="" class="btn btn-outline-primary d-none d-md-inline"><span
        onclick="event.preventDefault();document.getElementById('logout-form').submit();"> {{ trans('home.logout') }}</span></a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
          @csrf
        </form>
        <a href="{{ route('home.profile.show', auth('web')->id() ?? '' ) }}" class="appointment-btn scrollto d-none d-md-inline" style="max-width: 170px;overflow: hidden;text-overflow: ellipsis;"><span><i class="fa fa-user" aria-hidden="true"></i> {{ Auth::User()->name }}</span></a>
      @endif

    </div>
  </header>


