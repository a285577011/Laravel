<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    /**
     * 多语言字段处理
     */
    use \App\Traits\Column\LocalName;
    protected $appends = ['name'];
    /**
     * 关联到模型的数据表
     * @var string
     */
    protected $table = 'services';

    /**
     * 只包含启用的作用域
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeEnable($query)
    {
        return $query->where('enable', 1);
    }

    /**
     * 只包含给定类型的作用域
     * @param object $query
     * @param int $type
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * 只包含给定父级的作用域
     * @param object $query
     * @param int $parentId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeParent($query, $parentId=0)
    {
        return $query->where('parent_id', $parentId);
    }

    /**
     * 定义一对多关系
     * @return type
     */
    public function subService()
    {
        return $this->hasMany('\App\Models\Service', 'parent_id');
    }
}
