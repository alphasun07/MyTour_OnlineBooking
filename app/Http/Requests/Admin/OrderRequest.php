<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class OrderRequest extends FormRequest
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
        $validate = [
            'user_id' => ['required'],
            'first_name' => ['required', 'max:100'],
            'last_name' => ['required', 'max:100'],
            'organization' => ['nullable', 'max:255'],
            'address' => ['required', 'max:255'],
            'country' => ['required'],
            'city' => ['required', 'max:50'],
            'state' => ['required', 'max:50'],
            'zip' => ['required', 'max:50'],
            'phone' => ['nullable', 'max:50', 'regex:/^(\(?\+[0-9]{0,4}\)?)?[0-9]+$/'],
            'email' => ['required', 'max:255', 'email'],
            'referral_code' => ['nullable', 'max:50'],
        ];
        return $validate;
    }
}
