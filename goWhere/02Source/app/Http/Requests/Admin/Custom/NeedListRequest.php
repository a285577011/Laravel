<?php

namespace App\Http\Requests\Admin\Custom;

use App\Http\Requests\Request;

class NeedListRequest extends Request
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
            'planner' => 'integer|min:1',
            'page' => 'integer',
        ];
    }

}
