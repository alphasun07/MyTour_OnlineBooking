@php
use App\Models\Coupon;
@endphp
@extends('admin.layout.app')
@section('title')
    {{ 'Quản lý khuyến mãi' }}
@endsection
@section('content')
    @section('pageTitle')
        @include('admin.common.page-title', ['title' => 'Quản lý', 'subTitle' => 'khuyến mãi'])
    @endsection
    <div class="row ml-0">
        <div class="col-12 pl-0">
            <div class="d-flex flex-row">
            <span class="w-25">
                <a class="btn btn-success btn-block" href="{{route('admin.coupon.add')}}">Add new</a>
            </span>
            </div>
        </div>
        <div class="col-12 pl-0">
            <div class="d-flex flex-row">
                <div class="o-container__background--white x_panel">
                    <form method="get" action="">
                        <div class="border-bottom p-2 pl-2">
                            <input type="text" name="name" class="col-4 p-2" value="{{ $searchData['name'] ?? '' }}" placeholder="Search coupon">
                            <input type="submit" class="btn btn-dark ml-2" value="Search">
                        </div>
                    </form>
                    <dl class="o-dl__display--table">
                        <dt class="o-dtDd__display--table-cell o-dt__width--1"></dt>
                        <dt class="o-dtDd__display--table-cell o-dt__width--1"><input class="form-check-input checkall" type="checkbox" value="" id="flexCheckDefault"></dt>
                        <dt class="o-dtDd__display--table-cell  text-left">Code</dt>
                        <dt class="o-dtDd__display--table-cell text-left">Type</dt>
                        <dt class="o-dtDd__display--table-cell">Discount</dt>
                        <dt class="o-dtDd__display--table-cell">Times</dt>
                        <dt class="o-dtDd__display--table-cell o-dt__width--5">Used</dt>
                        <dt class="o-dtDd__display--table-cell o-dt__width--5">Published</dt>
                        <dt class="o-dtDd__display--table-cell o-dt__width--10"></dt>
                    </dl>
                    <div id="js-sortable">
                        @if ($coupons->count() != 0)
                            @foreach ($coupons as $coupon)
                                <div class="p0">
                                    <dl class="o-dl__display--table parent" data-sort="{{ $coupon->id }}">
                                        <dd class="o-dtDd__display--table-cell o-dt__width--1"></dd>
                                        <dd class="o-dtDd__display--table-cell o-dt__width--1"><input class="form-check-input checkbox_children" type="checkbox" value="" id="flexCheckDefault"></dd>
                                        <dd class="o-dtDd__display--table-cell text-left"><a href="{{ route('admin.coupon.detail', ['id' => $coupon->id]) }}">{{$coupon->code ?? ''}}</a></dd>
                                        <dd class="o-dtDd__display--table-cell text-left">{{Coupon::TYPE[$coupon->coupon_type] ?? ''}}</dd>
                                        <dd class="o-dtDd__display--table-cell">{{$coupon->discount ?? ''}}</dd>
                                        <dd class="o-dtDd__display--table-cell">{{$coupon->times ?? ''}}</dd>
                                        <dd class="o-dtDd__display--table-cell o-dt__width--5">{{$coupon->used ?? ''}}</dd>
                                        <dd class="o-dtDd__display--table-cell o-dt__width--5" ><i class="fa {{ $coupon->published == '1' ? 'fa-check-circle text-success' : 'fa-times-circle text-danger' }}" aria-hidden="true"></i></dd>
                                        <dd class="o-dtDd__display--table-cell o-iconRight pr-3 o-dt__width--10">
                                            <a href="{{ route('admin.coupon.detail', ['id' => $coupon->id])}}"><i class="fas fa-pencil-alt o-fontSize_1-5 pr-5"></i></a>
                                            <i data-action="{{ route('admin.coupon.delete') }}" data-id="{{ $coupon->id}}" class="far fa-times o-fontSize_1-5 js-delete-custom--ajax"></i></dd>
                                    </dl>
                                </div>
                            @endforeach
                        @else
                            <tr>
                                <center>
                                    <td colspan="4" style="text-align: center;">No data found</td>
                                </center>
                            </tr>
                        @endif
                        <div class="d-flex justify-content-center">{{$coupons->links()}}</div>
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" name="category_id" value="">
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('js/admin/bootbox.min.js') }}"></script>
    <script src="{{ asset('js/jquery-ui-1.13.1/jquery-ui.js') }}"></script>
    <script src="{{ asset('js/admin/common.js') }}"></script>
    <script>
        $(function () {

            $('.checkall').on('click', function () {
                $(this).parents().find('.checkbox_children').prop('checked', $(this).prop('checked'));
            });
        });
    </script>
@endsection
