<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;

class DbInit extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:init';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Initiate the necessary database data';

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
        if (!$this->confirm("This action will truncate the tables and insert default records.\n"
                . ' Do you wish to continue? [y|N]')) {
            return false;
        }
        $files = glob(__DIR__ . DIRECTORY_SEPARATOR . 'DbInit' . DIRECTORY_SEPARATOR . '*.php');
        foreach ($files as $file) {
            $this->insertData(include $file);
        }
    }

    /**
     * 插入数据
     * @param array $tableConf
     * @throws \Exception
     */
    protected function insertData($tableConf)
    {
        try {
            $column = '';
            $useKey = false;
            if (isset($tableConf['keyColumn']) && $tableConf['keyColumn']) {
                $column = $tableConf['keyColumn'];
                $useKey = true;
            }
            $column .= $column && $tableConf['dataColumn'] ? ',' . $tableConf['dataColumn'] : $tableConf['dataColumn'];
            $count = substr_count($column, ',') + 1;
            $query = 'insert into ' . $tableConf['table'] . ' (' . $column . ') values (';
            $query .= rtrim(str_repeat('?,', $count), ',') . ')';
            DB::beginTransaction();
            $this->truncate($tableConf['table']);
            foreach ($tableConf['data'] as $rkey => $row) {
                $data = [];
                $useKey ? $data[] = $rkey : '';
                is_array($row) ? $data = $data + $row : $data[] = $row;
                if (!DB::insert($query, $data)) {
                    throw new \Exception();
                }
            }
            DB::commit();
            $this->info("Table `" . $tableConf['table'] . "` is OK now.\n");
        } catch (\Exception $exc) {
            echo $exc->getMessage() . "\n";
            DB::rollBack();
            $this->error('Error occurs when initiate data for table:' . $tableConf['table'] . "\n");
        }
    }

    /**
     * 清空表
     * @param string $tableName
     * @throws \Exception
     */
    protected function truncate($tableName)
    {
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
