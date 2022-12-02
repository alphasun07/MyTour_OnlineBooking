@php
use Carbon\Carbon;
$now = Carbon::now();
@endphp
@extends('admin.layout.app')
@section('title')
{{ 'Quản lý công nhật' }}
@endsection
@section('head')
<style>
    .item-cell{
        max-height: 100px;
        overflow-y: auto;
    }
    /* width */
    ::-webkit-scrollbar {
    width: 10px;
    }

    /* Track */
    ::-webkit-scrollbar-track {
    background: #f1f1f1;
    }

    /* Handle */
    ::-webkit-scrollbar-thumb {
    background: #888;
    }

    /* Handle on hover */
    ::-webkit-scrollbar-thumb:hover {
    background: #555;
    }
</style>
@endsection
@section('content')
@section('pageTitle')
@include('admin.common.page-title', ['title' => 'Quản lý', 'subTitle' => 'Quản lý công nhật'])
@endsection
    @csrf
    <div class="row ml-0">
        <div class="col-12 pl-0">
            <div class="d-flex flex-row">
                <span class="w-25">
                    <a class="btn btn-success btn-block" href="{{route('admin.salary.dayWorked.add')}}">Thêm công</a>
                </span>
            </div>
        </div>
        <div class="col-12 pl-0">
            <div class="d-flex flex-row">
                <div class="o-container__background--white x_panel">
                    <dl class="o-dl__display--table">
                        <dt class="o-dtDd__display--table-cell o-dt__width--1"></dt>
                        <dt class="o-dtDd__display--table-cell text-left o-dt__width--2">#</dt>
                        <dt class="o-dtDd__display--table-cell o-dt__width--7 text-left">Nhân viên</dt>
                        <dt class="o-dtDd__display--table-cell o-dt__width--7 text-center">Số công</dt>
                        <dt class="o-dtDd__display--table-cell o-dt__width--7 text-center">Ngày</dt>
                        <dt class="o-dtDd__display--table-cell o-dt__width--5"></dt>
                    </dl>
                    <div id="js-sortable">
                        @if ($daysWorked->count() != 0)
                            @foreach ($daysWorked as $dayWorked)
                                <dl class="o-dl__display--table">
                                    <dd class="o-dtDd__display--table-cell text-left o-dt__width--1"></dd>
                                    <dd class="o-dtDd__display--table-cell text-left o-dt__width--2">{{ $loop->iteration }}</dd>
                                    <dd class="o-dtDd__display--table-cell text-left o-dt__width--7">{{ $dayWorked->member->name ?? '' }}</dd>
                                    <dd class="o-dtDd__display--table-cell text-center o-dt__width--7">{{ $dayWorked->days_count ?? '' }}</dd>
                                    <dd class="o-dtDd__display--table-cell text-center o-dt__width--7">{{ $dayWorked->created_at }}</dd>
                                    <dd class="o-dtDd__display--table-cell o-iconRight pr-3 o-dt__width--5"><a href="{{ route('admin.salary.dayWorked.detail', ['id' => $dayWorked->id ?? ''])}}"><i class="fas fa-pencil-alt o-fontSize_1-5 pr-5"></i></a><i data-action="{{ route('admin.salary.dayWorked.delete')}}" data-id="{{ $dayWorked->id ?? '' }}" class="far fa-times o-fontSize_1-5 js-delete-custom--ajax"></i></dd>
                                </dl>
                            @endforeach
                        @else
                            <tr>
                                <center>
                                    <td colspan="4" style="text-align: center;">No data found</td>
                                </center>
                            </tr>
                        @endif
                        <div class="d-flex justify-content-center">{{$daysWorked->links()}}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
<script src="{{ asset('js/admin/bootbox.min.js') }}"></script>
<script src="{{ asset('js/jquery-ui-1.13.1/jquery-ui.js') }}"></script>
<script src="{{ asset('js/admin/common.js') }}"></script>
@endsection
