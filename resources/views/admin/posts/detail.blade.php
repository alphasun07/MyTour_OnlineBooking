@extends('admin.layout.app')
@section('title')
{{ 'Quản lý bài viết' }}
@endsection
@php
use App\Models\Post;
@endphp
@section('content')
<form method="POST" action="{{ route('admin.post.store') }}">
    @csrf
    <div class="row ml-2">
        <div class="d-flex flex-row col-12 p-0">
            <div class="mt-0 border-0 w-100 o-container__background--white o-col__padding--right--left x_panel">
                <div class="col-12 pt-5">
                    <div class="d-flex flex-row mb-3">
                        <div class="p-2 w-100">
                            <div class="d-flex flex-row">
                                <label for="" class="p-label__medium mr-4">ID</label>
                                <div class="w-75">
                                    {{ !empty($post) ? str_pad($post->id, 10, '0', STR_PAD_LEFT) : str_pad(Post::max('id') + 1, 10, '0', STR_PAD_LEFT) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 d-flex">
                    <div class=" p-2">
                        <div class="d-flex flex-row">
                            <div class="d-flex flex-row">
                                <label>Hiển thị</label>
                            </div>
                            <div class="ml-5 custom-control custom-radio">
                                <input type="radio" class="custom-control-input" id="display" name="status" value="1" {{ (isset($post->status) && $post->status == Post::STATUS_ACTIVE) || is_null($post) ?  'checked' : '' }}>
                                <label for="display" class="custom-control-label">Có</label>
                            </div>
                            <div class="ml-3 custom-control custom-radio">
                                <input type="radio" class="custom-control-input" id="hide" name="status" value="0" {{ ((isset($post->status) && $post->status == Post::STATUS_HIDDEN)) ?  'checked' : '' }}>
                                <label for="hide" class="custom-control-label">Không</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="d-flex flex-row mb-3">
                        <div class="p-2 w-100">
                            <div class="d-flex flex-row">
                                <label for="" class="mr-4 p-label__medium">Tiêu đề<span class="text-danger"> * </span></label>
                                <div class="w-50">
                                    <input type="text" name="title" maxlength="256" data-field="title" value="{{$post->title ?? ''}}" class="p-2 flex-fill w-100 js-length__input">
                                    <div class="text-right pt-1 is-length__input--title"><strong>0/100 Ký tự</strong></div>
                                    @error('title')
                                    <div class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="d-flex flex-row mb-3">
                        <div class="p-2 w-100">
                            <div class="d-flex flex-row">
                                <label for="" class="mr-4 p-label__medium">Tóm tắt</label>
                                <div class="w-75">
                                    <textarea name="brief" id="editor" data-field="brief" class="p-2 flex-fill w-100 js-length__input">{{old('brief', $post->brief ?? '')}}</textarea>
                                    @error('brief')
                                    <div class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="d-flex flex-row mb-3">
                        <div class="p-2 w-100">
                            <div class="d-flex flex-row">
                                <label for="" class="mr-4 p-label__medium">Nội dung</label>
                                <div class="w-75">
                                    <textarea name="content" id="editor1" data-field="content" class="p-2 flex-fill w-100 js-length__input">{{old('content', $post->content ?? '')}}</textarea>
                                    @error('content')
                                    <div class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="d-flex flex-row mb-3">
                        <div class="p-2 w-100">
                            <div class="d-flex flex-row">
                                <label for="" class="mr-4 p-label__medium">Tag<span class="text-danger"> * </span></label>
                                <div class="w-50">
                                    <input type="text" name="tag" maxlength="256" data-field="tag" value="{{$post->tag ?? ''}}" class="p-2 flex-fill w-100 js-length__input">
                                    @error('tag')
                                    <div class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <input type="hidden" name="id" value="{{ $post->id ?? '' }}">

    <div class="col-12 mt-4">
        <div class="d-flex flex-row mb-3 justify-content-center">
            <input class="btn btn-success" type="submit" value="Save">
            <button type="button" class="btn btn-primary ml-2" onClick="location.reload()">Cancel</button>
        </div>
    </div>

</form>
@endsection
@section('scripts')
<!-- parsley.js -->
<script src="{{ asset('js/admin/common.js') }}"></script>
<script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
<script>
    CKEDITOR.replace('editor', {
        language: 'en'
    });
    CKEDITOR.replace('editor1', {
        language: 'en'
    });
</script>
@endsection
