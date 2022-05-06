<?php
namespace app\backend\model;
use think\Model;
use think\Request;
use think\Db;
class WarehouseGoodsLoad extends BaseModel
{
    protected $autoWriteTimestamp = true;
    protected $createTime = 'create_time';
    protected $updateTime = false;

    protected $append = [
        'type_text',
        'create_time_text'
    ];

    public function getCreateTimeTextAttr($value,$data){
        return !empty($data['create_time']) ? date('Y-m-d H:i:s',$data['create_time']) : '';
    }

    public function getTypeTextAttr($value,$data){
        $type = ['1' => '固定资产','2' => '损耗品'];
        return !empty($type[$data['goods_type']]) ? $type[$data['goods_type']] : '类型未知';
    }

    public function admin(){
        return $this->hasOne('AdminUser','id','admin_id');
    }

    public function goods(){
        return $this->hasOne('WarehouseGoods','id','goods_id');
    }
}
 
