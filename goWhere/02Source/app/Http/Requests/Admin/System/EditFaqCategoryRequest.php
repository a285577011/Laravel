<?php

/**
 * 表单验证-添加faq
 */

namespace App\Http\Requests\Admin\System;

use App\Http\Requests\Request;

class EditFaqCategoryRequest extends Request
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
                'name_zh_cn' => 'required|string|max:30',
                'name_zh_tw' => 'required|string|max:30',
                'name_en_us' => 'required|string|max:30',
                'sort' => 'integer',
            ];
        }
        return [
            'id' => 'required|integer|min:1',
        ];
    }

}
