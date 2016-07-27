<?php

namespace App\Extensions\Entrust;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

class EntrustRole extends \Zizaco\Entrust\EntrustRole
{

    //Big block of caching functionality.
    public function cachedPermissions()
    {
        if (is_null($this->cachedPermissions)) {
            $rolePrimaryKey = $this->primaryKey;
            $cacheKey = 'entrust_permissions_for_role_' . $this->$rolePrimaryKey;
            $cachedPermissions = Cache::tags(Config::get('entrust.permission_role_table'))->remember($cacheKey, Config::get('cache.ttl'), function () {
                return $this->perms()->get();
            });
            $this->cachedPermissions = $cachedPermissions;
        }
        return $this->cachedPermissions;
    }

    /**
     * Save the inputted permissions.
     *
     * @param mixed $inputPermissions
     *
     * @return void
     */
    public function savePermissions($inputPermissions)
    {
        if (!empty($inputPermissions)) {
            $this->perms()->sync($inputPermissions);
        } else {
            $this->perms()->detach();
        }
        Cache::tags(Config::get('entrust.permission_role_table'))->flush();
    }

}
