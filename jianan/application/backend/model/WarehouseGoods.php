<?php
namespace app\backend\model;
use think\Model;
use think\Request;
use think\Db;
class WarehouseGoods extends BaseModel
{
    protected $autoWriteTimestamp = true;
    protected $createTime = 'create_time';
    protected $updateTime = false;

    protected $append = [
        'type_text',
        'create_time_text'
    ];

    public function get_join_list($param,$where=[]){
        $res =  $this
            ->with('admin')
            ->where($where)
            ->where('ware_id',$param['id'])
            ->where('is_delete',1)
            ->order('id DESC')
            ->paginate($param['limit']);
        return [
            'count' => $res->total(),
            'list' => $res->items()
        ];
    }

    public function getTypeTextAttr($value,$data){
        $type = ['1' => '固定资产','2' => '损耗品'];
        return !empty($type[$data['type']]) ? $type[$data['type']] : '类型未知';
    }

    public function getCreateTimeTextAttr($value,$data){
        return !empty($data['create_time']) ? date('Y-m-d H:i:s',$data['create_time']) : '';
    }

    public function admin(){
        return $this->hasOne('AdminUser','id','admin_id');
    }
}
 
