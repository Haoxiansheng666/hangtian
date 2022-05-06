<?php
namespace app\backend\controller;
use think\Controller;
use think\Db;
use think\Config;
use think\Request;
use app\backend\model\NewsCate;
use app\backend\model\News as N;
use app\backend\model\NewsImg;
use app\backend\logic\NewsLogic;
use app\backend\model\AdminUser;
class News  extends Common
{   
    protected $tableName = 'news_cate';
    protected $tableName1 = 'news';
    protected $tableName2 = 'news_img';

    /** 
     * 新闻分类列表页面
     * @access public 
     * @since dxf 
     * @return [type] 页面
     */
    public function cateIndex(){
        $data=NewsCate::stDate();
        $this->assign('data',$data);
        return  $this->fetch();
    }
    /** 
     * 新闻分类添加和修改页面
     * @access public 
     * @since dxf 
     * @return [type] 页面
     */
    public function cateAdd(){
    	if(var_export(Request::instance()->isAjax(), true)==='true'){
          $model=new NewsCate;
      		$ress=$this->addAction($model);
    	}else{
          $param=input('param.');
          if(isset($param['id']) && !empty($param['id'])){
              $ress= NewsCate::get($param['id']);
          }else{
              $ress=['status'=>1];
          }
          $data=['ress'=>$ress];
          $this->assign('data',$data);
          return  $this->fetch();
      }
    }
    /** 
     * 新闻分类删除
     * @access public 
     * @since dxf 
     * @return [json] 
     */
    public function cateDelete(){
      if(var_export(Request::instance()->isAjax(), true)==='true'){
          $data=$this->dataAction();
          $rr=N::stDate(['cate_id'=>$data['id']]);
          if($rr){
              ajaxReturn($this->errCode('SQLError'), '分类下有新闻，禁止删除！');
          }
          $ress=$this->del($this->tableName);
          return $ress;
       }
    }
    /** 
     * 新闻列表页面
     * @access public 
     * @since dxf 
     * @return [type] 页面
     */
    public function index(){
        $catelist=NewsCate::getAll(['status'=>1]);
        $aulist=AdminUser::all();
        $data=[
            'news_status'=>config('news_status'),
            'catelist'=>$catelist,
            'aulist'=>$aulist,
        ];
        $this->assign('data',$data);
        return  $this->fetch();
    }
    /** 
     * 新闻数据的获取
     * @access public 
     * @since dxf 
     * @return [json]  
     */ 
    public function getData(){
        $model=new N;
        $param=input('param.');
        $where=NewsLogic::selectParam($param,$this->ausess());
        $rs=$model->get_join_list($param,$where);
        layuiReturn($this->errCode('OK'), '获取成功', $rs['count'], $rs['list']);
    }
    /** 
     * 新闻数据删除
     * @access public 
     * @since dxf 
     * @return [json]  
     */
    public function delete(){
      if(var_export(Request::instance()->isAjax(), true)==='true'){
          $ress=$this->del($this->tableName1);
       }
    }
    /** 
     * 新闻添加和修改页面
     * @access public 
     * @since dxf 
     * @return [type] [页面]
     */
    public function add(){
      if(var_export(Request::instance()->isAjax(), true)==='true'){
          $model=new N;
          $ress=$this->addAction($model);
      }else{
          $param=input('param.');
          $catelist=NewsCate::getAll(['status'=>1]);
          if(isset($param['id']) && !empty($param['id'])){
              $ress= N::get($param['id']);
          }else{
              $ress=['status'=>1,'is_new'=>0,'is_hot'=>0,'is_best'=>0,'cate_id'=>''];
          }
          $data=['ress'=>$ress,'catelist'=>$catelist];
          $this->assign('data',$data);
          return  $this->fetch();
      }
    }
    /** 
     * 新闻图集页面
     * @access public 
     * @since dxf 
     * @return [type] [页面]
     */
    public function tuji(){
        $param=input('param.');
        if(isset($param['id']) && !empty($param['id'])){
            $news_detail= N::get($param['id']);
            $ress= NewsImg::getAll(['news_id'=>$param['id']]);
        }else{
            $this->error('页面出错了！');
        }
        $data=['ress'=>$ress,'news_detail'=>$news_detail,'param'=>$param];
        $this->assign('data',$data);
        return  $this->fetch();
    }
    /** 
     * 编辑图集图片信息
     * @access public 
     * @since dxf 
     * @return [type] [页面]
     */
    public function editTuji(){
      if(var_export(Request::instance()->isAjax(), true)==='true'){
          $model=new NewsImg;
          $ress=$this->addAction($model);
      }else{
          $param=input('param.');
          if(isset($param['id']) && !empty($param['id'])){
              $ress= NewsImg::get($param['id']);
          }else{
              $this->error('页面错误！');
          }
          $data=['ress'=>$ress];
          $this->assign('data',$data);
          return  $this->fetch();
      }
    }
    /** 
     * 图片的删除
     * @access public 
     * @since dxf 
     * @return [json]
     */
    public function imgDelete(){
      if(var_export(Request::instance()->isAjax(), true)==='true'){
          $ress=$this->del($this->tableName2);
          return $ress;
      }
    }

    /** 
     * 数据提交之前的操作
     * @access public 
     * @param  array  $data  接收的数据
     * @since dxf 
     * @return [array] 
     */
    protected function before_add($data){

      if(!empty($data['is_new'])){
        $data['is_new']=1;
      }else{
        $data['is_new']=0;
      }
      
      if(!empty($data['is_hot'])){
          $data['is_hot']=1;
      }else{
          $data['is_hot']=0;
      }
      if(!empty($data['is_best'])){
        $data['is_best']=1;
      }else{
        $data['is_best']=0;
      }
        $data['contents'] = $data['test-editormd-html-code'];
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
      if(!empty($data['title'])){
        $contents="添加 / 修改了新闻内容，标题：$data[title]";
      }else{
        $contents="添加 / 修改了新闻分类：$data[name]";
      }
      
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
      if(!empty($data['title'])){
         $contents="删除了新闻内容，标题：$data[title]";
      }else{
         $contents="删除了新闻分类：$data[name]";
      }
      $this->writelog($contents);
    }
}
