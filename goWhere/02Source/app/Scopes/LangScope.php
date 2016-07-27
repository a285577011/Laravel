<?php

/**
 * 多语言全局Scope
 * 具有多语言lang字段的数据表模型需要在boot方法中定义此全局scope
 */

namespace App\Scopes;

use Illuminate\Database\Eloquent\ScopeInterface as Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class LangScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        return $builder->where('lang', \App\Helpers\Common::getDbLangType());
    }
    
    public function remove(Builder $builder, Model $model){}
}