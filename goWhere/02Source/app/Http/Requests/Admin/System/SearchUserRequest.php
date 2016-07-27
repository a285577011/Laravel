<?php

/**
 * 表单验证-角色用户管理
 */

namespace App\Http\Requests\Admin\System;

use App\Http\Requests\Request;

class SearchUserRequest extends Request
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
        return [
            'id' => 'required_without_all:username,name|integer|min:1',
            'page' => 'integer',
            'username' => 'required_without_all:id,name|string|max:16',
            'name' => 'required_without_all:id,username|string|max:30'
        ];
    }

}
