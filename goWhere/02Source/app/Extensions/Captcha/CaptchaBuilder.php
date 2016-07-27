<?php

namespace App\Extensions\Captcha;

/**
 * Description of newPHPClass
 *
 * @author wangw
 */
class CaptchaBuilder extends \Gregwar\Captcha\CaptchaBuilder
{
    protected $maxThickness = 2; //最大线宽


    /**
     * Draw lines over the image
     */
    protected function drawLine($image, $width, $height, $tcol = null)
    {
        if ($tcol === null) {
            $tcol = imagecolorallocate($image, $this->rand(100, 255), $this->rand(100, 255), $this->rand(100, 255));
        }

        if ($this->rand(0, 1)) { // Horizontal
            $Xa   = $this->rand(0, $width/2);
            $Ya   = $this->rand(0, $height);
            $Xb   = $this->rand($width/2, $width);
            $Yb   = $this->rand(0, $height);
        } else { // Vertical
            $Xa   = $this->rand(0, $width);
            $Ya   = $this->rand(0, $height/2);
            $Xb   = $this->rand(0, $width);
            $Yb   = $this->rand($height/2, $height);
        }
        imagesetthickness($image, $this->rand(1, $this->maxThickness));
        imageline($image, $Xa, $Ya, $Xb, $Yb, $tcol);
    }

    /**
     * 设置最大线宽
     * @param int $int
     */
    public function setMaxThickness($int)
    {
        (int)$int > 0 ? $this->maxThickness = (int)$int : '';
    }
}
