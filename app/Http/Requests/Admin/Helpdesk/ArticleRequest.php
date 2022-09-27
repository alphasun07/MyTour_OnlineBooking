<?php

namespace App\Http\Requests\Admin\Helpdesk;

use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest
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
            'title' => 'required',
            'category_id' => 'required|numeric',
            'text' => 'required',
        ];
        return $ruleArr;
    }
}
