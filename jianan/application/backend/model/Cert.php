<?php
namespace app\backend\model;
use think\Model;
use think\Request;
use think\Db;
class Cert extends BaseModel
{
    protected $autoWriteTimestamp = true;
    protected $createTime = 'create_time';
    protected $updateTime = false;

    protected $append = [
        'status_text',
        'create_time_text',
        'type_text'
    ];

    public function payStudent(){
        return $this->hasOne('PayStudent','id','pay_student_id');
    }

    public function getStatusTextAttr($v,$data){
        $status = [
            '未审核',
            '已领证',
            '-1' => '审核未通过'
        ];
        return !empty($status[$data['status']]) ? $status[$data['status']] : '未知';
    }
    public function getTypeTextAttr($v,$data){
        $status = [
            '1' => '自取',
            '2' => '邮寄'
        ];
        return !empty($status[$data['type']]) ? $status[$data['type']] : '未知';
    }

    public function getCreateTimeTextAttr($value,$data){
        return !empty($data['create_time']) ? date('Y-m-d H:i',$data['create_time']) : '未知';
    }
}
 
