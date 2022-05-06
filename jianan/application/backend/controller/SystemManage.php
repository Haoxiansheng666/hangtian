<?php
namespace app\backend\controller;
use think\Controller;
use think\Db;
use think\Request;
use app\backend\model\LoginLog;
use app\backend\logic\SystemLogic;
class SystemManage  extends Common
{      

    /** 
     * 登录日志
     * @access public 
     * @since dxf 
     * @return [type]  页面
     */
    public function loginlog(){
        $param=input('param.');
        $where=SystemLogic::selectParam($param,$this->ausess());
        $data=Db::name('login_log')->alias('log')
            ->join('admin_user au','log.auid=au.id','LEFT')
            ->field('log.*,au.admin_name')
            ->where($where['where'])
            ->order('log.id DESC')
            ->paginate(30,false, ['query' => request()->param()]);
        $this->assign('data',$data);
        $this->assign('param',$param);
        return  $this->fetch();
    }

    /** 
     * 操作日志
     * @access public 
     * @since dxf 
     * @return [type]  页面
     */
    public function actionLog(){
        $param=input('param.');
        $where=SystemLogic::selectAct($param,$this->ausess());
        $data=Db::name('log')->alias('log')
            ->join('admin_user au','log.auid=au.id','LEFT')
            ->field('log.*,au.admin_name')
            ->where($where['where'])
            ->order('log.id DESC')
            ->paginate(30,false, ['query' => request()->param()]);
        $this->assign('data',$data);
        $this->assign('param',$param);
        return  $this->fetch();
    }


    
   
}
