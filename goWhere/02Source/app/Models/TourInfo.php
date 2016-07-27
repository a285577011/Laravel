<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Es\TourEs;
use App\Helpers\Common;
use DB;
use App;
use App\Helpers\TransChinese;

class TourInfo extends Model
{
    /**
     * 引入 Trait 处理多语言字段
     */
    use \App\Traits\Column\LocalVisitView;
    use \App\Traits\Column\LocalDesc;
    use \App\Traits\Column\LocalRouteFeature;
    use \App\Traits\Column\LocalSimpleRoute;
    use \App\Traits\Column\LocalRemark;

    protected $appends = [
        'visit_view',
        'desc',
        'route_feature',
        'simple_route',
        'remark'
    ];

    protected $table = 'tour_info';

    public $timestamps = false;

    public static function add($tourInfo)
    {
        $self = new self();
        $lang = App::getLocale();
        $descKey = 'desc_' . $lang;
        $Key1 = 'visit_view_' . $lang;
        $Key2 = 'route_feature_' . $lang;
        $Key3 = 'simple_route_' . $lang;
        $self->tour_id = $tourInfo['tour_id'];
        $self->$descKey = $tourInfo['desc'];
        $self->$Key1 = $tourInfo['visit_view'];
        $self->$Key2 = $tourInfo['route_feature'];
        $self->$Key3 = $tourInfo['simple_route'];
        $remakKey = 'remark_' . $lang;
        $self->$remakKey = '';
        if ($lang == 'zh_cn') {
            $descKeyTw = 'desc_zh_tw';
            $Key1Tw = 'visit_view_zh_tw';
            $Key2Tw = 'route_feature_zh_tw';
            $Key3Tw = 'simple_route_zh_tw';
            $self->$descKeyTw = TransChinese::transToTw($tourInfo['desc']);
            $self->$Key1Tw = TransChinese::transToTw($tourInfo['visit_view']);
            $self->$Key2Tw = TransChinese::transToTw($tourInfo['route_feature']);
            $self->$Key3Tw = TransChinese::transToTw($tourInfo['simple_route']);
        }
        if ($self->save()) {
            return $self->id;
        }
        return false;
    }

    public static function updaterRemark($tourId, $remark)
    {
        $update = [
            'remark_' . App::getLocale() => $remark
        ];
        if (App::getLocale() == 'zh_cn') {
            $remarkTw = json_decode($remark, true);
            if ($remarkTw) {
                foreach ($remarkTw as $k => $v) {
                    $remarkTw[$k] = TransChinese::transToTw($v);
                }
            }
            $remarkTw = json_encode($remarkTw);
            $update['remark_zh_tw'] = $remarkTw;
        }
        return self::where([
            'tour_id' => $tourId
        ])->update($update);
    }

    public static function updateInfo($tourId, $data)
    {
        return self::where([
            'tour_id' => $tourId
        ])->update([
            'desc' => $data['desc'],
            'visit_view' => $data['visit_view'],
            'route_feature' => $data['route_feature'],
            'simple_route' => $data['simple_route']
        ]);
    }

    public static function getByTourId($tourId)
    {
        return self::where([
            'tour_id' => $tourId
        ])->first();
    }
}
