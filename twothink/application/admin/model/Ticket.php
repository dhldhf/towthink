<?php
/**
 * Created by PhpStorm.
 * User: DUHAILONG
 * Date: 2018/5/13
 * Time: 12:24
 */

namespace app\admin\model;
use think\Model;

class Ticket extends Model
{
    protected $insert = ['status'=>1];
}