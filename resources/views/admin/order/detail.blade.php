@php
use App\Models\PcmDmsOrder;
use Carbon\Carbon;
@endphp
@extends('admin.layout.app')
@section('title')
{{ 'Order management' }}
@endsection
@section('head')
<style>
    .user-items.selected{
        box-shadow: rgba(3, 102, 214, 0.3) 0px 0px 0px 3px;
    }
    #documents:focus + #doc-drop{
        display: block!important;
    }
    .chosen-choices{
        padding: .3rem!important;
    }
</style>
@endsection
@section('scripts')
@section('content')
@section('pageTitle')
@include('admin.common.page-title', ['title' => 'Management', 'subTitle' => 'Order management'])
@endsection
<form method="POST" action="{{ route('admin.order.store') }}">
    @csrf
    <div class="row ml-2">
        <div class="mt-0 border-0 w-100 o-container__background--white o-col__padding--right--left x_panel">
            <div class="row">
                <div class="col-6">
                    <div class="col-12">
                        <div class="title-left p-2">
                            <h4 class="px-2 py-0 mb-0">Billing Information</h4>
                            <hr>
                        </div>
                    </div>
                    <div class="col-12" style="min-height:75px">
                        <div class="d-flex flex-row mb-3">
                            <div class="p-2 w-100">
                                <div class="d-flex flex-row">
                                    <label for="" class="mr-4 p-label__medium">User ID<span class="text-danger"> * </span></label>
                                    <div class=" ml-2 w-50">
                                        <div class="position-relative">
                                            <input type="text" placeholder="Select user ID" name="user_name" value="{{ old('user_name') ? old('user_name') : ($order->user->name ?? '') }}" readonly maxlength="256" data-field="user_name" class="p-2 flex-fill w-100 js-length__input">
                                            <span class="position-absolute" style="right:0;"><div class="btn btn-primary m-0" data-toggle="modal" data-target="#userIDModal"><i class="fa fa-user" aria-hidden="true"></i></div></span>
                                        </div>
                                        <input type="hidden" placeholder="User ID" name="user_id" value="{{ old('user_id', $order->user_id ?? '') }}" maxlength="256" data-field="user_id" class="p-2 flex-fill w-100 js-length__input">
                                        @error('user_id')
                                        <div class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12" style="min-height:75px">
                        <div class="d-flex flex-row mb-3">
                            <div class="p-2 w-100">
                                <div class="d-flex flex-row">
                                    <label for="" class="pt-2 mr-4 p-label__medium">First Name<span class="text-danger"> * </span></label>
                                    <div class=" ml-2 w-50">
                                        <input type="text" placeholder="First Name" name="first_name" value="{{ old('first_name', $order->first_name ?? '') }}" maxlength="256" data-field="first_name" class="p-2 flex-fill w-100 js-length__input">
                                        <div class="text-right pt-1 is-length__input--first_name"><strong>000 Characters</strong></div>
                                        @error('first_name')
                                        <div class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12" style="min-height:75px">
                        <div class="d-flex flex-row mb-3">
                            <div class="p-2 w-100">
                                <div class="d-flex flex-row">
                                    <label for="" class="pt-2 mr-4 p-label__medium">Last Name<span class="text-danger"> * </span></label>
                                    <div class=" ml-2 w-50">
                                        <input type="text" placeholder="Last Name" name="last_name" value="{{ old('last_name', $order->last_name ?? '') }}" maxlength="256" data-field="last_name" class="p-2 flex-fill w-100 js-length__input">
                                        <div class="text-right pt-1 is-length__input--last_name"><strong>000 Characters</strong></div>
                                        @error('last_name')
                                        <div class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12" style="min-height:75px">
                        <div class="d-flex flex-row mb-3">
                            <div class="p-2 w-100">
                                <div class="d-flex flex-row">
                                    <label for="" class="pt-2 mr-4 p-label__medium">Company</label>
                                    <div class=" ml-2 w-50">
                                        <input type="text" placeholder="Company" name="organization" value="{{ old('organization', $order->organization ?? '') }}" maxlength="256" data-field="organization" class="p-2 flex-fill w-100 js-length__input">
                                        <div class="text-right pt-1 is-length__input--organization"><strong>000 Characters</strong></div>
                                        @error('organization')
                                        <div class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12" style="min-height:75px">
                        <div class="d-flex flex-row mb-3">
                            <div class="p-2 w-100">
                                <div class="d-flex flex-row">
                                    <label for="" class="pt-2 mr-4 p-label__medium">Address<span class="text-danger"> * </span></label>
                                    <div class=" ml-2 w-50">
                                        <input type="text" placeholder="Address" name="address" value="{{ old('address', $order->address ?? '') }}" maxlength="256" data-field="address" class="p-2 flex-fill w-100 js-length__input">
                                        <div class="text-right pt-1 is-length__input--address"><strong>000 Characters</strong></div>
                                        @error('address')
                                        <div class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12" style="min-height:75px">
                        <div class="d-flex flex-row mb-3">
                            <div class="p-2 w-100">
                                <div class="d-flex flex-row">
                                    <label for="" class="pt-2 mr-4 p-label__medium">Country<span class="text-danger"> * </span></label>
                                    <div class=" ml-2 w-50">
                                        <select name="country" id="country" class="p-2 flex-fill w-100">
                                            <option value="">-- Chosse your country --</option>
                                            @foreach ($countries as $country)
                                                <option value="{{ $country->country_id ?? '' }}" {{ $country->country_id && ((isset($order->country) && $country->country_id==$order->country) || old('country')==$country->country_id) ? 'selected' : '' }}>{{ $country->name ?? '' }}</option>
                                            @endforeach
                                        </select>
                                        @error('country')
                                        <div class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12" style="min-height:75px">
                        <div class="d-flex flex-row mb-3">
                            <div class="p-2 w-100">
                                <div class="d-flex flex-row">
                                    <label for="" class="pt-2 mr-4 p-label__medium">City<span class="text-danger"> * </span></label>
                                    <div class=" ml-2 w-50">
                                        <input type="text" placeholder="City" name="city" value="{{ old('city', $order->city ?? '') }}" maxlength="256" data-field="city" class="p-2 flex-fill w-100 js-length__input">
                                        <div class="text-right pt-1 is-length__input--city"><strong>000 Characters</strong></div>
                                        @error('city')
                                        <div class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12" style="min-height:75px">
                        <div class="d-flex flex-row mb-3">
                            <div class="p-2 w-100">
                                <div class="d-flex flex-row">
                                    <label for="" class="pt-2 mr-4 p-label__medium">State<span class="text-danger"> * </span></label>
                                    <div class=" ml-2 w-50">
                                        <input type="text" placeholder="State" name="state" value="{{ old('state', $order->state ?? '') }}" maxlength="256" data-field="state" class="p-2 flex-fill w-100 js-length__input">
                                        <div class="text-right pt-1 is-length__input--state"><strong>000 Characters</strong></div>
                                        @error('state')
                                        <div class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12" style="min-height:75px">
                        <div class="d-flex flex-row mb-3">
                            <div class="p-2 w-100">
                                <div class="d-flex flex-row">
                                    <label for="" class="pt-2 mr-4 p-label__medium">Zip<span class="text-danger"> * </span></label>
                                    <div class=" ml-2 w-50">
                                        <input type="text" placeholder="Zip" name="zip" value="{{ old('zip', $order->zip ?? '') }}" maxlength="256" data-field="zip" class="p-2 flex-fill w-100 js-length__input">
                                        <div class="text-right pt-1 is-length__input--zip"><strong>000 Characters</strong></div>
                                        @error('zip')
                                        <div class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12" style="min-height:75px">
                        <div class="d-flex flex-row mb-3">
                            <div class="p-2 w-100">
                                <div class="d-flex flex-row">
                                    <label for="" class="pt-2 mr-4 p-label__medium">Phone</label>
                                    <div class=" ml-2 w-50">
                                        <input type="text" placeholder="Phone" name="phone" value="{{ old('phone', $order->phone ?? '') }}" maxlength="256" data-field="phone" class="p-2 flex-fill w-100 js-length__input">
                                        <div class="text-right pt-1 is-length__input--phone"><strong>000 Characters</strong></div>
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
                    <div class="col-12" style="min-height:75px">
                        <div class="d-flex flex-row mb-3">
                            <div class="p-2 w-100">
                                <div class="d-flex flex-row">
                                    <label for="" class="pt-2 mr-4 p-label__medium">Email<span class="text-danger"> * </span></label>
                                    <div class=" ml-2 w-50">
                                        <input type="text" placeholder="Email" name="email" value="{{ old('email', $order->email ?? '') }}" maxlength="256" data-field="email" class="p-2 flex-fill w-100 js-length__input">
                                        <div class="text-right pt-1 is-length__input--email"><strong>000 Characters</strong></div>
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
                    <div class="col-12" style="min-height:75px">
                        <div class="d-flex flex-row mb-3">
                            <div class="p-2 w-100">
                                <div class="d-flex flex-row">
                                    <label for="" class="mr-4 p-label__medium">Referral Code</label>
                                    <div class=" ml-2 w-50">
                                        <input type="text" placeholder="Referral Code" autocomplete="off" name="referral_code_input" value="{{ old('referral_code_input', $order->referral_code ?? '') }}" maxlength="256" data-field="referral_code" class="p-2 flex-fill w-100 js-length__input">
                                        <input type="hidden" name="referral_code" value="{{ old('referral_code', $order->referral_code ?? '') }}">
                                        <div class="text-right pt-1 is-length__input--referral_code"><strong>000 Characters</strong></div>
                                        <div id="alert">
                                            @error('referral_code')
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
                <div class="col-6">
                    <div class="title-left p-2">
                        <h4 class="px-2 py-0 mb-0">Order Information</h4>
                        <hr>
                    </div>
                    <div class="col-12" style="min-height:75px">
                        <div class=" p-2 w-50">
                            <div class="d-flex flex-row">
                                <div class="d-flex flex-row">
                                    <label>Published</label>
                                </div>
                                <div class="ml-5 custom-control custom-radio">
                                    <input type="radio" class="custom-control-input" id="display" name="published" value="1" {{ ((!old() && isset($order->published) && $order->published == PcmDmsOrder::PUBLISHED_ON) || is_null($order) || (old() && old('published') == PcmDmsOrder::PUBLISHED_ON)) ?  'checked' : '' }}>
                                    <label for="display" class="custom-control-label">Yes</label>
                                </div>
                                <div class="ml-3 custom-control custom-radio">
                                    <input type="radio" class="custom-control-input" id="hide" name="published" value="0" {{ ((!old() && isset($order->published) && $order->published == PcmDmsOrder::PUBLISHED_OFF) || (old() && old('published') == PcmDmsOrder::PUBLISHED_OFF)) || (!old() && isset($order) && (!isset($order->published) || is_null($order->published))) ?  'checked' : '' }}>
                                    <label for="hide" class="custom-control-label">No</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12" style="min-height:75px">
                        <div class="d-flex flex-row mb-3">
                            <div class="p-2 w-100">
                                <div class="d-flex flex-row">
                                    <label for="" class="mr-4 p-label__medium">Payment Method</label>
                                    <div class=" ml-2 w-50">
                                        <input type="text" placeholder="Payment Method" name="payment_method" value="{{ old('payment_method', $order->payment_method ?? '') }}" maxlength="256" data-field="payment_method" class="p-2 flex-fill w-100 js-length__input">
                                        <div class="text-right pt-1 is-length__input--payment_method"><strong>000 Characters</strong></div>
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
                    <div class="col-12" style="min-height:75px">
                        <div class="d-flex flex-row mb-3">
                            <div class="p-2 w-100">
                                <div class="d-flex flex-row">
                                    <label for="" class="pt-2 mr-4 p-label__medium">Total Amount</label>
                                    <div class=" ml-2 w-50">
                                        <input type="text" placeholder="Total Amount" name="total_amount" value="{{ old('total_amount', $order->total_amount ?? '') }}" maxlength="256" data-field="total_amount" class="p-2 flex-fill w-100 js-length__input">
                                        <div class="text-right pt-1 is-length__input--total_amount"><strong>000 Characters</strong></div>
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
                    <div class="col-12" style="min-height:75px">
                        <div class="d-flex flex-row mb-3">
                            <div class="p-2 w-100">
                                <div class="d-flex flex-row">
                                    <label for="" class="pt-2 mr-4 p-label__medium">Discount</label>
                                    <div class=" ml-2 w-50">
                                        <input type="text" placeholder="Discount" name="discount" value="{{ old('discount', $order->discount ?? '') }}" maxlength="256" data-field="discount" class="p-2 flex-fill w-100 js-length__input">
                                        <div class="text-right pt-1 is-length__input--discount"><strong>000 Characters</strong></div>
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
                    <div class="col-12" style="min-height:75px">
                        <div class="d-flex flex-row mb-3">
                            <div class="p-2 w-100">
                                <div class="d-flex flex-row">
                                    <label for="" class="mr-4 p-label__medium">Transaction ID</label>
                                    <div class=" ml-2 w-50">
                                        <input type="text" placeholder="Transaction ID" name="transaction_id" value="{{ old('transaction_id', $order->transaction_id ?? '') }}" maxlength="256" data-field="transaction_id" class="p-2 flex-fill w-100 js-length__input">
                                        <div class="text-right pt-1 is-length__input--transaction_id"><strong>000 Characters</strong></div>
                                        @error('transaction_id')
                                        <div class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12" style="min-height:75px">
                        <div class="d-flex flex-row mb-3">
                            <div class="p-2 w-100">
                                <div class="d-flex flex-row">
                                    <label for="" class="mr-4 p-label__medium">Payment Date</label>
                                    <div class=" ml-2 w-50">
                                        <input type="date" placeholder="Payment Date" name="payment_date" value="{{ old('payment_date', isset($order->payment_date) ? Carbon::parse($order->payment_date)->format(config('const.format.date')) : '') }}" maxlength="256" data-field="payment_date" class="p-2 flex-fill w-100 js-length__input">
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
                    <div class="col-12" style="min-height:75px">
                        <div class="d-flex flex-row mb-3">
                            <div class="p-2 w-100">
                                <div class="d-flex flex-row">
                                    <label for="" class="pt-2 mr-4 p-label__medium">Document</label>
                                    <div class=" ml-2 w-50">
                                        <select name="document_id[]" id="multiple" class="p-2 flex-fill w-100 form-control form-control-chosen" data-placeholder="Select documents" multiple>
                                            @foreach( $documents as $document )
                                            <option value="{{ $document->id ?? '' }}" {{ isset($document->id) && (($orderItems && !old('document_id') && in_array($document->id, $orderItems)) || (old('document_id') && in_array($document->id, old('document_id')))) ? 'selected' : '' }}>{{ $document->title ?? '' }}</option>
                                            @endforeach
                                        </select>
                                        <div class="text-right pt-1 is-length__input--documents"><strong>000 Characters</strong></div>
                                        @error('documents')
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
            <div class="col-12 mt-4">
                <div class="d-flex flex-row mb-3 justify-content-center">
                    <input class="btn btn-success" type="submit" value="Save">
                    <button type="button" class="btn btn-primary ml-2" onClick="location.reload()">Cancel</button>
                </div>
            </div>
            <input type="hidden" name="id" value="{{isset($order->id) ? $order->id : 0}}" />
        </div>
    </div>
