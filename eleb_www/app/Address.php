<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'name', 'tel', 'detail_address','provence','city','area','user_id',
    ];
}
