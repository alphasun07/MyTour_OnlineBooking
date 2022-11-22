@extends('admin.layout.app')
@section('title')
{{ 'Quản lý Tour' }}
@endsection
@php
use App\Models\Tour;
@endphp
@section('content')
<form method="POST" action="{{ route('admin.tour.store') }}">
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
                                    {{ !empty($tour) ? str_pad($tour->id, 10, '0', STR_PAD_LEFT) : str_pad(Tour::max('id') + 1, 10, '0', STR_PAD_LEFT) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 d-flex">
                    <div class=" p-2 w-50">
                        <div class="d-flex flex-row">
                            <div class="d-flex flex-row">
                                <label>Nổi bật</label>
                            </div>
                            <div class="ml-5 custom-control custom-radio">
                                <input type="radio" class="custom-control-input" id="display" name="featured" value="1" {{ ((!old() && isset($tour->featured) && $tour->featured == Tour::FEATURED_ON) || is_null($tour) || (old() && old('featured') == Tour::FEATURED_ON)) ?  'checked' : '' }}>
                                <label for="display" class="custom-control-label">Có</label>
                            </div>
                            <div class="ml-3 custom-control custom-radio">
                                <input type="radio" class="custom-control-input" id="hide" name="featured" value="0" {{ ((!old() && isset($tour->featured) && $tour->featured == Tour::FEATURED_OFF) || (old() && old('featured') == Tour::FEATURED_OFF)) || (!old() && isset($tour) && (!isset($tour->featured) || is_null($tour->featured))) ?  'checked' : '' }}>
                                <label for="hide" class="custom-control-label">Không</label>
                            </div>
                        </div>
                    </div>
                    <div class=" p-2 w-50">
                        <div class="d-flex flex-row">
                            <label for="" class="mr-4 p-label__medium">Trạng thái<span class="text-danger"> * </span></label>
                            <div class="w-50">
                                <select name="status" class="p-2 flex-fill w-100 form-control-chosen">
                                    @foreach (Tour::STATUS_LIST as $key => $value)
                                    <option value="{{ $key ?? '' }}" {{ $tour && $tour->status == $key ? 'selected' : 0 }}>{{ $value ?? '' }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="d-flex flex-row mb-3">
                        <div class="p-2 w-100">
                            <div class="d-flex flex-row">
                                <label for="" class="mr-4 p-label__medium">Tên tour<span class="text-danger"> * </span></label>
                                <div class="w-50">
                                    <input type="text" name="name" maxlength="256" data-field="name" value="{{$tour->name ?? ''}}" class="p-2 flex-fill w-100 js-length__input">
                                    <div class="text-right pt-1 is-length__input--name"><strong>0/100 Ký tự</strong></div>
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
                                <label for="" class="mr-4 p-label__medium">Mô tả</label>
                                <div class="w-75">
                                    <textarea name="description" id="editor" data-field="description" class="p-2 flex-fill w-100 js-length__input">{{old('description', $tour->description ?? '')}}</textarea>
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
                <div class="col-12">
                    <div class="d-flex flex-row mb-3">
                        <div class="p-2 w-100">
                            <div class="d-flex flex-row">
                                <label for="" class="mr-4 p-label__medium">Số ngày diễn ra<span class="text-danger"> * </span></label>
                                <div class="w-50">
                                    <input type="number" name="tour_time" maxlength="256" data-field="tour_time" value="{{$tour->tour_time ?? '5'}}" class="p-2 flex-fill w-100 js-length__input">
                                    @error('tour_time')
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
                                <label for="" class="mr-4 p-label__medium">Địa điểm và lộ trình<span class="text-danger"> * </span></label>
                                <div class="w-50">
                                    <select name="places[]" class="form-control" multiple id="chosen_places">
                                        @foreach ($places as $place)
                                            <option value="{{ $place->id ?? '' }}" {{ (isset($place) && in_array($place->id, $tourPlaces)) ? 'selected' : '' }}>{{ $place->name ?? '' }}</option>
                                        @endforeach
                                    </select>
                                    @error('tour_time')
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
                                <label for="" class="mr-4 p-label__medium">Giá một người<span class="text-danger"> * </span></label>
                                <div class="w-50">
                                    <input type="text" name="price_per_person" maxlength="256" data-field="price_per_person" value="{{$tour->price_per_person ?? ''}}" class="p-2 flex-fill w-100 js-length__input">
                                    @error('price_per_person')
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
                                <label for="" class="mr-4 p-label__medium">Số người tối đa<span class="text-danger"> * </span></label>
                                <div class="w-50">
                                    <input type="number" name="max_person" maxlength="256" data-field="max_person" value="{{$tour->max_person ?? '5'}}" class="p-2 flex-fill w-100 js-length__input">
                                    @error('max_person')
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
                        <label for="" class="mr-4 p-label__medium">Hình ảnh</label>
                        <div class="p-2 w-75">
                            <div id="pc_image_dz" class="dropzone dz-clickable border-secondary o-borderDash o-minHeight__0">
                                <div class="dz-default dz-message needsclick d-flex flex-row p-2 justify-content-center">
                                    <i class="fas fa-cloud-download p-3 fa-4x o-iconColor"></i>
                                    <p class="p-3 mt-3">Kéo và thả hình ảnh</p>
                                    <span class="mt-4">
                                        <label for="product_main_image_url" class="filelabel o-buttonSize">Chọn tệp</label>
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
                                <label for="" class="mr-4 p-label__medium">Chuyên mục<span class="text-danger"> * </span></label>
                                <div class="w-50">
                                    <select name="category_id" id="" class="p-2 flex-fill w-100 form-control-chosen">
                                        @foreach ($categories as $category)
                                        <option value="{{ $category->id ?? '' }}" {{ $category->id && $tour->category_id && $category->id==$tour->category_id ? 'selected' : '' }}>{{ $category->name ?? '' }}</option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
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

    <input type="hidden" name="id" value="{{ $tour->id ?? '' }}">
    <input require type="hidden" name="thumbnail" id="thumbnail" value="{{old('thumbnail', $tour->thumbnail ?? '')}}" />

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
            0: 'thumbnail',
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
        urlUploadImage: '{{ route("admin.tour.upload.image") }}',
        urlRemoveImage: '{{ route("admin.tour.remove.image") }}',
        urlGetImage: '{{ route("admin.tour.getimage.infor") }}',
        imageFolder: '{{ Tour::FOLDER_IMAGE }}'
    };
    var imageNameObj = {
        0: '{{ old("thumbnail", $tour->thumbnail ?? "") }}'
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
    $("#chosen_places").chosen({allow_duplicates:true,hide_results_on_select: false})
</script>
@endsection
