<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MiceDestInfo extends Model
{
    
    /**
     * 引入 Trait 处理多语言字段
     */
    use \App\Traits\Column\LocalAddress;
    use \App\Traits\Column\LocalDesc;
    use \App\Traits\Column\LocalAirport;
    use \App\Traits\Column\LocalAdvantage;
    use \App\Traits\Column\LocalAttractions;
    use \App\Traits\Column\LocalFeature;
    protected $appends = [
        'address',
        'desc',
        'airport',
        'advantage',
        'attractions',
        'feature'
    ];

    protected $table = 'destinations_info';

    public $timestamps = false;
}
