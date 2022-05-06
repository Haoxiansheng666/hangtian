<?php
namespace app\backend\model;
use think\Model;
class Task extends Model
{
    protected $autoWriteTimestamp = true;
    protected $createTime = 'add_time';
    protected $updateTime = false;

    protected $append = [
        'action_time_text',
        'end_time_text'
    ];

    public function setContentAttr($value){
        return htmlspecialchars_decode($value);
    }
    public function getAddTimeAttr($v){
        return $v ? date('Y-m-d',$v) : '';
    }

    public function getActionTimeTextAttr($v,$data){
        return $data['action_time'] ? date('Y-m-d',$data['action_time']) : '';
    }
    public function getEndTimeTextAttr($v,$data){
        return $data['end_time'] ? date('Y-m-d',$data['end_time']) : '';
    }
}
 
