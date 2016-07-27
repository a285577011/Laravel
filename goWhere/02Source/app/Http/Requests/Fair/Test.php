<?php

namespace App\Http\Requests\Fair;

use App\Http\Requests\Request;

class Test extends Request
{
    /**
     * 需要合并的url参数
     * @var type 
     */
    protected $urlFields = ['fairId'];
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
            'fairId'=>'required'
        ];
    }
}
