<?php

namespace App\Http\Requests\Front;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class CartConfirmRequest extends FormRequest
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
            'point' => 'required',
            'pay_method' => 'required',
            'total_price' => 'required',
            'delivery_fee_total' => 'required',
            'use_point' => 'required',
            'add_point' => 'required',
            'use_coupon' => 'required',
            'cart_total' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'point' => 'ポイントのご利用方法を選択してください。',
            'pay_method' => '支払方法を選択してください。',
            'total_price' => 'お手数ですが、カート画面からやり直してください。',
            'delivery_fee_total' => 'お手数ですが、カート画面からやり直してください。',
            'use_point' => 'お手数ですが、カート画面からやり直してください。',
            'add_point' => 'お手数ですが、カート画面からやり直してください。',
            'use_coupon' => 'お手数ですが、カート画面からやり直してください。',
            'cart_total' => 'お手数ですが、カート画面からやり直してください。',
        ];
    }
}
