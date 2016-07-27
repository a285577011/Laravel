<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Helpers\Common;
use App\Helpers\Upload;
use App;

class MiceCasesInfo extends Model
{
    /**
     * 引入 Trait 处理多语言字段
     */
    use \App\Traits\Column\LocalTitle;
    use \App\Traits\Column\LocalDesc;
    use \App\Traits\Column\LocalCustomer;
    use \App\Traits\Column\LocalContactName;
    use \App\Traits\Column\LocalEventOverview;
    use \App\Traits\Column\LocalServiceContent;
    protected $appends = [
        'title',
        'desc',
        'customer',
        'contact_name',
        'service_content',
        'event_overview',
    ];

    protected $table = 'mice_cases_info';

    public $timestamps = false;
}
