@php
use App\Models\Coupon;
@endphp
@extends('admin.layout.app')
@section('title')
{{ 'Coupon management' }}
@endsection
@section('content')
@section('pageTitle')
@include('admin.common.page-title', ['title' => 'Management', 'subTitle' => 'Coupon management'])
@endsection
<!-- Modal -->
<form method="POST" action="{{route('admin.coupon.store')}}">
    @csrf
    <div class="row ml-2">
        <div class="col-12 o-col__padding--right--left">
            <div class="d-flex flex-column mb-3 o-container__background--white x_panel mt-0 border-top-0">
                <div class="col-12">
                    <div class="d-flex flex-row mb-3">
                        <div class="p-2 w-100">
                            <div class="d-flex flex-row">
                                <label for="" class="mr-4 p-label__small">Code <span class="text-danger"> * </span></label>
                                <div class="w-75">
                                    <input type="text" name="code" value="{{old('code', $coupon->code ?? '')}}" maxlength="255" data-field="code" class="p-2 flex-fill w-100 js-length__input">
                                    @error('code')
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
                                <label for="" class="mr-4 p-label__small">Discount <span class="text-danger"> * </span></label>
                                <div class="w-75">
                                    <input type="text" name="discount" value="{{old('discount', $coupon->discount ?? '')}}" maxlength="255" data-field="discount" class="p-2 flex-fill w-100 js-length__input">
                                    @error('discount')
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
                                <label for="" class="mr-4 p-label__small">Type <span class="text-danger"> * </span></label>
                                <div class="w-75">
                                    <select name="coupon_type" id="coupon_type" class="flex-fill w-100 js-length__input" style="width: 100%; padding:13px;">
                                        <option value="" selected disabled>-Select type-</option>
                                        @foreach(Coupon::TYPE as $key => $value)
                                        <option {{ old('coupon_type', isset($coupon) ? $coupon->coupon_type : '') == $key ? 'selected' : '' }} name="interview_status" id="{{$key}}" value="{{$key}}">{{$value}}</option>
                                        @endforeach
                                    </select>
                                    @error('coupon_type')
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
                                <label for="" class="mr-4 p-label__small">Tour <span class="text-danger"> * </span></label>
                                <div class="w-75">
                                    <select name="tour_id" id="tour_id" class="flex-fill w-100 js-length__input" style="width: 100%; padding:13px;">
                                        @foreach($tours as $tour)
                                        <option {{ old('tour_id', isset($coupon) ? $coupon->tour_id : '') == $tour->id ? 'selected' : ''}} value="{{$tour->id}}">{{$tour->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('tour_id')
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
                                <label for="" class="mr-4 p-label__small">Max use <span class="text-danger"> * </span></label>
                                <div class="w-75">
                                    <input type="number" name="max_use" value="{{old('max_use', $coupon->max_use ?? '')}}" maxlength="255" data-field="max_use" class="p-2 flex-fill w-100 js-length__input">
                                    @error('max_use')
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
                                <label for="" class="mr-4 p-label__small">Time Used</label>
                                <div class="w-75">
                                    {{old('used', $coupon->used ?? 0)}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="d-flex flex-row mb-3">
                        <div class="p-2 w-100">
                            <div class="d-flex flex-row">
                                <label for="" class="mr-4 p-label__small">Published </label>
                                <div class="w-75">
                                    <div class="d-flex">
                                        @foreach(Coupon::PUBLISHED as $key => $value)
                                        @php
                                        $published = old('published', isset($coupon) ? $coupon->published : '');
                                        @endphp
                                        <div class="form-check">
                                            &ensp;<input {{ $published == $key ? 'checked'  : '' }} class="form-check-input " type="radio" id="radio-{{$key}}" name="published" value="{{$key}}">
                                            <label class="form-check-label" for="radio-{{$key}}">{{$value}}</label>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" name="id" value="{{ old('id', isset($coupon->id) ? $coupon->id : '') }}">
        <div class="col-12 mt-4">
            <div class="d-flex flex-row mb-3 justify-content-center">
                <input class="btn btn-success" type="submit" value="Save">
                <a class="btn btn-primary ml-2" href="{{route('admin.coupon.list')}}">Cancel</a>
            </div>
        </div>
    </div>
</form>

@endsection
