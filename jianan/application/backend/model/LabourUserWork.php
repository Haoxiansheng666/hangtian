<?php
namespace app\backend\model;
use think\Model;
use think\Request;
use think\Db;
class LabourUserWork extends BaseModel
{
    protected $autoWriteTimestamp = 'create_time';
    protected $createTime = 'create_time';
    protected $updateTime = false;

    protected $append = [
        'create_time_text',
        'action_time_text',
        'action_time_add',
        'end_time_add',
        'end_time_text'
    ];

    public function getCreateTimeTextAttr($value,$data){
        return !empty($data['create_time']) ? date('Y-m-d H:i:s',$data['create_time']) : '';
    }
    public function getActionTimeTextAttr($value,$data){
        return !empty($data['action_time']) ? date('Y-m-d',$data['action_time']) : '';
    }
    public function getEndTimeTextAttr($value,$data){
        return !empty($data['end_time']) ? date('Y-m-d',$data['end_time']) : '';
    }
    public function getActionTimeAddAttr($value,$data){
        return !empty($data['action_time']) ? date('Y/m/d',$data['action_time']) : '';
    }
    public function getEndTimeAddAttr($value,$data){
        return !empty($data['end_time']) ? date('Y/m/d',$data['end_time']) : '';
    }
}
 
