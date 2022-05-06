<?php
namespace app\backend\model;
use think\Model;
use think\Request;
use think\Db;
class Apply extends BaseModel
{
    protected $autoWriteTimestamp = 'create_time';
    protected $createTime = 'create_time';
    protected $updateTime = false;

    protected $append = [
        'create_time_text',
        'check_time_text',
        'status_text',
    ];

    public function getCreateTimeTextAttr($value,$data){
        return !empty($data['create_time']) ? date('Y-m-d H:i:s',$data['create_time']) : '';
    }

    public function getCheckTimeTextAttr($value,$data){
        return !empty($data['create_time']) ? date('Y-m-d H:i:s',$data['create_time']) : '';
    }

    public function getStatusArray(){
        return ['未审核','审核通过','审核拒绝'];
    }

    public function getStatusTextAttr($value,$data){
        $status = $this->getStatusArray();
        return !empty($status[$data['status']]) ? $status[$data['status']] : '审核状态错误';
    }

    // 创建人
    public function admin(){
        return $this->hasOne('AdminUser','id','auid');
    }

    // 创建人
    public function company(){
        return $this->hasOne('Company','id','company_id');
    }

}
 
