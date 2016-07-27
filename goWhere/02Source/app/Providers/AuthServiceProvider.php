<?php

namespace App\Providers;

use Auth;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Providers\EloquentUserProvider;
use App\Extensions\OrangewayGuard;

class AuthServiceProvider extends ServiceProvider
{

    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any application authentication / authorization services.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate  $gate
     * @return void
     */
    public function boot(GateContract $gate)
    {
        parent::registerPolicies($gate);
        // 使用自定义的 Guard
        Auth::extend('orangewayEloquent', function ($app) {
            return new OrangewayGuard(
                new EloquentUserProvider($app['hash'], $app['config']['auth.model']),
                $app['session.store']
            );
        });
    }

}
