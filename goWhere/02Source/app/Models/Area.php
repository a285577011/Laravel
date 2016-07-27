<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cache;

class Area extends Model
{
    // public $selectAreaNum=18;//搜索插件 显示的数目
    /**
     * 引入 Trait 处理多语言字段
     */
    use \App\Traits\Column\LocalName;

    protected $appends = [
        'name'
    ];

    protected $table = 'area';

    public $timestamps = false;

    /**
     * 获取大洲数组
     *
     * @return array [id=>洲名,....]
     */
    public static function getContinents()
    {
        $continets = Cache::remember('fair:continets', 60, function () {
            $continets = self::where('type', 1)->select('id', 'name_zh_cn', 'name_en_us')->get();
            $continets = $continets->pluck('name', 'id')->all();
            return $continets;
        });
        return $continets;
    }

    public static function getAll()
    {
        static $data = null;
        if (! $data) {
            $data = Cache::store('file')->get('Area:all_data');
            if (! $data) {
                $data = [];
                self::chunk(1000, function ($lists) use (&$data) {
                    $data = array_merge($lists->toArray(), $data);
                });
                Cache::store('file')->forever('Area:all_data', $data);
            }
        }
        return $data;
    }

    public static function getById($id)
    {
        $data = Cache::store('file')->get('Area:data_id_' . $id);
        if (! $data) {
            $data = self::where([
                'id' => $id
            ])->first();
            Cache::store('file')->forever('Area:data_id_' . $id, $data);
        }
        return $data;
    }

    /**
     * 获所有父ID
     *
     * @param array $list
     *            要转换的数据集
     * @param string $pid
     *            parent标记字段
     * @return array
     *
     */
    public static function getAllParentId($id)
    {
        static $parentIds = [];
        if ($data = self::getById($id)) {
            $data->parent_id && $parentIds[] = $data->parent_id;
            self::getAllParentId($data->parent_id);
        }
        return $parentIds;
    }

    public static function getIdByName($name, $lang = false)
    {
        $all = self::getAll();
        $key = $lang ? 'name_' . $lang : 'name_' . \App::getLocale();
        foreach ($all as $v) {
            if ($v[$key] == $name) {
                return $v['id'];
                break;
            }
        }
        return false;
    }

    /**
     *
     * 获取父ID 没有父ID返回自己
     *
     * @return int
     *
     */
    public static function getParentId($id)
    {
        $parentId = '';
        if ($data = self::getById($id)) {
            $parentId = $data->parent_id;
        }
        $parentId or $parentId = $id;
        return $parentId;
    }

    /**
     * 根据区域类型获取数据
     */
    public static function getByType($type)
    {
        return self::where([
            'type' => $type
        ])->get();
    }

    /**
     * 获取所有城市信息(插件搜索)
     *
     * @param $getType 1获取城市2获取所有            
     */
    public static function getAllCityForSelect($getType = 1)
    {
        $city = [];
        $all = self::getAll();
        switch ($getType) {
            case 1:
                foreach ($all as $k => $v) {
                    if ($v['type'] == 4)
                        $city[$v['id']] = [
                            $v['name_' . \App::getLocale()],
                            $v['name_py'],
                            $v['id']
                        ];
                }
                break;
            case 2:
                foreach ($all as $k => $v) {
                    $city[$v['id']] = [
                        $v['name_' . \App::getLocale()],
                        $v['name_py'],
                        $v['id']
                    ];
                }
                break;
        }
        return $city;
    }

    /**
     * 获取热门城市ID(插件搜索)
     *
     * @param $getType 1获取城市2获取所有            
     */
    public static function getHotCityIdForSelect($getType = 1)
    {
        $city = [];
        $all = self::getAll();
        $i = 0;
        switch ($getType) {
            case 1:
                foreach ($all as $k => $v) {
                    if ($i > config('common.selectAreaNum')) {
                        break;
                    }
                    if ($v['hot'] >= 1 && $v['type'] == 4) {
                        $city[] = $v['id'];
                        $i ++;
                    }
                }
                break;
            case 2:
                foreach ($all as $k => $v) {
                    if ($i > config('common.selectAreaNum')) {
                        break;
                    }
                    if ($v['hot'] >= 1) {
                        $city[] = $v['id'];
                        $i ++;
                    }
                }
                break;
        }
        return $city;
    }

