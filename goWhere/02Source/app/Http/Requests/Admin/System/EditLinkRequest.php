<?php

/**
 * 表单验证-添加后台用户
 */

namespace App\Http\Requests\Admin\System;

use App\Http\Requests\Request;

class EditLinkRequest extends Request
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
                'title' => ['required', 'max:50'],
                'url' => 'required|url|string|max:255',
                'logo' => 'image',
                'logo_text' => 'string|max:255',
                'valid' => 'required|boolean',
            ];
        }
        return [
            'id' => 'required|integer|min:1',
        ];
    }

}
