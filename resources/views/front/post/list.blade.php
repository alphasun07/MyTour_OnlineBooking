@php
use Carbon\Carbon;
$now = Carbon::now();
@endphp
@extends('front.common.app')
@section("content")
<main>
    <div class="mr-auto ml-auto" style="max-width: 1300px">
        <br>
        <br>

        <div class="card-deck">
            @foreach ($tours as $t)
                <div class="card uu-dai taks">
                <div class="h-card-container">
                    <a href="{{ route('home.tour.show', ['id' => $t->id]) }}">
                    <img src="{{ asset('storage/tours/' . $t->thumbnail ?? '') }}" class="card-img-top h-latest-tour-image" alt="...">
                    </a>
                    <div class="h-card-rank">{{ $t->sth ?? ''}}</div>
                </div>
                <div class="card-body">
                    <p class="card-text mb-1"><small class="text-muted">{{ $t->tour_time ?? 5 }} ngày</small></p>
                    <a href="{{ route('home.tour.show', ['id' => $t->id]) }}"><h5 class="card-title pr-2 mb-1" style="color: #282365; font-size: medium;">{{ $t->name ?? '' }}</h5></a>
                    <p class="card-text"><b style="font-size: large; color:#FD5056;">{{number_format(($t->price_per_person ?? 0), 0, "", ",")}}đ</b><small class="text-muted">/người</small></p>
                    <a href="{{ route('home.tour.book', ['id' => $t->id]) }}" class="btn btn-danger" style="font-size: small; background-color: #D74449;"><i
                        class="fas fa-shopping-cart"></i>&#160;Đặt ngay</a>
                    <a href="{{ route('home.tour.show', ['id' => $t->id]) }}" class="btn btn-light" style="font-size: small; background-color: #ffffff; float: right; border: 1px solid #2f24a7; color: #2f24a7;">Xem chi tiết</a>
                </div>
                </div>
            @endforeach
        </div>
        <div class="d-flex justify-content-center">{{$tours->links()}}</div>
    </div>
</main>
@endsection

