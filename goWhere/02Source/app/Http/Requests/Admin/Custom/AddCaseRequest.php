<?php

/**
 * 表单验证-添加
 */

namespace App\Http\Requests\Admin\Custom;

use App\Http\Requests\Request;

class AddCaseRequest extends Request
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
                'enable' => 'required|boolean',
                'lang' => 'required|integer|min:1',
                'image' => 'image',
                'image_text' => 'required_without:image|string|max:255',
                'cost' => 'required|string|max:100',
                'createCht' => 'boolean',
            ];
        }
        return [
            'title' => 'string|max:200',
            'lang' => 'integer',
        ];
    }

}
