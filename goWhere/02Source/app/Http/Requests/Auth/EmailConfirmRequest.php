<?php

/**
 * 表单验证-添加后台用户
 */

namespace App\Http\Requests\Auth;

use App\Http\Requests\Request;

class EmailConfirmRequest extends Request
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
            'email' => 'required|email|max:255',
            'token' => 'required'
        ];
    }

}
