@php
use Carbon\Carbon;
$now = Carbon::now();
@endphp
@extends('front.common.app')
@section("content")

<div class="mr-auto ml-auto" style="max-width: 1300px">
<div class="col-12 mt-2">
    <small class="text-muted"><a href="#" style="color: #282365;"><u>Du lịch</u></a><small><i class="fas fa-chevron-right ml-3 mr-3"></i></small><a href="#" style="color: #282365;"><u>Đặt tour trong nước</u></a></small>
</div>
<hr>

<div class="col-12 mt-2">
    <span href="#" style="color:#4D4AEF; font-weight: 500;">1. Nhập thông tin</span><!--<i class="fas fa-chevron-right ml-3 mr-3"></i><span href="#" style="color: #282365; font-weight: 500;">2. Thanh toán</span> !-->
</div>
<hr>

<div class="card mb-3" style="max-width: 1300px;"">
        <div class="row no-gutters" style="background-color: #F9F9F9;">
          <div class="col-lg-3 col-12">
            <a href="#"><img src="{{ asset('storage/tours/' . $tour->thumbnail) }}" class="card-img" alt="..." style="border-radius: 10px 0 0 10px;"></a>
          </div>
          <div class="col-lg-9 col-12">
            <div class="card-body">
              <p class="card-text" style="font-weight: 500; font-size: large;">Rất tốt<small class="text-muted ml-2">&#160;&#160;|&#160;&#160;Lượt đi <span class="text-nomute" style="font-weight: 500; color: #282365;">{{ $tour->count_order ?? '' }} lượt</span></small></p>
              <h5 class="card-title pr-2 mb-1" style="color: #282365; font-size:x-large;">{{ $tour->name ?? '' }}</h5>
              <p class="card-text mb-0"><small class="text-muted">Khởi hành <span class="ml-1" style="color: #282365; font-weight: 500;">{{ $now->addDay(7)->format('d/n/Y') }}</span></small></p>
              <p class="card-text mb-0"><small class="text-muted">Thời gian <span class="ml-1" style="color: #282365; font-weight: 500;">{{ $tour->tour_time ?? ''}} ngày</span></small></p>
              <p class="card-text mb-0"><small class="text-muted">Nơi khởi hành  <span class="ml-1" style="color: #282365; font-weight: 500;">{{ ($places[0])->name ?? ''}}</span></small></p>
            </div>
          </div>
          </div>
        </div>
  </div>
  <!-- card thanh toán -->
  <div class="col d-flex justify-content-center">
    <div class="card" style="width: 30rem;">
        <div class="card-body justify-content-center">
          <h5 class="card-title" style="color: #282365;">Đặt tour</h5>
              <p class="card-text mb-2"><span class="ml-1" style="color: #282365; font-weight: 500; font-size: normal;">Tour {{ $tour->category_id ?? ''}}</span></p>
              <img src="{{ asset('storage/tours/' . ($tour->thumbnail ?? '')) }}" alt="..." class="img-thumbnail mr-2" style="width:25%; border: none; border-radius: 10px; float: left;">
              <p class="card-text mr-4" style="color: #282365; font-weight: 500;">{{ $tour->name ?? '' }}</p>
              <br>
              <br>
              <p class="card-text mb-4"><span class="ml-1" style="color: #282365; font-weight: 500; font-size: normal; float: left;">Hành khách</span></p>
              <div class="form-group">
                <form name="checkout_form" method="get" action="{{ route('home.tour.checkout.show', ['id' => $tour->id]) }}">
                    @csrf
                    <input class="form-control" value="1" onKeyDown="return false" type="number" name="order_number" min="1" max="{{ $tour->max_person ?? 5 }}">
                </form>
              </div>
        <br>
        <br><br><br>
            <p class="card-text mb-0"><span class="ml-1" style="color: #282365; font-weight: 500; font-size: normal; float: left;">Giá vé</span></p>
            <p class="card-text mb-4">
            <span class="ml-1" style="color: #282365; font-weight: 500; font-size: normal; float: right;">&#160;x&#160;{{ number_format(($tour->price_per_person ?? 0), 0, "", ",") }}₫</span>
            <span id = "price" price="{{ $tour->price_per_person ?? '' }}" class="ml-1" style="color: #282365; font-weight: 500; font-size: normal; float: right;">1</span>
            </p>

            <br><br><br><hr>
            <p class="card-text mb-0"><span class="ml-1" style="color: #282365; font-weight: 500; font-size: normal; float: left;">TỔNG CỘNG</span></p>
            <p class="card-text mb-4"><span id="totalPrice" class="ml-1" style="color: #FD5056; font-weight: 500; font-size: x-large; float: right;">{{ number_format(($tour->price_per_person ?? 0), 0, "", ",") }}đ</span></p>
            <br><br><br>
            <button onclick="submitcheckout()" id="order_now" tour_id="{{ $tour->id}}"
            type="button" class="btn btn-danger col d-flex justify-content-center p-3" style="background-color: #FD5056; font-size:large; font-weight: 500; border-radius: 10px;">ĐẶT NGAY</button>

        </div>
      </div>
  </div>
@endsection
@section('scripts')
<script>
    $(document).ready(function(){
        $("[name='order_number']").on('change', function(){
            $('#price').html($("[name='order_number']").val());
            $('#totalPrice').html(parseFloat($("[name='order_number']").val() * {{ $tour->price_per_person }}).toLocaleString(window.document.documentElement.lang) + 'đ');
        })
    })

    function submitcheckout(){
        $('[name = "checkout_form"]').submit()
    }
</script>
@endsection

