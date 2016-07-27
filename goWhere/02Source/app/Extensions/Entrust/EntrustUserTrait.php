<?php

namespace App\Extensions\Entrust;

/**
 * This file is part of Entrust,
 * a role & permission management solution for Laravel.
 *
 * @license MIT
 * @package Zizaco\Entrust
 */
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

trait EntrustUserTrait
{
    use \Zizaco\Entrust\Traits\EntrustUserTrait;

    //Big block of caching functionality.
    public function cachedRoles()
    {
        if(is_null($this->cachedRoles)) {
            $userPrimaryKey = $this->primaryKey;
            $cacheKey = 'entrust_roles_for_user_'.$this->$userPrimaryKey;
            $cachedRoles = Cache::tags(Config::get('entrust.role_user_table'))->remember($cacheKey, Config::get('cache.ttl'), function () use(&$cachedRoles) {
                return $this->roles()->get();
            });
            $this->cachedRoles = $cachedRoles;
        }
        return $this->cachedRoles;
    }

}
