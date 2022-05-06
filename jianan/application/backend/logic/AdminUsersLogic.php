<?php
namespace app\backend\logic;
use think\Db;
use think\Request;
class AdminUsersLogic 
{   
    /**
     * 账号查询的逻辑
     * @access public 
     * @param array   $ausess 账号的session信息
     * @since dxf 
     * @return [array]
     */
	static public  function selectParam($ausess){
        $where = [];
        $param=input('param.');
        //部门
        if(isset($param['group_id']) && !empty($param['group_id'])){
            $where['group_id']=$param['group_id'];
        }else{
            $param['group_id']='';
        }
        if(isset($param['campus_id']) && !empty($param['campus_id'])){
            $where['campus_id']=$param['campus_id'];
        }else{
            $param['campus_id']='';
        }
        if(isset($param['department_id']) && !empty($param['department_id'])){
            $where['department_id']=$param['department_id'];
        }else{
            $param['department_id']='';
        }
        //真实名称
        if(isset($param['real_name']) && !empty($param['real_name'])){
            $where['real_name']=array('like',"%$param[real_name]%");
        }
        //登陆账号
        if(isset($param['admin_name']) && !empty($param['admin_name'])){
            $where['admin_name']=array('like',"%$param[admin_name]%");
        }
        //手机
        if(isset($param['mobile']) && !empty($param['mobile'])){
            $where['mobile']=$param['mobile'];
        }
        //用户等级参数处理
        if($ausess['group_role']==1){
        }elseif($ausess['group_role']==2){
            $where['group_id']=$ausess['group_id'];
        }elseif($ausess['group_role']==3){
            $where['group_id']=$ausess['group_id'];
        }
        return ['where'=>$where,'param'=>$param];
    }
   
}
 

