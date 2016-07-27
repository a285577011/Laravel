<?php

namespace App\Http\Requests\Tour;

use App\Http\Requests\Request;

class TourDetailRequest extends Request
{
    //public $redirect='error.html';
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
          'id'  => 'required|numeric|integer|min:1',
        ];
    }
}
