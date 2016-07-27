<?php

namespace App\Extensions\Captcha;

/**
 * Description of PhraseBuilder
 *
 * @author wangw
 */
class PhraseBuilder extends \Gregwar\Captcha\PhraseBuilder
{
    protected $charset = 'abcdefhjkmnprstuvwxyz23456789';

    /**
     * Generates  random phrase of given length with given charset
     */
    public function build($length = 5, $charset = null)
    {
        if($charset === null) {
            $charset = $this->charset;
        }
        $phrase = '';
        $chars = str_split($charset);

        for ($i = 0; $i < $length; $i++) {
            $phrase .= $chars[array_rand($chars)];
        }

        return $phrase;
    }

    /**
     * 设置字符范围
     * @param string $charset
     */
    public function setCharset($charset)
    {
        $this->charset = $charset;
    }
}
