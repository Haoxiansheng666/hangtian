<?php
namespace app\backend\model;
use think\Model;
use think\Db;
use think\Session;
use think\Request;
use app\backend\model\Config;
use app\backend\model\AdminPwdcount;
class AdminUser extends Model
{   
    //类型转换
	protected $type = array(
        'created_time' => 'timestamp:Y-m-d H:i:s',
        'login_time' => 'timestamp:Y-m-d H:i:s',
    );
    //自动写入
    protected $insert = array(
       'created_time',
    );
    //自动更新
    protected $update = array(
       'login_time',
    );
    //写入当前创建时间
    protected function setcreatedTimeAttr()
    {
        return time();
    }
    //写入当前登录时间
    protected function setloginTimeTAttr()
    {
        return time();
    }
    //关联部门表
    public function hasGroupone()
    {
        return $this->hasOne('AuthGroup','id','group_id')->field('group_name,rules');
    }
    public function hasCampus()
    {
        return $this->hasOne('Campus','id','campus_id');
    }
    public function hasDepartment()
    {
        return $this->hasOne('AdminDepartment','id','department_id');
    }
    
    /**
     * 密码修改
     * @access public 
     * @param array   $data 提交的数据
     * @param array   $ausess 账号的session信息
     * @since dxf 
     * @return [json]
     */
    public function pwdaction($data,$ausess){
        $adminu=new AdminUser;
        $auress=$adminu->where('id', $ausess['auid'])->find();
        $pwd=password_encrypt($data['admin_password'], config('salt_admin'));
        if($auress['admin_password']!=$pwd){
            return ['status'=>0,'msg'=>'原密码错误！'];
        }
        if($data['pass']!=$data['repass']){
            return ['status'=>0,'msg'=>'两次输入的密码不一致！'];
        }
        $admin_password=password_encrypt($data['repass'],config('salt_admin'));
        if($adminu->save(['admin_password'=>$admin_password],['id'=>$ausess['auid']])){
            ajaxReturn(0, '密码修改成功');
        }else{
            ajaxReturn(2, '密码修改失败');

        }
    }

    /**
     * 用户登录处理
     * @access public 
     * @param array   $postdata 提交的数据
     * @since dxf 
     * @return [json]
     */
    public function loginAction($postdata){
        $ip=Request::instance()->ip();
        $ress= Db::name('admin_user')->where(['admin_name'=>$postdata['admin_name']])->find();
        if($ress){
            //账号被锁定提示
            if($ress['status']==0){
                return ['status'=>0,'msg'=>'账号被锁定，请联系管理员！'];
            }
            //密码错误
            $pwd=password_encrypt($postdata['admin_password'], config('salt_admin'));
            if($ress['admin_password']!=$pwd){
                //密码错误次数处理
                $pwdstatus=$this->pwdcount($ip,$postdata['admin_name']);
                if($pwdstatus['status']=='off'){
                    return ['status'=>0,'msg'=>'登陆账号错误次数超过五次，账号被锁定！'];
                }elseif($pwdstatus['status']=='on'){
                    $msg='账号或密码错误！,剩余登陆次数 '.$pwdstatus['count'].'次';
                    return ['status'=>2,'msg'=>$msg,'count'=>$pwdstatus['count']];
                }
            }
            //处理session
            $this->ausess($ress['id']);
            $data['login_time']=time();
            $result=Db::name('admin_user')->where('id', $ress['id'])->update($data);
            if($result){
                //登陆日志
                $this->signinlog($ress['id'],$ress['group_id']);
                AdminPwdcount::where('admin_name',$postdata['admin_name'])->delete();//删除错误登录次数信息
                return ['status'=>1,'msg'=>'登录成功！'];
            }else{
                return ['status'=>0,'msg'=>'登录失败！'];
            }
        }else{
            return ['status'=>0,'msg'=>'账号不存在！'];
        }
    }
    
    /**
     * 用户登录SEESION存入
     * @access public 
     * @param string   $auid 用户id
     * @since dxf 
     * @return []
     */
    public function ausess($auid){
        $adminu=new AdminUser;
        $auress=$adminu->where('id', $auid)->find();
        $where['id']=array('in',$auress->hasGroupone->rules);
        $where['left_nav']=1;
        $nav=Db::name('auth_rule')
            ->where($where)
            ->order('ord')
            ->select();
        $navlist=navList($nav);
        $login_ip=Request::instance()->ip();
        $ausess=[
          'auid'=>$auress->id,
          'campus_id'=>$auress->campus_id,
          'department_id'=>$auress->department_id,
          'group_id'=>$auress->group_id,
          'admin_name'=>$auress->admin_name,
          'real_name'=>$auress->real_name,
          'group_name'=>$auress->hasGroupone->group_name,
          'rules'=>$auress->hasGroupone->rules,
          'navlist'=>$navlist,
          'group_role'=>$auress->group_role,
          'login_ip'=>$login_ip,
          'login_time'=>date('Y-m-d H:i:s'),
        ];
        Session::set('ausess',$ausess);
    }
   
    /**
     * 密码错误次数处理
     * @access public 
     * @param int   $ip 用户ip
     * @param string   $admin_name 登录名称
     * @since dxf 
     * @return [array]
     */
    public function pwdcount($ip,$admin_name){
        $pwdress=AdminPwdcount::get(['admin_name' => $admin_name]);
        if($pwdress){
            if($pwdress['count_time']>4){
                $data['status']=0;
                Db::name('admin_user')->where('admin_name', $admin_name)->update($data);
                return ['status'=>'off'];
            }else{
                $pwdress->setInc('count_time',1);
                $count=5-$pwdress['count_time'];
                return ['count'=>$count,'status'=>'on'];
            }
        }else{
            AdminPwdcount::create([
                'login_ip'=>$ip,
                'admin_name' =>$admin_name,
                'count_time'=>1,
                'updated_t'=>time()
            ]);
            return ['count'=>4,'status'=>'on'];

        }
    }

    /**
     * 登录后日志存入
     * @access public 
     * @param int   $auid 用户id
     * @param string   $content 内容
     * @since dxf 
     * @return []
     */
    public function signinlog($auid,$group_id,$content='登录后台操作！'){
        $data=array(
            'auid'=>$auid,
            'group_id'=>$group_id,
            'login_time'=>time(),
            'ip'=>Request::instance()->ip()
        );
        Db::name('login_log')->insert($data);
    }

    /**
     * 员工数据
     * @access public 
     * @param array   $where 查询条件
     * @since dxf 
     * @return [obj]
     */
    static public function stDate($where){
        $ress=AdminUser::where($where)
            ->order('id desc')
            ->paginate(15,false, [
                'query' => request()->param()
            ]);
        return $ress;
    }
}
 

