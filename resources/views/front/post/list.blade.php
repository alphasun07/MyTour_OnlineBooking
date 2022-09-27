@php
use App\Models\PcmDmsCategory;
@endphp
@extends('front.common.app', ['active' =>  $active])
@section('title')
{{ ucfirst($category->name ?? '') }}
@endsection
@section("content")
<section class="wrapper" style="margin-top: 80px;">
    <div class="container mt-5 mb-5 p-5 pt-3 border-bottom">
        <div class="category-nav">
            @foreach ($list_categories as $list_category)
                <div class="d-flex flex-row border-bottom cate">
                    @foreach ($list_category as $child)
                        <a href="{{ route('home.post.list', $child) }}" class="hidden3l cate-item {{ (in_array($child, $list_parent_ids) || $child == $category->id) ? 'active' : '' }}">{{ ucfirst((PcmDmsCategory::find($child))['name_'.config('app.locale')]) }}</a>
                    @endforeach
                </div>
            @endforeach
        </div>
        <div class="post-list-container mt-5 row">
            <div class=" col-lg-8 col-md-7 col-12 pe-4">
                @if (is_null($highlight_post_by_category) && $posts_by_category->isEmpty())
                    <div class="text-center mt-5 mb-5" style="opacity:0.6;">{{ trans('home.no_result') }}</div>
                @else
                    @if (!is_null($highlight_post_by_category))
                        <a href="{{ route('home.post.show', $highlight_post_by_category->id) }}">
                            <div class="highlight row">
                                <div class="pic col-md-7 col-5 d-flex d-md-block justify-content-center align-items-center"><img src="{{ !empty($highlight_post_by_category->image) ? asset('storage/posts/'.$highlight_post_by_category->image) : asset('/css/icons/noimage.png') }}" width="100%" class="img-fluid" alt=""></div>
                                <div class="col-md-5 col-7">
                                    <div class="text pt-4">
                                        <h3 class="title-box">{{ $highlight_post_by_category['title_'.config('app.locale')] ?? '' }}</h3>
                                        <p class="brief hidden3l">{{ $highlight_post_by_category['brief_'.config('app.locale')] ?? '' }}</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endif
                    <div class="post-list">
                        @foreach ($posts_by_category as $post)
                            @if (!is_null($highlight_post_by_category) && $post->id == $highlight_post_by_category->id)
                                @continue
                            @endif
                            <hr>
                            <a href="{{ route('home.post.show', ['id' => $post->id]) }}">
                                <div class="post row">
                                    <div class="col-8 p-2">
                                        <h3 class="title-box">{{ $post['title_'.config('app.locale')] ?? '' }}</h3>
                                        <p class="brief hidden3l">{{ $post['brief_'.config('app.locale')] ?? '' }}</p>
                                    </div>
                                    <div class="col-4">
                                        <div class="pic"><img src="{{ !empty($post->image) ? asset('storage/posts/'.$post->image) : asset('/css/icons/noimage.png') }}" class="img-fluid" alt=""></div>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                    <div class="d-flex mt-5 justify-content-center">{{ $posts_by_category->links() }}</div>
                @endif
            </div>
            <div class="col-lg-4 col-md-5 col-12 ">
                @include('front.common.side-highlight-post')
            </div>
        </div>
    </div>
</section>
@endsection

