<?php

namespace App\Http\Requests\Mice;

use App\Http\Requests\Request;

class MiceNeedRequest extends Request
{
    public $errorPage=true;
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
            'area'  => 'required|numeric|integer|min:1',
            'people_num'  => 'required|numeric|integer|between:1,6',
            'budget'  => 'required|numeric|integer|between:1,6',
            'type'  => 'required|numeric|integer|between:1,2',
            'name'  => 'required|max:30',
            'phone'  => 'required|regex:/^1[34578][0-9]{9}$/',            
        ];
    }
}
