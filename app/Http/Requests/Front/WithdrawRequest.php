<?php

namespace App\Http\Requests\Front;

use Illuminate\Foundation\Http\FormRequest;

class WithdrawRequest extends FormRequest
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
            "delete1"    => 'required',
            "delete2"    => 'required',
        ];
    }

    public function messages()
    {
        return [
            'delete1.required' => 'チェックを入れてください。',
            'delete2.required' => 'チェックを入れてください。'
        ];
    }
}

