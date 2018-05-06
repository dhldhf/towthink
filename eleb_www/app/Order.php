<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
//    public $timestamps = false;
    protected $fillable = [
        'order_code', 'order_birth_time', 'order_status','shop_id','shop_img','shop_name','provence',
        'city', 'area', 'order_address','name','tel','order_price','user_id','created_at','updated_at',
    ];
}
