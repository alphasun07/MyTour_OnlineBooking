<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class AdminLoginRequest extends FormRequest
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
            'password' => 'required|min:8',
            'login_id' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'login_id.*' => 'Vui lòng nhập tên đăng nhập của bạn',
            'password.required' => 'Vui lòng nhập mật khẩu của bạn.',
            'password.min' => 'Mật khẩu phải có nhiều hơn 8 ký tự'
        ];
    }
}
