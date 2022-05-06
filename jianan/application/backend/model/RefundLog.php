<?php
namespace app\backend\model;
use think\Model;
use think\Request;
use think\Db;
class RefundLog extends BaseModel
{
    protected $autoWriteTimestamp = true;
    protected $createTime = 'create_time';
    protected $updateTime = false;

    protected $append = [
        'status_text',
        'create_time_text',
        'check_time_text',
        'zg_check_time_text',
        'lb_check_time_text'
    ];

    public function getStatusTextAttr($value,$data){
        $status = [
            '未审核',
            '审核通过',
            '财务审核拒绝',
            '待主管审核',
            '财务主管拒绝',
            '待老板审核',
            '老板审核拒绝',
        ];
        return !empty($status[$data['status']]) ? $status[$data['status']] : '审核状态错误';
    }

    public function getCreateTimeTextAttr($value,$data){
        return !empty($data['create_time']) ? date('Y-m-d H:i:s',$data['create_time']) : '';
    }
    public function getCheckTimeTextAttr($value,$data){
        return !empty($data['check_time']) ? date('Y-m-d H:i:s',$data['check_time']) : '未审核';
    }
    public function getZgCheckTimeTextAttr($value,$data){
        return !empty($data['zg_check_time']) ? date('Y-m-d H:i:s',$data['zg_check_time']) : '未审核';
    }
    public function getLbCheckTimeTextAttr($value,$data){
        return !empty($data['lb_check_time']) ? date('Y-m-d H:i:s',$data['lb_check_time']) : '未审核';
    }

    public function student(){
        return $this->hasOne('PayStudent','id','pay_student_id',[],'LEFT');
    }
}
 
