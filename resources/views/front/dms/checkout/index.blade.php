@php
use App\Helpers\Helper;
use Illuminate\Support\Facades\Auth;
use App\Models\Article;

$member = Auth::guard('web')->user();
@endphp
@extends('front.common.app', ['active' => 'checkout'])
@section('title')
Checkout
@endsection
@section("content")
<section id="hero" class="pt-0" style="background: rgba(176, 208, 255, 0.1);">
    <div class="container mb-5 pt-3">
        <h2 class="text-center payment-title">Checkout</h2>
        <div class="row mt-3 d-flex justify-content-center">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                <div class="account-info">
                    <div class="title">
                        <h5 class="mb-0">Account infomation</h5>
                    </div>
                    <div class="i-form text-start">
                        <form method="GET" action="{{ route('checkout.payment.create') }}" id="form-checkout">
                            <input type="hidden" name="document_id" id="document_id" value="{{ $document->id }}">
                            <input type="hidden" name="document_title" id="document_title" value="{{ $document->title }}">
                            <input type="hidden" name="document_price" id="document_price" value="{{ $document->renewal_price != 0 ? $document->renewal_price : $document->price }}">
                            <div class="mb-3 mt-3">
                                <label class="form-label">Name<span class="required">*</span></label>
                                <input type="text" name="name" class="form-control" data-parsley-required value="{{ $member ? $member->name : '' }}">
                            </div>
                            <div class="mb-3 mt-3">
                                <label class="form-label">Address<span class="required">*</span></label>
                                <input type="text" name="address" class="form-control" data-parsley-required value="{{ $member ? $member->address : '' }}">
                            </div>
                            <div class="mb-3 mt-3">
                                <label class="form-label">Email<span class="required">*</span></label>
                                <input type="email" name="email" class="form-control" data-parsley-required value="{{ $member ? $member->email : '' }}">
                            </div>
                            <div class="mb-3 mt-3">
                                <label class="form-label">Comment</label>
                                <textarea name="comment" rows="5" class="form-control w-100"></textarea>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6  text-center">
                <div class="payment-info">
                    <div class="title">
                        <h5  class="mb-0">Payment infomation</h5>
                    </div>
                    <div class="i-form">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td class="text-start" width="85%"><a href="{{ route('home.document.detail', $document->id) }}"><strong>{{ $document->title }}</strong></a></td>
                                    <td class="text-end">${{ $document->renewal_price != 0 ? $document->renewal_price : $document->price }}</td>
                                </tr>
                                <tr>
                                    <td class="text-end"><span>Sub Total:</span></td>
                                    <td class="text-end"><span>${{ $document->renewal_price != 0 ? $document->renewal_price : $document->price }}</span></td>
                                </tr>
                                <tr>
                                    <td class="text-end"><span>Discount Amount:</span></td>
                                    <td class="text-end"><span>$0.00</span></td>
                                </tr>
                                <tr style="border-style: none;">
                                    <td class="text-end" style="border-bottom-width: 0;"><span>Total:</span></td>
                                    <td class="text-end" style="border-bottom-width: 0;"><span><b>${{ $document->renewal_price != 0 ? $document->renewal_price : $document->price }}</b></span></td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="row">
                            <label for="referral_code" class="col-sm-6 col-md-5 col-form-label text-start">Referral code</label>
                            <div class="col-sm-6 col-md-7" id="referral">
                                <input type="text" name="referral_code" class="form-control w-75" id="referral_code">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <label for="coupon_code" class="col-sm-6 col-md-5 col-form-label text-start">Coupon code</label>
                            <div class="col-sm-6 col-md-7" id="coupon">
                                <input type="text" name="coupon_code" class="form-control w-75" id="coupon_code">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-sm-6 col-md-5 text-start">
                                <label class="mt-3">Payment method</label>
                            </div>
                            <div class="col-sm-6 col-md-7 document-description">
                                <img src="https://joomdonation.com/media/com_dms/assets/images/paypal.png" alt="Chicago" class="d-block w-100" height="auto">
                            </div>
                        </div>
                        <div class="form-check text-start mt-3">
                            <input class="form-check-input" type="checkbox" name="accept_terms" id="accept_erms">
                            <label for="disabledFieldsetCheck">
                                I accept <a href="{{ route('home.article.detail', ['slug' => (new Article)->getSlugById(Article::TERMS_AND_CONDITIONS)]) }}" target="_bank"><strong>Terms and Conditions</strong></a>
                            </label>
                        </div>
                        <div class="form-actions">
                            <button type="button" class="btn btn-primary" id="btn-payment">Process Order</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
    <script src="{{ asset('libs/parsley/parsley.min.js') }}"></script>
    <script src="{{ asset('libs/parsley/en.js') }}"></script>
    <script src="{{ asset('js/admin/common.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            $('#btn-payment').on('click', async function (e) {
                if ($('#accept_erms').is(':checked')) {
                    var coupon_code = $('#coupon_code').val();
                    var referral_code = $('#referral_code').val();
                    var checkSubmit = true;
                    if (coupon_code) {
                        await $.ajax({
                            url: "{{ route('coupon.check') }}",
                            type: 'POST',
                            data: {
                                coupon_code: coupon_code,
                                document_id: $('#document_id').val()
                            },
                            success: function (data) {
                                if (data.status) {
                                    checkSubmit = true
                                } else {
                                    $('#coupon p').remove()
                                    $('#coupon').append('<p class="text-start mb-0" style="color: #dc3545;font-size: .875em;">' + data.message +'</p>');
                                    checkSubmit = false
                                }
                            },
                            error: function (data) {
                                commonAlert(data.error);
                            }
                        });
                    }

                    if (referral_code) {
                        await $.ajax({
                            url: "{{ route('referral.check') }}",
                            type: 'POST',
                            data: {
                                code: referral_code,
                                userIdChose: {{ $member->id }},
                            },
                            success: function (data) {
                                console.log(data);
                                if (data.success) {
                                    checkSubmit = true
                                } else {
                                    $('#referral p').remove()
                                    $('#referral').append('<p class="text-start mb-0" style="color: #dc3545;font-size: .875em;">' + data.message +'</p>');
                                    checkSubmit = false
                                }
                            },
                            error: function (data) {
                                commonAlert(data.error);
                            }
                        });
                    }

                    if (checkSubmit) {
                        var form = $('#form-checkout');
                        form.parsley();

                        $('<input>').attr({
                            type: 'hidden',
                            name: 'referral_code',
                            value: $('#referral_code').val()
                        }).appendTo(form);

                        $('<input>').attr({
                            type: 'hidden',
                            name: 'coupon_code',
                            value: coupon_code
                        }).appendTo(form);

                        form.submit();
                    }
                } else {
                    alert('Please accept our terms and conditions to process order')
                }
            })
        })
    </script>
@endsection