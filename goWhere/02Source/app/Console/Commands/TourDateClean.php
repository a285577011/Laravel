<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\TourPriceDate;

class TourDateClean extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tour_date_clean';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'clean tour redis';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $lastMonth = date('Y-m', strtotime('-1 month'));
        \Log::info('tour clean redis date:' . $lastMonth . 'start');
        $keys = \LaravelRedis::keys(config('tour.calendar_redis_key') . $lastMonth . '*');
        if ($keys) {
            foreach ($keys as $key) {
                \LaravelRedis::del($key);
            }
        }
        TourPriceDate::where('price_date','<',time())->delete();
        \Log::info('tour clean redis date:' . $lastMonth . 'end');
    }
}
