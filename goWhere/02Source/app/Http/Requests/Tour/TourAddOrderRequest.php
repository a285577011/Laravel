<?php
namespace App\Http\Requests\Tour;

use App\Http\Requests\Request;

class TourAddOrderRequest extends Request
{

    //public $redirect = 'error.html';

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
            /*
            'tour_id' => 'required|numeric|integer|min:1',
            'money' => 'required|numeric|min:0',
           // 'currency' => 'required|numeric|integer|between:1,2',
            'departure_date' => 'required|date',
            'adult_num' => 'required|numeric|integer|min:0',
            'child_num' => 'required|numeric|integer|min:0',
            //'adult_price' => 'required|numeric|min:0',
           // 'child_price' => 'required|numeric|min:0',
            'invoice' => 'required|numeric|integer|min:1',
            //'total_price' => 'required|numeric|min:0',
            'contact_gender' => 'required|numeric|integer|between:1,2',
            'contact_phone' => 'required|regex:/^1[34578][0-9]{9}$/',
            'contact_email' => 'email',
            'num' => 'required|numeric|integer|min:1',
            'price' => 'required|numeric|min:0',
            'type' => 'required|numeric|integer|min:1',
            */            
        ];
    }
}
