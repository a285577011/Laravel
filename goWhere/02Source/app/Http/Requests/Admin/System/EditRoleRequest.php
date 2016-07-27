<?php

/**
 * 表单验证-添加后台用户
 */

namespace App\Http\Requests\Admin\System;

use App\Http\Requests\Request;

class EditRoleRequest extends Request
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
                'name' => ['required', 'max:30', 'unique:roles,name'.$this->input('id')],
                'display_name' => 'required|max:255|unique:roles,display_name'.$this->input('id'),
                'description' => 'max:255',
            ];
        }
        return [];
    }

}
