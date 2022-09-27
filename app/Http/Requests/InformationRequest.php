<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class InformationRequest extends FormRequest
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
        $dataValidate = [];
        $dataValidate =
            [
                'title' => ['required', 'max:100'],
                'direct_url' => ['nullable'],
                'description' => ['required'],
                'publish_end_date' => ['nullable', 'after:publish_date_start'],
            ];
        if($request->flag_copy) {
            $dataValidate['slug'] = ['required'];
        } else {
            if(!empty($request->id)) {
                $dataValidate['slug'] = ['required', 'unique:dtb_newses,url,'.$request->id.',id,deleted_at,NULL'];
            } else {
                $dataValidate['slug'] = ['required', 'unique:dtb_newses,url'];
            }
        }
        return $dataValidate;
    }

    public function messages()
    {
        return [
            'title.required' => '入力してください。',
            'title.max' => '100文字以下で指定してください。',
            'description.required' => '入力してください。',
            'slug.required' => "入力してください。",
            'slug.unique' => "URLが既に存在します。",
            'publish_end_date.after' => '終了日には開始日以降の日付を選択してください。',
        ];
    }
}
