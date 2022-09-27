<?php

namespace App\Http\Requests\Admin\Helpdesk;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoriesRequest extends FormRequest
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
                'title' => ['required', 'max:255', Rule::unique('pcm_helpdeskpro_categories', 'title')->ignore($request->category_id, 'id')],
                'description' => ['nullable', 'max:255'],
            ];
        } else{
            $validate = [
                'title' => ['required', 'max:255', Rule::unique('pcm_helpdeskpro_categories', 'title')->withoutTrashed()],
                'description' => ['nullable', 'max:255'],
            ];
        }
        return $validate;
    }

    public function messages()
    {
        return [

        ];
    }
}
