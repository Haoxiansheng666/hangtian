<?php
namespace app\backend\controller;
use think\exception\DbException;
use think\Request;
use app\backend\model\CustomerSource as CC;
use app\backend\model\Customer as C;
class CustomerSource extends Common
{

    /** 
     * 客户分类页面
     * @access public 
     * @since dxf 
     * @return [type] 页面 
     */ 
    public function index(){
        $data = (new CC())
        ->paginate(15);
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
      		$param = $this->request->param();
      		if (!empty($param['id'])){
      		    $model = CC::get($param['id']);
      		    unset($param['id']);
            }
      		$res = $model->allowField(true)->save($param);
      		if ($res !== false){
                $this->success('信息修改成功');
            }else{
      		    $this->error('方法请求错误');
            }
    	}else{
          $param=input('param.');
          if(isset($param['id']) && !empty($param['id'])){
              $ress= CC::get($param['id']);
          }else{
              $ress=[];
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
        $customer = CC::get($id);
        $customer->delete();
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
