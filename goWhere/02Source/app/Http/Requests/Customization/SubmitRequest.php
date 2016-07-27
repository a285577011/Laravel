<?php

namespace App\Http\Requests\Customization;

use App\Http\Requests\Request;

class SubmitRequest extends Request
{
    //protected $redirect = 'errors/error';
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
        if($this->isMethod('POST')){
            return [
                'planner'=>'integer|min:1',
                'name'=>'required|string|max:30',
                'gender'=>'required|integer|min:1|max:2',
                'phone'=>'required|cnphone',
                'contact_time'=>'required|comma_int:1,5',
                'email'=>'required|email|string|max:255',
                'destination'=>'required|string|max:50',
                'departure'=>'required|date_format:Y-m-d',
                'from'=>'required|string|max:50',
                'budget'=>'required|integer|min:1',
                'subject'=>'required|integer|min:1',
                'airline'=>'required|integer|min:1',
                'hotel'=>'required|integer|min:1',
                'dinner'=>'required|comma_int:1,3',
                'duration' => 'required|integer|min:1',
                'people' => 'required|integer|min:1',
                'attendant'=>'required|integer|min:1',
                'visa'=>'required|integer|min:0|max:1',
                'extra'=>'string|max:255',
            ];
        }
        return [];
    }
}
