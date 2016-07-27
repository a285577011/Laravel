<?php

/**
 * 表单验证-编辑前台用户
 */

namespace App\Http\Requests\Admin\System;

use App\Http\Requests\Request;

class EditMemberRequest extends Request
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
                'username' => ['required', 'max:16', 'regex:/^[a-zA-Z]+[a-zA-Z0-9_]*[a-zA-Z0-9]$/', 'unique:members,username,'.$this->input('id')],
                'nickname' => 'string|max:30',
                'name' => 'string|max:30',
                'email' => 'required_without_all:username,phone|email|max:255|unique:members,email,'.$this->input('id'),
                'phone' => 'required_without_all:username,email|cnphone|unique:members,phone,'.$this->input('id'),
                'password' => 'confirmed|min:6|max:20|password',
                'active' => 'required|boolean',
                'mobile_verify' => 'required|boolean',
                'email_verify' => 'required|boolean',
                'gender' => 'required|integer|min:1|max:2',
            ];
        }
        return [
            'id' => 'required|integer|min:1',
        ];
    }

}
