<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;

abstract class Request extends FormRequest
{
    
    /**
     * Retrieve an input item from the request.
     * 将路由的url参数并入input
     * @param  string  $key
     * @param  string|array|null  $default
     * @return string|array
     */
    public function input($key = null, $default = null)
    {
        $urlParameters = $this->route()->parameters();
        if($urlParameters) {
            $this->merge($urlParameters);
        }
        $input = $this->getInputSource()->all() + $this->query->all();
        return Arr::get($input, $key, $default);
    }
}
