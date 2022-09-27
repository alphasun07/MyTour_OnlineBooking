
@extends('admin.layout.app')
@section('title')
{{ 'Admin Manager' }}
@endsection
@section('content')
@section('pageTitle')
@include('admin.common.page-title', ['title' => 'Manager', 'subTitle' => 'Admin Manager'])
@endsection
    <div class="row ml-0">
        <div class="col-12 pl-0">
            <div class="d-flex flex-row">
                <span class="w-25">
                    <a class="btn btn-success btn-block" href="{{route('admin.add')}}">Add Admin</a>
                </span>
            </div>
        </div>
        <div class="col-12 pl-0">
            <div class="d-flex flex-row">
                <div class="o-container__background--white x_panel">
                    <form method="get" action="">
                        <div class="border-bottom p-2 pl-2">
                            <input type="text" name="name" class="col-4 p-2" value="{{ $searchData['name'] ?? '' }}" placeholder="Search">
                            <input type="submit" class="btn btn-dark ml-2" value="Search">
                        </div>
                    </form>
                    <dl class="o-dl__display--table">
                        <dt class="o-dtDd__display--table-cell text-left o-dt__width--1"></dt>
                        <dt class="o-dtDd__display--table-cell text-left o-dt__width--2">#</dt>
                        <dt class="o-dtDd__display--table-cell text-left">Name</dt>
                        <dt class="o-dtDd__display--table-cell text-left">Account Name</dt>
                        <dt class="o-dtDd__display--table-cell text-left">Phone</dt>
                        <dt class="o-dtDd__display--table-cell o-dt__width--5">　</dt>
                    </dl>
                    <div id="js-sortable">
                        @if ($members->count() != 0)
                            @foreach ($members as $member)
                                <div class="p0">
                                    <dl class="o-dl__display--table parent" data-sort="{{ $member->id }}">
                                        <dd class="o-dtDd__display--table-cell text-left o-dt__width--1"></dd>
                                        <dd class="o-dtDd__display--table-cell text-left o-dt__width--2">{{$loop->iteration}}</dd>
                                        <dd class="o-dtDd__display--table-cell text-left"><a href="{{ route('admin.detail', ['id' => $member->id])}}">{{ $member->name ?? '' }}</a></dd>
                                        <dd class="o-dtDd__display--table-cell text-left">{{ $member->login_id ?? '' }}</dd>
                                        <dd class="o-dtDd__display--table-cell text-left">{{ $member->phone_number ?? '' }}</dd>
                                        <dd class="o-dtDd__display--table-cell o-iconRight pr-3 o-dt__width--5">
                                            <a href="{{ route('admin.detail', ['id' => $member->id])}}">
                                                <i class="fas fa-pencil-alt o-fontSize_1-5 pr-5"></i>
                                            </a>
                                                <i data-action="{{ route('admin.delete')}}" data-id="{{ $member->id}}" class="far fa-times o-fontSize_1-5 js-delete-custom--ajax"></i>
                                        </dd>
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
                        <div class="d-flex justify-content-center">{{$members->links()}}</div>
                    </div>
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
