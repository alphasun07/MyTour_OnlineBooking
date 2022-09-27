@extends('admin.layout.app')

@section('title')
{{ '会員管理' }}
@endsection
@section('pageTitle')
    @include('admin.common.page-title', ['title' => '会員管理'])
@endsection
@section('scripts')
    <script src="{{ asset('js/admin/common.js') }}"></script>
    <script>
        var paramsSearch1 = "{{ $data_request['is_search1'] ?? 0 }}";
        var paramsSearch2 = "{{ $data_request['is_search2'] ?? 0 }}";
        if (paramsSearch1 != 0) {
            $('#js-modal__category--genre--top1').addClass('show');
        } else {
            $('#js-modal__category--genre--top1').removeClass('show');
        }
        if (paramsSearch2 != 0) {
            $('#js-modal__category--genre--top2').addClass('show');
        } else {
            $('#js-modal__category--genre--top2').removeClass('show');
        }
    </script>
@stop
@section('content')
        <form id="js-customer-form" method="GET" action="{{ route('admin.customer.list') }}">
            <div class="row ml-2">
            <div class="col-12 o-col__padding--right--left">
                    <div class="d-flex flex-row mb-3">
                        <div class="p-2 w-50">
                            <div class="d-flex flex-column">
                                <div class="pt-2">
                                    <lavel for="">会員ID (完全一致)</lavel>
                                    <input type="text" value="{{$data_request['id'] ?? ''}}" id=""  name="id" class="w-100 mt-2 p-2">
                                </div>
                            </div>
                        </div>
                        <div class="w-50 pt-4">
                            <div class="d-flex flex-column">
                                <label class="pl-4" for="">性別</label>
                                <div class="d-flex flex-row">
                                    @foreach($sex_lists as $key => $value)
                                    <div class="p-checkbox custom-control custom-checkbox">
                                        <input type="checkbox" value="{{$value->id}}" class="custom-control-input btn-dark mt-1" id="{{$value->name}}" name="sex_id[]" 
                                        @if(isset($data_request['sex_id']))
                                            @foreach($data_request['sex_id'] as $val)
                                            {{$val == $value->id ? "checked" : ""}}
                                            @endforeach
                                        @endif
                                        >
                                        <label class="p-checkbox--color pl-4" for="{{$value->name}}">{{$value->name}}</label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 o-paddingLeft-no ml-2">
                    <lavel for="">お名前 (部分一致)</lavel>
                    <input type="text" value="{{$data_request['name'] ?? ''}}" id=""  name="name" class="w-100 mt-2 p-2">
                </div>
                <p class="col-12">
                    <div class="d-flex flex-row">
                        <div data-toggle="collapse" data-target="#js-modal__category--genre--top1" aria-expanded="false" aria-controls="js-modal__category--genre--top1" onclick="modal_category_top1()" id="js-categoryTop">
                            <i class="fas fa-plus p-1 border border-dark o-detailButton__color" id="is-modal__plus--change"></i>
                            <i class="fas fa-minus p-1 border border-dark o-detailButton__color o-displayNone" id="is-modal__minus--change"></i>
                        </div>
                        <label for="js-categoryTop" class="ml-2">オプション検索</label>
                    </div>
                </p>
                <div class="col-12">
                    <div class="collapse o-paddingLeft-no x_panel" id="js-modal__category--genre--top1">
                        <div class="d-flex flex-column">
                            <div class="col-12 o-col__padding--right--left pl-3">
                                <div class="d-flex flex-row mb-3">
                                    <div class="p-2 w-50">
                                        <div class="d-flex flex-column">
                                            <div class="pt-2">
                                                <lavel for="">お名前（カナ）(部分一致)</lavel>
                                                <input type="text" value="{{$data_request['name_kana'] ?? ''}}" id=""  name="name_kana" class="w-100 mt-2 p-2">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="w-50 pl-3 pt-3">
                                        <div class="d-flex flex-column">
                                            <label for="">誕生日</label>
                                            <div class="d-flex flex-row">
                                                <input type="date" value="{{$data_request['birth_start'] ?? ''}}" name="birth_start" class="p-2 col-4">
                                                <h2 class="pl-5 mr-1">～</h2>
                                                <input type="date" value="{{$data_request['birth_end'] ?? ''}}" name="birth_end" class="p-2 col-4">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                             <div class="col-12 o-col__padding--right--left pl-3">
                                <div class="d-flex flex-row mb-3">
                                    <div class="p-2 w-50">
                                        <div class="d-flex flex-column">
                                            <div class="pt-2">
                                                <lavel for="">郵便番号 (部分一致)</lavel>
                                                <input type="text" value="{{$data_request['postal_code'] ?? ''}}" id=""  name="postal_code" class="w-100 mt-2 p-2">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="w-50 pt-4">
                                        <div class="d-flex flex-column">
                                            <div class="d-flex flex-column">
                                                <div class="d-flex flex-row pt-4">
                                                    @foreach($customer_status_lists as $key => $value)
                                                    <div class="p-checkbox custom-control custom-checkbox">
                                                        <input type="checkbox" value="{{$value->id}}" class="custom-control-input btn-dark mt-1" id="{{$value->name}}" name="customer_status_id[]"
                                                        @if(isset($data_request['customer_status_id']))
                                                            @foreach($data_request['customer_status_id'] as $val)
                                                            {{$val == $value->id ? "checked" : ""}}
                                                            @endforeach
                                                        @endif
                                                        >
                                                        <label class="p-checkbox--color pl-4" for="{{$value->name}}">{{$value->name}}</label>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-13 o-paddingLeft-no pl-3">
                                <div class="d-flex flex-row mb-3">
                                    <div class="p-2 w-50">
                                        <div class="d-flex flex-column">
                                            <div class="pt-2">
                                            <lavel for="">住所 (部分一致)</lavel>
                                                <input type="text" value="{{$data_request['address'] ?? ''}}" id=""  name="address" class="w-100 mt-2 p-2">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-13 o-paddingLeft-no pl-3">
                                <div class="d-flex flex-row mb-3">
                                    <div class="p-2 w-50">
                                        <div class="d-flex flex-column">
                                            <div class="pt-2">
                                                <lavel for="">電話番号 (部分一致)</lavel>
                                                <input type="text" value="{{$data_request['phone_number'] ?? ''}}" id=""  name="phone_number" class="w-100 mt-2 p-2">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <p class="col-12">
                    <div class="d-flex flex-row">
                        <div data-toggle="collapse" data-target="#js-modal__category--genre--top2" aria-expanded="false" aria-controls="js-modal__category--genre--top2" onclick="modal_category_top2()" id="js-categoryTop">
                            <i class="fas fa-plus p-1 border border-dark o-detailButton__color" id="is-modal__category_top2--plus--change"></i>
                            <i class="fas fa-minus p-1 border border-dark o-detailButton__color o-displayNone" id="is-modal__category_top2--minus--change"></i>
                        </div>
                        <label for="js-categoryTop" class="ml-2">お届け先情報</label>
                    </div>
                </p>
                <div class="col-12">
                    <div class="col-12 collapse o-paddingLeft-no x_panel" id="js-modal__category--genre--top2">
                        <div class="d-flex flex-column">
                             <div class="col-12 o-col__padding--right--left pl-3">
                                <div class="d-flex flex-row mb-3">
                                    <div class="p-2 w-50">
                                        <div class="d-flex flex-column">
                                            <div class="pt-2">
                                                <lavel for="">お名前 (部分一致)</lavel>
                                                <input type="text" value="{{$data_request['customer_address_name'] ?? ''}}" id=""  name="customer_address_name" class="w-100 mt-2 p-2">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="p-2 w-50">
                                        <div class="d-flex flex-column">
                                            <div class="pt-2">
                                                <lavel for="">郵便番号 (部分一致)</lavel>
                                                <input type="text" value="{{$data_request['customer_address_postal_code'] ?? ''}}" id=""  name="customer_address_postal_code" class="w-100 mt-2 p-2">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 o-col__padding--right--left pl-3">
                                <div class="d-flex flex-row mb-3">
                                    <div class="p-2 w-50">
                                        <div class="d-flex flex-column">
                                            <div class="pt-2">
                                                <lavel for="">お名前（カナ）(部分一致)</lavel>
                                                <input type="text" value="{{$data_request['customer_address_name_kana'] ?? ''}}" id=""  name="customer_address_name_kana" class="w-100 mt-2 p-2">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="p-2 w-50">
                                        <div class="d-flex flex-column">
                                            <div class="pt-2">
                                                <lavel for="">住所 (部分一致)</lavel>
                                                <input type="text" value="{{$data_request['customer_address'] ?? ''}}" id=""  name="customer_address" class="w-100 mt-2 p-2">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-13 o-paddingLeft-no pl-3">
                                <div class="d-flex flex-row mb-3">
                                    <div class="p-2 w-50">&nbsp;</div>
                                    <div class="p-2 w-50">
                                        <div class="d-flex flex-column">
                                            <div class="pt-2">
                                                <lavel for="">電話番号 (部分一致)</lavel>
                                                <input type="text" value="{{$data_request['customer_address_phone_number'] ?? ''}}" id=""  name="customer_address_phone_number" class="w-100 mt-2 p-2">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 p-0">
                    <div class="col-6 mt-5 p-0">
                        <div class="d-flex flex-row">
                            <button type="submit" class="btn btn-dark btn-block text-white w-25">検索</button>
                            <div class="align-self-center ml-4">検索結果：{{ $customer_lists->total() }}件が該当しました</div>
                        </div>
                    </div>
                </div>
                <div class="col-12 o-paddingLeft-no mt-5">
                    <div class="d-flex flex-row justify-content-end">
                        <span class="d-flex">
                        @include('admin.common.paging-dropdown',['limit' => $limit])
                        </span>
                    </div>
                </div>
                <div class="col-12 o-container__background--white">
                    <dl class="o-dl__display--table">
                        <dt class="o-dtDd__display--table-cell o-dt__width--5">ID</dt>
                        <dt class="o-dtDd__display--table-cell o-dt__width--10">お名前</dt>
                        <dt class="o-dtDd__display--table-cell o-dt__width--10">電話番号</dt>
                        <dt class="o-dtDd__display--table-cell o-dt__width--10">ブラックリスト</dt>
                        <dt class="o-dtDd__display--table-cell">　</dt>
                    </dl>
                    @foreach($customer_lists as $value)
                    <dl class="o-dl__display--table">
                        <dd class="o-dtDd__display--table-cell o-dt__width--5">{{$value->id}}</dd>
                        <dd class="o-dtDd__display--table-cell o-dt__width--10">{{$value->name01}} {{$value->name02}}</dd>
                        <dd class="o-dtDd__display--table-cell o-dt__width--10">{{$value->phone_number}}</dd>
                        <dd class="o-dtDd__display--table-cell o-dt__width--10">{{$value->black_list == 1 ? '〇' : ''}}    </dd>
                        <dd class="o-dtDd__display--table-cell o-iconRight pr-3"><a href="{{route('admin.customer.detail',$value->id )}}"><i class="fas fa-pencil-alt o-fontSize_1-5"></i></a></dd>
                    </dl>
                    @endforeach
                </div>
                <div class="col-12 mt-5">
                    <div class="d-flex flex-row mb-3 justify-content-center">
                        <span class="p-4 w-25">
                        {{$customer_lists->appends($_GET)->links('admin.common.paginator')}}
                        </span>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

