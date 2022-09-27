<?php

namespace App\Http\Requests\Front;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class CartPayCompletedRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(Request $request)
    {
        return [
            'total_price' => 'required',
            'delivery_fee_total' => 'required',
            'use_point' => 'required',
            'add_point' => 'required',
            'use_coupon' => 'required',
            'cart_total' => 'required',
            'request_delivery_date' => 'required',
            'request_delivery_time' => 'required',
            'name01' => 'required',
            'name02' => 'required',
            'postal_code' => 'required',
            'pref_id' => 'required',
            'addr01' => 'required',
            'addr02' => 'required',
            'phone_number' => 'required',
            'pay_method' => 'required',
            'order_first_name' => 'required',
            'order_last_name' => 'required',
            'order_postal_code' => 'required',
            'order_prefecture' => 'required',
            'order_city' => 'required',
            'order_street' => 'required',
            'order_apartment' => 'required',
            'order_phone' => 'required',
            'order_email' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'total_price' => 'お手数ですが、カート画面からやり直してください。',
            'delivery_fee_total' => 'お手数ですが、カート画面からやり直してください。',
            'use_point' => 'お手数ですが、カート画面からやり直してください。',
            'add_point' => 'お手数ですが、カート画面からやり直してください。',
            'use_coupon' => 'お手数ですが、カート画面からやり直してください。',
            'cart_total' => 'お手数ですが、カート画面からやり直してください。',
            'request_delivery_date' => 'お届希望日を入力してください。',
            'request_delivery_time' => 'お届け希望時間帯を入力してください。',
            'name01' => 'お届け先住所をすべて入力してください。',
            'name02' => 'お届け先住所をすべて入力してください。',
            'postal_code' => 'お届け先住所をすべて入力してください。',
            'pref_id' => 'お届け先住所をすべて入力してください。',
            'addr01' => 'お届け先住所をすべて入力してください。',
            'addr02' => 'お届け先住所をすべて入力してください。',
            'phone_number' => 'お届け先住所をすべて入力してください。',
            'pay_method' => 'お支払い方法を選択してください。',
            'order_first_name' => '注文者情報をすべて入力してください。',
            'order_last_name' => '注文者情報をすべて入力してください。',
            'order_postal_code' => '注文者情報をすべて入力してください。',
            'order_prefecture' => '注文者情報をすべて入力してください。',
            'order_city' => '注文者情報をすべて入力してください。',
            'order_street' => '注文者情報をすべて入力してください。',
            'order_apartment' => '注文者情報をすべて入力してください。',
            'order_phone' => '注文者情報をすべて入力してください。',
            'order_email' => '注文者情報をすべて入力してください。',
        ];
    }
}
