<?php

namespace App\Providers;

use Illuminate\Contracts\Auth\Authenticatable as UserContract;

class EloquentUserProvider extends \Illuminate\Auth\EloquentUserProvider
{

    /**
     * Validate a user against the given credentials.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  array  $credentials
     * @return bool
     */
    public function validateCredentials(UserContract $user, array $credentials)
    {
        $plain = $credentials['password'];
        
        if(config('app.isBackend') !== true && $user->type == 1) {
            return $user->getAuthPassword() === md5(md5($plain).$user->salt);
        }
        return $this->hasher->check($plain, $user->getAuthPassword());
    }

}
