<?php

/**
 * 表单验证-添加后台用户
 */

namespace App\Http\Requests\Admin\Custom;

use App\Http\Requests\Request;

class AddPlannerRequest extends Request
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
                'user_id' => 'required|integer|min:1|exists:admin_users,id',
                'name' => 'required|min:1|max:30',
                'desc' => 'string|max:255',
                'avatar' => 'mimes:jpeg,png,gif',
                'avatar_text' => 'required_without:avatar|string|max:255',
                'enable' => 'required|boolean',
            ];
        }
        return [];
    }

}
