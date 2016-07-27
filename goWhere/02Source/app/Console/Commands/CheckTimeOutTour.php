<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\TourPriceDate;
use PhpParser\Node\Stmt\Foreach_;
use App\Models\Tour;

class CheckTimeOutTour extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check_timeout_tour';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'check timeout tour';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        \Log::info('check_timeout_tour:start');
        $all = \DB::select('select max(price_date) as price_date,tour_id from tour_price_date group by tour_id');
        $dateTourId = [];
        if ($all) {
            foreach ($all as $k => $v) {
                $dateTourId[] = $v->tour_id;
            }
        }
        $tourIds = [];
        Tour::select('id', 'name_zh_cn')->where([
            'tour_status' => 1
        ])->chunk(1000, function ($lists) use (&$tourIds) {
            $tourIds = array_merge($lists->toArray(), $tourIds);
        });
        $skipTourId = [];
        foreach ($tourIds as $v) {
            if (! array_search($v['id'], $dateTourId)) {
                $skipTourId[] = $v['id'];
            }
        }
        if ($skipTourId) {
            foreach ($skipTourId as $k => $v) {
                Tour::where([
                    'id' => $v
                ])->update([
                    'tour_status' => - 2
                ]);
            }
        }
        if ($all) {
            foreach ($all as $k => $v) {
                $tourData = Tour::where([
                    'id' => $v->tour_id
                ])->select('advance_day', 'tour_status')->first();
                if ($tourData) {
                    if ($tourData['tour_status'] == 1 || $tourData['tour_status'] == - 2) { // 正常或过期修改状态
                        if ($v->price_date < $tourData['advance_day'] * 86400 + strtotime(date('Y-m-d'))) { // 过期
                            Tour::where([
                                'id' => $v->tour_id
                            ])->update([
                                'tour_status' => - 2
                            ]);
                        } else {
                            Tour::where([
                                'id' => $v->tour_id
                            ])->update([
                                'tour_status' => 1
                            ]);
                        }
                    }
                }
            }
        }
        \Log::info('check_timeout_tour:end');
    }
}
