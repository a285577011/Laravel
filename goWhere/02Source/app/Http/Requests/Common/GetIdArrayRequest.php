<?php

namespace App\Http\Requests\Common;

use App\Http\Requests\Request;

class GetIdArrayRequest extends Request
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
        if($this->isMethod('POST')) {
            return [
                'id'=>'required|int_array:1'
            ];
        }
        return [
            'id'=>'required|integer|min:1'
        ];
    }
}
