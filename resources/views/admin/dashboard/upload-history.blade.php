@extends('admin.layout.app')
@php
    use Carbon\Carbon;
    use App\Models\DtbCsv;
@endphp
@section('title')
{{ 'アップロード履歴' }}
@endsection
@section('pageTitle')
    @include('admin.common.page-title', ['title' => 'アップロード履歴'])
@endsection
@section('content')
        <div class="row">
            <div class="col-12">
                <div class="o-container__background--white x_panel">
                    <dl class="o-dl__display--table">
                        <dt class="o-dtDd__display--table-cell o-dt__width--10 o-iconLeft">アップロード項目</dt>
                        <dt class="o-dtDd__display--table-cell o-dt__width--5">アップロード日時</dt>
                        <dt class="o-dtDd__display--table-cell o-dt__width--2 o-iconRight">処理結果</dt>
                    </dl>
                    @foreach($rows as $value)
                    <dl class="o-dl__display--table">
                        <dd class="o-dtDd__display--table-cell o-dt__width--10 o-iconLeft">{{ $value->csv_name ?? '' }}</dd>
                        <dd class="o-dtDd__display--table-cell o-dt__width--5">{{ Carbon::parse($value->created_at)->format('Y/m/d H:i') }}</dd>
                        <dd class="o-dtDd__display--table-cell o-dt__width--2 o-iconRight">
                            @if (isset($value->upload_flag))
                                {{ DtbCsv::UPLOAD_ARRAY[$value->upload_flag] ?? '' }}
                            @endif
                        </dd>
                    </dl>
                    @endforeach
                </div>
                <div class="col-12">
                    <div class="d-flex flex-row mb-3 justify-content-center">
                        <span class="p-4 w-25">
                            {{$rows->links('admin.common.paginator')}}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection