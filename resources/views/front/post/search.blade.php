@php
use App\Models\PcmDmsCategory;
use App\Models\DtbPost;
@endphp
@extends('front.common.app', ['active' =>  'news'])
@section('title')
{{ trans('home.news') }}
@endsection
@section("content")
<section class="wrapper" style="margin-top: 80px;">
    <div class="container mt-5 mb-5 p-5 pt-3 border-bottom">
        <div class="post-list-container mt-2 row">
            <div class=" col-lg-8 col-md-7 col-12 pe-4">

                <div class="filter-nav">
                    <h2 class="title mb-2" style="color:#0DA0F2">
                        {{ trans('home.news') }}
                    </h2>
                    <form method="GET" action="">
                        <div class="filter-box row">
                            <div class="col-12 mb-3 position-relative">
                                <input class="form-control" name="title_{{ config('app.locale') }}" type="text" placeholder="Tìm kiếm" value="{{ $search_data['title_'.config('app.locale')] ?? '' }}">
                                <span class="search-icon" style="color: rgba(0, 0, 0, 0.438)"><i class="fas fa-search"></i></span>
                            </div>
                            <div class="col-4">
                                <label for="category_id" class="mb-2">{{ trans('home.category') }}</label>
                                <select name="category_id" class="form-control" id="category_id">
                                    <option value=''>{{ trans('home.all') }}</option>
                                    @foreach ($categories as $category)
                                    <option @if(isset($search_data['category_id']) && $category->id==$search_data['category_id']) {{ 'selected' }} @endif value="{{ $category->id }}">{{ $category['name_'.config('app.locale')] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-5 col-md-4">
                                <label for="featured" class="mb-2">{{ trans('home.type_post') }}</label>
                                <select name="featured" class="form-control" id="featured">
                                    <option value=''>{{ trans('home.all') }}</option>
                                    @foreach (DtbPost::FEATURED_LIST as $key => $value)
                                    <option @if(isset($search_data['featured']) && !is_null($search_data['featured']) && $key==$search_data['featured']) {{ 'selected' }} @endif value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-3 position-relative">
                                <button type="submit" class="btn btn-search">{{ trans('home.search') }}</button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="post-list">
                    @foreach ($search_results as $search_result)
                        @if((PcmDmsCategory::find($search_result->category_id)->name_en) != 'about us')
                        <hr>
                        <a href="{{ route('home.post.show', ['id'=>$search_result->id]) }}">
                            <div class="post row">
                                <div class="col-8 p-2">
                                    <h3 class="title-box">{{ $search_result['title_'.config('app.locale')] }} </h3>
                                    <p class="brief hidden3l">{{ $search_result['brief_'.config('app.locale')] }} </p>
                                </div>
                                <div class="col-4">
                                    <div class="pic"><img style="border-radius: 7px;width: 250px;height: 158px;object-fit: cover" src="{{ !empty($search_result->image) ? asset('storage/posts/'.$search_result->image) : asset('/css/icons/noimage.png') }}" class="img-fluid" alt=""></div>
                                </div>
                            </div>
                        </a>
                        @endif
                    @endforeach
                </div>
                <div class="d-flex mt-5 justify-content-center"> {{ $search_results->links() }} </div>
                @if($search_results->isEmpty())
                    <div class="text-center mt-5 mb-5" style="opacity:0.6;">{{ trans('home.no_result') }}</div>
                @endif
            </div>
            <div class="col-lg-4 col-md-5 col-12 ">
                @include('front.common.side-highlight-post')
            </div>
        </div>
    </div>
</section>
@endsection

