<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginPost extends ApiBaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
            'username'=>'required',
            'password'=>'required'
        ];
    }
    public function attributes()
    {
        return [
            'username'         =>'用户名',
            'password'         =>'密码'
        ];
    }
    public function messages()
    {
        return [
            'username.required'=>':attribute不能为空',
            'password.required'=>':attribute不能为空',
        ];
    }
}
