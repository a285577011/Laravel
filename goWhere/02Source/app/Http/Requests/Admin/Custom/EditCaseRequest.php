<?php

/**
 * 表单验证-添加faq
 */

namespace App\Http\Requests\Admin\Custom;

use App\Http\Requests\Request;

class EditCaseRequest extends Request
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
                'title' => ['required', 'max:200'],
                'content' => 'string',
                'enable' => 'required|boolean',
                'lang' => 'required|integer|min:1',
                'image' => 'image',
                'image_text' => 'required_without:image|string|max:255',
                'cost' => 'required|string|max:100',
            ];
        }
        return [
            'id' => 'required|integer|min:1',
        ];
    }

}
