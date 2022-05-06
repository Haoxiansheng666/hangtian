<?php
namespace app\backend\controller;
use think\exception\DbException;
use think\Request;
use app\backend\model\ProceedsType as C;
class ProceedsType  extends Common
{
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
    }

    /**
     * 客户列表
     * @access public
     * @return mixed [type] 页面
     * @since dxf
     */
    public function index(){
        return  $this->fetch();
    }

    /**
     * 客户列表数据的获取
     * @access public
     * @return void [json]
     * @throws DbException
     * @since dxf
     */
    public function getData(){
        $model=new C;
        $param=input('param.');
        $rs=$model->paginate($param['limit']);
        layuiReturn($this->errCode('OK'), '获取成功', $rs->total(), $rs->items());
    }

    /**
     * 客户数据的删除
     * @access public
     * @return bool [json]
     * @throws DbException
     * @since dxf
     */
    public function delete(){
      if(var_export(Request::instance()->isAjax(), true)==='true'){
          $p = C::get(input('post.id'));
          if (empty($p)){
              ajaxReturn(404,'数据错误');
          }
          $p->delete();
          $this->success('删除分类成功');
       }else{
          return false;
      }
    }

    /**
     * 客户添加和修改
     * @access public
     * @return mixed [type] 页面
     * @throws DbException
     * @since dxf
     */
    public function add(){
      if(var_export(Request::instance()->isAjax(), true)==='true'){
          $model=new C;
          $ress=$this->addAction($model);
      }else{
          $param=input('param.');
          if(!empty($param['id'])){
              $ress= C::get($param['id']);
          }else{
              $ress=[
                  'cate_id'=>'',
                  'from'=>''
              ];
          }
          $data=['ress'=>$ress];
          $this->assign('data',$data);
          return  $this->fetch();
      }
    }

    /**
     * 数据提交之前的操作
     * @access public
     * @param array $data 接收的数据
     * @return array [array]
     * @since dxf
     */
    protected function before_add($data){
      return $data;
    }
    /** 
     * 数据提交之后的操作
     * @access public 
     * @param  array  $data  接收的数据
     * @since dxf 
     * @return [] 
     */
    protected function after_add($data){
        //更新客户表中的状态和下次提醒时间
        if(!empty($data['customer_id']) && !empty($data['cate_id'])){
          $model=new C;
          $updata['id']=$data['customer_id'];
          $updata['cate_id']=$data['cate_id'];
          $updata['warn_time']=strtotime($data['warn_time']);
          $ress=$model->update_data($updata);
        }
    }
    /** 
     * 数据提交之后写入数据库
     * @access public 
     * @param  array  $data  接收的数据
     * @since dxf 
     * @return [] 
     */
    protected function write_log($data){
        $contents="添加 / 修改了支付方式，名称：".$data['title'];
      $this->writelog($contents);
      
    }
    /** 
     * 数据删除之后的操作
     * @access public 
     * @param  array  $data  数据
     * @since dxf 
     * @return [] 
     */
    protected function after_del($data){
        $contents="删除了支付方式，名称：".$data['title'];
      $this->writelog($contents);
    }



}
