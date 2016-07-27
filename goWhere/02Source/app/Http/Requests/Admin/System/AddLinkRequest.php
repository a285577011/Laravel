<?php

/**
 * 表单验证-添加链接
 */

namespace App\Http\Requests\Admin\System;

use App\Http\Requests\Request;

class AddLinkRequest extends Request
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
                'title' => ['required', 'max:50'],
                'url' => 'required|url|string|max:255',
                'logo' => 'image',
                'logo_text' => 'url|string|max:255',
                'valid' => 'required|boolean',
            ];
        }
        return [];
    }

}
