<?php

namespace App\Http\Requests\Fair;

use App\Http\Requests\Request;

class SearchPavilionRequest extends Request
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
            'keywords'=>'sometimes|string|max:100',
            'hotArea'=>'sometimes|integer|min:1',
        ];
    }
}
