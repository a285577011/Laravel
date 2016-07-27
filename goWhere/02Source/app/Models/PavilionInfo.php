<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PavilionInfo extends Model
{
    protected $table = 'pavilion_info';

    /**
     * 增加全局Scope处理多语言
     */
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new \App\Scopes\LangScope);
    }

    /**
     * 定义与pavilion表的关系
     */
    public function pavilion()
    {
        return $this->belongsTo('\App\Models\Pavilion', 'pavilion_id');
    }
}
