@extends('admin.layout.app')
@section('title')
{{ 'Quản lý thẻ' }}
@endsection
@php
use App\Models\DtbTag;
@endphp
@section('content')
    <ul class="nav nav-tabs row ml-2" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link p-2 {{ !Session::get('error_tab') ? 'active' : '' }}" id="content_vi-tab " data-toggle="tab" href="#content_vi" role="tab" aria-controls="content_vi" aria-selected="true"><img src="/css/icons/vn.png" width="28px" alt="vn.png"> Nội dung</a>
        </li>
        <li class="nav-item">
            <a class="nav-link p-2 {{ Session::get('error_tab') && Session::get('error_tab')=='en' ? 'active' : '' }}" id="content_en-tab" data-toggle="tab" href="#content_en" role="tab" aria-controls="content_en" aria-selected="false"><img src="/css/icons/en(1).png" width="28px" alt="en.png"> Content </a>
        </li>
    </ul>
<form method="POST" action="{{ route('admin.tags.update', ['id' => $tag->id]) }}">
    @csrf
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade {{ Session::get('error_tab') ? '' : 'show active' }}" id="content_vi" role="tabpanel" aria-labelledby="content_vi-tab">
            <div class="row ml-2">
                <div class="d-flex flex-row col-12 p-0">
                    <div class="mt-0 border-0 w-100 o-container__background--white o-col__padding--right--left x_panel">
                        <div class="col-12 pt-5">
                            <div class="d-flex flex-row mb-3">
                                <div class="p-2 w-100">
                                    <div class="d-flex flex-row">
                                        <label for="" class="p-label__small mr-4">ID</label>
                                        <div class="w-75">
                                            {{ str_pad(DtbTag::max('id') + 1, 10, '0', STR_PAD_LEFT) }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-flex flex-row mb-3">
                                <div class="p-2 w-100">
                                    <div class="d-flex flex-row">
                                        <label for="" class="mr-4 p-label__small">Tên thẻ<span class="text-danger"> * </span></label>
                                        <div class="w-50">
                                            <input type="text" name="name_vi" maxlength="256" data-field="name_vi" value="{{$tag->name_vi}}" class="p-2 flex-fill w-100 js-length__input">
                                            <div class="text-right pt-1 is-length__input--name"><strong>0/100 Ký tự</strong></div>
                                            @error('name_vi')
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

        </div>
        <div class="tab-pane fade {{ Session::get('error_tab') && Session::get('error_tab')=='en' ? 'show active' : '' }}" id="content_en" role="tabpanel" aria-labelledby="content_en-tab">
            <div class="row ml-2">
                <div class="d-flex flex-row col-12 p-0">
                    <div class="mt-0 border-0 w-100 o-container__background--white o-col__padding--right--left x_panel">
                        <div class="col-12 pt-5">
                            <div class="d-flex flex-row mb-3">
                                <div class="p-2 w-100">
                                    <div class="d-flex flex-row">
                                        <label for="" class="p-label__small mr-4">ID</label>
                                        <div class="w-75">
                                            {{ str_pad(DtbTag::max('id') + 1, 10, '0', STR_PAD_LEFT) }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-flex flex-row mb-3">
                                <div class="p-2 w-100">
                                    <div class="d-flex flex-row">
                                        <label for="" class="mr-4 p-label__small">Tên thẻ<span class="text-danger"> * </span></label>
                                        <div class="w-50">
                                            <input type="text" name="name_en" maxlength="256" data-field="name_en" value="{{$tag->name_en}}"  class="p-2 flex-fill w-100 js-length__input">
                                            <div class="text-right pt-1 is-length__input--name"><strong>0/100 Ký tự</strong></div>
                                            @error('name_en')
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
        </div>

        <div class="col-12 mt-4">
            <div class="d-flex flex-row mb-3 justify-content-center">
                <input class="btn btn-success" type="submit" value="Save">
                <button type="button" class="btn btn-primary ml-2" onClick="location.reload()">Cancel</button>
            </div>
        </div>
    </div>
    
</form>
@endsection
@section('scripts')
<!-- parsley.js -->
<script src="{{ asset('js/admin/dropzone-common.js') }}"></script>
<script src="{{ asset('js/admin/common.js') }}"></script>
@endsection
