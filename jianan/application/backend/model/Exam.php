<?php
namespace app\backend\model;
use think\Model;
use think\Request;
use think\Db;
class Exam extends BaseModel
{
    protected $autoWriteTimestamp = 'create_time';
    protected $createTime = 'create_time';
    protected $updateTime = false;

    protected $append = [
        'status_text',
        'create_time_text',
        'exam_time_text'
    ];

    public function getStatusArray(){
        return ['未开始','已结束'];
    }

    public function getStatusTextAttr($value,$data){
        $status = $this->getStatusArray();
        return !empty($status[$data['status']]) ? $status[$data['status']] : '审核状态错误';
    }

    public function getCreateTimeTextAttr($value,$data){
        return !empty($data['create_time']) ? date('Y-m-d H:i:s',$data['create_time']) : '';
    }
    public function getExamTimeTextAttr($value,$data){
        return !empty($data['exam_time']) ? date('Y-m-d',$data['exam_time']) : '';
    }

    // 班主任
    public function teacher(){
        return $this->hasOne('AdminUser','id','teacher_id');
    }
    // 工种
    public function profession(){
        return $this->hasOne('Profession','id','profession_id');
    }
    public function professionTop(){
        return $this->hasOne('Profession','id','profession_top_id');
    }
    // 创建人
    public function admin(){
        return $this->hasOne('AdminUser','id','admin_id');
    }
}
 
