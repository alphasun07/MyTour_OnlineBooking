<?php

namespace App\Http\Requests;

use App\Rules\TextNumberFullsize;
use Illuminate\Foundation\Http\FormRequest;

class OrderSendMailRequest extends FormRequest
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
            'mail_subject' => ['required'],
            'mail_text' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'mail_subject.required' => '入力してください。',
            'mail_text.required' => '入力してください。',
        ];
    }
}
