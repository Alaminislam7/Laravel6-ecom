<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class order extends Model
{
    public function orders(){
        return $this->hasMany('App\ordersProduct','order_id');
    }

    public static function getOrderDetails($order_id){
        $getOrderDetails = order::where('id',$order_id)->first();
        return $getOrderDetails;
    }

    public static function getCountryCode($country){
        $getCountryCode = country::where('country_name',$country)->first();
        return $getCountryCode;
    }
}
