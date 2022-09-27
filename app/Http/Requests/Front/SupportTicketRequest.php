<?php

namespace App\Http\Requests\Front;

use App\Models\Helpdesk\HelpdeskConfig;
use Illuminate\Foundation\Http\FormRequest;

class SupportTicketRequest extends FormRequest
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
        $config = (new HelpdeskConfig())->getData();
        $max = $config->max_file_size;
        if($config->max_filesize_type==1){
            $max = $max / 1024;
        } elseif ($config->max_filesize_type==3) {
            $max = $max * 1024;
        }

        return [
            'category_id' => 'required',
            'subject' => 'required|max:255',
            'priority_id' => 'required',
            'message' => 'required',
            'attachments.*' => ['nullable', 'file', 'max:' . $max, 'mimes:' . $config->allowed_file_types],
        ];
    }
}
