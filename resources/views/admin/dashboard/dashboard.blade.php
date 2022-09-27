@extends('admin.layout.app')
@section('title')
{{ 'Dashboard' }}
@endsection
@section('pageTitle')
@include('admin.common.page-title', ['title' => 'Dashboard'])
@endsection
@php
use Carbon\Carbon;
use App\Models\DtbCsv;
@endphp
@section('content')
<div class="row">
    <div class="col-8 flex-wrap">
        <div class="d-flex flex-column">
            <div class="d-flex flex-column mb-3 o-container__background--white x_panel">
                <div class="p-3 border-bottom">Error information</div>
                <!-- エラー情報をとってきてforeach -->
                <div class="d-flex flex-column">
                    <u class="p-3 border-bottom">2021.00.00.00.00 ******An error occurred in the process</u>
                    <u class="p-3 border-bottom">2021.00.00.00.00 ******An error occurred in the process</u>
                    <u class="p-3 border-bottom">2021.00.00.00.00 ******An error occurred in the process</u>
                    <u class="p-3 border-bottom">2021.00.00.00.00 ******An error occurred in the process</u>
                    <u class="p-3 border-bottom">2021.00.00.00.00 ******An error occurred in the process</u>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection