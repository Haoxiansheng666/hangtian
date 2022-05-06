<?php
namespace app\backend\model;
use think\Model;
class AuthRule extends Model
{   
    // 类型转换
    protected $type = array(
        'created_t' => 'timestamp:Y-m-d',
    );
    //自动写入
    protected $insert = array(
       'created_t',
    );
    //写入当前创建时间
    protected function setcreatedTAttr()
    {
        return time();
    }
  
   

}
 
