@php
use Carbon\Carbon;
use App\Models\PcmDmsDocument;
@endphp
@extends('front.common.app')
@section('title')
Terms condition
@endsection
@section("content")
<section id="hero" class="d-flex align-items-center pt-3" style="background: rgba(176, 208, 255, 0.1);">
</section>
<section id="services" class="services pt-0">
    <div class="container containtsv">
        <div class="section-title text-center pb-0">
            <h2 class="section-main-title w-100">{{ $page->title }}</h2>
        </div>
        <div>{!! $page->description !!}</div>
    </div>
</section>
@endsection