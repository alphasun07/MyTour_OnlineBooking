@extends('admin.layout.app')
@section('title')
{{ 'Quản lý hóa đơn' }}
@endsection
@php
use App\Models\Order;
use Carbon\Carbon;
@endphp
@section('content')
<form method="POST" action="{{ route('admin.order.store') }}">
    @csrf
    <div class="row ml-2">
        <div class="d-flex flex-row col-12 p-0">
            <div class="mt-0 border-0 w-100 o-container__background--white o-col__padding--right--left x_panel">
                <div class="col-12 pt-5">
                    <div class="d-flex flex-row mb-3">
                        <div class="p-2 w-100">
                            <div class="d-flex flex-row">
                                <label for="" class="p-label__medium mr-4">ID</label>
                                <div class="w-75">
                                    {{ !empty($order) ? str_pad($order->id, 10, '0', STR_PAD_LEFT) : str_pad(Order::max('id') + 1, 10, '0', STR_PAD_LEFT) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 d-flex">
                    <div class=" p-2">
                        <div class="d-flex flex-row">
                            <div class="d-flex flex-row">
                                <label>Trạng thái</label>
                            </div>
                            <div class="ml-5 custom-control custom-radio">
                                <input type="radio" class="custom-control-input" id="display" name="published" value="1" {{ ((!old() && isset($order->published) && $order->published == Order::PUBLISHED_ON) || is_null($order) || (old() && old('order') == Order::PUBLISHED_ON)) ?  'checked' : '' }}>
                                <label for="display" class="custom-control-label">Có</label>
                            </div>
                            <div class="ml-3 custom-control custom-radio">
                                <input type="radio" class="custom-control-input" id="hide" name="published" value="0" {{ ((!old() && isset($order->published) && $order->published == Order::PUBLISHED_OFF) || (old() && old('order') == Order::PUBLISHED_OFF)) || (!old() && isset($order) && (!isset($order->published) || is_null($order->published))) ?  'checked' : '' }}>
                                <label for="hide" class="custom-control-label">Không</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="d-flex flex-row mb-3">
                        <div class="p-2 w-100">
                            <div class="d-flex flex-row">
                                <label for="" class="mr-4 p-label__medium">Tour<span class="text-danger"> * </span></label>
                                <div class="w-50">
                                    <select name="tour_id" class="form-control" id="chosen_tours">
                                        @foreach ($tours as $tour)
                                            <option value="{{ $tour->id ?? '' }}" {{ (isset($order->tour_id) && $tour->id==$order->tour_id) ? 'selected' : '' }}>{{ $tour->name ?? '' }}</option>
                                        @endforeach
                                    </select>
                                    @error('tour_time')
                                    <div class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="d-flex flex-row mb-3">
                        <div class="p-2 w-100">
                            <div class="d-flex flex-row">
                                <label for="" class="mr-4 p-label__medium">Dịch vụ<span class="text-danger"> * </span></label>
                                <div class="w-50">
                                    <select name="services[]" class="form-control" multiple id="chosen_services">
                                        @foreach ($services as $service)
                                            <option value="{{ $service->id ?? '' }}" {{ (isset($service) && in_array($service->id, $servicesOrder)) ? 'selected' : '' }}>{{ $service->name ?? '' }}</option>
                                        @endforeach
                                    </select>
                                    @error('tour_time')
                                    <div class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="d-flex flex-row mb-3">
                        <div class="p-2 w-100">
                            <div class="d-flex flex-row">
                                <label for="" class="mr-4 p-label__medium">Người đặt<span class="text-danger"> * </span></label>
                                <div class="w-50">
                                    <select name="user_id" class="form-control" id="chosen_places">
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id ?? '' }}" {{ (isset($order->user_id) && $user->id==$order->user_id) ? 'selected' : '' }}>{{ $user->name ?? '' }}</option>
                                        @endforeach
                                    </select>
                                    @error('tour_time')
                                    <div class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="d-flex flex-row mb-3">
                        <div class="p-2 w-100">
                            <div class="d-flex flex-row">
                                <label for="" class="mr-4 p-label__medium">Điện thoại<span class="text-danger"> * </span></label>
                                <div class="w-50">
                                    <input type="text" name="phone" maxlength="256" data-field="phone" value="{{$order->phone ?? ''}}" class="p-2 flex-fill w-100 js-length__input">
                                    <div class="text-right pt-1 is-length__input--phone"><strong>0/100 Ký tự</strong></div>
                                    @error('phone')
                                    <div class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="d-flex flex-row mb-3">
                        <div class="p-2 w-100">
                            <div class="d-flex flex-row">
                                <label for="" class="mr-4 p-label__medium">Email<span class="text-danger"> * </span></label>
                                <div class="w-50">
                                    <input type="email" name="email" maxlength="256" data-field="email" value="{{$order->email ?? ''}}" class="p-2 flex-fill w-100 js-length__input">
                                    <div class="text-right pt-1 is-length__input--email"><strong>0/100 Ký tự</strong></div>
                                    @error('email')
                                    <div class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="d-flex flex-row mb-3">
                        <div class="p-2 w-100">
                            <div class="d-flex flex-row">
                                <label for="" class="mr-4 p-label__medium">Phương thức thanh toán<span class="text-danger"> * </span></label>
                                <div class="w-50">
                                    <select name="payment_method" class="form-control" id="chosen_places1">
                                        @foreach (Order::PAYMENT_METHOD_LIST as $key=>$value)
                                        <option value="{{ $key ?? '' }}" {{ isset($order->payment_method) && $key==$order->payment_method ? "selected   " : "" }} >{{ $value }}</option>
                                        @endforeach
                                    </select>
                                    @error('payment_method')
                                    <div class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="d-flex flex-row mb-3">
                        <div class="p-2 w-100">
                            <div class="d-flex flex-row">
                                <label for="" class="mr-4 p-label__medium">Tổng tiền</label>
                                <div class="w-50">
                                    <input type="text" name="total_amount" maxlength="256" data-field="total_amount" value="{{$order->total_amount ?? ''}}" class="p-2 flex-fill w-100 js-length__input">
                                    @error('total_amount')
                                    <div class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="d-flex flex-row mb-3">
                        <div class="p-2 w-100">
                            <div class="d-flex flex-row">
                                <label for="" class="mr-4 p-label__medium">Giảm giá<span class="text-danger"> * </span></label>
                                <div class="w-50">
                                    <input type="number" name="discount" max="100" min="0" data-field="discount" value="{{$order->discount ?? ''}}" class="p-2 flex-fill w-100 js-length__input">
                                    @error('discount')
                                    <div class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="d-flex flex-row mb-3">
                        <div class="p-2 w-100">
                            <div class="d-flex flex-row">
                                <label for="" class="mr-4 p-label__medium">Ngày thanh toán<span class="text-danger"> * </span></label>
                                <div class="w-50">
                                    <input type="date" name="payment_date" maxlength="256" data-field="payment_date" value="{{ isset($order['payment_date']) ? (Carbon::parse($order['payment_date'])->format('Y-m-d')) : '' }}" class="p-2 flex-fill w-100 js-length__input">
                                    @error('payment_date')
                                    <div class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="d-flex flex-row mb-3">
                        <div class="p-2 w-100">
                            <div class="d-flex flex-row">
                                <label for="" class="mr-4 p-label__medium">Lời nhắn<span class="text-danger"> * </span></label>
                                <div class="w-50">
                                    <input type="text" name="comment" maxlength="256" data-field="comment" value="{{$order->comment ?? ''}}" class="p-2 flex-fill w-100 js-length__input">
                                    @error('comment')
                                    <div class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="d-flex flex-row mb-3">
                        <div class="p-2 w-100">
                            <div class="d-flex flex-row">
                                <label for="" class="mr-4 p-label__medium">Loại tiền<span class="text-danger"> * </span></label>
                                <div class="w-50">
                                    <input type="text" name="payment_currency" maxlength="256" data-field="payment_currency" value="{{$order->payment_currency ?? ''}}" class="p-2 flex-fill w-100 js-length__input">
                                    @error('payment_currency')
                                    <div class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="d-flex flex-row mb-3">
                        <div class="p-2 w-100">
                            <div class="d-flex flex-row">
                                <label for="" class="mr-4 p-label__medium">Số tiền gốc<span class="text-danger"> * </span></label>
                                <div class="w-50">
                                    <input type="text" name="amount" maxlength="256" data-field="amount" value="{{$order->amount ?? ''}}" class="p-2 flex-fill w-100 js-length__input">
                                    @error('amount')
                                    <div class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <input type="hidden" name="id" value="{{ $order->id ?? '' }}">

    <div class="col-12 mt-4">
        <div class="d-flex flex-row mb-3 justify-content-center">
            <input class="btn btn-success" type="submit" value="Save">
            <button type="button" class="btn btn-primary ml-2" onClick="location.reload()">Cancel</button>
        </div>
    </div>

</form>
@endsection
@section('scripts')
<!-- parsley.js -->
<script src="{{ asset('js/admin/common.js') }}"></script>
<script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
<script>
    $("#chosen_places").chosen({})
    $("#chosen_places1").chosen({})
    $("#chosen_tours").chosen({})
    $("#chosen_services").chosen({})
</script>
@endsection
