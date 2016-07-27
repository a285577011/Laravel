<?php

/**
 * 表单验证-添加后台用户
 */

namespace App\Http\Requests\Admin\System;

use App\Http\Requests\Request;

class EditUserRequest extends Request
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
                'id' => 'required|integer|min:1',
                'name' => 'required|min:1|max:30',
                'username' => ['required', 'max:16', 'regex:/^[a-zA-Z]+[a-zA-Z0-9_]*[a-zA-Z0-9]$/', 'unique:admin_users,username,'.$this->input('id')],
                'phone' => 'required_without_all:username,email|cnphone|unique:admin_users,phone,'.$this->input('id'),
                'password' => 'confirmed|min:6|max:20|password',
                'email' => 'required|email|max:255|unique:admin_users,email,'.$this->input('id'),
            ];
        }
        return [
            'id' => 'required|integer|min:1',
        ];
    }

}
