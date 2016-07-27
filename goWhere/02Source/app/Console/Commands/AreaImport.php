<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use App\Helpers\TransChinese;
use Cache;

class AreaImport extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:areaimport';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import the area data from csv';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if (!$this->confirm("This action will truncate the area table and then import data from csv.\n"
                . ' Do you wish to continue? [y|N]')) {
            return false;
        }
        $dir = __DIR__ . DIRECTORY_SEPARATOR . 'AreaImport' . DIRECTORY_SEPARATOR;
        // 清空表
        $this->truncate('area');
        // 取消自增
        DB::statement('ALTER TABLE `area` CHANGE COLUMN `id` `id` INT(10) UNSIGNED NOT NULL FIRST');
        try {
            DB::beginTransaction();
            $this->insertData($dir.'way_area.csv');
            $this->updateLang($dir.'way_area_base.csv');
            $this->updateCityCode($dir.'way_area_city_code.csv');
            DB::commit();
            $this->info("Table `area` is OK now.\n");
        } catch (\Exception $e) {
            echo $e->getMessage() . "\n";
            DB::rollBack();
            $this->error('Error occurs when initiate data for table: area' .  "\n");
        }
        // 还原自增
        DB::statement('ALTER TABLE `area` CHANGE COLUMN `id` `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT FIRST');
        $lastId = DB::table('area')->max('id');
        $autoIncrement = $lastId+1;
        // 设置自增值
        $this->info("Setting new AUTO_INCREMENT to {$autoIncrement}.\n");
        DB::statement('ALTER TABLE `area` AUTO_INCREMENT='. $autoIncrement);
        // 清理掉不正常的数据
        $this->clearData();
        // 清除缓存
        $this->clearCache();
    }

    /**
     * 插入数据
     * @param string $file
     * @throws \Exception
     */
    protected function insertData($file)
    {
        $this->info("Inserting data.\n");
        $fp = fopen($file, 'rb');
        if ($fp !== FALSE) {
            while (($data = fgetcsv($fp)) !== FALSE) {
                $type = $this->getType($data[5]);
                if($type===false) {
                    continue;
                }
                $insert = [
                    'id' => $data[0],
                    'longitude' => $data[8],
                    'latitude' => $data[10],
                    'parent_id' => $data[2],
                    'path' => preg_replace('/^1-/', '', rtrim($data[3],'-'), 1),
                    'type' => $type
                ];
                DB::table('area')->insert($insert);
            }
            fclose($fp);
        }
    }

    /**
     * 更新地区名称
     * @param string $file
     */
    protected function updateLang($file)
    {
        $this->info("Updating names.\n");
        $fp = fopen($file, 'rb');
        if ($fp !== FALSE) {
            while (($data = fgetcsv($fp)) !== FALSE) {
                $id = $data[0];
                $lang = $data[1];
                $update = [];
                if($lang == 'zh_cn') {
                    $update['name_zh_cn'] = trim($data[2]);
                    $update['name_zh_tw'] = TransChinese::transToTw($update['name_zh_cn']);
                } else {
                    $update['name_en_us'] = trim($data[2]);
                }
                $data[11] && $update['name_py'] = trim($data[11]);
                DB::table('area')->where('id', $id)->update($update);
            }
            fclose($fp);
        }
    }

    /**
     * 更新机场代码
     */
    protected function updateCityCode($file)
    {
        $this->info("Updating iata.\n");
        $fp = fopen($file, 'rb');
        if ($fp !== FALSE) {
            while (($data = fgetcsv($fp)) !== FALSE) {
                $id = $data[0];
                $iata = trim($data[1]);
                $update = [
                    'name_iata' => $iata,
                ];
                DB::table('area')->where('id', $id)->update($update);
            }
            fclose($fp);
        }
    }

    /**
     * 获取层级类型
     * @staticvar array $config
     * @param string $string
     * @return int|false
     */
    protected function getType($string)
    {
        static $config = [
            'global' => false,
            'continent' => 0,
            'country' => 2,
            'region' => 7,
            'province' => 3,
            'city' => 4,
            'area' => 5,
        ];
        return isset($config[$string]) ? $config[$string] : false;
    }

    /**
     * 清空表
     * @param string $tableName
     * @throws \Exception
     */
    protected function truncate($tableName)
    {
        $this->info("try to truncate table `area`.\n");
        try {
            DB::statement('truncate table `' . $tableName . '`');
        } catch (\Exception $e) {
            if (DB::delete('delete from ' . $tableName) === false ||
                !DB::statement('alter table `' . $tableName . '` AUTO_INCREMENT = 1')) {
                throw new \Exception('truncate table `' . $tableName . '` fail.');
            }
        }
    }

    /*
     * 清除缓存，更新js版本号
     */
    protected function clearCache()
    {
        $data = Cache::store('file')->forget('Area:all_data');
        Cache::forever('Area:all_data_version', \date('YmdHis'));
    }

    /**
     * 是否只有英文字符
     * @param type $str
     */
    protected function checkStr($str)
    {
        $m = mb_strlen($str, 'utf-8');
        $s = strlen($str);
        return $m == $s ? true : false;
    }

    /**
     * 清理掉不正常的数据
     */
    public function clearData()
    {
        $records = DB::table('area')->where('name_zh_cn', '')->Where('name_en_us', '')->get();
        array_walk($records, function (&$value, $key) {
            $value = (array) $value;
        });
        $offset = 0;
        $length = 50;
        while ($slice = array_slice($records, $offset, $length)) {
            $ids = array_column($slice, 'id');
            $path = array_column($slice, 'path');
            array_map(function($p) {
                DB::table('area')->where('path', 'like', $p.'-%')->delete();
            }, $path);
            DB::table('area')->whereIn('id', $ids)->delete();
            $offset += $length;
        }
    }

}
