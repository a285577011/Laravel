<?php

namespace App\Http\Requests\Admin\Custom;

use App\Http\Requests\Request;

class ChangeStatusRequest extends Request
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
            'id' => 'required|integer|min:1',
            'status' => 'required|integer|min:0|max:2',
        ];
    }

}
