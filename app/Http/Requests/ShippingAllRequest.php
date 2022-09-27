<?php

namespace App\Http\Requests;

use App\Rules\NumberHalfsize;
use App\Rules\TextNumberFullsize;
use App\Rules\TextNumberHalfsize;
use Illuminate\Foundation\Http\FormRequest;

class ShippingAllRequest extends FormRequest
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
            'name' => ['nullable', 'max:256', new TextNumberFullsize()],
            'name_kana' => ['nullable', 'max:256', new TextNumberFullsize()],
            'company_name' => ['nullable', 'max:256'],
            'email' => ['nullable', 'max:256', new TextNumberHalfsize()],
            'phone_number' => ['nullable', 'max:256', new NumberHalfsize()],
            'question_no' => ['nullable', 'max:11'],
            'start_payment_total' => ['nullable', 'max:10', new NumberHalfsize()],
            'end_payment_total' => ['nullable', 'max:10', new NumberHalfsize()],
            'product_name' => ['nullable', 'max:256', new TextNumberFullsize()]
        ];
    }

    public function messages()
    {
        return [
            'name.max' => '256以下の値にしてください。',
            'name_kana.max' => '256以下の値にしてください。',
            'company_name.max' => '256以下の値にしてください。',
            'email.max' => '256以下の値にしてください。',
            'phone_number.max' => '256以下の値にしてください。',
            'question_no.max' => '256以下の値にしてください。',
            'start_payment_total.max' => '256以下の値にしてください。',
            'end_payment_total.max' => '256以下の値にしてください。',
            'product_name.max' => '256以下の値にしてください。',
        ];
    }
}
