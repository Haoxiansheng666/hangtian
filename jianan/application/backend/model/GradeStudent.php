<?php
namespace app\backend\model;
use think\Model;
use think\Request;
use think\Db;
class GradeStudent extends BaseModel
{
    protected $autoWriteTimestamp = 'create_time';
    protected $createTime = 'create_time';
    protected $updateTime = false;

    protected $append = [
        'create_time_text',
        'contact_status_text',
        'status_text'
    ];

    public function contact_status(){
        return [
            '未联系',
            '可参加',
            '不能参加',
            '待定'
        ];
    }

    public function statusList(){
        return [
            '0' => '培训中',
            '1' => '培训完成',
            '2' => '待培训',
            '-1' => '异常',
        ];
    }

    public function getContactStatusTextAttr($value,$data){
        $status = $this->contact_status();
        return !empty($status[$data['contact_status']]) ? $status[$data['contact_status']] : '未知';
    }

    public function getStatusTextAttr($value,$data){
        $status = $this->statusList();
        return !empty($status[$data['status']]) ? $status[$data['status']] : '未知';
    }

    public function getCreateTimeTextAttr($value,$data){
        return !empty($data['create_time']) ? date('Y-m-d H:i:s',$data['create_time']) : '';
    }

    public function payStudent1(){
        //return $this->hasOne('PayStudent','id','pay_student_id',[],'LEFT');
        return $this->belongsTo('app\backend\model\PayStudent', 'pay_student_id', 'id', [], 'LEFT')->setEagerlyType(0);
    }

    public function payStudent(){
        return $this->hasOne('PayStudent','id','pay_student_id',[],'LEFT');
    }

    public function grade1(){
       // return $this->hasOne('Grade','id','grade_id',[],'LEFT');
        return $this->belongsTo('app\backend\model\Grade', 'grade_id', 'id', [], 'LEFT')->setEagerlyType(0);
    }

    public function grade(){
         return $this->hasOne('Grade','id','grade_id',[],'LEFT');
    }
}
 
