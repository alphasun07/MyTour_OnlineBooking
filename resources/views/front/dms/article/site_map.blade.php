@php
use Carbon\Carbon;
use App\Models\Article;
@endphp
@extends('front.common.app')
@section('title')
Site map
@endsection
@section('head')
<style type="text/css">
    .site-map ul {
        padding: 0;
        margin: 10px 0 10px 25px;
        list-style: disc;
    }

    .site-map ul li {
        background: url("{{ asset('images/treeview-default-line.gif')}}")  no-repeat 0 0;
        line-height: normal;
        list-style: none;
        margin: 0;
        padding: 0 0 22px 25px;
    }

    .site-map ul li:last-child {
        background-position: 0 -1766px;
    }

    .site-map ul li a {
        color: #07b;
    }

    .site-map ul li a:hover {
        text-decoration: underline;
    }
</style>
@endsection
@section("content")
<section id="hero" class="d-flex align-items-center pt-3" style="background: rgba(176, 208, 255, 0.1);">
</section>
<section id="services" class="services pt-0 site-map">
    <div class="container containtsv">
        <div class="section-title pb-0">
            <h2 class="section-main-title w-100">Main Menu</h2>
        </div>
        <ul>
            <li><a href="{{ route('front.home') }}">Home</a></li>
            @foreach ($categories as $category)
                @include('front.dms.category.sub_category', ['category' => $category])
            @endforeach
        </ul>

        <div class="section-title pb-0">
            <h2 class="section-main-title w-100">Top Menu</h2>
        </div>
        <ul>
            <li><a href="{{ route('download.list') }}">My Downloads</a></li>
            <li><a href="#">Support Tikkers</a></li>
            <li><a href="{{ route('home.article.detail', ['slug' => (new Article)->getSlugById(Article::CONTACT_US)]) }}"">Contact Us</a></li>
        </ul>

        <div class="section-title pb-0">
            <h2 class="section-main-title w-100">Support</h2>
        </div>
        <ul>
            <li><a href="#">FAQs</a></li>
            <li><a href="#">Forum</a></li>
            <li><a href="{{ route('home.article.detail', ['slug' => (new Article)->getSlugById(Article::CONTACT_US)]) }}">Contact Us</a></li>
            <li><a href="{{ route('home.article.detail', ['slug' => (new Article)->getSlugById(Article::SITE_MAP)]) }}">Site map</a></li>
            <li><a href="{{ route('home.article.detail', ['slug' => (new Article)->getSlugById(Article::TERMS_AND_CONDITIONS)]) }}">Terms and Conditions</a></li>
        </ul>
    </div>
</section>
@endsection