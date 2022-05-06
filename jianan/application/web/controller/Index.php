<?php
namespace app\web\controller;
use think\Controller;
use think\Db;
use think\Session;
use think\Request;
use app\backend\model\News as N;
class Index extends Common
{   
    public function index()
    {
        $res= getSystemInfo();
        //$this->redirect('/backend/login');
        //return $this->fetch();
    }
    public function details()
    {	
        $param=input('param.');
        $model=new N;
        $data=N::get($param['id']);
        if($data){
            //浏览量+1
            Db::name('news')->where('id',$data['id'])->setInc('num');
            $this->assign('data',$data);
            return $this->fetch();
        }else{
            $this->error('暂无数据！');
        }
    }
    public function getData(){
        
        $param=input('param.');
        $model=new N;
        $rs=$model->get_join_list($param);
        layuiReturn($this->errCode('OK'), '获取成功', $rs['count'], $rs['list']);
    }

}
