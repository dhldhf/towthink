<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order_goods extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'order_id', 'goods_id', 'amount','goods_name','goods_price','goods_img',
    ];
    public function order()
    {
        return $this->belongsTo(Order_goods::class,'order_id');
    }
}
