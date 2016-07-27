<?php

namespace App\Traits\Auth;

use Illuminate\Http\Request;
use Config;

trait ThrottlesLogins
{
    use \Illuminate\Foundation\Auth\ThrottlesLogins;

    /**
     * Get the throttle key for the given request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    protected function getThrottleKey(Request $request)
    {
        return mb_strtolower(Config::get('auth.prefix').$request->input($this->loginUsername())).'|'.$request->ip();
    }

}
