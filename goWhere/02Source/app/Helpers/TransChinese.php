<?php
namespace App\Helpers;

class TransChinese
{

    public static function transToTw($word)
    
    {
        $array = array_flip(config('utf_t2s'));
        return strtr($word, $array);
    }
}
