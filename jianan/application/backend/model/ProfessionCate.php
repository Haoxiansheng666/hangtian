<?php
namespace app\backend\model;
use think\Model;
class ProfessionCate extends BaseModel
{   

    protected $tableName = 'customer_cate';
    protected $order = "status desc,ord desc,id desc";

    // 类型转换
    protected $type = array(
        'create_time' => 'timestamp:Y-m-d H:i:s'
    );
    //自动写入
    protected $insert = array(
       'create_time',
    );
    //自动更新
    protected $update = array(

    );
    //写入当前创建时间
    protected function setCreateTimeAttr()
    {
        return time();
    }

    //模型关联部门
    public function hasGroupone()
    {
        return $this->hasOne('AuthGroup','id','group_id')->field('group_name,rules');
    }
    //模型关联员工
    public function hasAuone()
    {
        return $this->hasOne('AdminUser','id','auid')->field('real_name');
    }
    
    /**
     * 客户分类数据
     * @access public 
     * @param array   $where 查询条件
     * @param string   $ord  排序
     * @param string   $perPage  每页大小
     * @since dxf 
     * @return [obj]
     */
    static public function stDate($where='1=1',$ord="ord desc,status desc,id desc",$perPage=15){
        $ress=CustomerCate::where($where)->order($ord)->paginate($perPage);
        return $ress;
    }
   
    /**
     * 全部客户分类数据
     * @access public 
     * @param array   $where 查询条件
     * @param string   $ord  排序
     * @since dxf 
     * @return [obj]
     */
    static public function getAll($where='1=1',$ord="status desc,ord desc,id desc"){
        $ress=CustomerCate::where($where)->order($ord)->select();
        return $ress;
    }
    
     
}
 
