@extends('admin.layout.app')
@section('title')
{{ 'Quản lý dịch vụ' }}
@endsection
@php
use App\Models\Service;
@endphp
@section('content')
<form method="POST" action="{{ route('admin.service.store') }}">
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
                                    {{ !empty($service) ? str_pad($service->id, 10, '0', STR_PAD_LEFT) : str_pad(Service::max('id') + 1, 10, '0', STR_PAD_LEFT) }}
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
                                <input type="radio" class="custom-control-input" id="display" name="status" value="1" {{ (isset($service->status) && $service->status == Service::STATUS_ACTIVE) || is_null($service) ?  'checked' : '' }}>
                                <label for="display" class="custom-control-label">Có</label>
                            </div>
                            <div class="ml-3 custom-control custom-radio">
                                <input type="radio" class="custom-control-input" id="hide" name="status" value="0" {{ ((isset($service->status) && $service->status == Service::STATUS_HIDDEN)) ?  'checked' : '' }}>
                                <label for="hide" class="custom-control-label">Không</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="d-flex flex-row mb-3">
                        <div class="p-2 w-100">
                            <div class="d-flex flex-row">
                                <label for="" class="mr-4 p-label__medium">Tên dịch vụ<span class="text-danger"> * </span></label>
                                <div class="w-50">
                                    <input type="text" name="name" maxlength="256" data-field="name" value="{{$service->name ?? ''}}" class="p-2 flex-fill w-100 js-length__input">
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
                                    <textarea name="description" id="editor" data-field="description" class="p-2 flex-fill w-100 js-length__input">{{old('description', $service->description ?? '')}}</textarea>
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
                                <label for="" class="mr-4 p-label__medium">Điều khoản</label>
                                <div class="w-75">
                                    <textarea name="term_condition" id="editor1" data-field="term_condition" class="p-2 flex-fill w-100 js-length__input">{{old('term_condition', $service->term_condition ?? '')}}</textarea>
                                    @error('term_condition')
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
                                <label for="" class="mr-4 p-label__medium">Giá<span class="text-danger"> * </span></label>
                                <div class="w-50">
                                    <input type="text" name="price" maxlength="256" data-field="price" value="{{$service->price ?? ''}}" class="p-2 flex-fill w-100 js-length__input">
                                    @error('price')
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

    <input type="hidden" name="id" value="{{ $service->id ?? '' }}">

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
