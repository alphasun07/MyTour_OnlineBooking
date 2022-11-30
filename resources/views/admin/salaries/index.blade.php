@php
use App\Models\Post;
use Carbon\Carbon;
$now = Carbon::now();
@endphp
@extends('admin.layout.app')
@section('title')
{{ 'Quản lý lương' }}
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
@include('admin.common.page-title', ['title' => 'Quản lý', 'subTitle' => 'Quản lý lương'])
@endsection
    @csrf
    <div class="row ml-0">
        <div class="col-12 pl-0">
            <div class="d-flex flex-row">
                <span class="w-25">
                    <a class="btn btn-success btn-block" href="{{route('admin.salary.add')}}">Tính lương tháng hiện tại</a>
                </span>
            </div>
        </div>
        <div class="col-12 pl-0">
            <div class="d-flex flex-row">
                <div class="o-container__background--white x_panel">
                    <form method="get" action="">
                        <div class="border-bottom p-2 pl-2 d-flex">
                            <input class="form-control pr-2" type="number" name="month" min="1" max="12" value="{{ isset($searchData['month']) ? $searchData['month'] : $now->month }}">
                            <input class="form-control pr-2" type="number" name="year" min="1" max="12" value="{{ isset($searchData['year']) ? $searchData['year'] : $now->year }}">
                        <input class="form-control pr-2" type="text" name="name" placeholder="Search name" value="{{ isset($searchData['name']) ? $searchData['name'] : '' }}">
                            <input type="submit" class="btn btn-dark ml-2" value="Search">
                        </div>
                    </form>
                    <dl class="o-dl__display--table">
                        <dt class="o-dtDd__display--table-cell o-dt__width--1"></dt>
                        <dt class="o-dtDd__display--table-cell text-left o-dt__width--2">#</dt>
                        <dt class="o-dtDd__display--table-cell o-dt__width--7 text-left">Nhân viên</dt>
                        <dt class="o-dtDd__display--table-cell o-dt__width--7 text-center">Lương</dt>
                        <dt class="o-dtDd__display--table-cell o-dt__width--7 text-center">Số công</dt>
                        <dt class="o-dtDd__display--table-cell o-dt__width--5"></dt>
                    </dl>
                    <div id="js-sortable">
                        @if ($salaries->count() != 0)
                            @foreach ($salaries as $salary)
                                <dl class="o-dl__display--table">
                                    <dd class="o-dtDd__display--table-cell text-left o-dt__width--1"></dd>
                                    <dd class="o-dtDd__display--table-cell text-left o-dt__width--2">{{ $loop->iteration }}</dd>
                                    <dd class="o-dtDd__display--table-cell text-left o-dt__width--7">{{ $salary->member->name ?? '' }}</dd>
                                    <dd class="o-dtDd__display--table-cell text-center o-dt__width--7">{{ $salary->monthly_salary ?? '' }}</dd>
                                    <dd class="o-dtDd__display--table-cell text-center o-dt__width--7">{{ ($salary->countDayWorked[0])->total_day ?? '' }}</dd>
                                    <dd class="o-dtDd__display--table-cell o-iconRight pr-3 o-dt__width--5"><a href="{{ route('admin.salary.detail', ['id' => $salary->id ?? ''])}}"><i class="fas fa-pencil-alt o-fontSize_1-5 pr-5"></i></a></dd>
                                </dl>
                            @endforeach
                        @else
                            <tr>
                                <center>
                                    <td colspan="4" style="text-align: center;">No data found</td>
                                </center>
                            </tr>
                        @endif
                        <div class="d-flex justify-content-center">{{$salaries->links()}}</div>
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
