<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FairReservation extends Model
{
    protected $table = 'fair_reservations';
    public $timestamps = false;



    /**
     * 定义与fair表的关系
     */
    public function fairs()
    {
        return $this->belongsTo('\App\Models\Fair', 'fair_id');
    }

    /**
     * 为指定的展会插入一条预订记录
     * @param object $fair
     * @param object $request
     * @return int
     */
    public static function saveReservation($fair, $request)
    {
        $reservation = new \App\Models\FairReservation();
        $reservation->name = \trim($request->input('name'));
        $reservation->phone = \trim($request->input('phone'));
        $reservation->address = \trim($request->input('address'));
        $reservation->email = \trim($request->input('email'));
        $reservation->company = \trim($request->input('company'));
        $reservation->company_addr = \trim($request->input('company_addr'));
        $reservation->num = \intval($request->input('num'));
        $reservation->needs = \trim($request->input('needs'));
        $reservation->services = \trim($request->input('service'));
        $reservation = $fair->fairReservation()->save($reservation);
        return $reservation->id;
    }
}
