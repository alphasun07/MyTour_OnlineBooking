@php
use App\Models\PcmDmsOrder;
@endphp
@extends('admin.layout.app')
@section('title')
{{ 'Order management' }}
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
@include('admin.common.page-title', ['title' => 'Management', 'subTitle' => 'Order management'])
@endsection
    @csrf
    <div class="row ml-0">
        <div class="col-12 pl-0">
            <div class="d-flex flex-row">
                <span class="w-25">
                    <a class="btn btn-success btn-block" href="{{route('admin.order.add')}}">Add new</a>
                </span>
            </div>
        </div>
        <div class="col-12 pl-0">
            <div class="d-flex flex-row">
                <div class="o-container__background--white x_panel">
                    <form method="get" action="">
                        <div class="border-bottom p-2 pl-2">
                            <input type="text" name="name" class="col-4 p-2" value="{{ $searchData['name'] ?? '' }}" placeholder="Search order">
                            <input type="submit" class="btn btn-dark ml-2" value="Search">
                        </div>
                    </form>
                    <dl class="o-dl__display--table">
                        <dt class="o-dtDd__display--table-cell o-dt__width--1"></dt>
                        <dt class="o-dtDd__display--table-cell text-left o-dt__width--2">#</dt>
                        <dt class="o-dtDd__display--table-cell o-dt__width--8 text-left">First name</dt>
                        <dt class="o-dtDd__display--table-cell o-dt__width--8 text-left">Last name</dt>
                        <dt class="o-dtDd__display--table-cell o-dt__width--8 text-left">Email</dt>
                        <dt class="o-dtDd__display--table-cell o-dt__width--8 text-left">Items</dt>
                        <dt class="o-dtDd__display--table-cell o-dt__width--8 text-center">Order date</dt>
                        <dt class="o-dtDd__display--table-cell o-dt__width--8 text-center">Amount</dt>
                        <dt class="o-dtDd__display--table-cell o-dt__width--8 text-center">Order status</dt>
                        <dt class="o-dtDd__display--table-cell o-dt__width--5"></dt>
                    </dl>
                    <div id="js-sortable">
                        @if ($orders->count() != 0)
                            @foreach ($orders as $order)
                                <dl class="o-dl__display--table">
                                    <dd class="o-dtDd__display--table-cell text-left o-dt__width--1"></dd>
                                    <dd class="o-dtDd__display--table-cell text-left o-dt__width--2">{{$loop->iteration}}</dd>
                                    <dd class="o-dtDd__display--table-cell text-left o-dt__width--8">{{ $order->first_name ?? '' }}</dd>
                                    <dd class="o-dtDd__display--table-cell text-left o-dt__width--8">{{ $order->last_name ?? '' }}</dd>
                                    <dd class="o-dtDd__display--table-cell text-left o-dt__width--8">{{ $order->email ?? '' }}</dd>
                                    <dd class="o-dtDd__display--table-cell text-left o-dt__width--8"><div class="item-cell">@foreach ($order->documents as $item){{ $item ? ($item->title ?? '') : '' }}<br>@endforeach</div></dd>
                                    <dd class="o-dtDd__display--table-cell text-center o-dt__width--8">{{ !is_null($order->created_at) ? $order->created_at->format(config('const.format.date_time')) : '' }}</dd>
                                    <dd class="o-dtDd__display--table-cell text-center o-dt__width--8">{{ $order->total_amount ? number_format($order->total_amount, 2) : '' }}</dd>
                                    <dd class="o-dtDd__display--table-cell text-center o-dt__width--8"><i class="fa {{ $order->published == PcmDmsOrder::PUBLISHED_ON ? 'fa-check-circle text-success' : 'fa-times-circle text-danger' }}" aria-hidden="true"></i></dd>
                                    <dd class="o-dtDd__display--table-cell o-iconRight pr-3 o-dt__width--5"><a href="{{ route('admin.order.edit', ['id' => $order->id ?? ''])}}"><i class="fas fa-pencil-alt o-fontSize_1-5 pr-5"></i></a><i data-action="{{ route('admin.order.delete')}}" data-id="{{ $order->id ?? '' }}" class="far fa-times o-fontSize_1-5 js-delete-custom--ajax"></i></dd>
                                </dl>
                            @endforeach
                        @else
                            <tr>
                                <center>
                                    <td colspan="4" style="text-align: center;">No data found</td>
                                </center>
                            </tr>
                        @endif
                        <div class="d-flex justify-content-center">{{$orders->links()}}</div>
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
