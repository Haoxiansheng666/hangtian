<?php
namespace app\backend\model;
use think\Model;
class CustomerTransfer extends BaseModel
{
    protected $autoWriteTimestamp = 'create_time';

    protected $createTime = 'create_time';
    protected $updateTime = false;

    protected $append = [
        'create_time_text',
        'audit_time_text'
    ];

    public function getCreateTimeTextAttr($value,$data){
        $value = !empty($data['create_time']) ? $data['create_time'] : '';
        return !empty($value) ? date('Y-m-d H:i:s',$value) : '';
    }
    
    public function getAuditTimeTextAttr($value,$data){
        $value = !empty($data['audit_time']) ? $data['audit_time'] : '';
        return !empty($value) ? date('Y-m-d H:i:s',$value) : '';
    }

    public function oldAdmin(){
        return $this->hasOne('AdminUser','id','old_admin_id');
    }

    public function admins(){
        return $this->hasOne('AdminUser','id','admin_id');
    }

    public function customer(){
        return $this->hasOne('Customer','id','customer_id');
    }
}
 
