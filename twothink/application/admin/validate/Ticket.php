<?php
/**
 * Created by PhpStorm.
 * User: DUHAILONG
 * Date: 2018/5/13
 * Time: 14:10
 */

namespace app\admin\validate;
use think\Validate;

class Ticket extends Validate
{
    protected $rule = [
        ['title', 'require', '标题不能为空'],
        ['name', 'require', '报修人不能为空'],
        ['tel', 'require', '电话不能为空'],
        ['address', 'require', '地址不能为空'],
        ['content', 'require', '内容不能为空'],
    ];
}