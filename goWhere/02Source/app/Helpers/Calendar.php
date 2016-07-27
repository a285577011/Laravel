<?php
namespace App\Helpers;

use Input;

/**
 * 后台跟团游票数日历
 */
class Calendar
{

    protected $_table;
    // table表格
    protected $_currentDate;
    // 当前日期
    protected $_year;
    // 年
    protected $_month;
    // 月
    protected $_days;
    // 给定的月份应有的天数
    protected $_dayofweek;
    // 给定月份的 1号 是星期几
    public $priceDate;

    /**
     * 构造函数
     */
    public function __construct(array $priceDate, $time = false)
    {
        $this->priceDate = $priceDate;
        $this->_table = "";
        $this->calendarTime = Input::get('calendarTime') ?: $time;
        // print_r($calendarTime);die;
        $this->_year = date("Y", strtotime($this->calendarTime));
        $this->_month = date("m", strtotime($this->calendarTime));
        if ($this->_month > 12) { // 处理出现月份大于12的情况
            $this->_month = 1;
            $this->_year ++;
        }
        if ($this->_month < 1) { // 处理出现月份小于1的情况
            $this->_month = 12;
            $this->_year --;
        }
        $this->_currentDate = $this->_year . '年' . $this->_month . '月份'; // 当前得到的日期信息
        $this->_days = date("t", mktime(0, 0, 0, $this->_month, 1, $this->_year)); // 得到给定的月份应有的天数
        $this->_dayofweek = date("w", mktime(0, 0, 0, $this->_month, 1, $this->_year)); // 得到给定的月份的 1号 是星期几
    }

    /**
     * 输出标题和表头信息
     */
    protected function _showTitle()
    {
        $this->_table = "<table id='sample-table-1' class='table table-striped table-bordered table-hover'><thead><tr align='center'><th class='center'><label> <input type='checkbox' class='ace checkall' /> <span class='lbl'></span>
									</label></th><th colspan='7'>" . $this->_currentDate . "</th></tr></thead>";
        $this->_table .= "<tbody><tr>";
        $this->_table .= "<td style='color:red'>星期日</td>";
        $this->_table .= "<td>星期一</td>";
        $this->_table .= "<td>星期二</td>";
        $this->_table .= "<td>星期三</td>";
        $this->_table .= "<td>星期四</td>";
        $this->_table .= "<td>星期五</td>";
        $this->_table .= "<td style='color:red'>星期六</td>";
        $this->_table .= "</tr>           
            ";
    }

    /**
     * 输出日期信息
     * 根据当前日期输出日期信息
     */
    protected function _showDate()
    {
        $nums = $this->_dayofweek + 1;
        for ($i = 1; $i <= $this->_dayofweek; $i ++) { // 输出1号之前的空白日期
            $this->_table .= "<td> </td>";
        }
        for ($i = 1; $i <= $this->_days; $i ++) { // 输出天数信息
            $time = strtotime($this->_year . '-' . $this->_month . '-' . $i);
            if ($nums % 7 == 0) { // 换行处理：7个一行
                $this->_table .= "<td><p>{$i}</p>";
                // echo $this->_year . '-' . $this->_month . '-' . $i.'</br>';
                if (array_key_exists($time, $this->priceDate)) {
                    $this->_table .= "<input type='checkbox' class='ace ids' value='{$this->priceDate[$time]['id']}' /><span class='lbl'></span></br>";
                    $this->_table .= "价格:<input type='text' name='pirceData[{$this->priceDate[$time]['id']}][price]' value='{$this->priceDate[$time]['adult_price']}' style='width: 85px;'/></br>";
                    $this->_table .= "儿童价格:<input type='text' name='pirceData[{$this->priceDate[$time]['id']}][child_price]' value='{$this->priceDate[$time]['child_price']}' style='width: 85px;'/></br>";
                    $this->_table .= "票数:<input type='text' name='pirceData[{$this->priceDate[$time]['id']}][stock]' value='{$this->priceDate[$time]['stock']}' style='width: 85px;'/>";
                }
                $this->_table .= "</td></tr><tr>";
            } else {
                $this->_table .= "<td><p>{$i}</p>";
                if (array_key_exists($time, $this->priceDate)) {
                    $this->_table .= "<input type='checkbox' class='ace ids' value='{$this->priceDate[$time]['id']}' /><span class='lbl'></span></br>";
                    $this->_table .= "价格:<input type='text' name='pirceData[{$this->priceDate[$time]['id']}][price]' value='{$this->priceDate[$time]['adult_price']}' style='width: 85px;'/></br>";
                    $this->_table .= "儿童价格:<input type='text' name='pirceData[{$this->priceDate[$time]['id']}][child_price]' value='{$this->priceDate[$time]['child_price']}' style='width: 85px;'/></br>";
                    $this->_table .= "票数:<input type='text' name='pirceData[{$this->priceDate[$time]['id']}][stock]' value='{$this->priceDate[$time]['stock']}' style='width: 85px;'/>";
                }
                $this->_table .= " </td>";
            }
            $nums ++;
            unset($k);
        }
        $this->_table .= "</tbody></table>";
    }

    /**
     * 输出日历
     */
    public function showCalendar()
    {
            $this->_showTitle();
            $this->_showDate();
            echo $this->_table;
    }
}