<?php

namespace App\Providers;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'SocialiteProviders\Manager\SocialiteWasCalled' => [
            'SocialiteProviders\Weibo\WeiboExtendSocialite',
            'SocialiteProviders\Qq\QqExtendSocialite'
        ],
        'App\Events\UploadsChanged' => [
            'App\Listeners\RemoveOldFile',
        ],
        'App\Events\EmailNeedToBeSent' => [
            'App\Listeners\SendEmail',
        ],
        'auth.login' => [
            'App\Listeners\SetLastLoginInfo',
        ],
    ];

    /**
     * Register any other events for your application.
     *
     * @param  \Illuminate\Contracts\Events\Dispatcher  $events
     * @return void
     */
    public function boot(DispatcherContract $events)
    {
        parent::boot($events);

        //
    }
}
