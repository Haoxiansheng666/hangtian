<?php
namespace app\backend\logic;
use think\Db;
use think\Request;
class NewsLogic 
{   
    /**
     * 新闻查询的逻辑
     * @access public 
     * @param array   $param 条件数据
     * @param array   $ausess 账号的session信息
     * @since dxf 
     * @return [array]
     */
	static public  function selectParam($param,$ausess){
        $where='';
        //新闻标题
        if(isset($param['title']) && !empty($param['title'])){
            $where['t.title']=array('like',"%$param[title]%");
        }
        //类别id
        if(isset($param['cate_id']) && !empty($param['cate_id'])){
            $where['t.cate_id']=$param['cate_id'];
        }
        //状态
        if(isset($param['status']) && !empty($param['status'])){
            $where['t.status']=$param['status'];
        }
        //添加人
        if(isset($param['auid']) && !empty($param['auid'])){
            $where['t.auid']=$param['auid'];
        }

        $zdy_rule=config('zdy_rule');
        //用户等级参数处理
        if($ausess['group_role']==1){
            if($zdy_rule==5){
                $where['t.auid']=$ausess['auid'];
            }
        }elseif($ausess['group_role']==2){
            if($zdy_rule==3){
                $where['t.group_id']=$ausess['group_id'];
            }elseif($zdy_rule==4){
                $where['group_id']=$ausess['group_id'];
            }elseif($zdy_rule==5){
                $where['t.auid']=$ausess['auid'];
            }
        }elseif($ausess['group_role']==3){
            if($zdy_rule==2){
                $where['t.auid']=$ausess['auid'];
            }elseif($zdy_rule==3){
                $where['t.group_id']=$ausess['group_id'];
            }elseif($zdy_rule==4){
                $where['t.auid']=$ausess['auid'];
            }elseif($zdy_rule==5){
                $where['t.auid']=$ausess['auid'];
            }
        }
        return $where;
    }
   
}
 

