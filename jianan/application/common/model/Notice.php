<?php
namespace app\common\model;
use think\Model;
class Notice extends Model
{
    protected $autoWriteTimestamp = true;
    protected $createTime = 'add_time';
    protected $updateTime = false;

    public function setContentAttr($value){
        return htmlspecialchars_decode($value);
    }
    public function getAddTimeAttr($v){
        return $v ? date('Y-m-d',$v) : '';
    }
}
 
