<?php

namespace App\Http\Requests\Admin;

use App\Rules\CheckTeleNumberRule;
use App\Rules\TextFullsizeKana;
use App\Rules\TextFullsizeKanjiHira;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminRequest extends FormRequest
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
        $data_member = $request->all();
        $id = $data_member['member_id'] ?? null;
        $rule = [
            'name' => ['required'],
            'login_id' => ['required', Rule::unique('pcm_members', 'login_id')->withoutTrashed()],
            'password' => ['required', 'min:8'],
            'phone_number' => ['nullable', 'max:16', 'regex:/^(\(?\+[0-9]{0,4}\)?)?[0-9]+$/'],
            'address' => ['max:255'],
            'gender_id' => ['in:1,2,3'],
            'birthdate' => ['nullable', 'before:today'],
        ];

        if($id){
            $rule['login_id'] = ['required', Rule::unique('pcm_members', 'login_id')->ignore($id, 'id')];
            $rule['password'] = ['nullable', 'min:8'];
        }

        return $rule;
    }
}
