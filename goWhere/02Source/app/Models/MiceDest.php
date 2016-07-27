<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Helpers\Upload;
use App\Helpers\Common;
use App;
use App\Helpers\TransChinese;

class MiceDest extends Model
{

    protected $table = 'destinations';

    public $timestamps = false;

    public static function getOneByArea($areaId)
    {
        return self::where([
            'area_id' => $areaId
        ])->first();
    }

    public static function add($data)
    {
        \DB::beginTransaction();
        try {
            $dest = new self();
            $dest->meeting_area = intval($data['meeting_area']);
            $dest->confer_center = intval($data['confer_center']);
            $dest->hotel_num = intval($data['hotel_num']);
            $dest->hotel_rooms = intval($data['hotel_rooms']);
            $upload = new Upload();
            $res = $upload->save();
            $image = '';
            if ($res && $res['success']) {
                $image = $res['success'][0]['path'];
            }
            $dest->image = $image;
            $dest->area_id = intval($data['destination']);
            $dest->creat_time = time();
            $dest->save();
            $destInfo = new MiceDestInfo();
            $lang = \App::getLocale();
            $airportKey = 'airport_' . $lang;
            $descKey = 'desc_' . $lang;
            $advantageKey = 'advantage_' . $lang;
            $addressKey = 'address_' . $lang;
            $attractionsKey = 'attractions_' . $lang;
            $featureKey = 'feature_' . $lang;
            $destInfo->$airportKey = $data['airport'];
            $destInfo->destinations_id = $dest->id;
            $destInfo->$descKey = isset($data['desc'])?$data['desc']:'';
            $destInfo->$advantageKey = isset($data['advantage'])?$data['advantage']:'';
            $destInfo->$addressKey = isset($data['address'])?$data['address']:'';
            $destInfo->$attractionsKey = isset($data['attractions'])?$data['attractions']:'';
            $destInfo->$featureKey = isset($data['feature'])?$data['feature']:'';
            if ($lang == 'zh_cn') {
            $airportKeyTw = 'airport_zh_tw';
            $descKeyTw = 'desc_zh_tw';
            $advantageKeyTw = 'advantage_zh_tw';
            $addressKeyTw = 'address_zh_tw';
            $attractionsKeyTw = 'attractions_zh_tw';
            $featureKeyTw = 'feature_zh_tw';
            $destInfo->$airportKeyTw = TransChinese::transToTw($data['airport']);
            $destInfo->$descKeyTw = isset($data['desc'])?TransChinese::transToTw($data['desc']):'';
            $destInfo->$advantageKeyTw = isset($data['advantage'])?TransChinese::transToTw($data['advantage']):'';
            $destInfo->$addressKeyTw = isset($data['address'])?TransChinese::transToTw($data['address']):'';
            $destInfo->$attractionsKeyTw = isset($data['attractions'])?TransChinese::transToTw($data['attractions']):'';
            $destInfo->$featureKeyTw = isset($data['feature'])?TransChinese::transToTw($data['feature']):'';
            }
            $destInfo->save();
            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollback();
            throw new \Exception($e->getMessage());
        }
        // $case->title_zh_cn=Common::filterStr($data['']);
        return $dest->id;
    }

    public static function updateById($data)
    {
        \DB::beginTransaction();
        try {
           // print_r($data);die;
            $dest = new self();
            $id = intval($data['id']);
            $lang = App::getLocale();
            // $case->title.$langCn = Common::filterStr($data['title']);
            $destUpdate['meeting_area'] = intval($data['meeting_area']);
            $destUpdate['confer_center'] = intval($data['confer_center']);
            $destUpdate['hotel_num'] = intval($data['hotel_num']);
            $destUpdate['area_id'] = intval($data['destination']);
            $destUpdate['hotel_rooms'] = intval($data['hotel_rooms']);
            $upload = new Upload();
            $res = $upload->save();
            $image = '';
            if ($res && $res['success']) {
                $image = $res['success'][0]['path'];
            }
            $image && $destUpdate['image'] = $image;
            $dest::where([
                'id' => $id
            ])->update($destUpdate);
            $destInfo = new MiceDestInfo();
            $destInfoUpdate['airport_' . $lang] = $data['airport'];
            $destInfoUpdate['desc_' . $lang] = isset($data['desc'])?$data['desc']:'';
            $destInfoUpdate['advantage_' . $lang] = isset($data['advantage'])?$data['advantage']:'';
            $destInfoUpdate['address_' . $lang] = isset($data['address'])?$data['address']:'';
            $destInfoUpdate['attractions_' . $lang] = isset($data['attractions'])?$data['attractions']:'';
            $destInfoUpdate['feature_' . $lang] = isset($data['feature'])?$data['feature']:'';
            if ($lang == 'zh_cn') {
                $airportKeyTw = 'airport_zh_tw';
                $descKeyTw = 'desc_zh_tw';
                $advantageKeyTw = 'advantage_zh_tw';
                $addressKeyTw = 'address_zh_tw';
                $attractionsKeyTw = 'attractions_zh_tw';
                $featureKeyTw = 'feature_zh_tw';
                $destInfoUpdate[$airportKeyTw] = TransChinese::transToTw($data['airport']);
                $destInfoUpdate[$descKeyTw] = isset($data['desc'])?TransChinese::transToTw($data['desc']):'';
                $destInfoUpdate[$advantageKeyTw] = isset($data['advantage'])?TransChinese::transToTw($data['advantage']):'';
                $destInfoUpdate[$addressKeyTw] = isset($data['address'])?TransChinese::transToTw($data['address']):'';
                $destInfoUpdate[$attractionsKeyTw] = isset($data['attractions'])?TransChinese::transToTw($data['attractions']):'';
                $destInfoUpdate[$featureKeyTw] = isset($data['feature'])?TransChinese::transToTw($data['feature']):'';
            }
            $destInfo::where([
                'destinations_id' => $id
            ])->update($destInfoUpdate);
            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollback();
            throw new \Exception($e->getMessage());
        }
        return true;
    }
}
