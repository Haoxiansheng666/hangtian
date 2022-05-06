<?php
namespace app\backend\model;
use think\Model;
class TaskAccomplish extends Model
{
    protected $autoWriteTimestamp = true;
    protected $createTime = 'create_time';
    protected $updateTime = false;

    protected $append = [
        'create_time_text'
    ];

    public function getCreateTimeTextAttr($value,$data){
        return !empty($data['create_time']) ? date('Y-m-d H:i:s',$data['create_time']) : '';
    }

    public function task(){
        return $this->hasOne('Task','id','task_id');
    }

    public function admin(){
        return $this->hasOne('AdminUser','id','admin_id');
    }

}
 
