<?php

namespace App\Helpers;

use Storage;
use Config;
use Illuminate\Support\Facades\Input;

/**
 *
 * @author jishu01
 *        
 */
class Upload
{

    public $maxSize = 2 * 1024 * 1024;
    // 上传的文件大小限制 (0-不做限制)
    public $savePath;
    public $saveName;
    public $extension;//文件类型
    public $oriName;//原文件名
    public $fileSize;//上传文件大小
    public function __construct($savePath = null)
    {
        $this->setFolder($savePath);
        $this->setSaveFileName();
    }

    /**
     *
     * @param unknown $file
     *            文件输入对象
     * @param array $maxSize 最大尺寸 [width, height] 超过的图片会被按比例缩小
     * @return unknown 无图片直接返回fals 有图失败返回key为error的代表有上传错误的文件 success代表上传成功 并返回成功路径 值
     */
    public function save($file = null, $maxSize = [])
    {
        if (!$file) {
            $file = $this->getFileData();
            if (!$file) {
                return false;
            }
        }
        !is_array($file) && $file = [
            $file
        ];
        $info = [
            'error' => [],
            'success' => []
        ];
        foreach ($file as $k => $f) {
            if ($f && $f->isValid()) {
                $this->oriName = $f->getClientOriginalName(); // 客户端文件名
                /* 检查文件大小 */
                if (!$this->checkSize($f)) {
                    $info['error'][$this->oriName] = '文件大小超出' . $this->maxSize;
                    continue;
                }
                $this->extension = strtolower($f->getClientOriginalExtension()); // 后缀
                /* 对图像文件进行严格检测 */
                if (in_array($this->extension, array(
                        'gif',
                        'jpg',
                        'jpeg',
                        'bmp',
                        'png',
                        'swf'
                    ))) {
                    $imginfo = getimagesize($f->getRealPath());
                    if (empty($imginfo) || ($this->extension == 'gif' && empty($imginfo['bits']))) {
                        $info['error'][$k] = [
                            'fileName' => $this->oriName,
                            'info' => trans('message.invalid_image')
                        ];
                        continue;
                    }
                    if(!empty($maxSize) && !in_array($this->extension, ['bmp', 'swf'])) {
                        if(!$this->shrinkImage($f->getRealPath(), $maxSize, $imginfo)) {
                            $info['error'][$k] = [
                                'fileName' => $this->oriName,
                                'info' => trans('message.resize_image_fail')
                            ];
                            continue;
                        }
                    }
                }
                $savePath = $this->savePath . $this->saveName . '.' . $this->extension;
                Storage::put($savePath, file_get_contents($f->getRealPath()));

                if (! Storage::exists($savePath)) {
                    $info['error'][$k] = [
                        'fileName' => $this->oriName,
                        'info' => trans('message.upload_fail')
                    ];

                } else {
                    $info['success'][$k] = [
                        'fileName' => $this->oriName,
                        'path' => $savePath
                    ];
                }
            }
        }
        return $info;
    }

    /**
     * 设置保存路径
     * @return string
     */
    public function setFolder($savePath = null)
    {
        if ($savePath) {
            $this->savePath = trim($savePath, '\\/') . '/';
        } else {
            $s = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $saveFolder = str_shuffle($s);
            $this->savePath = substr($saveFolder, 0, 1);
            if (strrchr($this->savePath, "/") != "/") {
                $this->savePath .= "/";
            }
        }
    }

    public function setSaveFileName()
    {
        $this->saveName = time() . rand(0, 1000);
    }

    /**
     * 检查文件大小是否合法
     *
     * @param integer $size
     *            数据
     */
    private function checkSize($file)
    {
        $this->fileSize=$file->getSize();
        return !($file->getSize() > $this->maxSize) || (0 == $this->maxSize);
    }

