<?php
namespace app\backend\model;
use think\Model;
use think\Request;
use think\Db;
class LabourCompanyReturned extends BaseModel
{
    protected $autoWriteTimestamp = 'create_time';
    protected $createTime = 'create_time';
    protected $updateTime = false;

    protected $append = [
        'create_time_text'
    ];

    public function getCreateTimeTextAttr($value,$data){
        return !empty($data['create_time']) ? date('Y-m-d H:i:s',$data['create_time']) : '';
    }

    public function company(){
        return $this->hasOne('LabourCompany','id','company_id');
    }

    public function admin(){
        return $this->hasOne('AdminUser','id','admin_id');
    }
}
 
