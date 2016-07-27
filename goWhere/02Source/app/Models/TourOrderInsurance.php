<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TourOrderInsurance extends Model
{

    protected $table = 'tour_order_insurance';

    public $timestamps = false;

    public static function add($insuranceData)
    {
        $insurance = new self();
        $insurance->tour_order_id = $insuranceData['tour_order_id'];
        $insurance->num = $insuranceData['num'];
        $insurance->price = $insuranceData['price'];
        $insurance->name = $insuranceData['name'];
        $insurance->description = $insuranceData['description'];
        $insurance->type = $insuranceData['type'];
        if ($insurance->save()) {
            return $insurance->id;
        }
        return false;
    }
}
