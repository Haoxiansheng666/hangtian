<?php
namespace app\backend\controller;
use think\Request;
use think\Controller;
use think\Db;
use think\Session;
use app\backend\model\AdminUser;
class Login  extends Controller
{
    /** 
     * 后台登录
     * @access public 
     * @since dxf 
     * @return [type] 页面 
     */ 
    public function index(){
        //查看是否登录
        $ausess= Session::get('ausess');
        if($ausess['auid']){
            echo '<script>parent.location.href="http://'.$_SERVER['HTTP_HOST'].'/backend/index";</script>';
            die;
        }

      $this->assign('config',tpCache());
      return  $this->fetch('two');
    }
    /** 
     * 页面缺失
     * @access public 
     * @since dxf 
     * @return [type] 页面 
     */
    public function notfound(){
        return  $this->fetch();
    }
    /** 
     * 登录的处理
     * @access public 
     * @since dxf 
     * @return [json]  
     */
    public function dologin(){
      $postdata=Request::instance()->post(); // 获取post变量1 
      if(!$this->check_verify($postdata['yzm'])){
          return  ['status'=>0,'msg'=>'验证码不正确,请刷新验证码！'];
      };
      $adminu=new AdminUser;
      $ress=$adminu->loginAction($postdata);
      return $ress;
    }
    /** 
     * 退出登录
     * @access public 
     * @since dxf 
     * @return []  
     */
  	public function loginout(){
        session('ausess',NULL);
        return json(['code'=>1,'msg'=>'退出登录成功']);
    }
  	public function check_error(){
  		 return $this->error("没有权限",U('backend/index/welcome'),2);
  	}
    /** 
     * 验证码
     * @access public 
     * @since dxf 
     * @return [json]  
     */
    public function captcha(){
      $config =    [
        'fontSize'    =>    20,    
        'length'      =>    4,
        'codeSet'    =>'0123456789',
        'useNoise'    =>    true, 
        'useCurve'=>    false, 
        'imageH'=>40
      ];        
      $captcha = new \think\captcha\Captcha($config);
      return $captcha->entry();
    }
    /** 
     * 验证码检验
     * @access public 
     * @since dxf 
     * @return [json]  
     */
    public function check_verify($code, $id = ''){
        $captcha = new \think\captcha\Captcha();
        return $captcha->check($code, $id);
    }

    
}
