<?php

namespace App\Http\Requests\Front;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class CartAddressRequest extends FormRequest
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
        if($request->page == '注文者情報'){
            return [
                'name01' => ['required','regex:/^[a-zA-Z\x82-\x9f\xe0-\xef][\x40-\x7e\x80-\xfc]+$/'],
                'name02' => ['required','regex:/^[a-zA-Z\x82-\x9f\xe0-\xef][\x40-\x7e\x80-\xfc]+$/'],
                'kana01' => ['required','regex:/^[ア-ン゛゜ァ-ォャ-ョー]+$/u'],
                'kana02' => ['required','regex:/^[ア-ン゛゜ァ-ォャ-ョー]+$/u'],
                'postal_code' => ['required','regex:/^[0-9]+$/','digits:7'],
                'pref_id' => 'required',
                'addr01' => ['required','regex:/^[\x82-\x9f\xe0-\xef][\x40-\x7e\x80-\xfc]+$/'],
                'addr02' => ['required','regex:/^[0-9][\x82-\x9f\xe0-\xef][\x40-\x7e\x80-\xfc]+$/'],
                'addr03' => ['nullable','regex:/^[a-zA-Z0-9\x82-\x9f\xe0-\xef][\x40-\x7e\x80-\xfc]+$/'],
                'phone_number' => ['required','regex:/^[0-9]+$/','digits_between:9,11'],
                'email' => ['required','strict','dns','spoof'],
            ];
        }elseif($request->page == 'お届け先選択'){
            return [
                'customer_address_select_id' => 'required',
            ];
        }else{
            return [
                'name01' => ['required','regex:/^[a-zA-Z\x82-\x9f\xe0-\xef][\x40-\x7e\x80-\xfc]+$/'],
                'name02' => ['required','regex:/^[a-zA-Z\x82-\x9f\xe0-\xef][\x40-\x7e\x80-\xfc]+$/'],
                'kana01' => ['required','regex:/^[ア-ン゛゜ァ-ォャ-ョー]+$/u'],
                'kana02' => ['required','regex:/^[ア-ン゛゜ァ-ォャ-ョー]+$/u'],
                'postal_code' => ['required','regex:/^[0-9]+$/','digits:7'],
                'pref_id' => 'required',
                'addr01' => ['required','regex:/^[\x82-\x9f\xe0-\xef][\x40-\x7e\x80-\xfc]+$/'],
                'addr02' => ['required','regex:/^[0-9\x82-\x9f\xe0-\xef][\x40-\x7e\x80-\xfc]+$/'],
                'addr03' => ['regex:/^[a-zA-Z0-9\x82-\x9f\xe0-\xef][\x40-\x7e\x80-\xfc]+$/'],
                'phone_number' => ['required','regex:/^[0-9]+$/','digits_between:9,11'],
            ];
        }
    }

    public function messages()
    {
        return [
            'name01.required' => '姓を入力してください。',
            'name01.regex' => 'その文字は入力できません。',
            'name02.required' => '名を入力してください。',
            'name02.regex' => 'その文字は入力できません。',
            'kana01.required' => '姓(セイ)を入力してください。',
            'kana01.regex' => 'カタカナで入力してください。',
            'kana02.required' => '名(メイ)を入力してください。',
            'kana02.regex' => 'カタカナで入力してください。',
            'postal_code.required' => '郵便番号を入力してください。',
            'postal_code.regex' => '半角数字を入力してください。',
            'postal_code.digits' => '7桁を入力してください。',
            'pref_id.required' => '都道府県を入力してください。',
            'addr01.required' => '市区町村を入力してください。',
            'addr01.regex' => 'その文字は入力できません。',
            'addr02.required' => '番地を入力してください。',
            'addr02.regex' => 'その文字は入力できません。',
            'addr03.regex' => 'その文字は入力できません。',
            'phone_number.required' => '電話番号を入力してください。',
            'phone_number.regex' => '半角数字を入力してください。',
            'phone_number.digits_between' => '9~11桁を入力してください。',
            'email.required' => 'メールアドレスを入力してください。',
            'email.strict' => 'このメールアドレスは使用できません。',
            'email.dns' => '＠以降が正しくありません。',
            'customer_address_select_id.required' => 'お届け先住所を選択してください。',
        ];
    }
}
