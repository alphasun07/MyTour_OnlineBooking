@extends('admin.layout.app')
@section('title')
{{ 'Quản lý Lương' }}
@endsection
@php
use App\Models\Salary;
@endphp
@section('content')
<form method="POST" action="{{ route('admin.salary.store') }}">
    @csrf
    <div class="row ml-2">
        <div class="d-flex flex-row col-12 p-0">
            <div class="mt-0 border-0 w-100 o-container__background--white o-col__padding--right--left x_panel">
                <div class="col-12">
                    <div class="d-flex flex-row mb-3">
                        <div class="p-2 w-100">
                            <div class="d-flex flex-row">
                                <label for="" class="mr-4 p-label__medium">Lương<span class="text-danger"> * </span></label>
                                <div class="w-50">
                                    <select name="member_id" id="" class= "form-control">
                                        @foreach ($members as $member)
                                        <option value="{{ $member->id }}" {{ isset($salary->member_id) && $member->id==$salary->member_id ? 'selected' : '' }}>{{ $member->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="text-right pt-1 is-length__input--monthly_salary"><strong>0/100 Ký tự</strong></div>
                                    @error('monthly_salary')
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
                                <label for="" class="mr-4 p-label__medium">Lương<span class="text-danger"> * </span></label>
                                <div class="w-50">
                                    <input type="text" name="monthly_salary" maxlength="256" data-field="monthly_salary" value="{{$tour->monthly_salary ?? ''}}" class="p-2 flex-fill w-100 js-length__input">
                                    <div class="text-right pt-1 is-length__input--monthly_salary"><strong>0/100 Ký tự</strong></div>
                                    @error('monthly_salary')
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

    <input type="hidden" name="id" value="{{ $salary->id ?? '' }}">

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
