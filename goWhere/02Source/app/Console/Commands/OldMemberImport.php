<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use App\Helpers\TransChinese;
use Cache;
use Log;

class OldMemberImport extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:oldmemberimport';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import old member data from csv';

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
        if (!$this->confirm("This action will import old member data from csv to table: members.\n"
                . ' Do you wish to continue? [y|N]')) {
            return false;
        }
        $dir = __DIR__ . DIRECTORY_SEPARATOR . 'OldMemberImport' . DIRECTORY_SEPARATOR;
        // 清空表
        $this->truncate('members');
        // 取消自增
        DB::statement('ALTER TABLE `members` CHANGE COLUMN `id` `id` INT(10) UNSIGNED NOT NULL FIRST');
        try {
            DB::beginTransaction();
            $this->insertData($dir.'way_member.csv');
            DB::commit();
            $this->info("Table `members` is OK now.\n");
        } catch (\Exception $e) {
            $this->error($e->getMessage());
            DB::rollBack();
        }
        // 还原自增
        DB::statement('ALTER TABLE `members` CHANGE COLUMN `id` `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT FIRST');
        $lastId = DB::table('members')->max('id');
        $autoIncrement = $lastId + 1;
        // 设置自增值
        $this->info("Setting new AUTO_INCREMENT to {$autoIncrement}.\n");
        DB::statement('ALTER TABLE `members` AUTO_INCREMENT=' . $autoIncrement);
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
                //appid
                $appid = $data[1];
                if($appid != 'qq') {
                    $insert = [
                        // member_id
                        'id' => $data[0],
                        'nickname' => $data[9] ?:'',
                        'email' => $data[3] ?: null,
                        'phone' => null,
                        'salt' => $data[6],
                        'password' => $data[5],
                        'ctime' => $data[7],
                        'atime' => $data[48],
                        'mobile_verify' => 0,
                        'email_verify' => 1,
                        'name' => $data[58],
                        'gender' => $data[20] == 'male' ? 1 : 2,
                        'type' => 1,
                        'appid' => $appid,
                        'active' => 1,
                        'username' => null,
                    ];
                    if($data[58] && $this->checkStr($data[58])) {
                        $insert['username'] = $data[58];
                    }
                    if(empty($insert['username']) && empty($insert['email'])) {
                        unset($insert);
                        Log::info('OldMemberImport:lack of identifier, skip.', $data);
                    }
                    try {
                        DB::table('members')->insert($insert);
                    }  catch (\Exception $e) {
                         Log::info('OldMemberImport:'.$e->getMessage(), $data);
                         continue;
                    }
                    
                }
            }
            fclose($fp);
        }
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
     * 清空表
     * @param string $tableName
     * @throws \Exception
     */
    protected function truncate($tableName)
    {
        $this->info("try to truncate table `members`.\n");
        try {
            DB::statement('truncate table `' . $tableName . '`');
        } catch (\Exception $e) {
            if (DB::delete('delete from ' . $tableName) === false ||
                !DB::statement('alter table `' . $tableName . '` AUTO_INCREMENT = 1')) {
                throw new \Exception('truncate table `' . $tableName . '` fail.');
            }
        }
    }
}
