<?php

namespace App\Http\Requests;

use App\Rules\TextNumberFullsizeHalfsize;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class SiteSettingRequest extends FormRequest
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
            'need_money' => ['required','max:256', new TextNumberFullsizeHalfsize],
            'pay_limit' => ['required','max:256', new TextNumberFullsizeHalfsize],
            'sale_price' => ['required','max:256', new TextNumberFullsizeHalfsize],
            'delivery_time' => ['required','max:256', new TextNumberFullsizeHalfsize],
            'return' => ['required','max:256', new TextNumberFullsizeHalfsize],
            'gest_flg' => 'required',
            'site_flg' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'need_money.required' => '入力してください。',
            'pay_limit.required' => '入力してください。',
            'sale_price.required' => '入力してください。',
            'delivery_time.required' => '入力してください。',
            'return.required' => '入力してください。',
            'gest_flg.required' => '入力してください。',
            'site_flg.required' => '入力してください。',
            'need_money.max' => '255文字以下にしてください。',
            'pay_limit.max' => '255文字以下にしてください。',
            'sale_price.max' => '255文字以下にしてください。',
            'delivery_time.max' => '255文字以下にしてください。',
            'return.max' => '255文字以下にしてください。',
        ];
    }
}