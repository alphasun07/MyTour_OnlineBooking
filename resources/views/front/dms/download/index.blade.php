@php
use Carbon\Carbon;
use App\Models\PcmDmsDocument;
use App\Models\PcmDmsOrder;
@endphp
@extends('front.common.app', ['active' => 'list'])
@section('title')
Download
@endsection
@section("content")
@include('front.common.alert')
<section id="hero" class="d-flex align-items-center pt-3" style="background: rgba(176, 208, 255, 0.1);">
    <div class="container">
        <table class="table table-striped table-bordered">
            <thead>
                <tr class="text-center">
                    <th>
                        {{ trans('home.document') }}
                    </th>
                    <th>
                        {{ trans('home.price') }} ({{ trans('home.unit_price') }})
                    </th>
                    <th>
                        {{ trans('home.order_date') }}
                    </th>
                    <th>
                        {{ trans('home.restriction') }}
                    </th>
                    <th>
                        {{ trans('home.download') }}
                    </th>
                    @if ($config->activate_invoice_feature)
                    <th nowrap="nowrap">
                        {{ trans('home.invoice') }}
                    </th>
                    @endif  
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                    <tr class="text-center">
                        @php
                            $canDownload = true;
                            if ($order->prevent_download_type == 2) {
                                $restriction = $order->number_downloads.' DOWNLOADS';

                                if ($order->number_downloads > $order->downloaded) {
                                    $canDownload = true;
                                } else {
                                    $canDownload = false;
                                }
                            } else if ($order->prevent_download_type == 3) {
                                $restriction = $order->number_days.' DAYS';

                                if (strtotime((new Carbon($order->payment_date))->addDays($order->number_days)) > strtotime(Carbon::now())) {
                                    $canDownload = true;
                                } else {
                                    $canDownload = false;
                                }
                            } else {
                                $restriction = 'LIFETIME';

                                if ($order->prevent_download_type == 1) {
                                    $canDownload = true;
                                } else {
                                    $canDownload = false;
                                }
                            }
                        @endphp
                        <td>{{ $order->title }}</td>
                        <td>{{ $order->price }}</td>
                        <td>{{ Carbon::parse($order->payment_date)->format('d/m/Y') }}</td>
                        <td>{{ $restriction }}</td>
                        <td>
                            @if ($canDownload)
                                <a href="{{ route('home.document.download', $order->order_id) }}"><strong>DOWNLOAD</strong></a>
                            @else
                                <span class="text-danger">EXPIRED</span>
                            @endif
                        </td>
                        @if ($config->activate_invoice_feature)
                        <td>
                            <a href="{{route('download.export.invoice', $order->order_id)}}"><strong>{{(new PcmDmsOrder())->formatInvoiceNumber($order->order_id, $config)}}</strong></a>
                        </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>
@endsection