</form>
<!-- Modal User ID -->
<div class="modal fade" id="userIDModal" tabindex="-1" role="dialog" aria-labelledby="userIDModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Select a user</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input onkeyup="searchUser($(this))" value="{{ $key ?? '' }}" autocomplete="off" class="form-control mb-2" type="text" id="user_search" name="key" placeholder="Search user">
                <div id="user-pagination">
                    @include('admin.common.user-paginate', ['users'=>$users ?? '', 'user_id'=>$order->user_id ?? ''])
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script src="{{ asset('js/admin/common.js') }}"></script>
<script>
    $(".form-control-chosen").chosen();
    var selectedUser = '';

    function clickUser(user_div){
        selectedUser = user_div.children('.user_id_div').html();
        $('[name="user_id"]').val(selectedUser);
        $('[name="user_name"]').val(user_div.children('.username_span').html());
        $('.user-items').removeClass('selected');
        $('[name="referral_code_input"]').val('');
        $('[name="referral_code"]').val('');
        user_div.addClass('selected');
    }

    function searchUser(user_key){
        let key = user_key.val();
        getAjaxUserModal(key);
    }

    function getAjaxUserModal(key, page = 1){
        let user_id = $('[name="user_id"]').val();
        $.ajax({
            url: "{{ route('admin.order.getUsers') }}?page=" + page,
            type: 'POST',
            dataType: 'json',
            data: {
                user_id: user_id,
                key: key,
            },
            success: function(json) {
                if(json.success) {
                    $('#user-pagination').html(json.page);
                };
            },
            error: function(json) {
                //
            }
        });
    }

    function getAjaxUserByReferralCode(code, userIdChose){
        $.ajax({
            url: "{{ route('admin.order.getUserByReferralCode') }}",
            type: 'POST',
            dataType: 'json',
            data: {
                code: code,
                userIdChose: userIdChose,
            },
            success: function(json) {
                if(json.success){
                    $('[name="referral_code"]').val(json.code);
                    $('#alert').html('<div class="text-success" role="alert">Referral code belongs to <strong>' + json.name + '</strong></div>')
                } else {
                    $('[name="referral_code"]').val('');
                    $('#alert').html('<div class="text-danger" role="alert">Referral code belongs to no one</div>')
                }
            },
            error: function(json) {
                //
            }
        });
    }

    $(document).ready(function() {
        $(document).on('click', '.pagination a', function(event) {
            event.preventDefault();
            let page = $(this).attr('href').split('page=')[1];
            let key = $('#user_search').val();
            getAjaxUserModal(key, page);
        });

        $('[name="referral_code_input"]').on('keyup', function(event) {
            let code = $(this).val();
            let userIdChose = $('[name="user_id"]').val();
            getAjaxUserByReferralCode(code, userIdChose);
        });
    });
</script>
@endsection
