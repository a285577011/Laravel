<?php

/**
 * 表单验证-添加后台用户
 */

namespace App\Http\Requests\Admin\System;

use App\Http\Requests\Request;

class GrantPermissionRequest extends Request
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
                'id' => 'required|integer|min:1', // roleId
                'permissions' => 'int_array:1', // permission id, int array, min:1
            ];
        }
        return [
            'id' => 'required|integer|min:1', // roleId
        ];
    }

}
