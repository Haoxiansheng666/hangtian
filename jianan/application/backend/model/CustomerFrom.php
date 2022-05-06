<?php
namespace app\backend\model;
use think\Model;
class CustomerFrom extends BaseModel
{   

    protected $tableName = 'customer_from';
    protected $order = "status desc,ord desc,id desc";

    // 类型转换
    protected $type = array(
        'ctime' => 'timestamp:Y-m-d H:i:s',
        'uptime'=> 'timestamp:Y-m-d H:i:s'
    );
    protected $insert = array(
       'ctime',
    );
    protected $update = array(
       'uptime',
    );
    protected function setCtimeAttr()
    {
        return time();
    }
    protected function setUptimeAttr()
    {
        return time();
    }

    //模型关联
    public function hasGroupone()
    {
        return $this->hasOne('AuthGroup','id','group_id')->field('group_name,rules');
    }
    public function hasAuone()
    {
        return $this->hasOne('AdminUser','id','auid')->field('real_name');
    }
    
    //查询数据1 
    static public function stDate($where='1=1',$ord="status desc,ord desc,id desc",$perPage=15){
        $ress=CustomerFrom::where($where)->order($ord)->paginate($perPage);
        return $ress;
    }
   

    //获取所有数据
    static public function getAll($where='1=1',$ord="status desc,ord desc,id desc"){
        $ress=CustomerFrom::where($where)->order($ord)->select();
        return $ress;
    }
    
     
}
 
