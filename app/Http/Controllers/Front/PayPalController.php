<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\PayPalService as PayPalSvc;
use Illuminate\Support\Facades\URL;
use App\Models\PcmDmsDocument;
use App\Models\PcmDmsOrder;
use App\Models\PcmDmsOrderItem;
use App\Models\PcmDmsCoupon;
use App\Models\PcmDmsConfig;
use App\Models\PcmDmsMessage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Jobs\CheckMailPaymentSuccess;

class PayPalController extends Controller
{
    private $paypalSvc;
    private $order;

    public function __construct(PayPalSvc $paypalSvc, PcmDmsOrder $order)
    {
        $this->paypalSvc = $paypalSvc;
        $this->order = $order;
    }

    public function index($document_id) {
        $document = (new PcmDmsDocument)->getDocumentById($document_id);

        if (is_null($document)) {
            abort(404);
        }

        return view('front.dms.checkout.index', compact('document'));
    }

    public function paymentCreate(Request $request)
    {
        $data_post = $request->all();
        $discount = 0;
        $coupon_code = [];
        if ($data_post['coupon_code']) {
            $coupon_code = (new PcmDmsCoupon())->getCouponOfDocucmentByCode($data_post['document_id'], $data_post['coupon_code']);
            if ($coupon_code && $coupon_code->times > $coupon_code->used) {
                $discount =  number_format($coupon_code->coupon_type == PcmDmsCoupon::Amount ? $coupon_code->discount : ($data_post['document_price'] * ($coupon_code->discount / 100)), 2);
            }
        }
        $data = [
            [
                'name' => $data_post['document_title'],
                'quantity' => 1,
                'price' => $data_post['document_price'] - $discount,
                'sku' => $data_post['document_id']
            ]
        ];

        $transactionDescription = "Tobaco";

        $paypalCheckout = $this->paypalSvc
                                  // ->setCurrency('eur')
                                  ->setReturnUrl(URL::route('checkout.payment.status') . '?coupon_id=' . (empty($coupon_code) ? 0 : $coupon_code->id) . '&document_id=' . $data_post['document_id'])
                                  // ->setCancelUrl(url('paypal/status'))
                                  ->setItem($data)
                                  // ->setItem($data[0])
                                  // ->setItem($data[1])
                                  ->createPayment($transactionDescription);

        if ($paypalCheckout) {
            $member = Auth::guard('web')->user();
            $data_insert = [
                'user_id' => $member->id,
                'first_name' => $member->name ?? '',
                'last_name' => $member->name ?? '',
                'address' => $member->address ?? '',
                'address2' => $member->address ?? '',
                'phone' => $member->phone_number ?? '',
                'email' => $data_post['email'],
                'discount' => $discount,
                'published' => 0,
                'comment' => $data_post['comment'] ?? '',
                'license_code' => $data_post['referral_code'] ?? '',
                'email_sent' => 0,
                'customer_ip' => getHostByName(getHostName()),
                'referral_code' => $data_post['referral_code'] ?? '',
                'order_number' => $paypalCheckout['paymentId']
            ];
            (new PcmDmsOrder())->create($data_insert);

            return redirect($paypalCheckout['checkoutUrl']);
        } else {
            abort(500);
        }
    }

    public function paymentStatus(Request $request)
    {
        try {
            $data = $this->paypalSvc->getPaymentStatus();
            $data_update = [
                'organization' => 'personal',
                'city' => $data->payer->payer_info->shipping_address->city,
                'state' => $data->state,
                'zip' => $data->payer->payer_info->shipping_address->postal_code,
                'country' => $data->payer->payer_info->shipping_address->country_code,
                'fax' => $data->payer->payer_info->shipping_address->postal_code,
                'email_sent' => 1,
                'payment_method' => $data->payer->payment_method,
                'total_amount' => $data->transactions[0]->amount->total,
                'transaction_id' => $data->transactions[0]->related_resources[0]->sale->id,
                'payment_date' => $data->create_time,
                'published' => 1,
                'payment_amount' => $data->transactions[0]->amount->total,
                'payment_currency' => $data->transactions[0]->amount->currency,
                'amount' => $data->transactions[0]->amount->total
            ];
            
            $order = (new PcmDmsOrder())->where('order_number', $data->id);
            $order->update($data_update);
            $order = $order->first();
            $document_id = $request->input('document_id', 0);
            Log::info('aaaaaaa' . $document_id);
            (new PcmDmsOrderItem())->create([
                'order_id' => $order->id,
                'document_id' => $document_id,
                'download_code' => '',
                'downloaded' => 0,
                'order_date' => $order->payment_date,
                'item_price' => $order->total_amount,
                'license_code' => $order->license_code
            ]);
            (new PcmDmsCoupon())->usedCoupon($request->input('coupon_id', 0));
            $document = PcmDmsDocument::findOrFail($document_id);
            $config = (new PcmDmsConfig())->getData();
            $messages = (new PcmDmsMessage())->getMessage();
            dispatch(new CheckMailPaymentSuccess($order, $document, $config, $messages));

            return redirect()->route('download.list');
        } catch(\Exception $e) {
            Log::info($e->getMessage());
        }
    }

    public function paymentList()
    {
        $limit = 10;
        $offset = 0;

        $paymentList = $this->paypalSvc->getPaymentList($limit, $offset);

        dd($paymentList);
    }

    public function paymentDetail($paymentId)
    {
        $paymentDetails = $this->paypalSvc->getPaymentDetails($paymentId);

        dd($paymentDetails);
    }
}
