<?php
namespace app\backend\model;
use think\Model;
class LoginLog extends Model
{   
    // 类型转换
    protected $type = array(
        'login_time' => 'timestamp:Y-m-d H:i:s',
    );

}
 
