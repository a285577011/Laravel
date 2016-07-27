<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Helpers\Common;

class TourDictionary extends Model
{

    protected $table = 'tour_dictionary';

    public $timestamps = false;

    public static function add($name, $desc, $type)
    {
        $self = new self();
        $self->name = $name;
        $self->desc = $desc;
        $self->type = $type;
        if ($self->save()) {
            return $self->id;
        }
        return false;
    }
}
