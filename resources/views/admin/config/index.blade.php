@php
use App\Models\Config;
use App\Helpers\PcmHtml;
@endphp
@extends('admin.layout.app')
@section('title')
{{ 'Configuration' }}
@endsection
@section('content')
@section('pageTitle')
@include('admin.common.page-title', ['title' => 'Configuration', 'subTitle' => ''])
@endsection
@section('content')
<!-- Modal -->
<ul class="nav nav-tabs row ml-2" id="myTab" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" id="data-tab" data-toggle="tab" href="#data" role="tab" aria-controls="data" aria-selected="true">Gerenal</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="invoice-tab" data-toggle="tab" href="#invoice" role="tab" aria-controls="invoice" aria-selected="false">Invoice Setting</a>
    </li>
</ul>
<form method="POST" action="{{route('admin.dms.config.store')}}">
    @csrf
    <div class="row ml-2">
        <div class="col-12 o-col__padding--right--left">
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="data" role="tabpanel" aria-labelledby="data-tab">
                    <div class="d-flex flex-column mb-3 o-container__background--white x_panel mt-0 border-top-0">
                        <div class="col-12">
                            <div class="d-flex flex-row mb-3">
                                <div class="p-2 w-100">
                                    <div class="d-flex flex-row">
                                        <label for="" class="mr-4 w-25">{!! PcmHtml::getFieldLabel('allowed_file_types', 'Allowed File Types', 'Enter file extensions of allowed file types (without . character, sepearted by |) . For example pdf|zip|doc') !!}</label>
                                        <div class="w-75">
                                            <input type="text" name="allowed_file_types" value="{{isset($config->allowed_file_types) ? $config->allowed_file_types : ''}}" maxlength="255" data-field="allowed_file_types" class="p-2 flex-fill w-100 js-length__input">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-flex flex-row mb-3">
                                <div class="p-2 w-100">
                                    <div class="d-flex flex-row">
                                        <label for="" class="mr-4 w-25">{!!PcmHtml::getFieldLabel('notification_emails', 'Notification Emails', 'You can put multiple email here, command seperated (For example sales@laravel.com,accounting@pcmdonation.com)')!!}</label>
                                        <div class="w-75">
                                            <input type="text" name="notification_emails" value="{{isset($config->notification_emails) ? $config->notification_emails : ''}}" maxlength="255" data-field="notification_emails" class="p-2 flex-fill w-100 js-length__input">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-flex flex-row mb-3">
                                <div class="p-2 w-100">
                                    <div class="d-flex flex-row">
                                        <label for="" class="mr-4 w-25">{!!PcmHtml::getFieldLabel('send_document_via_email', 'Send Documents via Email')!!}</label>
                                        <div class="w-75">
                                            {!!PcmHtml::getBooleanInput('send_document_via_email', isset($config->send_document_via_email) ? $config->send_document_via_email : '0')!!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-flex flex-row mb-3">
                                <div class="p-2 w-100">
                                    <div class="d-flex flex-row">
                                        <label for="" class="mr-4 w-25">{!!PcmHtml::getFieldLabel('send_download_link', 'Send Download Link via Email')!!}</label>
                                        <div class="w-75">
                                            {!!PcmHtml::getBooleanInput('send_download_link', isset($config->send_download_link) ? $config->send_download_link : '0')!!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if (count($pages) > 0)
                        <div class="col-12">
                            <div class="d-flex flex-row mb-3">
                                <div class="p-2 w-100">
                                    <div class="d-flex flex-row">
                                        <label for="" class="mr-4 w-25">{!!PcmHtml::getFieldLabel('article_id', 'Terms and conditions article')!!}</label>
                                        <div class="w-75">
                                            <div class="position-relative">
                                                <select name="article_id"  class="p-2 flex-fill w-100">
                                                    @foreach ($pages as $page)
                                                    <option {{$page->id == @$config->article_id ? 'selected' : ''}} value="{{$page->id}}">{{$page->title}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <div class="tab-pane fade" id="invoice" role="tabpanel" aria-labelledby="invoice">
                    <div class="d-flex flex-column mb-3 o-container__background--white x_panel mt-0 border-top-0">
                        <div class="col-12">
                            <div class="d-flex flex-row mb-3">
                                <div class="p-2 w-100">
                                    <div class="d-flex flex-row">
                                        <label for="" class="mr-4 w-25">{!!PcmHtml::getFieldLabel('activate_invoice_feature', 'Activate Invoice Feature')!!}</label>
                                        <div class="w-75">
                                            {!!PcmHtml::getBooleanInput('activate_invoice_feature', isset($config->activate_invoice_feature) ? $config->activate_invoice_feature : '0')!!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex flex-row mb-3">
                                <div class="p-2 w-100">
                                    <div class="d-flex flex-row">
                                        <label for="" class="mr-4 w-25">{!!PcmHtml::getFieldLabel('invoice_prefix', 'Invoice prefix', 'Enter invoice prefix. For example, if you enter IV, the invoice number will have the format IV00001,IV00002...')!!}</label>
                                        <div class="w-75">
                                            <input type="text" name="invoice_prefix" value="{{isset($config->invoice_prefix) ? $config->invoice_prefix : ''}}" maxlength="255" class="p-2 flex-fill w-100 js-length__input">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex flex-row mb-3">
                                <div class="p-2 w-100">
                                    <div class="d-flex flex-row">
                                        <label for="" class="mr-4 w-25">{!!PcmHtml::getFieldLabel('invoice_number_length', 'Invoice Number Length', 'Choose the length of invoice number. For example, if you set it to 4, invoice number will have the following format IV0001, IV0002..')!!}</label>
                                        <div class="w-75">
                                            <input type="text" name="invoice_number_length" value="{{isset($config->invoice_number_length) ? $config->invoice_number_length : ''}}" maxlength="255" class="p-2 flex-fill w-100 js-length__input">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex flex-row mb-3">
                                <div class="p-2 w-100">
                                    <div class="d-flex flex-row">
                                        <label for="" class="mr-4 w-25">Invoice Format</label>
                                        <div class="w-75">
                                            <textarea name="invoice_format" id="editor" data-field="invoice_format" class="p-2 flex-fill w-100 js-length__input">{{isset($config->invoice_format) ? $config->invoice_format : ''}}</textarea>
                                        </div>
                                    </div>
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
                <a class="btn btn-primary ml-2" href="{{route('admin.coupon.list')}}">Cancel</a>
            </div>
        </div>
    </div>
</form>
@endsection

@section('scripts')
<script src="{{ asset('js/admin/bootbox.min.js') }}"></script>
<script src="{{ asset('js/jquery-ui-1.13.1/jquery-ui.js') }}"></script>
<script src="{{ asset('js/admin/common.js') }}"></script>
<!-- parsley.js -->
<script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
<script>
    CKEDITOR.replace('editor', {
        language: 'en'
    });

    function setValueSwitch(that) {
        var id = that.id;
        if (that.checked == true) {
            $('#'+id).val(1);
            $('input[name="'+id+'"]').remove();
            $('#'+id).html('<input type="hidden" value="1" name='+id+'>');
        }else{
            $('#'+id).val(0);
            $('input[name="'+id+'"]').remove();
            $('#'+id).html('<input type="hidden" value="0" name='+id+'>');
        }
    }

</script>
@endsection
