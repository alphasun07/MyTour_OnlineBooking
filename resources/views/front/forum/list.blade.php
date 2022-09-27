@php
use App\Models\User;
use App\Models\DtbQuestion;
use App\Models\PcmDmsCategory;
use Carbon\Carbon;
use Illuminate\Support\Facades\URL as FacadesURL;
Carbon::setLocale(config('app.locale'));
@endphp
@extends('front.common.app', ['active' => 'forum', 'page' => 'forum'])
@section("content")
<section class="wrapper" style="margin-top: 80px;">
    <div class="container mt-3 mb-5 p-5 pt-3 border-bottom">
        <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet">
        <div class="row">
            <!-- Main content -->
            <div class="col-lg-9 mb-3">
                <form action="" method="get" id="forum_filter" class="row text-left mb-5">
                    <div class="col-lg-4 mb-3 mb-sm-0">
                        <div class="border-0 dropdown bootstrap-select form-control form-control-lg bg-white bg-op-9 text-sm w-lg-50" style="width: 100%;">
                            <select onchange="document.getElementById('forum_filter').submit()" name="category_id" class="form-control form-control-lg bg-white bg-op-9 text-sm w-lg-50 filter-selector" data-toggle="select" tabindex="-98">
                                <option value=""> {{ trans('home.category') }} </option>
                                @foreach ($categories as $category)
                                <option value="{{ $category->id ?? '' }}" {{ isset($filter_data['category_id']) && $filter_data['category_id']==$category->id ? 'selected' : '' }}> {{ ucfirst($category['name_'.config('app.locale')] ?? '') }} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-4 text-lg-right">
                        <div class="border-0 dropdown bootstrap-select form-control form-control-lg bg-white bg-op-9 ml-auto text-sm w-lg-50" style="width: 100%;">
                            <select name="by" onchange="document.getElementById('forum_filter').submit()" class="form-control form-control-lg bg-white bg-op-9 ml-auto text-sm w-lg-50 filter-selector" data-toggle="select" tabindex="-98">
                                <option value="" {{ isset($filter_data['by']) && $filter_data['by']=='' ? 'selected' : '' }}> {{ trans('home.sort_by') }} </option>
                                <option value="votes_count" {{ isset($filter_data['by']) && $filter_data['by']=='votes_count' ? 'selected' : '' }}> {{ trans('home.votes') }} </option>
                                <option value="ans_count" {{ isset($filter_data['by']) && $filter_data['by']=='ans_count' ? 'selected' : '' }}> {{ trans('home.replies') }} </option>
                                <option value="views_count" {{ isset($filter_data['by']) && $filter_data['by']=='views_count' ? 'selected' : '' }}> {{ trans('home.views') }} </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-4 text-lg-right">
                        <div class="border-0 dropdown bootstrap-select form-control form-control-lg bg-white bg-op-9 ml-auto text-sm w-lg-50" style="width: 100%;">
                            <select name="time" onchange="document.getElementById('forum_filter').submit()" class="form-control form-control-lg bg-white bg-op-9 ml-auto text-sm w-lg-50 filter-selector" data-toggle="select" tabindex="-98">
                                <option value="day" {{ isset($filter_data['time']) && $filter_data['time']=='day' ? 'selected' : '' }}>1 {{ trans('home.day') }}</option>
                                <option value="week" {{ isset($filter_data['time']) && $filter_data['time']=='week' ? 'selected' : '' }}>1 {{ trans('home.week') }}</option>
                                <option value="month" {{ (isset($filter_data['time']) && $filter_data['time']=='month') || !isset($filter_data['time']) || $filter_data['time']=='' ? 'selected' : '' }}>1 {{ trans('home.month') }}</option>
                                <option value="year" {{ isset($filter_data['time']) && $filter_data['time']=='year' ? 'selected' : '' }}>1 {{ trans('home.year') }}</option>
                            </select>
                        </div>
                    </div>
                </form>
                <!-- End of post -->
                @if($questions->isEmpty())
                    <div class="text-center mt-5 mb-5" style="opacity:0.6;">{{ trans('home.no_question') }}</div>
                @endif
                @foreach ($questions as $question)
                    <div class="card row-hover pos-relative py-3 px-3 mb-3 border-primary border-top-0 border-right-0 border-bottom-0 rounded-0">
                        <div class="row align-items-center">
                        <div class="col-md-7 mb-3 mb-sm-0">
                            <h5>
                            <a href="{{route('forum.question.answer',['id'=>$question->id])}}" class="text-primary">{{ $question->title ?? '' }}</a>
                            </h5>
                            <p class="text-sm"><span class="op-6">{{ trans('home.posted') }}</span> <a class="text-black" href="#">{{ (Carbon::parse( $question->created_at))->diffForHumans(Carbon::now()) }} </a> <span class="op-6">{{ trans('home.by') }}</span> <a class="text-black" href="{{ route('home.profile.show', $question->user_id ?? '') }}">{{ User::find($question->user_id)->name ?? ''}}</a></p>
                            <div class="text-sm op-5"> <a class="text-black mr-2" href="{{ Route('forum.question.list') . '?category_id=' . ($question->category_id) }}">{{ ((new PcmDmsCategory())->find($question->category_id))['name_'.config('app.locale')] ?? '' }}</a> </div>
                        </div>
                        <div class="col-md-5 op-7">
                            <div class="row text-center op-7">
                            <div class="col px-1"> <i class="ion-connection-bars icon-1x"></i> <span class="d-block text-sm">{{ $question->votes_count ?? '0' }} {{ trans('home.votes') }}</span> </div>
                            <div class="col px-1"> <i class="ion-ios-chatboxes-outline icon-1x"></i> <span class="d-block text-sm">{{ $question->ans_count ?? '0' }} {{ trans('home.replies') }}</span> </div>
                            <div class="col px-1"> <i class="ion-ios-eye-outline icon-1x"></i> <span class="d-block text-sm">{{ $question->views_count ?? '0' }} {{ trans('home.views') }}</span> </div>
                            </div>
                        </div>
                        </div>
                    </div>
                <!-- /End of post -->
                @endforeach
                <div>{{ $questions->withQueryString()->links() }}</div>
            </div>
            @include('front.common.side-topic')
            @if (!Auth::check())
            <div class="align-items-center">
                <div class="row pos-relative mb-3 rounded-0 p-3" style="padding: 0;background: #fff;border: 1px solid rgba(0,0,0,.125);">
                    <div class="col-md-6">
                        <h3 class="text-center mt-3">{{ trans('home.create_account') }}</h3>
                        <div class="text-center registerform">
                            <p class="text-left" style="text-align: justify">{{ trans('home.create_account_explain') }}</p>
                            <a href="{{ route('user.showRegisterForm') }}" type="submit" style="background: #0DA0F2">{{ trans('home.register') }}</a>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h3 class="text-center mt-3">{{ trans('home.signin_your_account') }}</h3>
                        <form action="{{ route('login') }}" method="POST" class="registerform">
                            @csrf
                            <div class="form-group mt-3">
                                <div class="row mb-4">
                                    <div class="col-md-10 m-auto">
                                        <input type="email" class="form-control rounded" id="email" name="email" placeholder="{{ trans('home.email') }}" value="{{ old('email') }}">
                                        @error('email')
                                        <div class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <div class="col-md-10 m-auto">
                                        <input type="password" class="form-control rounded" id="password" name="password" placeholder="{{ trans('home.password') }}" value="{{ old('password') }}">
                                        @error('password')
                                        <div class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <input type="hidden" name="another_login" value="1">
                            </div>
                            <div class="text-center registerform mt-3 mb-3"><button type="submit" style="background: #0DA0F2">{{trans('home.login') }}</button></div>
                        </form>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</section>
@endsection
