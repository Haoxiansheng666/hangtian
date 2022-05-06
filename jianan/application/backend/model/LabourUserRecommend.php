<?php
namespace app\backend\model;
use think\Model;
use think\Request;
use think\Db;
class LabourUserRecommend extends BaseModel
{
    protected $autoWriteTimestamp = 'create_time';
    protected $createTime = 'create_time';
    protected $updateTime = false;

    protected $append = [
        'create_time_text',
        'entry_time_text',
        'status_text'
    ];

    public function status(){
        return [
            '未面试',
            '面试通过',
            '已面试',
            '面试拒绝'
        ];
    }

    public function getStatusTextAttr($value,$data){
        $status = $this->status();
        return !empty($status[$data['status']]) ? $status[$data['status']] : '未知';
    }

    public function getCreateTimeTextAttr($value,$data){
        return !empty($data['create_time']) ? date('Y-m-d H:i:s',$data['create_time']) : '';
    }
    public function getEntryTimeTextAttr($value,$data){
        return !empty($data['entry_time']) ? date('Y-m-d H:i:s',$data['entry_time']) : '';
    }

    public function company(){
        return $this->hasOne('LabourCompany','id','company_id');
    }
    public function user(){
        return $this->hasOne('LabourUser','id','labour_user_id');
    }
    public function demand(){
        return $this->hasOne('LabourCompanyDemand','id','demand_id');
    }
}
 