    /**
     * 获取所有属于该洲城市ID(插件搜索)
     *
     * @param $getType 1获取城市2获取州底下国家            
     */
    public static function getByIslandNameForSelect($name, $getType = 1)
    {
        $id = self::getIdByName($name, 'zh_cn');
        $city = [];
        $all = self::getAll();
        $i = 0;
        switch ($getType) {
            case 1:
                foreach ($all as $k => $v) {
                    if ($i > config('common.selectAreaNum')) {
                        break;
                    }
                    $all_belong = explode('-', $v['path']);
                    if (in_array($id, $all_belong) && $v['type'] == 4) {
                        $city[] = $v['id'];
                        $i ++;
                    }
                }
                break;
            case 2:
                foreach ($all as $k => $v) {
                    if ($i > config('common.selectAreaNum')) {
                        break;
                    }
                    $all_belong = explode('-', $v['path']);
                    if (in_array($id, $all_belong) && $v['hot'] >= 1) {
                        $city[] = $v['id'];
                        $i ++;
                    }
                }
                break;
        }
        
        return $city;
    }

    public static function add($data)
    {
        if (Area::insert($data)) {
            Cache::store('file')->forget('Area:all_data');
            Cache::store('file')->forget('Area:select-type:2'); // 地区下拉类型
            Cache::forever('Area:all_data_version', \date('YmdHis'));
            return true;
        }
        return false;
    }

    public static function updateById($data)
    {
        $updateData = $data;
        unset($updateData['id']);
        if (is_int(Area::where([
            'id' => $data['id']
        ])->update($updateData))) {
            Cache::store('file')->forget('Area:all_data');
            Cache::store('file')->forget('Area:data_id_' . $data['id']);
            Cache::store('file')->forget('Area:select-type:2'); // 地区下拉类型
            Cache::forever('Area:all_data_version', \date('YmdHis'));
            return true;
        }
        return false;
    }

    public static function del(array $ids)
    {
        if ($ids) {
            foreach ($ids as $id) {
                self::destroy($id);
                $data = Cache::store('file')->forget('Area:data_id_' . $id);
            }
            $data = Cache::store('file')->forget('Area:all_data');
            Cache::store('file')->forget('Area:select-type:2'); // 地区下拉类型
            Cache::forever('Area:all_data_version', \date('YmdHis'));
            return true;
        }
        return false;
    }

    public static function getAllCity($lang = false)
    {
        $city = [];
        $all = self::getAll();
        foreach ($all as $k => $v) {
            if ($v['type'] == 4)
                $city[$v['id']] = $v['name_' . ($lang ? $lang : \App::getLocale())];
        }
        return $city;
    }

    public static function getNameById($id)
    {
        return self::getById($id)['name_' . \App::getLocale()];
    }

    public static function getDataByABC($firstABC)
    { // 根据首字母获取所有地区
        $all = self::getAll();
        $data = [];
        $firstABC = strtolower($firstABC);
        $lang = \App::getLocale() == 'zh_tw' ? 'zh_cn' : \App::getLocale();
        
        foreach ($all as $v) {
            if (strtolower(self::getFirstChar($v['name_' . $lang])) == $firstABC) {
                $data[] = $v;
            }
        }
        return $data;
    }

    public static function getFirstChar($str)
    {
        if (empty($str)) {
            return '';
        }
        $fchar = ord($str{0});
        if ($fchar >= ord('A') && $fchar <= ord('z'))
            return strtoupper($str{0});
        $s1 = iconv('UTF-8', 'GBK', $str);
        $s2 = iconv('GBK', 'UTF-8', $s1);
        $s = $s2 == $str ? $s1 : $str;
        $asc = ord($s{0}) * 256 + ord($s{1}) - 65536;
        if ($asc >= - 20319 && $asc <= - 20284)
            return 'A';
        if ($asc >= - 20283 && $asc <= - 19776)
            return 'B';
        if ($asc >= - 19775 && $asc <= - 19219)
            return 'C';
        if ($asc >= - 19218 && $asc <= - 18711)
            return 'D';
        if ($asc >= - 18710 && $asc <= - 18527)
            return 'E';
        if ($asc >= - 18526 && $asc <= - 18240)
            return 'F';
        if ($asc >= - 18239 && $asc <= - 17923)
            return 'G';
        if ($asc >= - 17922 && $asc <= - 17418)
            return 'H';
        if ($asc >= - 17417 && $asc <= - 16475)
            return 'J';
        if ($asc >= - 16474 && $asc <= - 16213)
            return 'K';
        if ($asc >= - 16212 && $asc <= - 15641)
            return 'L';
        if ($asc >= - 15640 && $asc <= - 15166)
            return 'M';
        if ($asc >= - 15165 && $asc <= - 14923)
            return 'N';
        if ($asc >= - 14922 && $asc <= - 14915)
            return 'O';
        if ($asc >= - 14914 && $asc <= - 14631)
            return 'P';
        if ($asc >= - 14630 && $asc <= - 14150)
            return 'Q';
        if ($asc >= - 14149 && $asc <= - 14091)
            return 'R';
        if ($asc >= - 14090 && $asc <= - 13319)
            return 'S';
        if ($asc >= - 13318 && $asc <= - 12839)
            return 'T';
        if ($asc >= - 12838 && $asc <= - 12557)
            return 'W';
        if ($asc >= - 12556 && $asc <= - 11848)
            return 'X';
        if ($asc >= - 11847 && $asc <= - 11056)
            return 'Y';
        if ($asc >= - 11055 && $asc <= - 10247)
            return 'Z';
        return null;
    }

