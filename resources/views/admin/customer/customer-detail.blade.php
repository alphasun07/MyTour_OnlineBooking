    @extends('admin.layout.app')

@php
use Carbon\Carbon;
use App\Models\DtbCustomer;
use App\Helpers\Helper;
@endphp
@section('title')
{{ '会員詳細' }}
@endsection
@section('content')
    @section('pageTitle')
    @include('admin.common.page-title', ['title' => '会員管理', 'subTitle' => '会員詳細'])
    @endsection
    <!-- Modal -->
    <div class="modal fade" id="js-media" tabindex="-1" role="dialog" aria-labelledby="mediaLabel" aria-hidden="true">
        <div class="modal-dialog p-modalDialog__width" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="mediaLabel">お届け先住所</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></button>
                </div>
                <form method="POST" action="{{route('admin.customer.updateCustomerAddress')}}" id="is-address__form">
                    @csrf
                <div class="modal-body o-col__padding--right--left pt-2">
                    <div class="d-flex flex-column mb-3 o-container__background--white">
                        <!-- 会員のidを取得 -->
                        <input type="hidden" name="customerLists_id" id="p-customerListId" value="">
                        <input type="hidden" name="customer_address_id">
                        <input type="hidden" name="customer_id" value="{{$customer['id']}}">
                        <div class="col-12">
                            <div class="d-flex flex-row mb-3">
                                <div class="p-2 mr-4 col-2">
                                    <div class="d-flex flex-row pt-2">
                                        <label for="">お名前</label for="">
                                        <p class="rounded text-white bg-dark o-needMark__size ml-1">必須</p>
                                    </div>
                                </div>
                                <div class="pt-2 pb-2 col-8">
                                    <div class="d-flex flex-row">
                                        <div class="d-flex flex-row">
                                            <div class="col-5">
                                                <input type="text" name="name01" value="" class="w-100 p-2 flex-fill">
                                                <strong id="name01" class="text-danger"></strong>
                                            </div>
                                            <div class="col-5">
                                                <input type="text" name="name02" value="" class="w-100 p-2 flex-fill">
                                                <strong id="name02" class="text-danger"></strong>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-flex flex-row mb-3">
                                <div class="p-2 mr-4 col-2">
                                    <div class="d-flex flex-row pt-2">
                                        <label for="" class="text-nowrap">お名前（カナ)</label for="">
                                        <p class="rounded text-white bg-dark o-needMark__size ml-1 text-nowrap">必須</p>
                                    </div>
                                </div>
                                <div class="pt-2 pb-2 col-8">
                                    <div class="d-flex flex-row">
                                        <div class="d-flex flex-row">
                                            <div class="col-5">
                                                <input type="text" name="kana01" value="" class="w-100 p-2 flex-fill">
                                                <strong id="kana01" class="text-danger"></strong>
                                            </div>
                                            <div class="col-5">
                                                <input type="text" name="kana02" value="" class="w-100 p-2 flex-fill">
                                                <strong id="kana02" class="text-danger"></strong>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-flex flex-row mb-3">
                                <div class="pt-2 pl-2 pr-1">
                                    <div class="d-flex flex-row pt-2">
                                        <label for="" class="text-nowrap">住所　（郵便番号）</label for="">
                                        <p class="rounded text-white bg-dark o-needMark__size ml-0 text-nowrap">必須</p>
                                    </div>
                                </div>
                                <div class="pt-2 pb-2 flex-fill">
                                    <div class="d-flex flex-column">
                                        <div class="h-adr">
                                            <span class="p-country-name" style="display:none;">Japan</span>
                                            <span class="d-flex flex-row ml-3">
                                                <span class="h4 mt-1">〒</span>
                                                <div>
                                                    <div class="ml-2">
                                                        <input type="text" name="postal_code" value="" class="p-postal-code p-2 flex-fill">
                                                    </div>
                                                </div>
                                            </span>
                                            <div class="flex-fill ml-4"><strong id="postal_code" class="text-danger ml-4"></strong></div>
                                            <select id="pref_name" name="pref_id" class="p-region-id col-6 mt-4 p-2">
                                                <!-- 都道府県情報をとってきてforeach -->
                                                <option selected class="pref_name" value="">選択してください</option>
                                                @foreach($pref_lists as $value)
                                                <option value="{{$value->id}}">{{$value->name}}</option>
                                                @endforeach
                                            </select>
                                            <div class="flex-fill"><strong id="pref_id" class="text-danger"></strong></div>
                                            <input type="text" name="addr01" value="" class="p-locality p-2 mt-3 flex-fill col-10" placeholder="市区町村">
                                            <div class="flex-fill"><strong id="addr01" class="text-danger"></strong></div>
                                            <input type="text" name="addr02" value="" class="p-street-address p-2 mt-3 flex-fill col-10" placeholder="番地">
                                            <div class="flex-fill"><strong id="addr02" class="text-danger"></strong></div>
                                            <input type="text" name="addr03" value="" class="p-extended-address p-2 mt-3 flex-fill col-10" placeholder="建物名・号室">
                                            <div class="flex-fill"><strong id="addr03" class="text-danger"></strong></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-flex flex-row mb-3">
                                <div class="pt-2 pb-2 pl-2 pr-3 mr-5">
                                    <div class="d-flex flex-row mt-2">
                                        <label for="">電話番号</label for="">
                                        <p class="rounded text-white bg-dark o-needMark__size ml-1">必須</p>
                                    </div>
                                </div>
                                <div class="pt-2 pb-2 pr-2 flex-fill">
                                    <input type="text" name="phone_number" value="" class="p-2 col-11">
                                    <div class="flex-fill"><strong id="phone_number" class="text-danger"></strong></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top-0 justify-content-center">
                    <button type="button" class="btn btn-dark rounded w-25" onclick="updateCustomerAddress()">登録</button>
                    <button type="button" class="btn btn-primary rounded w-25" data-dismiss="modal">キャンセル</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <form method="POST" action="{{route('admin.customer.update')}}">
        @csrf
        <div class="row ml-2">
            <div class="col-12 o-col__padding--right--left x_panel">
                <div class="d-flex flex-column">
                    <h5 class="border-bottom p-4">会員情報</h5>
                    @if(!empty($customer->customer_status_id) && $customer->customer_status_id == DtbCustomer::CUSTOMER_STATUS_ID_WITHDRAW)
                    <div class="alert alert-warning text-center" role="alert">
                        退会申請中
                    </div>
                    @endif
                    <div class="d-flex flex-column mb-3 o-container__background--white">
                        <div class="col-12">
                            <div class="d-flex flex-row mb-3">
                                <div class="p-2 w-25">会員ID</div>
                                    {{ $customer->id }}
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-flex flex-row mb-3">
                                <div class="p-2 w-25">
                                    <span for="">お名前</span>
                                </div>
                                <div class="p-2 w-75">
                                    {{ $customer->name01 }} {{ $customer->name02 }}
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-flex flex-row mb-3">
                                <div class="p-2 w-25">
                                    <span for="">お名前（カナ）</span>
                                </div>
                                <div class="p-2 w-75">
                                    {{ $customer->kana01 }} {{ $customer->kana02 }}
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-flex flex-row mb-3">
                                <div class="p-2 w-25">
                                    <span for="">住所</span>
                                </div>
                                <div class="p-2 w-75">
                                    <p>〒 {{ $customer->postal_code }}</p>
                                    <p>{{ $customer->preg_name }}</p>
                                    <p>{{ $customer->addr01 }}</p>
                                    <p>{{ $customer->addr02 }}</p>
                                    <p>{{ $customer->addr03 }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-flex flex-row mb-3">
                                <div class="p-2 w-25">
                                    <span>メールアドレス</span>
                                </div>
                                @if($latest_order)
                                    <div class="p-2 w-75">
                                        <p>{{ $latest_order->email }}</p>                                        
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-flex flex-row mb-3">
                                <div class="p-2 w-25">
                                    <span>電話番号</span>
                                </div>
                                <div class="p-2 w-75">
                                    <p>{{ $customer->phone_number }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-flex flex-row mb-3">
                                <div class="p-2 w-25">
                                    <span class="">性別</span>
                                </div>
                                <div class="p-2 w-75">
                                    <p>{{ $customer->sex_name }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-flex flex-row mb-3">
                                <div class="p-2 w-25">
                                    <span class="">誕生日</span>
                                </div>
                                <div class="p-2 w-75">
                                    <p>{{ $customer->birth }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-flex flex-row mb-3">
                                <div class="p-2 w-25">
                                    <div class="d-flex flex-row">
                                        <label for="">ブラックリスト</label for="">
                                        <p class="rounded text-white bg-dark o-needMark__size">必須</p>
                                    </div>
                                </div>
                                <div class="p-2 w-75">
                                    <div class="d-flex flex-row">
                                        <div class="custom-control custom-radio">
                                            <div>
                                            <input type="radio" class="custom-control-input" id="yet" name="black_list" {{$customer['black_list']=="0" ? "checked" : "" }}>
                                            <label for="yet" class="custom-control-label">未</label>
                                            </div>
                                        </div>
                                        <div class="ml-3 custom-control custom-radio">
                                            <input type="radio" value="1" class="custom-control-input" id="done" name="black_list" {{$customer['black_list']=="1" ? "checked" : "" }}>
                                            <label for="done" class="custom-control-label">ブラックリストに入れる</label>
                                        </div>
                                    </div>
                                    @error('black_list')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 o-col__padding--right--left x_panel">
                <div class="d-flex flex-column">
                    <h5 class="border-bottom p-3">アクセス履歴</h5>
                    <span class="pl-2 pr-2">
                        <dl class="o-dl__display--table o-backColor__gray--thick mb-0">
                            <dt class="o-dtDd__display--table-cell o-iconLeft pl-3">期間</dt>
                            <dt class="o-dtDd__display--table-cell">アクセス回数</dt>
                        </dl>
                        <!-- ユーザー情報をforeachで表示 -->
                        @foreach($customer_access_histories as $value)
                        <dl class="o-dl__display--table mb-0">
                            <dd class="o-dtDd__display--table-cell o-iconLeft pl-3">{{Carbon::parse($value->created_at)->format('Y/m/01')}} ~ {{Carbon::parse($value->created_at)->format('Y/m/t')}}</dd>
                            <dd class="o-dtDd__display--table-cell">{{$value->access_count}}</dd>
                        </dl>
                        @endforeach
                    </span>
                </div>
            </div>
            <div class="col-12 o-col__padding--right--left x_panel">
                <div class="d-flex flex-column">
                    <h5 class="border-bottom p-3">お届け先住所</h5>
                    <span class="pl-2 pr-2">
                        <dl class="o-dl__display--table o-backColor__gray--thick mb-0">
                            <dt class="o-dtDd__display--table-cell o-iconLeft pl-3 o-dt__width--20">お名前</dt>
                            <dt class="o-dtDd__display--table-cell o-iconLeft">住所</dt>
                            <dt class="o-dtDd__display--table-cell">電話番号</dt>
                            <dt class="o-dtDd__display--table-cell">　</dt>
                        </dl>
                        <!-- ユーザー情報をforeachで表示 -->
                        @foreach($customer_addresses as $value)
                            <dl class="o-dl__display--table mb-0">
                                <dd class="o-dtDd__display--table-cell o-iconLeft pl-3 o-dt__width--20">{{$value->name01}} {{ $value->name02 }}</dd>
                                <dd class="o-dtDd__display--table-cell o-iconLeft">〒{{$value->postal_code}} {{$value->pref['name'] ?? ''}}{{$value->addr01}}{{$value->addr02}}{{$value->addr03}}</dd>
                                <dd class="o-dtDd__display--table-cell">{{$value->phone_number}}</dd>
                                <!-- send_id（ここにこの行のid値を入れる） -->
                                <dd class="o-dtDd__display--table-cell o-iconRight pr-3">
                                    <div data-toggle="modal" data-target="#js-media" onclick="getCustomerAddressById({{$value->id}})">
                                        <i class="fas fa-pencil-alt fa-2x"></i>
                                    </div>
                                </dd>
                            </dl>
                        @endforeach
                    </span>
                </div>
            </div>
            <div class="col-12 o-col__padding--right--left x_panel">
                <div class="d-flex flex-column">
                    <h5 class="border-bottom p-3">注文履歴</h5>
                    <span class="pl-2 pr-2">
                        <dl class="o-dl__display--table o-backColor__gray--thick mb-0">
                            <dt class="o-dtDd__display--table-cell o-iconLeft pl-3 o-dt__width--20">日付</dt>
                            <dt class="o-dtDd__display--table-cell o-iconLeft">受注番号</dt>
                            <dt class="o-dtDd__display--table-cell">購入金額</dt>
                            <dt class="o-dtDd__display--table-cell">対応状況</dt>
                        </dl>
                        <!-- ユーザー情報をforeachで表示 -->
                        @foreach($orders as $value)
                        <dl class="o-dl__display--table mb-0">
                            <dd class="o-dtDd__display--table-cell o-iconLeft pl-3 o-dt__width--20">{{ Carbon::parse($value->order_date)->format('Y/m/d G:i')}}</dd>
                            <dd class="o-dtDd__display--table-cell o-iconLeft">{{$value->id}}</dd>
                            <dd class="o-dtDd__display--table-cell">{{(new Helper)->formatPrice($value->payment_total ?? 0)}}</dd>
                            <dd class="o-dtDd__display--table-cell p-3"><span class="p-status__gray p-2">{{$value->mtbOrderStatus->name ?? ''}}</span></dd>
                        </dl>
                        @endforeach
                    </span>
                </div>
            </div>
            <div class="col-12 o-col__padding--right--left x_panel">
                <div class="d-flex flex-column">
                    <h5 class="border-bottom p-3">ショップ用メモ欄</h5>
                    <div class="col-12 border-bottom p-2">
                        <div class="d-flex flex-row mb-3">
                            <div class="d-flex flex-row">
                                <textarea id="" name="note" cols="140" rows="6" class="w-100">{{$customer['note']}}</textarea>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="customer_id" value="{{$customer['id']}}">
                </div>
            </div>
            <div class="col-12 o-col__padding--right--left">
                <div class="d-flex flex-row">
                    <div class="col-3 mt-5 mb-5">
                        @if(!empty($customer->customer_status_id) && $customer->customer_status_id == DtbCustomer::CUSTOMER_STATUS_ID_WITHDRAW)
                            <button type="button" class="btn btn-dark col-5" onclick="unsubscribe({{$customer['id']}})">退会申請解除</button>
                        @endif
                    </div>
                    <div class="col-6 mt-5 mb-5">
                        <button type="submit" class="btn btn-success mr-3 col-4">登録</button>
                        <button type="button" class="btn btn-primary pl-3 col-4" onClick="location.reload()">キャンセル</button>
                    </div>
                    <div class="col-3 mt-5 mb-5 text-right">
                    <button type="button" class="btn btn-dark ml-4 col-5 js-delete-custom--ajax" data-id="{{ $customer['id'] }}"
                        data-action="{{ route('admin.customer_detail.delete') }}"
                        data-confirm="この会員を削除してもいいですか。">会員情報削除
                    </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    </div>
@endsection
@section('scripts')
<script src="{{ asset('yubinbango-gh-pages/yubinbango.js') }}" charset="UTF-8"></script>
<script src="{{ asset('js/admin/bootbox.min.js') }}"></script>
<script src="{{ asset('js/admin/common.js') }}"></script>
<script>
    function getCustomerAddressById(id) {
        $.ajax({
            url: 'customer-address/' + id,
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                $('input[name=customer_address_id]').val(data['id'])
                $('input[name=name01]').val(data['name01'])
                $('input[name=name02]').val(data['name02'])
                $('input[name=kana01]').val(data['kana01'])
                $('input[name=kana02]').val(data['kana02'])
                $('input[name=postal_code]').val(data['postal_code']);
                $('input[name=addr01]').val(data['addr01'])
                $('input[name=addr02]').val(data['addr02'])
                $('input[name=addr03]').val(data['addr03'])
                $('input[name=phone_number]').val(data['phone_number'])
                $("#pref_name").val(data['pref_id']);
            },
            error: function(error) {}
        });
    }
    function unsubscribe(id) {
        commonConfirm('退会申請を解除してもよろしいですか。', function (result) {
            if (result) {
                $.ajax({
                    url: "{{route('admin.customer.unsubscribe')}}/" + id,
                    type: 'POST',
                    dataType: 'json',
                    success: function(data) {
                        location.reload();
                    },
                    error: function(error) {}
                })
            }
        });
    }

    function updateCustomerAddress() {
        $.ajax({
            url: "{{route('admin.customer.updateCustomerAddress')}}",
            type: 'POST',
            data: $("#is-address__form").serialize(),
            dataType: 'json',
        }).done(function(data) {
            if(!data.status) {
                $('.text-danger').remove();
                $.each(data.errors, function (key, error_value) {
                    $('input[name="'+key+'"]').after("<div class='text-danger'><strong>"+error_value+"</strong></div>");
                });
            } else {
                location.reload();
                window.scrollTo(0, 0);
            }
        }).fail(function(jqXHR){
            var errors = jqXHR.responseJSON.errors;
            console.log(errors);
            if(errors.name01){
                var name01 = document.getElementById("name01");
                name01.innerHTML = errors.name01;
            }
            if(errors.name02){
                var name02 = document.getElementById("name02");
                name02.innerHTML = errors.name02;
            }
            if(errors.kana01){
                var kana01 = document.getElementById("kana01");
                kana01.innerHTML = errors.kana01;
            }
            if(errors.kana02){
                var kana02 = document.getElementById("kana02");
                kana02.innerHTML = errors.kana02;
            }
            if(errors.addr01){
                var addr01 = document.getElementById("addr01");
                addr01.innerHTML = errors.addr01;
            }
            if(errors.addr02){
                var addr02 = document.getElementById("addr02");
                addr02.innerHTML = errors.addr02;
            }
            if(errors.addr03){
                var addr03 = document.getElementById("addr03");
                addr03.innerHTML = errors.addr03;
            }
            if(errors.phone_number){
                var phone_number = document.getElementById("phone_number");
                phone_number.innerHTML = errors.phone_number;
            }
            if(errors.postal_code){
                var postal_code = document.getElementById("postal_code");
                postal_code.innerHTML = errors.postal_code;
            }
            if(errors.pref_id){
                var pref_id = document.getElementById("pref_id");
                pref_id.innerHTML = errors.pref_id;
            }
        })
    }
</script>
<style>
.p-status__gray{
    background: #e1e1e1;
    border-radius: 5px;
}
</style>
@endsection