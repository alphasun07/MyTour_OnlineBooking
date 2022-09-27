<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SocialMediaRequest extends FormRequest
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
            'facebook' => 'max:255',
            'instagram' => 'max:255',
            'youtube' => 'max:255',
            'linkedIn' => 'max:255'
        ];
    }
    public function messages()
    {
        return [
            'facebook.max' => 'Chỉ nhập tối đa 255 ký tự',
            'instagram.max' => 'Chỉ nhập tối đa 255 ký tự',
            'youtube.max' => 'Chỉ nhập tối đa 255 ký tự',
            'linkedIn.max' => 'Chỉ nhập tối đa 255 ký tự'
        ];
    }
}
