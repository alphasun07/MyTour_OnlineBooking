@php
use App\Models\PcmDmsCategory;
use App\Models\DtbTag;
use App\Models\DtbMember;
@endphp
@extends('front.common.app', ['active' => $active])
@section('title')
{{ ucfirst($post['title_'.config('app.locale')] ?? '') }}
@endsection
@section("content")
<section class="wrapper" style="margin-top: 80px;">
    <div class="container mb-5 p-5 border-bottom">
        <div class="row">
            <div class="main-content col-lg-9 col-md-7 col-12">
                <div class="d-flex justify-content-between mt-4">
                    <ol class="breadcrumb">
                        @foreach (array_reverse($list_parent_ids) as $parent)
                            <li class="breadcrumb-item"><a href="{{ route('home.post.list', $parent) }}" style="text-transform: capitalize;">{{ !empty($parent) ? ((new PcmDmsCategory())->find($parent))['name_'.config('app.locale')] : '' }}</a></li>
                        @endforeach
                        <li class="breadcrumb-item active" aria-current="page" style="text-transform: capitalize;"><a href="{{ route('home.post.list', $post->category_id) }}">{{ !empty($post->category_id) ? (PcmDmsCategory::find($post->category_id))['name_'.config('app.locale')] : '' }}</a></li>
                    </ol>
                    <div class="release-date">{{ !empty($post->created_at) ? date('d/m/Y', strtotime($post->created_at)) : '--/--/----' }}</div>
                </div>
                <div class="content-wrapper">
                    <h2 class="title">{{ $post['title_'.config('app.locale')] ?? '' }}</h2>
                    <div class="tag-wrapper d-flex justify-content-start">
                        @foreach ($post_tags as $post_tag)
                            <div class="pe-3 stext tag">#{{ !empty($post_tag->tag_id) ? (DtbTag::find($post_tag->tag_id))->name_vi : '' }}</div>
                        @endforeach
                    </div>
                    <div class="brief-wrapper stext w-auto" style="text-align: justify">
                        {{$post['brief_'.config('app.locale')] ?? ''}}
                    </div>
                    <div class="d-flex justify-content-center mb-5">
                        <img src="{{ !empty($post->image) ? asset('storage/posts/'.$post->image) : '' }}" width='85%' alt="">
                    </div>
                    <div class="post-content" style="text-align: justify">
                        @php echo $post['content_'.config('app.locale')] ?? ''@endphp
                    </div>
                    <div class="signature-box d-flex flex-row-reverse me-5 fs-3">
                        <span><strong style="text-transform: uppercase;">{{ $post->user_id ? DtbMember::getMember($post->user_id)->name : '' }}</strong></span>
                    </div>
                </div>
            </div>
            <div class="mt-5 col-lg-3 col-md-5 col-12 position-relative">
                @include('front.common.side-highlight-post')
            </div>
        </div>
    </div>
    <div class="container mt-5">
        <div class="title-box">
            <a href="{{ URL::route('home.post.search') . '?category_id=' . $post->category_id }}">{{ trans('home.related') }}</a>
        </div>
        @include('front.common.slide-post', $slide_posts)
    </div>
</section>
@endsection

