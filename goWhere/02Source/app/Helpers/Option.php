<?php
namespace App\Helpers;

/**
 * 操作保存在数据库中的选项
 */
class Option
{
    protected static $_options = [];
    protected static $_optionsAllLoaded = false;
    protected static $_optionsCdt = [];

    /**
     * 从数据库获取选项
     * @param string $key 配置键名
     * @return mixed 获取单一配置直接返回值，获取多个配置返回[key=>value,...]的数组
     */
    public static function get($key='')
    {
        $table = \DB::table('options_'.\App::getLocale());
        if(empty($key)) {
            // 获取所有配置
            if (static::$_optionsAllLoaded) {
                return static::$_options;
            }
            $options = $table->lists('value', 'key');
            $all = true;
        } elseif(\strpos($key, '%')!==false) {
            if (isset(static::$_optionsCdt[$key]))
            {
                return static::$_optionsCdt[$key];
            }
            $options = $table->where('key', 'like', $key)->lists('value', 'key');
            $condition = true;
        } else {
            if (isset(static::$_options[$key])) {
                return static::$_options[$key];
            }
            $single = true;
            $options = $table->where('key', $key)->lists('value', 'key');
        }
        if($options) {
            foreach ($options as $k => $v) {
                $options[$k] = \unserialize($v);
                !isset(static::$_options[$k]) ? static::$_options[$k] = $options[$k] : '';
            }
            isset($condition) && $condition ? static::$_optionsCdt[$key] = $options : '';
            isset($all) && $all ? static::$_optionsAllLoaded = true : '';
        }
        return isset($single) && $single
                ? (isset(static::$_options[$key]) ? static::$_options[$key] : null)
                : $options;
    }

    /**
     * 临时或永久保存一个option
     * @param string $key
     * @param mix $value
     * @param string $lang 语言 zh_cn|en_us 默认为当前语言
     * @param boolean $permanent 是否持久化到数据库
     * @return boolean
     */
    public static function set($key, $value, $lang='', $permanent = false)
    {
        $lang = empty($lang) ? \App::getLocale() : $lang;
        if($permanent) {
            $insert = \DB::insert('replace into `options_'.$lang.'` (`key`,`value`) values (?, ?)', [$key, \serialize($value)]);
            if(!$insert)
            {
                return false;
            }
        }
        static::$_options[$key] = $value;
        return true;
    }

}
