<?php

namespace App\Http\Requests;

use App\Rules\NumberHalfsize;
use App\Rules\TextNumberFullsize;
use App\Rules\TextFullsizeKanjiHira;
use App\Rules\TextFullsizeKana;
use App\Rules\TextNumberFullsizeHalfsize;
use Illuminate\Foundation\Http\FormRequest;

class OrderUpdateRequest extends FormRequest
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
    public function rules()
    {
        return [
            'order_name01' => ['nullable', 'max:256', new TextFullsizeKanjiHira()],
            'order_name02' => ['nullable', 'max:256', new TextFullsizeKanjiHira()],
            'order_kana01' => ['nullable', 'max:256', new TextFullsizeKana()],
            'order_kana02' => ['nullable', 'max:256', new TextFullsizeKana()],
            'order_postal_code' => ['nullable', 'max:7', new NumberHalfsize()],
            'order_addr01' => ['nullable', 'max:256', new TextNumberFullsize()],
            'order_addr02' => ['nullable', 'max:256', new TextNumberFullsize()],
            'order_email' => ['nullable', 'max:256', 'email'],
            'order_phone_number' => ['nullable', 'max:11', new NumberHalfsize()],
            'order_operate_note' => ['nullable', 'max:256', new TextNumberFullsizeHalfsize()],
            'shipping_name01' => ['nullable', 'max:256', new TextFullsizeKanjiHira()],
            'shipping_name02' => ['nullable', 'max:256', new TextFullsizeKanjiHira()],
            'shipping_kana01' => ['nullable', 'max:256', new TextFullsizeKana()],
            'shipping_kana02' => ['nullable', 'max:256', new TextFullsizeKana()],
            'shipping_postal_code' => ['nullable', 'max:7', new NumberHalfsize()],
            'shipping_addr01' => ['nullable', 'max:256', new TextNumberFullsize()],
            'shipping_addr02' => ['nullable', 'max:256', new TextNumberFullsize()],
            'shipping_phone_number' => ['nullable', 'max:11', new NumberHalfsize()],
            'shipping_tracking_number' => ['nullable', 'max:256', new NumberHalfsize()],
            'delivery_note' => ['nullable', 'max:256', new TextNumberFullsizeHalfsize()],
            'shop_note' => ['nullable', 'max:256', new TextNumberFullsizeHalfsize()],
        ];
    }

    public function messages()
    {
        return [
            'order_name01.max' => '256文字以下で入力してください。',
            'order_name02.max' => '256文字以下で入力してください。',
            'order_kana02.max' => '256文字以下で入力してください。',
            'order_kana01.max' => '256文字以下で入力してください。',
            'order_postal_code.max' => '7桁の半角数字を入力してください。',
            'order_addr01.max' => '256文字以下で入力してください。',
            'order_addr02.max' => '256文字以下で入力してください。',
            'order_email.max' => '256桁以下の半角英数字を入力してください。',
            'order_email.email' => '正しいメールアドレスを入力してください。',
            'order_phone_number.max' => '11桁以下の半角数字を入力してください。',
            'shipping_name01.max' => '256文字以下で入力してください。',
            'shipping_name02.max' => '256文字以下で入力してください。',
            'shipping_kana01.max' => '256文字以下で入力してください。',
            'shipping_kana02.max' => '256文字以下で入力してください。',
            'shipping_postal_code.max' => '7桁の半角数字を入力してください。',
            'shipping_addr01.max' => '256文字以下で入力してください。',
            'shipping_addr02.max' => '256文字以下で入力してください。',
            'shipping_phone_number.max' => '11桁以下の半角数字を入力してください。',
            'shipping_tracking_number.max' => '256桁以下の数字を入力してください。',
            'delivery_note.max' => '256文字以下で入力してください。',
            'delivery_note.max' => '256文字以下で入力してください。',
        ];
    }
}
