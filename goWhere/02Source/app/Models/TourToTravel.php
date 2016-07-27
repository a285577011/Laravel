<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Helpers\Common;
use App;
use App\Helpers\TransChinese;
use function GuzzleHttp\json_decode;
use function GuzzleHttp\json_encode;

class TourToTravel extends Model
{
    /**
     * 引入 Trait 处理多语言字段
     */
    use \App\Traits\Column\LocalDesc;

    protected $appends = [
        'desc'
    ];

    protected $table = 'tour_to_travel';

    public $timestamps = false;

    public static function add($tourId, $day, $image, $desc, $area, $destination, $transport)
    {
        $lang = App::getLocale();
        $self = new self();
        $self->tour_id = $tourId;
        $self->day = $day;
        $self->image = $image;
        $self->area = $area;
        $self->creat_time = time();
        $descKye = 'desc_' . $lang;
        $self->$descKye = $desc;
        if ($lang == 'zh_cn') {
            $descTw = json_decode($desc, true);
            if ($descTw) {
                foreach ($descTw as $k => $v) {
                    $descTw[$k] = TransChinese::transToTw($v);
                }
            }
            $descTw = json_encode($descTw);
            $self->desc_zh_tw = $descTw;
        }
        $self->transport = $transport;
        $self->destination = $destination;
        if ($self->save()) {
            return $self->id;
        }
        return false;
    }

    public static function updateById($id, $area, $day, $image, $desc, $destination, $transport)
    {
        $where = [
            'day' => $day,
            'desc_' . App::getLocale() => $desc,
            'area' => $area,
            'destination' => $destination,
            'transport' => $transport
        ];
        if (App::getLocale() == 'zh_cn') {
            $descTw = json_decode($desc, true);
            if ($descTw) {
                foreach ($descTw as $k => $v) {
                    $descTw[$k] = TransChinese::transToTw($v);
                }
            }
            $descTw = json_encode($descTw);
            $where['desc_zh_tw'] = $descTw;
        }
        $image && $where['image'] = $image;
        self::where([
            'id' => $id
        ])->update($where);
    }

    public static function getByTourId($tourId)
    {
        return self::where([
            'tour_id' => $tourId
        ])->get();
    }
}
