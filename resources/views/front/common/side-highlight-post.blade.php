@php
    use App\Models\DtbPost;
    use App\Models\PcmDmsCategory;
@endphp
<div class="highlight-post p-4 ms-4">
    <div class="title-box mb-3"><a href="{{ URL::route('home.post.search') . '?featured=0' }}">{{ trans('home.highlight_news') }}</a></div>
    @foreach ((DtbPost::getHighlightPosts()) as $highlight_post)
        @if((PcmDmsCategory::find($highlight_post->category_id)->name_en) != 'about us')
        <a href="{{ route('home.post.show', $highlight_post->id) }}">
            <div class="side-highlight-news">
                <div class="w-100 d-flex justify-content-center overflow-hidden rounded mb-2">
                    <img style="max-height: 252px; object-fit: cover;" src="{{ !empty($highlight_post->image) ? asset('storage/posts/'.$highlight_post->image) : asset('/css/icons/noimage.png') }}" class="testimonial-img" width="100%" alt="">
                </div>
                <h5>{{ $highlight_post['title_'.config('app.locale')] ?? '' }}</h5>
                <span><img src="/css/icons/calendar.png" alt="" class="me-1">{{ !empty($highlight_post->created_at) ? date('d/m/Y', strtotime($highlight_post->created_at)) : '--/--/----' }}</span>
                <p class="hidden3l">
                    {{ $highlight_post['brief_'.config('app.locale')] ?? '' }}
                </p>
            </div>
        </a>
        @endif
        <hr>
    @endforeach
</div>
