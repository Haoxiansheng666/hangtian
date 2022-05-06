<?php
namespace app\backend\model;
use think\Model;
use think\Request;
use think\Db;
class ExamStudent extends BaseModel
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
            '0' => '考试中',
            '1' => '考试完成',
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

    public function payStudent(){
        return $this->hasOne('PayStudent','id','pay_student_id');
    }

    public function exam(){
        return $this->hasOne('exam','id','exam_id');
    }

    public function payStudent1(){
        return $this->belongsTo('app\backend\model\PayStudent', 'pay_student_id', 'id', [], 'LEFT')->setEagerlyType(0);
    }

    public function exam1(){
        return $this->belongsTo('app\backend\model\Exam', 'exam_id', 'id', [], 'LEFT')->setEagerlyType(0);
    }
}
 
