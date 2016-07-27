<?php

namespace App\Extensions;

use Illuminate\Auth\Guard;
use Config;

class OrangewayGuard extends Guard
{

    /**
     * Get a unique identifier for the auth session value.
     *
     * @return string
     */
    public function getName()
    {
        return Config::get('auth.prefix').'login_'.md5(get_class($this));
    }

    /**
     * Get the name of the cookie used to store the "recaller".
     *
     * @return string
     */
    public function getRecallerName()
    {
        return Config::get('auth.prefix').'remember_'.md5(get_class($this));
    }

    public function logout()
    {
        $user = $this->user();

        // If we have an event dispatcher instance, we can fire off the logout event
        // so any further processing can be done. This allows the developer to be
        // listening for anytime a user signs out of this application manually.
        $this->clearUserDataFromStorage();
        
        // 清除额外的session数据
        $this->clearExtraSession();

        if (!is_null($this->user)) {
            $this->refreshRememberToken($user);
        }

        if (isset($this->events)) {
            $this->events->fire('auth.logout', [$user]);
        }

        // Once we have fired the logout event we will clear the users out of memory
        // so they are no longer available as the user is no longer considered as
        // being signed into this application and should not be available here.
        $this->user = null;

        $this->loggedOut = true;
    }

    /**
     * 清除额外的session
     */
    protected function clearExtraSession()
    {
        $this->session->forget('canDo');
        $this->session->forget('oauthLogin');
        $this->session->forget('orangewayCaptcha');
        $this->session->forget('orangewaySMSCaptcha');
    }

}
