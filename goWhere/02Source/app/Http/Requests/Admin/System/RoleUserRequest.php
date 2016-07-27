<?php

/**
 * 表单验证-角色用户管理
 */

namespace App\Http\Requests\Admin\System;

use App\Http\Requests\Request;

class RoleUserRequest extends Request
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
        if($this->isMethod('POST'))
        {
            return [
                'id' => 'required|integer|min:1',
                'user' => 'required|string|max:16',
            ];
        } elseif ($this->input('action')) {
            return [
                'id' => 'required|integer|min:1',
                'user' => 'required|integer|min:1',
                'action' => 'integer|min:1|max:2',
                'page' => 'interger'
            ];
        }
        return [
            'id' => 'required|integer|min:1',
            'page' => 'integer'
        ];
    }

}
