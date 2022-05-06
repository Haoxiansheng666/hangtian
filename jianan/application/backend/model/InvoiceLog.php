<?php
namespace app\backend\model;
use think\Model;
use think\Request;
use think\Db;
class InvoiceLog extends BaseModel
{
    protected $autoWriteTimestamp = 'create_time';
    protected $createTime = 'create_time';
    protected $updateTime = false;

    protected $append = [
        'status_text',
        'operate_time_text',
        'create_time_text'
    ];

    public function getStatusArray(){
        return ['未审核','审核通过','审核拒绝'];
    }

    public function getStatusTextAttr($value,$data){
        $status = $this->getStatusArray();
        return !empty($status[$data['status']]) ? $status[$data['status']] : '审核状态错误';
    }

    public function getOperateTimeTextAttr($value,$data){
        return !empty($data['operate_time']) ? date('Y-m-d H:i:s',$data['operate_time']) : '未审核';
    }

    public function getCreateTimeTextAttr($value,$data){
        return !empty($data['create_time']) ? date('Y-m-d H:i:s',$data['create_time']) : '';
    }
   
}
 
