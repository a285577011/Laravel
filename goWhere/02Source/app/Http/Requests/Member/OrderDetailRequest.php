<?php

/**
 * 表单验证-头像上传
 */

namespace App\Http\Requests\Member;

use App\Http\Requests\Request;

class OrderDetailRequest extends Request
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
            'ordersn' => 'required'
        ];
    }

}
