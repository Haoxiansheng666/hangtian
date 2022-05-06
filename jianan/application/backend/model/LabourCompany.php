<?php
namespace app\backend\model;
use think\Model;
use think\Request;
use think\Db;
class LabourCompany extends BaseModel
{
    protected $autoWriteTimestamp = 'create_time';
    protected $createTime = 'create_time';
    protected $updateTime = false;

    protected $append = [
        'create_time_text',
        'status_text'
    ];

    public function status(){
        return [
            '1' => '缺人',
            '2' => '不缺人'
        ];
    }

    public function getStatusTextAttr($value,$data){
        $status = $this->status();
        return !empty($status[$data['status']]) ? $status[$data['status']] : '未知';
    }

    public function getCreateTimeTextAttr($value,$data){
        return !empty($data['create_time']) ? date('Y-m-d H:i:s',$data['create_time']) : '';
    }

    public function salesman(){
        return $this->hasOne('AdminUser','id','salesman_id');
    }

    public function admin(){
        return $this->hasOne('AdminUser','id','admin_id');
    }

}
 
