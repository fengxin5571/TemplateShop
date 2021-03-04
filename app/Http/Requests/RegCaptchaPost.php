<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegCaptchaPost extends ApiBaseRequest
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
            'mobile'=>'required|is_mobile'
        ];
    }
    public function attributes()
    {
        return [
            'mobile'         =>'手机号',
        ];
    }
    public function messages()
    {
        return [
            'mobile.required'=>':attribute不能为空',
            'mobile.is_mobile'=>':attribute格式不正确',
        ];
    }
}
