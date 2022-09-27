<?php

namespace App\Http\Requests\Front;

use Illuminate\Foundation\Http\FormRequest;

class AddressRequest extends FormRequest
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
            "name01"    => 'required',
            "name02"    => 'required',
            'kana01' => '',
            'kana02' => '',
            'company_name' => 'required',
            'postal_code' => 'required',
            'pref_id' => 'required',
            'addr01' => 'required',
            'addr02' => 'required',
            'addr03' => '',
            'phone_number' => 'required',
            'customer_id' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'name01.required' => '姓を入力してください。',
            'name02.required' => '名を入力してください。',
            'company_name.required' => '会社名を入力してください。',
            'postal_code.required' => '郵便番号を入力してください。',
            'pref_id.required' => '都道府県を入力してください。',
            'addr01.required' => '住所１を入力してください。',
            'addr02.required' => '住所２を入力してください。',
            'phone_number.required' => '電話番号を入力してください。',
            'customer_id.required' => '会員IDを入力してください。',
        ];
    }
}
