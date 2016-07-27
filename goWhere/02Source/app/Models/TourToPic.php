<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Helpers\Common;

class TourToPic extends Model
{

    protected $table = 'tour_to_pic';

    public $timestamps = false;

    public static function add($tourId, $image)
    {
        $self = new self();
        $self->tour_id = $tourId;
        $self->image = $image;
        $self->creat_time = time();
        if ($self->save()) {
            return $self->id;
        }
        return false;
    }

    public static function getPicById($tourId)
    {
        return self::where([
            'tour_id' => $tourId
        ])->lists('image');
    }

    public static function getOnePicByTourId($tourId)
    {
        return self::where([
            'tour_id' => $tourId
        ])->orderBy('id','desc')->value('image');
    }
}
