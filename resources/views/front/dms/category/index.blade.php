@php
use App\Models\PcmDmsCategory;

$documents = $category->documents;
@endphp
@extends('front.common.app', ['active' => 'list'])
@section('title')
{{ ucfirst($category->name ?? '') }}
@endsection
@section("content")
<section id="hero" class="d-flex align-items-center pt-0">
</section>
<section id="services" class="services pt-0">
    <div class="container containtsv">
        <div class="section-title text-center pb-0">
            <h2 class="section-main-title w-100">{{ $category->name }}</h2>
        </div>
        @if ($category->layout_type == PcmDmsCategory::LIST)
            <div>
                @foreach ($documents as $document)
                    <div class="row document-list">
                        <div class="col-md-3 center-div">
                            <div class="icon vaccination w-100 document-img">
                                <img src="{{ asset('storage/documents/' . ($document->thumb ?? '')) }}" height="100%" alt="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h5><a href="{{ route('home.document.detail', $document->id) }}">{{ $document->title }}</a></h5>
                            <p class="mb-2">{!! $document->short_description !!}</p>
                        </div>
                        <div class="col-md-3 center-div">
                            <a href="{{ route('checkout.payment', $document->id) }}" class="button-71"><i class="fa fa-shopping-cart pe-2"></i>{{ trans('home.buy_now') }}<strong> (${{ $document->renewal_price != 0 ? $document->renewal_price : $document->price }})</strong></a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
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
        @endif
    </div>
</section>
@endsection