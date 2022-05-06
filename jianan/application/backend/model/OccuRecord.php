<?php
namespace app\backend\model;
use think\Model;
class OccuRecord extends BaseModel
{

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
     * 客户退款记录数据
     * @param array $where
     * @param string $ord
     * @param int $perPage
     * @return \think\Paginator
     * @throws \think\exception\DbException
     */
    static public function stDate($where=[],$ord="status desc,ord desc,id desc",$perPage=15){
        $ress = OccuRecord::where($where)->order($ord)->paginate($perPage);
        return $ress;
    }
     
}
 
