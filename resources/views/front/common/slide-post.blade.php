<div class="testimonials-slider swiper mt-4" data-aos="fade-up" data-aos-delay="100">
    <div class="swiper-wrapper swiper-wrapper2">
        @foreach ($slide_posts as $slide_post)
            <div class="swiper-slide">
                <div class="slide-card">
                    <a href="{{ route('home.post.show', $slide_post->id) }}">
                        <div class="w-100 d-flex justify-content-center align-items-center" style="height:257px">
                                    <img width="100%" height="fit-content" style="border-radius: 10px;height: 257px;max-width: 406px;object-fit: cover" src="{{ !empty($slide_post->image) ? asset('storage/posts/'.$slide_post->image) : asset('/css/icons/noimage.png') }}" class="testimonial-img img-fluid" alt="">
                        </div>
                        <h3>{{ $slide_post['title_'.config('app.locale')] ?? '' }}</h3>
                        <span><img src="/css/icons/calendar.png" alt="" class="me-1">{{ !empty($slide_post->created_at) ? date('d/m/Y', strtotime($slide_post->created_at)) : '--/--/----' }}</span>
                        <p class="hidden3l">
                            {{ $slide_post['brief_'.config('app.locale')] ?? '' }}
                        </p>
                    </a>
                </div>
            </div>
        @endforeach
    </div>
    <div class="swiper-pagination"></div>
</div>
