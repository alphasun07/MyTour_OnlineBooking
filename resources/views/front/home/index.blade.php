@php
use App\Models\DtbRegisterInformation;
@endphp
@extends('front.common.app', ['active' => 'index'])
@section("content")
<section id="hero" class="d-flex align-items-center pt-0">
    <img height="500px" src="{{asset('images/slide/eshop.png')}}" alt="Los Angeles" class="d-block w-100">
</section>

<section id="services" class="services pt-0">
    <div class="container containtsv">
        <div class="section-title text-center">
            <h2 class="section-main-title w-100">{{ trans('home.documents') }}</h2>
            <div class="title-detail">
                <strong>PCMDonation</strong> is the top Laravel extension and services company. Over 10 years working with Laravel, we have developed many great Laravel extension. Below are the best our Laravel extensions which were recognized by thousands of Laravel! users.
            </div>
        </div>
        <div class="row d-flex justify-content-between">
            @foreach ($documents as $document)
            <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4 document-box">
                <div class="icon-box w-100">
                    <div class="icon vaccination w-100 document-img">
                        <img src="{{ asset('storage/documents/' . ($document->thumb ?? '')) }}" height="100%" alt="">
                    </div>
                    <h4 class="text-center"><a href="{{ route('home.document.detail', $document->id) }}">{{ $document->title }}</a></h4>
                    <p class="hidden3l text-center">{!! $document->short_description !!}</p>
                    <div class="row btn-list">
                        <div class="col-9 text-center">
                            <a href="{{ route('checkout.payment', $document->id) }}" class="w-100"><i class="fa fa-shopping-cart pe-2"></i>{{ trans('home.buy_now') }}<strong> (${{ $document->renewal_price != 0 ? $document->renewal_price : $document->price }})</strong></a>
                        </div>
                        <div class="col-3 text-center">
                            <a href="{{ route('home.document.detail', $document->id) }}" class="w-100"><i class="fa fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

@endsection