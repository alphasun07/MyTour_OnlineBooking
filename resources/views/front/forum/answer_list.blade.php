@php
use App\Models\User;
use App\Models\DtbQuestion;
use App\Models\DtbAnswers;
use Carbon\Carbon;
Carbon::setLocale(config('app.locale'));
@endphp
@extends('front.common.app', ['active' => 'forum', 'page' => 'forum'])
@section('content')
<section class="wrapper" style="margin-top: 80px;">
    <div class="container mt-3 mb-5 p-5 pt-3 border-bottom">
        <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet">
        <div class="row">
            <!-- Main content -->
            <div class="col-lg-9 mb-3">
                <div class="card mb-2"><div class="card-body">
                    <div class="media forum-item d-flex" style="align-items: flex-start;">
                        <a href="{{ route('home.profile.show', $question->user_id ?? '') }}" class="card-link text-center" style="max-width: 120px;"><img src="/css/icons/user.png" class="rounded-circle" width="50" alt="User"><small class="d-block text-center text-body   font-weight-bold">{{ User::find($question->user_id)->name ?? ''}}</small></a>
                        <div class="media-body ms-3" style="flex: 1;">
                            <small class="text-muted ml-2">{{ (Carbon::parse( $question->created_at))->diffForHumans(Carbon::now()) }}</small>
                            <h5 class="mt-1">{{ $question->title ?? '' }}</h5>
                            <div class="mt-3 font-size-sm" style="text-align: justify">
                                @php
                                    echo $question->content ?? '';
                                @endphp
                            </div>
                        </div>
                        <div class="text-muted small text-center" style="position: relative;height: 90px;">
                            <span class="d-none d-sm-inline-block"><i class="far fa-eye"></i> {{ $question->views_count ?? '' }}</span>
                            <span><i class="far fa-comment ms-2"></i> {{ $question->ans_count ?? '' }}</span>
                            <span><i class="fa fa-signal ms-2"></i> {{ $question->votes_count ?? '' }}</span>
                            <span class="d-block" style="position: absolute;bottom: 0; {{ in_array(auth('web')->id(), $userVoted) ? "color:#0DA0F2" : "opacity:0.6" }}">
                                <form method="POST" action="{{ route('forum.vote.update') }}" id="form_id">
                                    @csrf
                                    <input type="hidden" name="user_id" value="{{ in_array(auth('web')->id(), $userVoted) ? '' : auth('web')->id() }}">
                                    <input type="hidden" name="question_id" value="{{ $question->id ?? '' }}">
                                    @if (Auth::Check() && Auth::User()->id == $question->user_id)
                                    <a style="text-decoration:underline;cursor: pointer;" data-bs-toggle="modal" data-bs-target="#edit_question"><i class="fa fa-check-circle"></i> {{ trans('admin.edit') }}</a>
                                    @else
                                    <a href="javascript:$('#form_id').submit();" style="text-decoration:underline;"><i class="fa fa-check-circle"></i> {{ trans('home.votes') }}</a>
                                    @endif
                                </form>
                            </span>
                        </div>
                    </div>
                </div>
                </div>
                <!-- Forum List -->
                <form action="{{ route('forum.question.answer.store') }}" method="POST">
                    @csrf
                    <div class="d-flex align-items-baseline">
                        <textarea class="form-control form-control-lg bg-white bg-op-9 text-sm w-lg-50 filter-selector me-3" id="content" name="contents" placeholder="{{ trans('home.replies') . ' ...' }}"></textarea>
                        <input type="hidden" name="question_id" value="{{$question->id}}">
                        <button type="submit" class="btn btn-lg btn-search position-relative me-2" style="width: auto;display: flex;justify-content: center">{{ trans('home.send') }}</button>
                    </div>
                </form>
                @if($answers->isEmpty())
                    <div class="text-center mt-5 mb-5" style="opacity:0.6;">{{ trans('home.no_answer') }}</div>
                @endif
                <div class="border mt-3 mb-3">
                @foreach ($answers as $answer)
                    @if($answer->status == DtbAnswers::Public)
                    <div class="inner-main-body p-2 p-sm-3 collapse forum-content show">
                        <div class="card mb-2" style="border-radius: 25px;">
                            <div class="card-body p-2 p-sm-3">
                                <div class="media forum-item row">
                                    <a class="col-md-2 d-flex justify-content-center align-items-baseline" href="{{ route('home.profile.show', $question->user_id ?? '') }}" data-toggle="collapse" data-target=".forum-content"><img src="/css/icons/user.png" class="mr-3 rounded-circle" width="50" alt="User" /></a>
                                    <div class="media-body col-md-10">
                                        <input type="hidden" id="answer_id" value="{{ $answer->id ?? '' }}">
                                        <h6><a href="{{ route('home.profile.show', $question->user_id ?? '') }}" data-toggle="collapse" data-target=".forum-content" class="text-body font-weight-bold">{{ $answer->user->name ?? '' }}</a>  <span class="text-secondary">{{ (Carbon::parse( $answer->created_at))->diffForHumans(Carbon::now()) ?? '' }}</span></h6>
                                        <p class="text-body ans_content" style="text-align: justify;" id="">{{ $answer->content ?? '' }}</p>
                                        @if($answer->user_id == auth('web')->id())
                                            <span class="small" style="opacity: 0.75;"><a href="" data-bs-toggle="modal" data-bs-target="#editAnswer" class="text-decoration-underline edit me-2">{{ trans('admin.edit') }}</a><a href="" data-bs-toggle="modal" data-bs-target="#deleteAnswer"  class="text-decoration-underline delete">{{ trans('admin.delete') }}</a></span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                @endforeach
                <!-- /Forum List -->
                @if (Auth::Check() && Auth::User()->id == $question->user_id)
                <!-- Modal edit question -->
                <div class="modal fade" id="edit_question" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="edit_questionLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="edit_questionLabel">{{ trans('admin.edit') }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('forum.question.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" value="{{ $question->id ?? '' }}" name="id">
                                    <input type="hidden" value="{{ $question->category_id ?? '' }}" name="category_id">
                                    <input required value="{{ $question->title ?? '' }}" class="form-control mb-3" name="title" id="title" placeholder="{{ trans('home.title_of_question') }}">
                                    @error('title')
                                        <div class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                    @enderror
                                    <textarea required name="contents" id="contents" data-field="content" class="p-2 flex-fill w-100 js-length__input">{{ $question->content ?? '' }}</textarea>
                                    @error('contents')
                                        <div class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                    @enderror

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ trans('admin.close') }}</button>
                                        <button type="submit" class="btn btn-primary">{{ trans('admin.submit') }}</button>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- Modal edit question -->
                @endif
                <!-- Modal edit answer -->
                <div class="modal fade" id="editAnswer" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editAnswerLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">{{ trans('home.edit_ans') }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('forum.question.answer.store') }}" method="post" class="d-flex flex-column p-2">
                                    @csrf
                                    <textarea id="edit_answaer_content" name="contents" class="form-control" type="text" placeholder="{{ trans('home.replies') }}"></textarea>
                                    <div class="d-flex justify-content-end mt-3">
                                        <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">{{ trans('admin.close') }}</button>
                                        <button type="submit" class="btn btn-primary">{{ trans('admin.submit') }}</button>
                                    </div>
                                    <input type="hidden" name="answer_id" value="">
                                    <input type="hidden" name="question_id" value="{{ $question->id ?? '' }}">
                                    <input type="hidden" name="user_id" value="{{ auth('web')->id() ?? '' }}">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Modal edit answer -->
                <!-- Modal delete confirmation -->
                <div class="modal fade" id="deleteAnswer" data-bs-keyboard="false" tabindex="-1" aria-labelledby="deleteAnswerLabel" aria-hidden="true">
                    <div class="modal-dialog modal-sm">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">{{ trans('admin.delete') }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('forum.question.answer.delete') }}" method="post" class="d-flex flex-column p-2">
                                    @csrf
                                    <div class="d-flex justify-content-end mt-3">
                                        <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">{{ trans('admin.close') }}</button>
                                        <button type="submit" class="btn btn-primary">{{ trans('admin.delete') }}</button>
                                    </div>
                                    <input type="hidden" name="answer_id" value="">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Modal delete confirmation -->
                <div>{{ $answers->withQueryString()->links() }}</div>
            </div>
            </div>
            @include('front.common.side-topic')
        </div>
    </div>
</section>
@endsection
@section('scripts')
<script>
    $(document).ready(function(){
        $('.edit').click(function(){
            $('#edit_answaer_content').html($(this).closest(".media-body").children(".ans_content").html());
            $('[name="answer_id"]').val($(this).closest(".media-body").children("#answer_id").val());
        })

        $('.delete').click(function(){
            $('[name="answer_id"]').val($(this).closest(".media-body").children("#answer_id").val());
        })
    })
</script>
@endsection
