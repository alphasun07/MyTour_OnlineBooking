@php
    use App\Models\User;
    use App\Models\DtbQuestion;
    use App\Models\PcmDmsCategory;
    use Carbon\Carbon;
    $topViewQuestions = (new DtbQuestion)->getTopViewQuestion()->take(5)->get();
    $categories_count = ( new PcmDmsCategory)->getForumCategories()->count();
    $questions_count = (new DtbQuestion)->getPublicQuestions()->count();
    $categories = ( new PcmDmsCategory)->getForumCategories()->get();
@endphp
<!-- Sidebar content -->
<div class="col-lg-3 mb-4 mb-lg-0 px-lg-0 mt-lg-0">
    <div style="visibility: hidden; display: none; width: 285px; height: 801px; margin: 0px; float: none; position: static; inset: 85px auto auto;"></div><div data-settings="{&quot;parent&quot;:&quot;#content&quot;,&quot;mind&quot;:&quot;#header&quot;,&quot;top&quot;:10,&quot;breakpoint&quot;:992}" data-toggle="sticky" class="sticky" style="top: 85px;"><div class="sticky-inner d-flex flex-column">
        <div style="visibility: hidden; display: none; width: 285px; height: 801px; margin: 0px; float: none; position: static; inset: 85px auto auto;"></div><div data-settings="{&quot;parent&quot;:&quot;#content&quot;,&quot;mind&quot;:&quot;#header&quot;,&quot;top&quot;:10,&quot;breakpoint&quot;:992}" data-toggle="sticky" class="sticky" style="top: 85px;"><div class="sticky-inner d-flex flex-column">
            <a class="btn btn-lg btn-block mt-1 mb-3 py-3 bg-op-6 roboto-bold appointment-btn action_ask" href="#" data-bs-toggle="modal" data-bs-target="#staticBackdrop">{{ trans('home.ask_question') }}</a>
            <!-- Modal -->
            <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">{{ trans('home.ask_question') }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('forum.question.store') }}" method="POST">
                                @csrf
                                <select required class="form-control form-control-lg bg-white bg-op-9 text-sm w-lg-50 filter-selector mb-3 " name="category_id" id="category_id" data-toggle="select">
                                    <option value=""> {{ trans('home.category') }} </option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id ?? '' }}" {{ isset($filter_data['category_id']) && $filter_data['category_id']==$category->id ? 'selected' : '' }}> {{ ucfirst($category['name_'.config('app.locale')] ?? '') }} </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                                <input required class="form-control mb-3" name="title" id="title" placeholder="{{ trans('home.title_of_question') }}">
                                @error('title')
                                    <div class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                                <textarea required name="contents" id="contents" data-field="content" class="p-2 flex-fill w-100 js-length__input"></textarea>
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
            </div>
        </div>
        <div class="bg-white mb-3">
            <h4 class="px-3 py-4 op-5 m-0" style="text-transform: capitalize;">
                {{ trans('home.popular_topics') }}
            </h4>
            <hr class="m-0">
            @foreach ($topViewQuestions as $topViewQuestion)
                <div class="pos-relative px-3 py-3">
                    <h6 class="text-primary text-sm">
                    <a href="{{ route('forum.question.answer', $topViewQuestion->id) }}" class="text-primary">{{ $topViewQuestion->title ?? '' }}</a>
                    </h6>
                    <p class="mb-0 text-sm"><span class="op-6">{{ trans('home.posted') }}</span> <a class="text-black" href="#">{{ (Carbon::parse( $topViewQuestion->created_at))->diffForHumans(Carbon::now()) }}</a> <span class="op-6">{{ trans('home.by') }}</span> <a class="text-black" href="{{ route('home.profile.show', $question->user_id ?? '') }}">{{ User::getUser($topViewQuestion->user_id)->name }}</a></p>
                </div>
                <hr class="m-0">
            @endforeach
        </div>
        <div class="bg-white text-sm">
        <h4 class="px-3 py-4 op-5 m-0 roboto-bold">
            {{ trans('home.stats') }}
        </h4>
        <hr class="my-0">
        <div class="row text-center d-flex flex-row op-7 mx-0">
            <div class="col-sm-6 flex-ew text-center py-3 border-bottom border-right"> <a class="d-block lead font-weight-bold" href="#">{{ $questions_count ?? '' }}</a> {{ trans('home.topics') }} </div>
            <div class="col-sm-6 col flex-ew text-center py-3 border-bottom mx-0"> <a class="d-block lead font-weight-bold" href="#">{{ $categories_count ?? '' }}</a> {{ trans('home.categories') }} </div>
        </div>
        <div class="row d-flex flex-row op-7">
            <div class="col-sm-6 flex-ew text-center py-3 border-right mx-0"> <a class="d-block lead font-weight-bold" href="#">{{ (new User)->getUsers()->count() ?? '' }}</a> {{ trans('home.members') }} </div>
            <div class="col-sm-6 flex-ew text-center py-3 mx-0"> <a class="d-block lead font-weight-bold" href="#">{{ (new User)->getUsers()->first()->name }}</a> {{ trans('home.newest_member') }} </div>
        </div>
        </div>
    </div></div>
</div>
