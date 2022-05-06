<?php
namespace app\backend\model;
use think\Model;
use think\Request;
use think\Db;
class Grade extends BaseModel
{
    protected $autoWriteTimestamp = 'create_time';
    protected $createTime = 'create_time';
    protected $updateTime = false;

    protected $append = [
        'status_text',
        'train_site_text',  // 培训地点
        'create_time_text',
        'train_action_time_text',
        'train_end_time_text'
    ];

    public function getStatusArray(){
        return ['未开课','已开课','已结束'];
    }

    public function getTrainSiteTextAttr($value,$data){
        $status = [
            '1' => '线上',
            '2' => '线下'
        ];
        return !empty($status[$data['train_site']]) ? $status[$data['train_site']] : '未知';
    }

    public function getStatusTextAttr($value,$data){
        $status = $this->getStatusArray();
        return !empty($status[$data['status']]) ? $status[$data['status']] : '审核状态错误';
    }

    public function getCreateTimeTextAttr($value,$data){
        return !empty($data['create_time']) ? date('Y-m-d H:i:s',$data['create_time']) : '';
    }
    public function getTrainActionTimeTextAttr($value,$data){
        return !empty($data['train_action_time']) ? date('Y-m-d',$data['train_action_time']) : '';
    }
    public function getTrainEndTimeTextAttr($value,$data){
        return !empty($data['train_end_time']) ? date('Y-m-d',$data['train_end_time']) : '';
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
 
