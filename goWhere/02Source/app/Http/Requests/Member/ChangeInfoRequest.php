<?php

/**
 * 表单验证-头像上传
 */

namespace App\Http\Requests\Member;

use App\Http\Requests\Request;

class ChangeInfoRequest extends Request
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
            'avatar' => 'mimes:jpeg,png,gif',
            'name' => 'string|max:30',
            'nickname' => 'string|max:30',
            'gender' => 'integer',
        ];
    }

}
