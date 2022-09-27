@php
use App\Models\PcmDmsCategory;
@endphp
@extends('front.common.app', ['active' =>  $active])
@section('title')
{{ ucfirst($category->name ?? '') }}
@endsection
@section("content")
<section class="wrapper" style="margin-top: 80px;">
    <div class="container mb-5 p-5 pt-3 border-bottom">
        <div class="post-list-container mt-5 row">
            <div class="col-lg-8 col-md-7 col-12 pe-4">
                <div class="section-title d-flex text-center justify-content-center">
                    <h2 class="section-main-title">
                        {{ $category['name_'.config('app.locale')] ?? '' }}
                        <span class="underline"></span>
                    </h2>
                </div>
                @foreach ($list_childs as $child)
                <a href="{{ route('home.post.list', $child->id ?? '') }}" class="row mb-5 category_reverse">
                    <div class="col-lg-3 col-md-3 col-sm-2 d-flex align-items-stretch p-4 border rounded-3 service_icon_border_none" >
                        <div class="icon-box w-100">
                            <div class="icon vaccination text-center service_icon" >
                                <img src="{{ !empty($child->icon) ? asset('storage/categories/'.$child->icon) : asset('/css/icons/noimage.png') }}" width="100%" height="100%" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8 col-md-9 col-sm-10 d-flex flex-column align-items-stretch p-4 border shadow mx-4 border border-secondary service_text">
                        <h4>{{ ucfirst($child['name_'.config('app.locale')] ?? '') }}</h4>
                        <p>{{ $child['description_'.config('app.locale')] ?? '' }}</p>
                    </div>
                </a>
                @endforeach
                {{ $list_childs->links() }}
            </div>
            <div class="col-lg-4 col-md-5 col-12 ">
                @include('front.common.side-highlight-post')
            </div>
        </div>
    </div>
</section>
@endsection
