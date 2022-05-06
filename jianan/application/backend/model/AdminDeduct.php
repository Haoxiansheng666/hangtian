<?php
namespace app\backend\model;
use think\Model;
use think\Request;
use think\Db;
class AdminDeduct extends BaseModel
{
    protected $autoWriteTimestamp = 'create_time';
    protected $createTime = 'create_time';
    protected $updateTime = false;

    protected $append = [
        'create_time_text',
        'status_text'
    ];

    public function getCreateTimeTextAttr($value,$data){
        return !empty($data['create_time']) ? date('Y-m-d H:i:s',$data['create_time']) : '';
    }

    public function getStatusTextAttr($value,$data){
        $statusList = [
            '未审核','审核同意','审核拒绝'
        ];
        return !empty($statusList[$data['status']]) ? $statusList[$data['status']] : '未知';
    }

    public function admin(){
        return $this->hasOne('AdminUser','id','admin_id');
    }
    public function profession(){
        return $this->hasOne('Profession','id','profession_id');
    }
    public function student(){
        return $this->hasOne('PayStudent','id','pay_student_id');
    }
}
 
