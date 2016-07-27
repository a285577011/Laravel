<?php

/**
 * 表单验证-添加后台用户
 */

namespace App\Http\Requests\Admin\System;

use App\Http\Requests\Request;

class AdManagementRequest extends Request
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
                'title' => ['required', 'max:30'],
                'module' => 'required|integer|min:1',
                'type' => 'required|integer|min:1',
                'sort' => 'required|integer',
                'size' => 'string',
                'position' => 'required|integer|min:1',
                'href' => 'required|url|max:255',
                'desc' => 'string|max:255',
                'attachment' => 'mimes:jpeg,bmp,png,gif,swf',
                'attachment_text' => 'required_without:attachment|string|max:255'
            ];
        }
        return [
            'title' => 'string|max:30',
            'module' => 'integer',
            'type' => 'integer',
        ];
    }

}
