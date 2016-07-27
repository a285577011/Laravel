<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Helpers\Common;
use App\Helpers\Upload;
use App;
use App\Helpers\TransChinese;

class MiceCases extends Model
{

    protected $table = 'mice_cases';

    public $timestamps = false;

    public static function getCaseByDest($id, $limit = null)
    {
        $data = self::where([
            'destination' => $id
        ])->take($limit)->get();
        if ($data->count()) {
            foreach ($data as $k => $v) {
                $data[$k]->infoData = MiceCasesInfo::where([
                    'cases_id' => $v->id
                ])->first();
            }
            return $data;
        }
        return false;
    }

    public static function getCases($limit = null)
    {
        $data = self::take($limit)->get();
        if ($data->count()) {
            foreach ($data as $k => $v) {
                $data[$k]->infoData = MiceCasesInfo::where([
                    'cases_id' => $v->id
                ])->first();
            }
            return $data;
        }
        return false;
    }

    public static function add($data)
    {
        \DB::beginTransaction();
        try {
            $case = new self();
            $langCn = App::getLocale();
            // $case->title.$langCn = Common::filterStr($data['title']);
            $case->type = intval($data['type']);
            $case->start_time = strtotime($data['start_time']);
            $case->day = intval($data['day_num']);
            $case->destination = intval($data['destination']);
            $case->people_num = intval($data['people_num']);
            $case->cost = floatval($data['cost']);
            // $case->customer = Common::filterStr($data['customer']);
            // $case->contact_name = Common::filterStr($data['contact_name']);
            $case->contact_info = Common::filterStr($data['contact_info']);
            $case->email = Common::filterStr($data['email']);
            $case->creat_time = time();
            $case->enable = 1;
            // $case->service_content.$langCn = Common::filterStr($data['service_content']);
            // $case->event_overview.$langCn = Common::filterStr($data['event_overview']);
            // $case->desc.$langCn = Common::filterStr($data['desc']);
            $upload = new Upload();
            $res = $upload->save();
            $image = '';
            if ($res && $res['success']) {
                $image = $res['success'][0]['path'];
                // $upload->saveName=$upload->saveName.'_'.config('mice.case_thumb_size')[0].'_'.config('mice.case_thumb_size')[1];
                // $res=$upload->save(null,config('mice.case_thumb_size'));
            }
            $case->image = $image;
            $case->image_type = 1;
            $case->save();
            $caseInfo = new MiceCasesInfo();
            $titleKey = 'title_' . $langCn;
            $customerKey = 'customer_' . $langCn;
            $serviceContentKey = 'service_content_' . $langCn;
            $contactNameKey = 'contact_name_' . $langCn;
            $eventOverviewKey = 'event_overview_' . $langCn;
            $descKey = 'desc_' . $langCn;
            $caseInfo->$titleKey = Common::filterStr($data['title']);
            $caseInfo->$customerKey = Common::filterStr($data['customer']);
            $caseInfo->$serviceContentKey = Common::filterStr($data['service_content']);
            $caseInfo->$contactNameKey = Common::filterStr($data['contact_name']);
            $caseInfo->$eventOverviewKey = isset($data['event_overview']) ? $data['event_overview'] : '';
            $caseInfo->$descKey = isset($data['desc']) ? $data['desc'] : '';
            $caseInfo->cases_id = $case->id;
            if ($langCn == 'zh_cn') {
                $titleKeyTw = 'title_zh_tw';
                $customerKeyTw = 'customer_zh_tw';
                $serviceContentKeyTw = 'service_content_zh_tw';
                $contactNameKeyTw = 'contact_name_zh_tw';
                $eventOverviewKeyTw = 'event_overview_zh_tw';
                $descKeyTw = 'desc_zh_tw';
                $caseInfo->$titleKeyTw = TransChinese::transToTw(Common::filterStr($data['title']));
                $caseInfo->$customerKeyTw = TransChinese::transToTw(Common::filterStr($data['customer']));
                $caseInfo->$serviceContentKeyTw = TransChinese::transToTw(Common::filterStr($data['service_content']));
                $caseInfo->$contactNameKeyTw = TransChinese::transToTw(Common::filterStr($data['contact_name']));
                $caseInfo->$eventOverviewKeyTw = isset($data['event_overview']) ? TransChinese::transToTw($data['event_overview']) : '';
                $caseInfo->$descKeyTw = isset($data['desc']) ? TransChinese::transToTw($data['desc']) : '';
            }
            $caseInfo->save();
            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollback();
            throw new \Exception($e->getMessage());
        }
        // $case->title_zh_cn=Common::filterStr($data['']);
        return $case->id;
    }

