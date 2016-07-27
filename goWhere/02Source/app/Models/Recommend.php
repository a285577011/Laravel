<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recommend extends Model
{
    /**
     * 引入 Trait 处理多语言字段
     */
    use \App\Traits\Column\LocalName;
    use \App\Traits\Column\LocalDesc;
    protected $appends = [
        'desc',
        'name',
    ];
    protected $table = 'recommends';

    public $timestamps = false;

    /**
     * 获取推荐展会的作用域
     */
    public function scopeFairRec($query, $limit = 5)
    {
        return $query->with([
            'fairs' => function ($query) {
                // 只取启用的展会
                $query->enable();
            }
        ])
            ->where('item_type', 1)
            ->orderBy('order', 'desc')
            ->take($limit);
    }

    /**
     * 定义与pavilions表的关联关系
     */
    public function fairs()
    {
        return $this->belongsTo('\App\Models\Fair', 'item_id');
    }

    /**
     * 获取推荐展会
     */
    public static function getRecFairs($limit = 5)
    {
        $fairs = [];
        $fairRec = self::fairRec($limit)->get();
        if ($fairRec->count()) {
            foreach ($fairRec as $f) {
                $fairs[] = $f->fairs;
            }
        }
        return $fairs;
    }

    /**
     * 获取推荐
     */
    public static function getRecommond($type, $limit = null)
    {
        return self::where([
            'type' => $type
        ])->take($limit)->get();
    }

    public static function getOne($id)
    {
        return self::findOrFail($id);
    }
}
