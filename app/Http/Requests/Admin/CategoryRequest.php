<?php

namespace App\Http\Requests\Admin;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class CategoryRequest extends FormRequest
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
        if($request->category_id){
            $validate = [
                'name' => ['required', 'max:255', Rule::unique('pcm_dms_categories', 'name')->ignore($request->category_id, 'id')],
                'description' => ['nullable', 'max:255'],
            ];
        } else{
            $validate = [
                'name' => ['required', 'max:255', Rule::unique('pcm_dms_categories', 'name')->withoutTrashed()],
                'description' => ['nullable', 'max:255'],
            ];
        }
        return $validate;
    }

    //カスタムメッセージを設定
    public function messages()
    {
        return [

        ];
    }
}
