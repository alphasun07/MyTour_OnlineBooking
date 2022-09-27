<?php

namespace App\Http\Requests\Admin;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class TagRequest extends FormRequest
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
        if($request->id){
            $validate = [
                'title' => ['required', 'max:256', Rule::unique('pcm_dms_tags', 'title')->ignore($request->id, 'id')],
            ];
        } else{
            $validate = [
                'title' => ['required', 'max:256', Rule::unique('pcm_dms_tags', 'title')->withoutTrashed()],
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
