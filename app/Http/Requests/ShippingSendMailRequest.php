<?php

namespace App\Http\Requests;

use App\Rules\TextNumberFullsize;
use Illuminate\Foundation\Http\FormRequest;

class ShippingSendMailRequest extends FormRequest
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
            'mail_subject' => ['required','max:255', new TextNumberFullsize()],
            'mail_body' => ['required', new TextNumberFullsize()],
            'sendMailChoose' => ['required']
        ];
    }

    public function messages()
    {
        return [
            'mail_subject.max' => '255以下の値にしてください。',
            'mail_subject.required' => 'この値は必須です。',
            'mail_body.required' => 'この値は必須です。',
            'sendMailChoose.required' => 'この値は必須です。'
        ];
    }
}
