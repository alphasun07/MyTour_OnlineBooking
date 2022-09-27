@php
use App\Models\DtbTag;
@endphp
@extends('admin.layout.app')
@section('title')
{{ 'Tag management' }}
@endsection
@section('content')
@section('pageTitle')
@include('admin.common.page-title', ['title' => 'Management', 'subTitle' => 'Tag management'])
@endsection
    @csrf
    <div class="row ml-0">
        <div class="col-12 pl-0">
            <div class="d-flex flex-row">
                <span class="w-25">
                    <a class="btn btn-success btn-block" href="{{route('admin.tag.add')}}">Add new</a>
                </span>
            </div>
        </div>
        <div class="col-12 pl-0">
            <div class="d-flex flex-row">
                <div class="o-container__background--white x_panel">
                    <form method="get" action="">
                        <div class="border-bottom p-2 pl-2">
                            <input type="text" name="name" class="col-4 p-2" value="{{ $searchData['name'] ?? '' }}" placeholder="Search tag">
                            <input type="submit" class="btn btn-dark ml-2" value="Search">
                        </div>
                    </form>
                    <dl class="o-dl__display--table">
                        <dt class="o-dtDd__display--table-cell o-dt__width--1"></dt>
                        <dt class="o-dtDd__display--table-cell text-left o-dt__width--2">#</dt>
                        <dt class="o-dtDd__display--table-cell o-dt__width--8 text-left">Title</dt>
                        <dt class="o-dtDd__display--table-cell o-dt__width--8 text-center">Hits</dt>
                        <dt class="o-dtDd__display--table-cell o-dt__width--8 text-center">Created date</dt>
                        <dt class="o-dtDd__display--table-cell o-dt__width--5"></dt>
                    </dl>
                    <div id="js-sortable">
                        @if ($tags->count() != 0)
                            @foreach ($tags as $tag)
                                <dl class="o-dl__display--table">
                                    <dd class="o-dtDd__display--table-cell text-left o-dt__width--1"></dd>
                                    <dd class="o-dtDd__display--table-cell text-left o-dt__width--2">{{$loop->iteration}}</dd>
                                    <dd class="o-dtDd__display--table-cell text-left o-dt__width--8">{{ $tag->title ?? '' }}</dd>
                                    <dd class="o-dtDd__display--table-cell text-center o-dt__width--8">{{ $tag->hits ?? '' }}</dd>
                                    <dd class="o-dtDd__display--table-cell text-center o-dt__width--8">{{ !is_null($tag->created_at) ? $tag->created_at->format(config('const.format.date_time')) : '' }}</dd>
                                    <dd class="o-dtDd__display--table-cell o-iconRight pr-3 o-dt__width--5"><a href="{{ route('admin.tag.edit', ['id' => $tag->id ?? ''])}}"><i class="fas fa-pencil-alt o-fontSize_1-5 pr-5"></i></a><i data-action="{{ route('admin.tag.delete')}}" data-id="{{ $tag->id ?? '' }}" class="far fa-times o-fontSize_1-5 js-delete-custom--ajax"></i></dd>
                                </dl>
                            @endforeach
                        @else
                            <tr>
                                <center>
                                    <td colspan="4" style="text-align: center;">No data found</td>
                                </center>
                            </tr>
                        @endif
                        <div class="d-flex justify-content-center">{{$tags->links()}}</div>
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
