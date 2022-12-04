@php
use Carbon\Carbon;
$now = Carbon::now();
@endphp
@extends('front.common.app_login')
@section("content")
<main role="main">
    <div class="tour-detail">
        <div class="entry-head">

            <section class="section-01">
                <div class="container-xl">
                    <div class="row">
                        <div class="col-md-6 col-12 left">
                            <div class="warp-mark">
                                <i class="fal fa-ticket"></i><label>{{ $tour->id . '_' . $tour->tour_time . '_' . $tour->price_per_person . '_' . $tour->status . '_' . $tour->featured }}</label>
                            </div>
                            <h1 class="title">{{$tour->name ?? '' }}</h1>
                            <div class="short-rating">
                                <div class="s-rate">
                                    <span>9.08</span>
                                    <div class="s-comment">
                                        <h4>Tuyệt vời</h4>
                                        <p>379 nhận xét</p>
                                    </div>
                                </div>
                                <div class="s-wishlist">
                                    <i class="fas fa-heart"></i><label>126</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-12 right">
                            <div class="group-price">
                                <div class="sale-price">
                                    <p><span class="price">{{ number_format(($tour->price_per_person ?? 0), 0, "", ",") }}₫</span>/ khách</p>
                                </div>
                                <div class="saving">
                                </div>
                            </div>
                            <div class="group-add-cart">
                                <a href="{{ route('home.tour.book', ['id' => $tour->id]) }}"
                                    class="add-to-cart">
                                    <i class="fal fa-shopping-cart"></i>
                                    <label>
                                        Đặt ngay
                                    </label>
                                </a>
                                <a href="#" class="add-to-group" data-bs-toggle="modal" data-bs-target="#supportModal">
                                    <label>Liên hệ tư vấn</label>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>


            <section class="section-02">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-7 col-md-12 col-sm-12 left">
                            <div class="image">
                                <img src={{ asset('storage/tours/' . $tour->thumbnail)}}
                                    class="img-fluid" alt="image">
                            </div>
                        </div>
                    </div>
                </div>
            </section>

        </div>
        <div class="tab-panels">
            <div class="overview active">

                <section class="section-03 mb-5">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-5 col-12 left">
                                <p class="s-title-03 tour-des"><?php echo $tour->description ?></p>
                                <div class="box-code d-lg-none">
                                    <div class="d-flex flex-column">
                                        <span>Mã tour:</span>
                                        <span class="fw-bold">{{ $tour->id . '_' . $tour->tour_time . '_' . $tour->price_per_person . '_' . $tour->status . '_' . $tour->featured }}</span>
                                    </div>
                                    <i class="icon icon--ticket"></i>
                                </div>
                                <div class="box-order">
                                    <div class="time">
                                        <p>Khởi hành <b>{{ $now->addDay(7)->format('d/n/Y') }}</b></p>
                                        <p>Thời gian <b>{{ $tour->tour_time ?? '' }}</b></p>
                                        {{ ($places[0])->name ?? '' }}
                                    </div>
                                </div>
                                <div class="box-support">
                                    <label>Quý khách cần hỗ trợ?</label>
                                    <div class="group-contact">
                                        <a href="https://webcall.talking.vn/frame-click-to-call/new?code=tCEZl1-MKPuA6JU-czVAScCb0pPkHmPt"
                                            onclick="javascript:window.open(this.href,'targetWindow','toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no,width=375,height=667');return false;"
                                            target="_blank" class="phone">
                                            <i class="icon icon--phone"></i>
                                            <p>Gọi miễn phí <br>qua internet</p>
                                        </a>
                                        <a href="mailto:info@vietravel.com" class="mail">
                                            <i class="icon icon--mail"></i>
                                            <p>Gửi yêu cầu <br>hỗ trợ ngay</p>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-7 col-12 right">
                                <div class="group-services">
                                    <div class="item">
                                        <i class="icon icon--calendar"></i>
                                        <label>Thời gian</label>
                                        <p>{{ $tour->tour_time ?? ''}} ngày</p>
                                    </div>
                                    <div class="item">
                                        <i class="icon icon--map"></i>
                                        <label>Điểm tham quan</label>
                                        <p>@foreach ($places as $place)
                                            {{ $place->name ?? '' }}
                                            <br>
                                        @endforeach</p>
                                    </div>
                                    <div class="item">
                                        <i class="icon icon--fire"></i>
                                        <label>Ẩm thực</label>
                                        <p></p>
                                    </div>
                                    <div class="item">
                                        <i class="icon icon--hotel"></i>
                                        <label>Khách sạn</label>
                                        <p></p>
                                    </div>
                                    <div class="item">
                                        <i class="icon icon--tour"></i>
                                        <label>Phương tiện di chuyển</label>
                                        <p></p>
                                    </div>
                                    <div class="item">
                                        <i class="icon icon--sparkle"></i>
                                        <label>Dịch vụ đi kèm</label>
                                        <p>@foreach ($tour->services as $service)
                                            {{ $service->name ?? '' }}
                                            <br>
                                        @endforeach</p>
                                    </div>
                                </div>
                                <div class="box-map hardCode d-none">
                                    <div class="addess">
                                        <i class="icon icon--location-marker"></i>
                                        <label>VinWonder, Đ. Phú Quốc, Việt Nam</label>
                                    </div>
                                    <div class="map">
                                        <i class="icon icon--map"></i>
                                        <label>VinWonder, Đ. Phú Quốc, Việt Nam</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>






            </div>
            <div class="map-route">

                <section class="section-06 mb-5">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12 col-12">
                                <h2 class="mb-4">Lịch trình:
                                    @foreach ($places as $place)
                                        {{ $place->name ?? '' }} @if(!$loop->last) -> @endif
                                    @endforeach
                                </h2>
                            </div>
                        </div>
                    </div>
                </section>

            </div>
            <div class="note-info">


            </div>
            <div class="customer-comments">


            </div>
        </div>
    </div>

    <div class="modal fade" id="supportModal" tabindex="-1" aria-labelledby="supportModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <form id="form-support" action="/Comment/TuVan" method="post"><input name="__RequestVerificationToken"
                    type="hidden"
                    value="lSRz8uG-Iaj_dt9QH37I1LeHQAuye9noferAuQyC2BMQ9DbARUIYY5vs9v0LsEqjeEkRCEtfvJR12GVfef78h7mE3-GxvdZC2j8-tJa749A1">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">GỬI THÔNG TIN TƯ VẤN</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>
                            Quý khách vui lòng nhập thông tin bên dưới, Vietravel sẽ liên hệ
                            lại sau ít phút
                        </p>
                        <div class="row g-3">
                            <div class="col-12">
                                <label for="name" class="form-label">Họ tên<span class="required-star">*</span></label>
                                <input type="text" class="form-control" id="name"
                                    placeholder="Nhập họ tên của Quý khách" value="" name="Fullname" required="">
                            </div>
                            <div class="col-12">
                                <label for="phone" class="form-label">Điện thoại<span
                                        class="required-star">*</span></label>
                                <input type="text" class="form-control" id="phone" placeholder="Nhập số điện thoại"
                                    value="" name="Telephone" required="">
                            </div>
                            <div class="col-12">
                                <label for="email" class="form-label">Email<span class="required-star">*</span></label>
                                <input type="email" class="form-control" id="email" placeholder="you@example.com"
                                    name="Email" required="">
                            </div>
                            <div class="col-12">
                                <label for="note" class="form-label">
                                    Thông tin cần tư vấn
                                </label>
                                <textarea id="note" rows="3" class="form-control" name="NoiDung"
                                    placeholder="Quý khách cần tư vấn về vấn đề gì" required=""></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Gửi đi</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</main>
@endsection

