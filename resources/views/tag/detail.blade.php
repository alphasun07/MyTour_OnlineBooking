@php
use App\Models\PcmDmsTag;
use App\Helpers\Helper;
@endphp
@extends('admin.layout.app')
@section('title')
{{ 'Tag management' }}
@endsection
@section('scripts')
@section('content')
@section('pageTitle')
@include('admin.common.page-title', ['title' => 'management', 'subTitle' => 'Tag management'])
@endsection
<form method="POST" action="{{ route('admin.tag.store') }}">
    @csrf
    <div class="row ml-2">
        <div class="mt-0 border-0 w-100 o-container__background--white o-col__padding--right--left x_panel">
            <div class="col-12 pt-5">
                <div class="d-flex flex-row mb-3">
                    <div class="p-2 w-100">
                        <div class="d-flex flex-row">
                            <label for="" class="p-label__small mr-4">ID</label>
                            <div class="w-75">
                                {{ str_pad(PcmDmsTag::max('id') + 1, 10, '0', STR_PAD_LEFT) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="d-flex flex-row mb-3">
                    <div class="p-2 w-100">
                        <div class="d-flex flex-row">
                            <label for="" class="mr-4 p-label__small">Title<span class="text-danger"> * </span></label>
                            <div class="w-50">
                                <input type="text" name="title" value="{{ old('title', $tag->title ?? '') }}" maxlength="256" data-field="title" class="p-2 flex-fill w-100 js-length__input">
                                <div class="text-right pt-1 is-length__input--title"><strong>000 Characters</strong></div>
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
            <div class="col-12 mt-4">
                <div class="d-flex flex-row mb-3 justify-content-center">
                    <input class="btn btn-success" type="submit" value="Save">
                    <button type="button" class="btn btn-primary ml-2" onClick="location.reload()">Cancel</button>
                </div>
            </div>
            <input type="hidden" name="id" value="{{isset($tag->id) ? $tag->id : 0}}" />
        </div>
    </div>
</form>
@endsection
@section('scripts')
<script src="{{ asset('js/admin/common.js') }}"></script>
@endsection
