@php
use App\Models\PcmUser;
@endphp
@extends('admin.layout.app')
@section('title')
{{ 'Member Manager' }}
@endsection
@section('content')
@section('pageTitle')
@include('admin.common.page-title', ['title' => 'Manager', 'subTitle' => 'Member Manager'])
@endsection
<form method="POST" action="{{ route('admin.member.store') }}">
    @csrf
    <div class="row ml-2">
        <div class="col-12 o-col__padding--right--left">
            <div class="d-flex flex-column mb-3 o-container__background--white x_panel">
                <div class="col-12">
                    <div class="d-flex flex-row mb-3">
                        <div class="p-2 w-100">
                            <div class="d-flex flex-row">
                                <label for="" class="mr-4 p-label__small">Name <span class="text-danger"> * </span></label>
                                <div class="w-75">
                                    <input type="text" name="name" value="{{ old('name', $user->name ?? '') }}" maxlength="256" data-field="name" class="p-2 flex-fill w-100 js-length__input">
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
                                <label for="" class="mr-4 p-label__small">Email <span class="text-danger"> * </span></label>
                                <div class="w-75">
                                    <input type="text" name="email" value="{{old('email', $user->email ?? '')}}" data-field="email" class="p-2 flex-fill w-100 js-length__input">
                                    @error('email')
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
                                <label for="" class="mr-4 p-label__small">Phone</label>
                                <div class="w-75">
                                    <input type="text" name="phone_number" value="{{old('phone_number', $user->phone_number ?? '')}}" data-field="phone_number" class="p-2 flex-fill w-100 js-length__input">
                                    @error('phone_number')
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
                                <label for="" class="mr-4 p-label__small">Address</label>
                                <div class="w-75">
                                    <input type="text" name="address" value="{{old('address', $user->address ?? '')}}" data-field="address" class="p-2 flex-fill w-100 js-length__input">
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
                <div class="col-12">
                    <div class="d-flex flex-row mb-3">
                        <div class="p-2 w-100">
                            <div class="d-flex flex-row">
                                <label for="" class="mr-4 p-label__small">Gender <span class="text-danger"> * </span></label>
                                <div class="w-75">
                                    <select  name="gender_id" class="flex-fill w-100 js-length__input" style="width: 100%; padding:13px;">
                                        @foreach( PcmUser::GENDER as $key => $value )
                                            <option {{ ( $user && ($user->gender_id ==  $key)) ? 'selected' : '' }} value="{{$key}}">{{$value}}</option>
                                        @endforeach
                                    </select>
                                    @error('gender_id')
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
                                <label for="" class="mr-4 p-label__small">Birthday</label>
                                <div class="w-75">
                                    <input type="date" name="birthdate" value="{{old('birthdate', $user->birthdate ?? '')}}" data-field="birthdate" class="p-2 flex-fill w-100 js-length__input">
                                    @error('birthdate')
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
                                <label for="" class="mr-4 p-label__small">Password <span class="text-danger">{{ empty($user) ? ' * ' : '' }}</span></label>
                                <div class="w-75">
                                    <input type="password" name="password" value="{{old('password')}}" data-field="password" class="p-2 flex-fill w-100 js-length__input">
                                    @error('password')
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
        <div class="col-12 mt-4">
            <div class="d-flex flex-row mb-3 justify-content-center">
                <input class="btn btn-success" type="submit" value="Save">
                <button type="button" class="btn btn-primary ml-2" onClick="location.reload()">Cancel</button>
            </div>
        </div>
    </div>
    <input require type="hidden" name="is_form_detail" value="1" />
    <input type="hidden" name="user_id" value="{{old('user_id', $user->id ?? '')}}" />
</form>
</div>
@endsection
@section('scripts')
<!-- parsley.js -->
<script src="{{ asset('js/admin/common.js') }}"></script>
@endsection
