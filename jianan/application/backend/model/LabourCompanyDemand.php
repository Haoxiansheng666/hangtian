<?php
namespace app\backend\model;
use think\Model;
use think\Request;
use think\Db;
use traits\model\SoftDelete;

class LabourCompanyDemand extends BaseModel
{
    use SoftDelete;
    protected $autoWriteTimestamp = 'create_time';
    protected $createTime = 'create_time';
    protected $updateTime = false;
    protected $deleteTime = "delete_time";

    protected $append = [
        'create_time_text'
    ];

    public function work_exp(){
        return [
            '无工作经验',
            '1年以下',
            '1-3年',
            '3-5年',
            '5-10年',
            '10年以上',
        ];
    }

    public function getCreateTimeTextAttr($value,$data){
        return !empty($data['create_time']) ? date('Y-m-d H:i:s',$data['create_time']) : '';
    }

    public function profession(){
        return $this->hasOne('Profession','id','profession_id');
    }
}
 