    public function getFileData()
    {
        $files = Input::file();
        if (!$files) {
            return false;
        }
        $file = [];
        foreach ($files as $k => $v) {
            if (is_array($v)) {
                foreach ($v as $vc) {
                    $file[] = $vc;
                }
            } else {
                $file[] = $v;
            }
        }
        return $file;
    }

    /**
     * 保存上传图片
     * @param \Symfony\Component\HttpFoundation\File\UploadedFile $file
     * @param array $maxSize [宽,高,true/false(可选，true:无条件修改尺寸;false:原图过大时保持原比例缩小)]
     * @return mixed 无上传图片返回false，否则返回保存后的信息数组
     */
    public function saveImage($file, $maxSize = [])
    {
        if (is_null($file)) {
            return false;
        } elseif (is_object($file) && ($file instanceof \Symfony\Component\HttpFoundation\File\UploadedFile)) {
            $saveInfo = $this->save($file, $maxSize);
            if ($saveInfo['error']) {
                return ['error' => true, 'errorMsg' => array_shift($saveInfo['error'])['info']];
            }
            return ['error' => false, 'errorMsg' => '', 'path' => array_shift($saveInfo['success'])['path']];
        } elseif (is_array($file)) {
            $info = [];
            foreach ($file as $k => $f) {
                $info[$k] = $this->saveImage($f, $maxSize);
            }
            return $info;
        }
    }

    /**
     * 缩小图片
     * @param string $filePath
     * @param array $newSize
     * @param array $oldSize
     */
    public function shrinkImage($filePath, $maxSize, $oldSize = [])
    {
        if(empty($oldSize)) {
            $oldSize = getimagesize($filePath);
        }
        if(isset($maxSize[2]) && $maxSize[2]) {
            return $this->resizeImage($filePath, $maxSize, $oldSize);
        }
        if(($maxSize[0] < $oldSize[0]) || ($maxSize[1] < $oldSize[1]))
        {
            $oldWLRatio = $oldSize[0] / $oldSize[1];
            $newWLRatio = $maxSize[0] / $maxSize[1];
            if($newWLRatio < $oldWLRatio) {
                $width = $maxSize[0];
                $height = round(($maxSize[0] / $oldSize[0]) * $oldSize[1]);
            } else {
                $height = $maxSize[1];
                $width = round(($maxSize[1] / $oldSize[1]) * $oldSize[0]);
            }
            $image = imagescale(imagecreatefromstring(file_get_contents($filePath)), $width, $height);
            if ($image && imagejpeg($image, $filePath)) {
                $this->extension = 'jpg';
                imagedestroy($image);
                return true;
            }
        } else {
            return true;
        }
        return false;
    }

    /**
     * 无条件裁剪图片至指定大小
     * @param string $filePath
     * @param array $newSize
     * @param array $oldSize
     */
    public function resizeImage($filePath, $maxSize, $oldSize = [])
    {
        $oldWLRatio = $oldSize[0] / $oldSize[1];
        $newWLRatio = $maxSize[0] / $maxSize[1];
        if ($newWLRatio < $oldWLRatio) {
            $height = $maxSize[1];
            $width = round(($maxSize[1]/$oldSize[1]) * $oldSize[0]);
        } else {
            $width = $maxSize[0];
            $height = round(($maxSize[0]/$oldSize[0]) * $oldSize[1]);
        }
        $img = imagecreatefromstring(file_get_contents($filePath));
        imagesavealpha($img,true);
        $image = imagescale($img, $width, $height);
        $new = imagecreatetruecolor($maxSize[0], $maxSize[1]);
        imagealphablending($new,false);
        imagesavealpha($new,true);
        if (imagecopyresampled(
                $new, $image, 0, 0,
                round(($width-$maxSize[0])/2),
                round(($height-$maxSize[1])/2),
                $maxSize[0], $maxSize[1],
                $maxSize[0], $maxSize[1]
            ) && imagejpeg($new, $filePath)) {
            $this->extension = 'jpg';
            imagedestroy($image);
            imagedestroy($new);
            return true;
        }
        return false;
    }

}
