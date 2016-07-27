<?php

/**
 * 表单验证-添加faq
 */

namespace App\Http\Requests\Admin\System;

use App\Http\Requests\Request;

class AddFaqRequest extends Request
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
                'title' => ['required', 'max:200'],
                'content' => 'string',
                'category_id' => 'required|integer|min:1',
                'author' => 'string|max:30',
                'sort' => 'integer',
                'lang' => 'required|integer|min:1',
            ];
        }
        return [
            'category' => 'integer',
            'title' => 'string|max:200',
            'lang' => 'integer',
        ];
    }

}
