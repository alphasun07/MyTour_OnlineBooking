@php
use App\Models\PcmDmsOrder;
use App\Models\PcmDmsDocument;
@endphp
<div class="table-section bill-tbl w-100 mt-10">
    <table class="table w-100 mt-10">
        <tr>
            <th class="w-50">Document Name</th>
            <th class="w-50">Price</th>
            <th class="w-50">Order Date</th>
            <th class="w-50">Downloaded</th>
        </tr>
        @foreach ($order->orderItem as $order_item)
        <tr align="center">
            <td>{{(new PcmDmsDocument())->getDocumentById($order_item->document_id)->title ?? null}}</td>
            <td>${{$order_item->item_price ?? null}}</td>
            <td>{{$order_item->order_date ?? null}}</td>
            <td>{{$order_item->downloaded ?? null}}</td>
        </tr>
        @endforeach
        <tr>
            <td colspan="7">
                <div class="total-part">
                    <div class="total-left w-85 float-left" align="right">
                        <p>Sub Total</p>
                        <p>Tax</p>
                        <p>Total Payable</p>
                    </div>
                    <div class="total-right w-15 float-left text-bold" align="right">
                        <p>${{$order->total_amount ?? 0}}</p>
                        <p>${{$order->discount ?? 0}}</p>
                        <p>${{$order->total_amount ?? 0}}</p>
                    </div>
                    <div style="clear: both;"></div>
                </div>
            </td>
        </tr>
    </table>
</div>
