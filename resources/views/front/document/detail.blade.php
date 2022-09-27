@php
use App\Helpers\Helper;
@endphp
@extends('front.common.app', ['active' => 'detail'])
@section('title')
{{ $document->title ?? 'PCM Donation' }}
@endsection
@section("content")
<section id="hero" class="pt-0 document-detail">
    <div class="container mw-100">
        <div class="row container">
            <div class="col-lg-3 col-md-5 col-sm-12 col-xs-12 document-image">
                <img src="{{ asset('storage/documents/' . ($document->thumb ?? '')) }}" alt="Chicago" class="d-block w-100" height="auto">
            </div>
            <div class="col-lg-9 col-md-7 col-sm-12 col-xs-12 document-description">
                <div>
                    <h4>{{ $document->title }}</h4>
                    <div class="description">
                        {!! $document->description !!}
                    </div>
                    <div class="d-flex justify-content-start">
                        <a href="{{ route('checkout.payment', $document->id) }}" class="button-71"><i class="fa fa-shopping-cart pe-2"></i>{{ trans('home.buy_now') }}<strong> (${{ $document->renewal_price != 0 ? $document->renewal_price : $document->price }})</strong></a>
                        @if ($document->demo_url)
                        <a style="margin-left:20px"href="{{ $document->demo_url }}" target="_blank" class="button-72"><i class="fa fa-eye pe-2"></i>Demo</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@if(Helper::isShowTabData($document))
<section class="wrapper pt-2">
    <div class="container mb-5 pt-3">
        <div class="category-nav border-bottom">
            <div class="d-flex flex-row cate justify-content-center">
                @if($document->tab_1_title != '')
                <div class="hidden3l cate-item active" data-id="1">{{ $document->tab_1_title }}</div>
                @endif
                @if($document->tab_2_title != '')
                <div class="hidden3l cate-item" data-id="2">{{ $document->tab_2_title }}</div>
                @endif
                @if($document->tab_3_title != '')
                <div class="hidden3l cate-item" data-id="3">{{ $document->tab_3_title }}</div>
                @endif
                @if($document->tab_4_title != '')
                <div class="hidden3l cate-item" data-id="4">{{ $document->tab_4_title }}</div>
                @endif
                @if(!empty($document->tab_5_title))
                <div class="hidden3l cate-item" data-id="5">{{ $document->tab_5_title }}</div>
                @endif
            </div>
        </div>
        <div class="document-tab-content mt-3">
            @if($document->tab_1_title != '')
            <div id="tab-content-1" class="tab-content">
                {!! $document->tab_1_data !!}
            </div>
            @endif
            @if($document->tab_2_title != '')
            <div id="tab-content-2" class="tab-content d-none">
                {!! $document->tab_2_data !!}
            </div>
            @endif
            @if($document->tab_3_title != '')
            <div id="tab-content-3" class="tab-content d-none">
                {!! $document->tab_3_data !!}
            </div>
            @endif
            @if($document->tab_4_title != '')
            <div id="tab-content-4" class="tab-content d-none">
                {!! $document->tab_4_data !!}
            </div>
            @endif
            @if($document->tab_5_title != '')
            <div id="tab-content-5" class="tab-content d-none">
                {!! $document->tab_5_data !!}
            </div>
            @endif
        </div>
    </div>
</section>
@endif
@endsection

@section('scripts')
<script type="text/javascript">
    $(document).ready(function() {
        $('.cate-item').on('click', function() {
            var tabId = $(this).data('id');
            $('.cate-item').removeClass('active');
            $(this).addClass('active');
            $('.tab-content').addClass('d-none');
            $('#tab-content-' + tabId).removeClass('d-none');
        })
    })
</script>
@endsection
