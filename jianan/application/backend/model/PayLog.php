<?php
namespace app\backend\model;
use think\Model;
use think\Request;
use think\Db;
class PayLog extends BaseModel
{
    protected $autoWriteTimestamp = 'create_time';
    protected $createTime = 'create_time';
    protected $updateTime = false;

    protected $append = [
        'status_text',
        'type_text',
        'pay_way_text',
        'pay_site_text',
        'proceeds_type_text',
        'operate_time_text',
        //'pay_time_text',
        'create_time_text'
    ];

    public function getStatusArray(){
        return ['未审核','审核通过','审核拒绝'];
    }

    public function getPayWayTextAttr($value,$data){
        $pay_way = [
            '1' => '对公',
            '2' => '对私'
        ];
        return attrCheck($pay_way,$value,$data,'pay_way');
    }

    public function getProceedsTypeTextAttr($value,$data){
        $proceeds_type = [
            '1' => '支付宝',
            '2' => '微信',
            '3' => '银行卡转账',
            '4' => '现金'
        ];
        return attrCheck($proceeds_type,$value,$data,'proceeds_type');
    }

    public function getPaySiteTextAttr($value,$data){
        $pay_site = [
            '1' => '线上',
            '2' => '线下'
        ];
        return attrCheck($pay_site,$value,$data,'pay_site');
    }

    public function getStatusTextAttr($value,$data){
        $status = $this->getStatusArray();
        return !empty($status[$data['status']]) ? $status[$data['status']] : '审核状态错误';
    }

    public function getTypeTextAttr($value,$data){
        $status = [
            '1' => '报名缴费',
            '2' => '补考缴费',
        ];
        return !empty($status[$data['type']]) ? $status[$data['type']] : '支付类型错误';
    }

    public function getOperateTimeTextAttr($value,$data){
        return !empty($data['operate_time']) ? date('Y-m-d H:i:s',$data['operate_time']) : '未审核';
    }

    public function getCreateTimeTextAttr($value,$data){
        return !empty($data['create_time']) ? date('Y-m-d H:i:s',$data['create_time']) : '';
    }

//    public function getPayTimeTextAttr($value,$data){
//        return !empty($data['pay_time']) ? date('Y-m-d',$data['pay_time']) : '';
//    }
}
 
