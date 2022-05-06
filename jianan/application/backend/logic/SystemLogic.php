<?php
namespace app\backend\logic;
use think\Db;
use think\Request;
class SystemLogic 
{   
    /**
     * 登录日志查询的逻辑
     * @access public 
     * @param array   $param 条件数据
     * @param array   $ausess 账号的session信息
     * @since dxf 
     * @return [array]
     */
	static public  function selectParam($param,$ausess){
        $where= [];
        if(isset($param['admin_name']) && !empty($param['admin_name'])){
            $where['au.admin_name']=array('like',"%$param[admin_name]%");
        }
        $zdy_rule=config('zdy_rule');
        //用户等级参数处理
        if($ausess['group_role']==1){
            if($zdy_rule==5){
                $where['log.auid']=$ausess['auid'];
            }
        }elseif($ausess['group_role']==2){
            if($zdy_rule==3){
                $where['log.group_id']=$ausess['group_id'];
            }elseif($zdy_rule==4){
                $where['log.group_id']=$ausess['group_id'];
            }elseif($zdy_rule==5){
                $where['log.auid']=$ausess['auid'];
            }
        }elseif($ausess['group_role']==3){
            if($zdy_rule==2){
                $where['log.auid']=$ausess['auid'];
            }elseif($zdy_rule==3){
                $where['log.group_id']=$ausess['group_id'];
            }elseif($zdy_rule==4){
                $where['log.auid']=$ausess['auid'];
            }elseif($zdy_rule==5){
                $where['log.auid']=$ausess['auid'];
            }
        }
        if ($ausess['group_id'] != 1){
            $where['log.auid'] = $ausess['auid'];
        }
        return ['where'=>$where,'param'=>$param];
    }
    /**
     * 操作日志查询的逻辑
     * @access public 
     * @param array   $param 条件数据
     * @param array   $ausess 账号的session信息
     * @since dxf 
     * @return [array]
     */
    static public  function selectAct($param,$ausess){
        $where= [];
        if(isset($param['admin_name']) && !empty($param['admin_name'])){
            $where['au.admin_name']=array('like',"%$param[admin_name]%");
        }
        if(isset($param['content']) && !empty($param['content'])){
            $where['log.content']=array('like',"%$param[content]%");
        }
        $zdy_rule=config('zdy_rule');
        //用户等级参数处理
        if($ausess['group_role']==1){
            if($zdy_rule==5){
                $where['log.auid']=$ausess['auid'];
            }
        }elseif($ausess['group_role']==2){
            if($zdy_rule==3){
                $where['log.group_id']=$ausess['group_id'];
            }elseif($zdy_rule==4){
                $where['log.group_id']=$ausess['group_id'];
            }elseif($zdy_rule==5){
                $where['log.auid']=$ausess['auid'];
            }
        }elseif($ausess['group_role']==3){
            if($zdy_rule==2){
                $where['log.auid']=$ausess['auid'];
            }elseif($zdy_rule==3){
                $where['log.group_id']=$ausess['group_id'];
            }elseif($zdy_rule==4){
                $where['log.auid']=$ausess['auid'];
            }elseif($zdy_rule==5){
                $where['log.auid']=$ausess['auid'];
            }
        }
        if ($ausess['group_id'] != 1){
            $where['log.auid'] = $ausess['auid'];
        }
        return ['where'=>$where,'param'=>$param];
    }
   
}
 

