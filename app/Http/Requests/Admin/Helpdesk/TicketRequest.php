<?php

namespace App\Http\Requests\Admin\Helpdesk;

use App\Models\Helpdesk\HelpdeskConfig;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class TicketRequest extends FormRequest
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
        $config = (new HelpdeskConfig())->getData();
        $max = $config->max_file_size;
        if($config->max_filesize_type==1){
            $max = $max / 1024;
        } elseif ($config->max_filesize_type==3) {
            $max = $max * 1024;
        }
        if(isset($request['id'])){
            return [
                'name'          => ['required','max:255'],
                'email'         => ['required','max:50'],
                'subject'       => ['required','max:50'],
                'message'       => ['required'],
                'attachments.new.tickets.*' => ['nullable', 'file', 'max:' . $max, 'mimes:' . $config->allowed_file_types],
            ];
        } else {
            return [
                'name'          => ['required','max:255'],
                'email'         => ['required','max:50'],
                'category_id'   => ['required'],
                'priority_id'   => ['required'],
                'status_id'     => ['required'],
                'subject'       => ['required','max:50'],
                'message'       => ['required'],
                'attachments.new.tickets.*' => ['nullable', 'file', 'max:' . $max, 'mimes:' . $config->allowed_file_types],
            ];
        }
    }
}
