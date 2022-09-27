<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class DocumentRequest extends FormRequest
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
            'title'                         => 'required|max:255',
            'alias'                         => 'nullable|max:80',
            'thumb'                         => 'nullable|image',
            'filename'                      => 'nullable|max:255',
            'price'                         => 'required|numeric',
            'renewal_price'                 => 'required|numeric',
            'version'                       => 'nullable|max:10',
            'demo_url'                      => 'nullable|max:255|url',
            'detail_url'                    => 'nullable|max:255|url',
            'documentation_url'             => 'nullable|max:255|url',
            'tags'                          => 'nullable|max:255',
            'short_description'             => 'required',
            'description'                   => 'required',
            'prevent_download_type'         => 'nullable|in:1,2,3',
            'number_downloads'              => 'nullable|numeric',
            'number_days'                   => 'nullable|numeric',
            'meta_key'                      => 'nullable|max:255',
            'meta_description'              => 'nullable|max:255',
            'category'                      => 'nullable',
            'tab_1_title'                   => 'nullable|max:100',
            'document_image.image.*'        => 'nullable|image',
            'document_image.published.old.*'=> 'in:0,1',
            'document_image.published.new.*'=> 'in:0,1',
        ];
    }
}
