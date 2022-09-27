<?php

namespace App\Http\Requests;

use App\Models\PcmMember;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class ManagementRequest extends FormRequest
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
                'name' => ['required', 'max:255'],
                'authority_id' => 'required',
                'work_id' => 'required'
            ];
        if (empty($request->id)) {
            $dataValidate['password'] = ['required', 'min:8', 'max:40'];
            $dataValidate['login_id'] = ['required', 'max:255', 'unique:pcm_members'];
        } else {
            if (!empty($request->password)) {
                $dataValidate['password'] = ['min:8', 'max:40'];
            }
            $member = PcmMember::findOrFail($request->id);
            $login_id = $request['login_id'] ?? '';
            if ($member->login_id !== $login_id) {
                $dataValidate['login_id'] = ['required', 'max:255', 'unique:pcm_members'];
            } else {
                $dataValidate['login_id'] = ['required', 'max:255'];
            }
        }
        return $dataValidate;
    }

    public function messages()
    {
        return [
            'name.required' => 'この値は必須です。',
            'name.max' => '255 文字以下で入力してください。',
            'login_id.required' => 'この値は必須です。',
            'login_id.unique' => 'このIDが存在するので、登録できません。',
            'login_id.max' => '255 文字以下で入力してください。',
            'password.required' => 'パスワードを入力してください。',
            'password.min' => 'パスワードは8～40文字で入力してください。',
            'password.max' => 'パスワードは8～40文字で入力してください。',
            'authority_id.required' => 'この値は必須です。',
            'work_id.required' => 'この値は必須です。'
        ];
    }
}
