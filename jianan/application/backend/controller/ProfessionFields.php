<?php
namespace app\backend\controller;
use think\exception\DbException;
use think\Request;
use app\backend\model\ProfessionFields as C;
class ProfessionFields  extends Common
{
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
    }

    /**
     * 报名资料列表
     * @access public
     * @return mixed [type] 页面
     * @since dxf
     */
    public function index(){
        return $this->fetch();
    }

    /**
     * 报名资料列表数据的获取
     * @access public
     * @return void [json]
     * @throws DbException
     * @since dxf
     */
    public function getData(){
        $model=new C;
        $param=input('param.');
        $rs=$model->order('id DESC')->paginate($param['limit']);
        layuiReturn($this->errCode('OK'), '获取成功', $rs->total(), $rs->items());
    }

    /**
     * 报名资料数据的删除
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
     * 报名资料添加和修改
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
    }
    /** 
     * 数据提交之后写入数据库
     * @access public 
     * @param  array  $data  接收的数据
     * @since dxf 
     * @return [] 
     */
    protected function write_log($data){
        $contents="添加 / 修改了报名资料，名称：".$data['title'];
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
        $contents="删除了报名资料，名称：".$data['title'];
      $this->writelog($contents);
    }



}
