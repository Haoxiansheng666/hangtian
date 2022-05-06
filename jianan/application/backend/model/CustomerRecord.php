<?php
namespace app\backend\model;
use think\Model;
class CustomerRecord extends BaseModel
{   

    protected $tableName = 'customer_record';

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
    //模型关联客户分类
    public function hasCate()
    {
        return $this->hasOne('customer_cate','id','cate_id')->field('name,color');
    }
    /**
     * 客户回访记录数据
     * @access public 
     * @param array   $where 查询条件
     * @param string   $ord  排序
     * @param string   $perPage  每页大小
     * @since dxf 
     * @return [obj]
     */
    static public function stDate($where=[],$ord="status desc,ord desc,id desc",$perPage=15){
        $ress=CustomerRecord::where($where)->order($ord)->paginate($perPage);
        return $ress;
    }
   
    /**
     * 全部客户回访数据
     * @access public 
     * @param array   $where 查询条件
     * @param string   $ord  排序
     * @since dxf 
     * @return [obj]
     */
    static public function getAll($where=[],$ord="id desc"){
        $ress=CustomerRecord::where($where)->order($ord)->select();
        return $ress;
    }
    
     
}
 
