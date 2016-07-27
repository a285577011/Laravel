<?php

/**
 * 表单验证-添加后台用户
 */

namespace App\Http\Requests\Admin\System;

use App\Http\Requests\Request;

class ProfileRequest extends Request
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
        if ($this->isMethod('POST')) {
            return [
                'phone' => 'required_without_all:username,email|cnphone|unique:admin_users,phone,'.\Auth::user()->id,
                'password' => 'confirmed|min:6|max:20|password',
                'email' => 'required|email|max:255|unique:admin_users,email,'.\Auth::user()->id,
            ];
        }
        return [
        ];
    }

}
