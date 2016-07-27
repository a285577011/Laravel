<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FairInfo extends Model
{
    protected $table = 'fair_info';

    /**
     * 增加全局Scope处理多语言
     */
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new \App\Scopes\LangScope);
    }
    
    public function fairs()
    {
        return $this->belongsTo('\App\Models\Fair', 'fair_id');
    }
}
