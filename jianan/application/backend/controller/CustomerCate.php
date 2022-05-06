<?php
namespace app\backend\controller;
use think\Controller;
use think\Db;
use think\Config;
use think\exception\DbException;
use think\Request;
use app\backend\model\CustomerCate as CC;
use app\backend\model\CustomerFrom;
use app\backend\model\CustomerRecord;
use app\backend\model\Customer as C;
use app\backend\logic\CustomerLogic;
use app\backend\model\AdminUser;
class CustomerCate extends Common
{

    /** 
     * 客户分类页面
     * @access public 
     * @since dxf 
     * @return [type] 页面 
     */ 
    public function index(){
        $data=CC::stDate();
        $this->assign('data',$data);
        return  $this->fetch();
    }

    /**
     * 客户分类添加修改页面
     * @access public
     * @return mixed|void [type] 页面
     * @throws DbException
     * @since dxf
     */
    public function add(){
    	if(var_export(Request::instance()->isAjax(), true)==='true'){
          $model=new CC();
      		$ress=$this->addAction($model);
    	}else{
          $param=input('param.');
          if(isset($param['id']) && !empty($param['id'])){
              $ress= CC::get($param['id']);
          }else{
              $ress=['status'=>1];
          }
          $data=['ress'=>$ress];
          $this->assign('data',$data);
          return  $this->fetch();
      }
    }

    /**
     * 删除
     * @throws DbException
     */
    public function del_data(){
        $id = input('id');
        $customer = C::get([
            'cate_id' => $id
        ]);
        if(!empty($customer)){
            $this->error('该分类下有客户，请转移客户后再删除');
        }
        CC::destroy([
            'id' => $id
        ]);
        $this->success('删除成功');
    }

    public function before_add($data){
        return $data;
    }

    public function write_log(){

    }
    public function after_add(){

    }
}
