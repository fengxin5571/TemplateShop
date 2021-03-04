<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddressSavePost extends ApiBaseRequest
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
            'addressDetail'=>'required',
            'name'=>'required',
            'tel'=>'required|is_mobile',
        ];
    }
    public function attributes()
    {
        return [
            'addressDetail'=>'详细地址',
            'name'=>'联系人',
            'tel'=>'手机号',
        ];
    }
    public function messages()
    {
        return [
            'addressDetail.required'=>':attribute不能为空',
            'name.required'=>':attribute不能为空',
            'tel.required'=>':attribute不能为空',
            'tel.is_mobile'=>':attribute格式不正确',
        ];
    }
}