    public static function updateById($data)
    {
        \DB::beginTransaction();
        try {
            $case = new self();
            $id = intval($data['id']);
            $langCn = App::getLocale();
            // $case->title.$langCn = Common::filterStr($data['title']);
            $caseUpdate['type'] = intval($data['type']);
            $caseUpdate['start_time'] = strtotime($data['start_time']);
            $caseUpdate['day'] = intval($data['day_num']);
            $caseUpdate['destination'] = intval($data['destination']);
            $caseUpdate['people_num'] = intval($data['people_num']);
            $caseUpdate['cost'] = floatval($data['cost']);
            // $case->customer = Common::filterStr($data['customer']);
            // $case->contact_name = Common::filterStr($data['contact_name']);
            $caseUpdate['contact_info'] = Common::filterStr($data['contact_info']);
            $caseUpdate['email'] = Common::filterStr($data['email']);
            // $case->creat_time = time();
            // $case->enable = 1;
            // $case->service_content.$langCn = Common::filterStr($data['service_content']);
            // $case->event_overview.$langCn = Common::filterStr($data['event_overview']);
            // $case->desc.$langCn = Common::filterStr($data['desc']);
            $upload = new Upload();
            $res = $upload->save();
            $image = '';
            if ($res && $res['success']) {
                $image = $res['success'][0]['path'];
                $upload->saveName = $upload->saveName . '_' . config('mice.case_thumb_size')[0] . '_' . config('mice.case_thumb_size')[1];
                // echo $upload->saveName;die;
                $res = $upload->save(null, config('mice.case_thumb_size'));
            }
            $image && $caseUpdate['image'] = $image;
            // $case->image = $image;
            $caseUpdate['image_type'] = 1;
            $case::where([
                'id' => $id
            ])->update($caseUpdate);
            $caseInfo = new MiceCasesInfo();
            $titleKey = 'title_' . $langCn;
            $customerKey = 'customer_' . $langCn;
            $serviceContentKey = 'service_content_' . $langCn;
            $contactNameKey = 'contact_name_' . $langCn;
            $eventOverviewKey = 'event_overview_' . $langCn;
            $descKey = 'desc_' . $langCn;
            $caseInfoUpdate[$titleKey] = Common::filterStr($data['title']);
            $caseInfoUpdate[$customerKey] = Common::filterStr($data['customer']);
            $caseInfoUpdate[$serviceContentKey] = Common::filterStr($data['service_content']);
            $caseInfoUpdate[$contactNameKey] = Common::filterStr($data['contact_name']);
            $caseInfoUpdate[$eventOverviewKey] = isset($data['event_overview']) ? $data['event_overview'] : '';
            $caseInfoUpdate[$descKey] = isset($data['desc']) ? $data['desc'] : '';
            if ($langCn == 'zh_cn') {
                $titleKeyTw = 'title_zh_tw';
                $customerKeyTw = 'customer_zh_tw';
                $serviceContentKeyTw = 'service_content_zh_tw';
                $contactNameKeyTw = 'contact_name_zh_tw';
                $eventOverviewKeyTw = 'event_overview_zh_tw';
                $descKeyTw = 'desc_zh_tw';
                $caseInfoUpdate[$titleKeyTw] = TransChinese::transToTw(Common::filterStr($data['title']));
                $caseInfoUpdate[$customerKeyTw] = TransChinese::transToTw(Common::filterStr($data['customer']));
                $caseInfoUpdate[$serviceContentKeyTw] = TransChinese::transToTw(Common::filterStr($data['service_content']));
                $caseInfoUpdate[$contactNameKeyTw] = TransChinese::transToTw(Common::filterStr($data['contact_name']));
                $caseInfoUpdate[$eventOverviewKeyTw] = isset($data['event_overview']) ? TransChinese::transToTw($data['event_overview']) : '';
                $caseInfoUpdate[$descKeyTw] = isset($data['desc']) ? TransChinese::transToTw($data['desc']) : '';
            }
            $caseInfo::where([
                'cases_id' => $id
            ])->update($caseInfoUpdate);
            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollback();
            throw new \Exception($e->getMessage());
        }
        return true;
    }

    public function del($id)
    {
        return self::destroy($id);
    }
}
