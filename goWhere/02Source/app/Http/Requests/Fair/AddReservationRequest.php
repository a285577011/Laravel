<?php

namespace App\Http\Requests\Fair;

use App\Http\Requests\Request;

class AddReservationRequest extends Request
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
        if($this->isMethod('POST')){
            return [
                'fairId'=>'required|integer|min:1',
                'name'=>'required|string|max:30',
                'phone'=>'required|string|max:20',
                'address'=>'string|max:200',
                'email'=>'email|string|max:255',
                'company'=>'required|string|max:80',
                'company_addr'=>'string|max:200',
                'num'=>'integer|min:1',
                'needs'=>'string|max:255',
                'services'=>'string|max:255'
            ];
        }
        return ['fairId'=>'required|integer|min:1'];
    }
}
