@php
use App\Models\PcmDmsCategory;
use App\Helpers\Helper;
@endphp
@extends('admin.layout.app')
@section('title')
{{ 'Category management' }}
@endsection
@section('head')
<style>
    .dz-preview .dz-image img {
        width: 100% !important;
        height: 100% !important;
        object-fit: cover;
    }

    .o-li_selected {
        background: #f1f1f1;
    }

    .p-hide {
        display: none;
    }

    .p-show {
        display: block;
    }

    .p-label__small {
        width: 100px;
    }
</style>
@stop
@section('content')
@section('pageTitle')
@include('admin.common.page-title', ['title' => 'Management', 'subTitle' => 'Category management'])
@endsection
<!-- Modal -->
@if (count($parent_categories))
@include('admin.common.parent-category-select', ['categories' => $parent_categories, 'single' => true, 'inputNumber' => 1, 'list_parent_ids' => $list_parent_ids])
@endif

<form method="POST" action="{{ route('admin.category.store') }}">
    @csrf
    <div class="row ml-2">
        <div class="col-12 o-col__padding--right--left">
            <div class="d-flex flex-column mb-3 o-container__background--white x_panel mt-0 border-top-0">
                <div class="col-12 pt-5">
                    <div class="d-flex flex-row mb-3">
                        <div class="p-2 w-25">
                            <div class="d-flex flex-row">
                                <label for="" class="p-label__small mr-4">ID</label>
                                <div class="w-75">
                                    {{ !empty($category) ? str_pad($category->id, 10, '0', STR_PAD_LEFT) : str_pad(PcmDmsCategory::max('id') + 1, 10, '0', STR_PAD_LEFT) }}
                                </div>
                            </div>
                        </div>
                        <div class="ml-3 p-2 w-25">
                            <div class="d-flex flex-row">
                                <div class="d-flex flex-row">
                                    <label>Publish</label>
                                </div>
                                <div class="ml-5 custom-control custom-radio">
                                    <input type="radio" class="custom-control-input" id="display" name="published" value="1" {{ ((!old() && isset($category->published) && $category->published == PcmDmsCategory::PUBLISHED_ON) || is_null($category) || (old() && old('published') == PcmDmsCategory::PUBLISHED_ON)) ?  'checked' : '' }}>
                                    <label for="display" class="custom-control-label">Yes</label>
                                </div>
                                <div class="ml-3 custom-control custom-radio">
                                    <input type="radio" class="custom-control-input" id="hide" name="published" value="0" {{ ((!old() && isset($category->published) && $category->published == PcmDmsCategory::PUBLISHED_OFF) || (old() && old('published') == PcmDmsCategory::PUBLISHED_OFF)) || (!old() && isset($category) && (!isset($category->published) || is_null($category->published))) ?  'checked' : '' }}>
                                    <label for="hide" class="custom-control-label">No</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="d-flex flex-row mb-3">
                        <div class="p-2 w-100">
                            <div class="d-flex flex-row">
                                <label for="" class="mr-4 p-label__small">Name<span class="text-danger"> * </span></label>
                                <div class="w-75">
                                    <input type="text" name="name" value="{{old('name', $category->name ?? '')}}" placeholder="Name of category" maxlength="255" data-field="name" class="p-2 flex-fill w-100 js-length__input">
                                    <div class="text-right pt-1 is-length__input--name"><strong>000 Characters</strong></div>
                                    @error('name')
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
                                <label for="" class="mr-4 p-label__small">Parent category</label>
                                <div class="w-75">
                                    <div class="d-flex flex-row flex-fill">
                                        <input type="text" readonly="true" name="category_label_selected_1" class="p-2 flex-fill ml-0" value="{{ old('category_label_selected_1', $category_label)}}" placeholder="Category / Heading / Large Category / Medium Category / Small Category">
                                        <button type="button" class="btn btn-default" onclick="showPopupCategory(true, 1)" data-toggle="modal" data-target="#js-category_1">
                                            <i class="fa fa-folder-open fa-2x"></i>
                                        </button>
                                    </div>
                                    @if($errors->has('category_label_selected_1'))
                                    <div class="text-danger" role="alert">
                                        <strong>{{$errors->first('category_label_selected_1')}}</strong>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="d-flex flex-row mb-3">
                        <label for="" class="mr-4 p-label__small">Image</label>
                        <div class="p-2 w-75">
                            <div id="pc_image_dz" class="dropzone dz-clickable border-secondary o-borderDash o-minHeight__0">
                                <div class="dz-default dz-message needsclick d-flex flex-row p-2 justify-content-center">
                                    <i class="fas fa-cloud-download p-3 fa-4x o-iconColor"></i>
                                    <p class="p-3 mt-3">Drag and drop images</p>
                                    <span class="mt-4">
                                        <label for="product_main_image_url" class="filelabel o-buttonSize">Browse file</label>
                                    </span>
                                </div>
                            </div>
                            <div id="error-pc_image_dz" class="error-message mt-1">
                                <ul class="parsley-errors-list filled">
                                    @if($errors->has('category_thumb'))
                                    <strong>{{$errors->first('category_thumb')}}</strong>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="d-flex flex-row mb-3">
                        <div class="p-2 w-100">
                            <div class="d-flex flex-row">
                                <label for="" class="mr-4 p-label__small">Description</label>
                                <div class="w-75">
                                    <textarea name="description" id="editor" data-field="description" class="p-2 flex-fill w-100 js-length__input">{{old('description', $category->description ?? '')}}</textarea>
                                    @error('description')
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
            </div>
            <input require type="hidden" name="is_form_detail" value="1" />
            <input require type="hidden" name="category_thumb" id="category_thumb" value="{{old('category_thumb', $category->category_thumb ?? '')}}" />
            <input type="hidden" name="category_id" value="{{isset($category->id) ? $category->id : 0}}" />
            <input type="hidden" id="js-parent_id_1" name="parent_id" value="{{isset($category->parent_id) ? $category->parent_id : ''}}" />
        </div>
    </div>
</form>
@endsection
@section('scripts')
<!-- parsley.js -->
<script src="{{ asset('js/admin/dropzone-common.js') }}"></script>
<script src="{{ asset('js/admin/common.js') }}"></script>
<script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
<script>
    Dropzone.autoDiscover = false;
    var dropzoneOptions = {
        idDz: {
            0: 'pc_image_dz',
        },
        nameInput: {
            0: 'category_thumb',
        },
        maxFiles: {
            0: 1,
        },
        required: {
            0: ''
        },
        dictMaxFilesExceeded: {
            0: '',
        },
        urlUploadImage: '{{ route("admin.category.upload.image") }}',
        urlRemoveImage: '{{ route("admin.category.remove.image") }}',
        urlGetImage: '{{ route("admin.category.getimage.infor") }}',
        imageFolder: '{{ PcmDmsCategory::FOLDER_IMAGE }}'
    };
    var imageNameObj = {
        0: '{{ old("category_thumb", $category->category_thumb ?? "") }}'
    };

    $(document).ready(function() {
        runDropzone(dropzoneOptions);
        showImageObject(dropzoneOptions, imageNameObj);
        // check modal is hide
        $('#js-category').on('hidden.bs.modal', function(e) {
            $("#js-category ul li").removeClass('o-li_selected')
        })
    })
    CKEDITOR.replace('editor', {
        language: 'en'
    });
</script>
@endsection