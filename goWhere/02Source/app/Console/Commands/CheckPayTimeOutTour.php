<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\TourPriceDate;
use PhpParser\Node\Stmt\Foreach_;
use App\Models\Tour;
use function Predis\config;
use App\Models\Orders;
use App\Models\TourOrder;
use Config;
class CheckPayTimeOutTour extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check_pay_timeout_tour';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'check pay timeout tour';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        \Log::info('check_pay_timeout_tour:start');
        $maxTimeOut=Config::get('tour.pay_time');
        $orderIds=Orders::where(['status'=>1,'type'=>1])->where('ctime','<',time()-$maxTimeOut)->lists('id');
        if($orderIds){
            foreach ($orderIds as $id){
                \DB::beginTransaction();
                try {
                $tourOrderData=TourOrder::where(['orders_id'=>$id])->select('adult_num','child_num','tour_id','departure_date')->first();
                if($tourOrderData){
                   // $booknum=$tourOrderData['adult_num']+$tourOrderData['child_num'];
                   // \DB::table('tour_price_date')->where(['tour_id'=>$tourOrderData['tour_id'],'price_date'=>$tourOrderData['departure_date']])//不更新 跟团游没票数
                   // ->increment('stock',$booknum); // 返回门票数量
                    
                    // 更新redis
                    //\LaravelRedis::hIncrBy(Config::get('tour.calendar_redis_key') . date('Y-m-d',$tourOrderData['departure_date']), Config::get('tour.calendar_redis_field_key_total') . $tourOrderData['tour_id'], ($tourOrderData['adult_num'] + $tourOrderData['child_num']));
                    Orders::where(['id'=>$id])->update(['status'=>3]);//订单状态跟新为取消
                }
                \DB::commit();
                } catch (\Exception $e) {
                    \DB::rollback();
                    \Log::info('check_pay_timeout_tour:error:'.$e->getMessage());
                    continue;
                }
            }
        }
        \Log::info('check_pay_timeout_tour:end');
    }
}