    /**
     * 获取搜索插件初始化JS
     *
     * @param number $type            
     */
    public static function getSelectJs($type = 2, $elementId = 'city', $inputId = 'cityId')
    {
        $script = '';
        switch ($type) {
            case 1:
                $script = "
<script>
var citysFlight=" . json_encode(self::getAllCityForSelect()) . ";
var labelFromcity = [];
labelFromcity ['" . trans('common.hot_city') . "'] = " . json_encode(self::getHotCityIdForSelect()) . ";
labelFromcity ['" . trans('common.Asia') . "'] = " . json_encode(self::getByIslandNameForSelect('亚洲')) . ";
labelFromcity ['" . trans('common.ouzhou') . "'] = " . json_encode(self::getByIslandNameForSelect('欧洲')) . ";
labelFromcity ['" . trans('common.America') . "'] = " . json_encode(self::getByIslandNameForSelect('美洲')) . ";
labelFromcity ['" . trans('common.Africa') . "'] = " . json_encode(Area::getByIslandNameForSelect('非洲')) . ";
$(document).ready(function(){
	$('#$elementId').querycity({'inputCityIdName':'$inputId','data':citysFlight,'tabs':labelFromcity,'hotList':'','defaultText':'" . trans('common.ChineseOrpPinyin') . "','popTitleText'   :'" . trans('common.cityselectOS') . "','suggestTitleText' : '" . trans('common.suggest_city_select') . "','nofundText':'" . trans('common.city_notfound') . "','pingyinOrder':'" . trans('common.pingyinOrder') . "'});
});
</script>
";
                break;
            case 2:
                //$script = Cache::store('file')->get('Area:select-type:2');
                //if (! $script) {
                    $script = "
<script>
var citysFlight=" . json_encode(self::getAllCityForSelect(2)) . ";
var labelFromcity = [];
labelFromcity ['" . trans('common.hot_area') . "'] = " . json_encode(self::getHotCityIdForSelect(2)) . ";
labelFromcity ['" . trans('common.Asia') . "'] = " . json_encode(self::getByIslandNameForSelect('亚洲', 2)) . ";
labelFromcity ['" . trans('common.ouzhou') . "'] = " . json_encode(self::getByIslandNameForSelect('欧洲', 2)) . ";
labelFromcity ['" . trans('common.America') . "'] = " . json_encode(self::getByIslandNameForSelect('美洲', 2)) . ";
labelFromcity ['" . trans('common.Africa') . "'] = " . json_encode(Area::getByIslandNameForSelect('非洲', 2)) . ";
                $(document).ready(function(){
                $('#$elementId').querycity({'inputCityIdName':'$inputId','data':citysFlight,'tabs':labelFromcity,'hotList':'','defaultText':'" . trans('common.ChineseOrpPinyin') . "','popTitleText'   :'" . trans('common.cityselectOS') . "','suggestTitleText' : '" . trans('common.suggest_city_select') . "','nofundText':'" . trans('common.city_notfound') . "','pingyinOrder':'" . trans('common.pingyinOrder') . "'});
});
</script>
";
                   // Cache::store('file')->forever('Area:select-type:2', $script);
                //}
                break;
        }
        return $script;
    }

    /**
     * 获取所有地区ID对应的NAME 后台搜索
     *
     * @param string $lang            
     */
    public static function getAllIdName($lang = false)
    {
        $area = [];
        $all = self::getAll();
        foreach ($all as $k => $v) {
            $area[$v['id']] = $v['name_' . ($lang ? $lang : \App::getLocale())];
        }
        return $area;
    }

    public static function isHasArea($name, $nameEnus)
    {
        $isHas = false;
        $all = self::getAll();
        foreach ($all as $k => $v) {
            if ($v['name_zh_cn'] == $name || $v['name_en_us'] == $nameEnus) {
                $isHas = true;
            }
        }
        return $isHas;
    }
}
