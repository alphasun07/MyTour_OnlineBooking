<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CouponRequest extends FormRequest
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
        $ruleArr = [
            'code' => 'required|max:255',
            'discount' => 'required|numeric',
            'coupon_type' => 'required',
            'tour_id' => 'required',
            'max_use' => 'required|numeric',

        ];

        return $ruleArr;
    }
}
