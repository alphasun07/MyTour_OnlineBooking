@extends('admin.layout.app')
@section('title')
{{ 'Quản lý địa điểm' }}
@endsection
@php
use App\Models\Place;
@endphp
@section('content')
<form method="POST" action="{{ route('admin.place.store') }}">
    @csrf
    <div class="row ml-2">
        <div class="d-flex flex-row col-12 p-0">
            <div class="mt-0 border-0 w-100 o-container__background--white o-col__padding--right--left x_panel">
                <div class="col-12 pt-5">
                    <div class="d-flex flex-row mb-3">
                        <div class="p-2 w-100">
                            <div class="d-flex flex-row">
                                <label for="" class="p-label__small mr-4">ID</label>
                                <div class="w-75">
                                    {{ !empty($place) ? str_pad($place->id, 10, '0', STR_PAD_LEFT) : str_pad(Place::max('id') + 1, 10, '0', STR_PAD_LEFT) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="d-flex flex-row mb-3">
                        <div class="p-2 w-100">
                            <div class="d-flex flex-row">
                                <label for="" class="mr-4 p-label__small">Tên địa điểm<span class="text-danger"> * </span></label>
                                <div class="w-50">
                                    <input type="text" name="name" maxlength="256" data-field="name" value="{{$place->name ?? ''}}" class="p-2 flex-fill w-100 js-length__input">
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
                                <label for="" class="mr-4 p-label__small">Đất nước<span class="text-danger"> * </span></label>
                                <div class="w-50">
                                    <input type="text" name="country" maxlength="256" data-field="country" value="{{$place->country ?? ''}}" class="p-2 flex-fill w-100 js-length__input">
                                    <div class="text-right pt-1 is-length__input--country"><strong>0/100 Ký tự</strong></div>
                                    @error('country')
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
                                <label for="" class="mr-4 p-label__small">Tỉnh / Thành phố<span class="text-danger"> * </span></label>
                                <div class="w-50">
                                    <input type="text" name="city" maxlength="256" data-field="city" value="{{$place->city ?? ''}}" class="p-2 flex-fill w-100 js-length__input">
                                    <div class="text-right pt-1 is-length__input--city"><strong>0/100 Ký tự</strong></div>
                                    @error('city')
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
                                <label for="" class="mr-4 p-label__small">Địa chỉ cụ thể<span class="text-danger"> * </span></label>
                                <div class="w-50">
                                    <input type="text" name="address" maxlength="256" data-field="address" value="{{$place->address ?? ''}}" class="p-2 flex-fill w-100 js-length__input">
                                    <div class="text-right pt-1 is-length__input--address"><strong>0/100 Ký tự</strong></div>
                                    @error('address')
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

    <input type="hidden" name="id" value="{{ $place->id ?? '' }}">
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
@endsection
