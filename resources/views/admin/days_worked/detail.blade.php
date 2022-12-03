@extends('admin.layout.app')
@section('title')
{{ 'Quản lý Lương' }}
@endsection
@php
use App\Models\Salary;
@endphp
@section('content')
<form method="POST" action="{{ route('admin.salary.dayWorked.store') }}">
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
                                    <select name="member_id" id="" disabled class= "form-control">
                                        @foreach ($members as $member)
                                        <option value="{{ $member->id }}" {{ isset($dayWorked->member_id) && $member->id==$dayWorked->member_id ? 'selected' : '' }}>{{ $member->name }}</option>
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
                                <label for="" class="mr-4 p-label__medium">Ngày<span class="text-danger"> * </span></label>
                                <div class="w-50">
                                    <input type="date" name="created_at" maxlength="256" data-field="created_at" value="{{$salary->created_at ?? ''}}" class="p-2 flex-fill w-100 js-length__input">
                                    <div class="text-right pt-1 is-length__input--created_at"><strong>0/100 Ký tự</strong></div>
                                    @error('created_at')
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
                                <label for="" class="mr-4 p-label__medium"><span class="text-danger"></span></label>
                                <div class="w-50">
                                    <div class="ml-5 custom-control custom-radio">
                                        <input type="checkbox" class="custom-control-input" id="display" name="calculate" value="1" >
                                        <label for="display" class="custom-control-label" style="text-decoration: underline">Tính lại lương</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <input type="hidden" name="id" value="{{ $dayWorked->id ?? '' }}">
    <input type="hidden" name="member_id" value="{{ $salary->member_id ?? '' }}">
    <input type="hidden" name="salary_id" value="{{ $salary->id ?? 0 }}">

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
