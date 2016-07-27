<?php

/**
 * 表单验证-添加后台用户
 */

namespace App\Http\Requests\Admin\System;

use App\Http\Requests\Request;

class AddUserRequest extends Request
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
                'username' => ['required', 'max:16', 'regex:/^[a-zA-Z]+[a-zA-Z0-9_]*[a-zA-Z0-9]$/', 'unique:admin_users'],
                'name' => 'required|min:1|max:30',
                'phone' => 'required_without_all:username,email|cnphone|unique:admin_users',
                'password' => 'required|confirmed|min:6|max:20|password',
                'email' => 'required|email|max:255|unique:admin_users',
                'userRole' => 'required|int_array:1'
            ];
        }
        return [];
    }

}
