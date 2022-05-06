<?php
namespace app\backend\model;
use think\Model;
use think\Request;
use think\Db;
class ServiceContact extends BaseModel
{
    protected $autoWriteTimestamp = 'create_time';
    protected $createTime = 'create_time';
    protected $updateTime = false;

    protected $append = [
        'create_time_text',
        'contact_time_text',
        'contact_status_text'
    ];

    public function contact_status(){
        return [
            '未联系',
            '可参加',
            '不能参加',
            '待定'
        ];
    }

    public function getContactStatusTextAttr($value,$data){
        $status = $this->contact_status();
        return !empty($status[$data['contact_status']]) ? $status[$data['contact_status']] : '未知';
    }

    public function getCreateTimeTextAttr($value,$data){
        return !empty($data['create_time']) ? date('Y-m-d H:i:s',$data['create_time']) : '';
    }

    public function getContactTimeTextAttr($value,$data){
        return !empty($data['create_time']) ? date('Y-m-d H:i:s',$data['create_time']) : '';
    }

    public function payStudent(){
        return $this->hasOne('PayStudent','id','pay_student_id');
    }

    public function grade(){
        return $this->hasOne('Grade','id','grade_id');
    }
    public function exam(){
        return $this->hasOne('Exam','id','exam_id');
    }

    public function admin(){
        return $this->hasOne('AdminUser','id','contact_admin_id');
    }
}
 
