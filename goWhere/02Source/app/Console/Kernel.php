<?php
namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{

    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        \App\Console\Commands\Inspire::class,
        \App\Console\Commands\TourDateClean::class,
        \App\Console\Commands\DbInit::class,
        \App\Console\Commands\AreaImport::class,
        \App\Console\Commands\OldMemberImport::class,
        \App\Console\Commands\CheckTimeOutTour::class,
        \App\Console\Commands\CheckPayTimeOutTour::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule            
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('inspire')->hourly();
        $schedule->command('tour_date_clean')
            ->monthly()
            ->sendOutputTo(storage_path() . '/logs/tourDateClean.cron.log');
        $schedule->command('check_timeout_tour')
            ->daily()
            ->sendOutputTo(storage_path() . '/logs/checkTimeOutTour.cron.log');
        $schedule->command('check_pay_timeout_tour')
            ->everyMinute()
            ->sendOutputTo(storage_path() . '/logs/checkPayTimeOutTour.cron.log');
    }
}
