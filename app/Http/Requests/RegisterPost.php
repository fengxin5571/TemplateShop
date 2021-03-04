<?php

namespace App\Http\Requests;


class RegisterPost extends ApiBaseRequest
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
            'mobile'         =>'required|is_mobile',
            'password'       =>'required',
            'repeatPassword' =>'required|same:password',
            'username'       =>'required',
            'code'           =>'required'
        ];
    }
    public function attributes()
    {
        return [
            'mobile'         =>'手机号',
            'password'       =>'密码',
            'repeatPassword' =>'确认密码',
            'username'       =>'用户名',
            'code'           =>'验证码'
        ];
    }
    public function messages()
    {
        return [
            'mobile.required'=>':attribute不能为空',
            'mobile.is_mobile'=>':attribute格式不正确',
            'password.required'=>':attribute不能为空',
            'repeatPassword.required'=>':attribute不能为空',
            'repeatPassword.same'=>'两次密码不一致',
            'username.required'=>':attribute不能为空',
            'code.required'=>':attribute不能为空',
        ];
    }
}
