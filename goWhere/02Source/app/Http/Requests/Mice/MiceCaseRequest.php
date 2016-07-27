<?php

namespace App\Http\Requests\Mice;

use App\Http\Requests\Request;

class MiceCaseRequest extends Request
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
            'start_time'=>'required|date',
           /*'area'  => 'required|numeric|integer|min:1',
            'people_num'  => 'required|numeric|integer|between:1,6',
            'budget'  => 'required|numeric|integer|between:1,6',
            'type'  => 'required|numeric|integer|between:3,7',
            'name'  => 'required|max:30',
            'phone'  => 'required|regex:/^1[34578][0-9]{9}$/',            
            'departure_date'  => 'required|date',
            'duration'  => 'required|numeric|integer|min:1',
            'services'  => 'required|array',
            'remark'=>'max:255',
            'hotel_level'=>'required|numeric|integer|between:0,5',
            'hotel_rooms'=>'required|numeric|integer|min:1',
            'email'=>'email',
            'qq_wechat'=>array('regex:/([1-9][0-9]{4,})|(^[a-zA-Zd_]{5,}$)/'),
            */
        ];
    }
}
