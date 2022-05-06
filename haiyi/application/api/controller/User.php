<?php

namespace app\api\controller;

use app\api\model\Focus;
use app\api\model\Forum;
use app\api\model\ForumFavor;
use app\api\model\GoodsFavor;
use app\api\model\MoneyLog;
use app\api\model\Withdraw;
use app\api\model\Zan;
use app\common\controller\Api;
use app\common\library\Ems;
use app\common\library\Sms;
use app\api\model\ScoreLog;
use fast\Random;
use think\Config;
use think\Validate;
use function fast\e;

/**
 * 会员接口
 */
class User extends Api
{
    protected $noNeedLogin = ['login', 'mobilelogin', 'register', 'resetpwd', 'changeemail', 'changemobile', 'third'];
    protected $noNeedRight = '*';

    public function _initialize()
    {
        parent::_initialize();

        if (!Config::get('fastadmin.usercenter')) {
            $this->error(__('User center already closed'));
        }

    }

    /**
     * 会员中心
     */
    public function index()
    {
        $this->success('', ['welcome' => $this->auth->nickname]);
    }

    /**
     * 会员登录
     * @ApiMethod (POST)
     * @param string $account  账号
     * @param string $password 密码
     */
    public function login()
    {
        $account = $this->request->post('account');
        $password = $this->request->post('password');
        if (!$account || !$password) {
            $this->error(__('Invalid parameters'));
        }
        $ret = $this->auth->login($account, $password);
        if ($ret) {
            $data = ['userinfo' => $this->auth->getUserinfo()];
            $this->success(__('Logged in successful'), $data);
        } else {
            $this->error($this->auth->getError());
        }
    }

    /**
     * 手机验证码登录
     * @ApiMethod (POST)
     * @param string $mobile  手机号
     * @param string $captcha 验证码
     */
    public function mobilelogin()
    {
        $mobile = $this->request->post('mobile');
        $captcha = $this->request->post('captcha');
        if (!$mobile || !$captcha) {
            $this->error(__('Invalid parameters'));
        }
        if (!Validate::regex($mobile, "^1\d{10}$")) {
            $this->error(__('Mobile is incorrect'));
        }
        if (!Sms::check($mobile, $captcha, 'mobilelogin')) {
            $this->error(__('Captcha is incorrect'));
        }
        $user = \app\common\model\User::getByMobile($mobile);
        if ($user) {
            if ($user->status != 'normal') {
                $this->error(__('Account is locked'));
            }
            //如果已经有账号则直接登录
            $ret = $this->auth->direct($user->id);
        } else {
            $ret = $this->auth->register($mobile, Random::alnum(), '', $mobile, []);
        }
        if ($ret) {
            Sms::flush($mobile, 'mobilelogin');
            $data = ['userinfo' => $this->auth->getUserinfo()];
            $this->success(__('Logged in successful'), $data);
        } else {
            $this->error($this->auth->getError());
        }
    }

    /**
     * 注册会员
     * @ApiMethod (POST)
     * @param string $username 用户名
     * @param string $password 密码
     * @param string $email    邮箱
     * @param string $mobile   手机号
     * @param string $code     验证码
     */
    public function register()
    {
        $username = $this->request->post('username');
        $password = $this->request->post('password');
        $email = $this->request->post('email');
        $mobile = $this->request->post('mobile');
        $code = $this->request->post('code');
        if (!$username || !$password) {
            $this->error(__('Invalid parameters'));
        }
        if ($email && !Validate::is($email, "email")) {
            $this->error(__('Email is incorrect'));
        }
        if ($mobile && !Validate::regex($mobile, "^1\d{10}$")) {
            $this->error(__('Mobile is incorrect'));
        }
        $ret = Sms::check($mobile, $code, 'register');
        if (!$ret) {
            $this->error(__('Captcha is incorrect'));
        }
        $ret = $this->auth->register($username, $password, $email, $mobile, []);
        if ($ret) {
            $data = ['userinfo' => $this->auth->getUserinfo()];
            $this->success(__('Sign up successful'), $data);
        } else {
            $this->error($this->auth->getError());
        }
    }

    /**
     * 退出登录
     * @ApiMethod (POST)
     */
    public function logout()
    {
        if (!$this->request->isPost()) {
            $this->error(__('Invalid parameters'));
        }
        $this->auth->logout();
        $this->success(__('Logout successful'));
    }

    /**
     * 修改会员个人信息
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function profile()
    {
        $user = $this->auth->getUser();
        $username = $this->request->post('username');
        $nickname = $this->request->post('nickname');
        $bio = $this->request->post('bio');
        $avatar = $this->request->post('avatar', '', 'trim,strip_tags,htmlspecialchars');
        if ($username) {
            $exists = \app\common\model\User::where('username', $username)->where('id', '<>', $this->auth->id)->find();
            if ($exists) {
                $this->error(__('Username already exists'));
            }
            $user->username = $username;
        }
        if ($nickname) {
            $exists = \app\common\model\User::where('nickname', $nickname)->where('id', '<>', $this->auth->id)->find();
            if ($exists) {
                $this->error(__('Nickname already exists'));
            }
            $user->nickname = $nickname;
        }
        $user->bio = $bio;
        $user->avatar = $avatar;
        $user->save();
        $this->success();
    }

    /**
     * 修改邮箱
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function changeemail()
    {
        $user = $this->auth->getUser();
        $email = $this->request->post('email');
        $captcha = $this->request->post('captcha');
        if (!$email || !$captcha) {
            $this->error(__('Invalid parameters'));
        }
        if (!Validate::is($email, "email")) {
            $this->error(__('Email is incorrect'));
        }
        if (\app\common\model\User::where('email', $email)->where('id', '<>', $user->id)->find()) {
            $this->error(__('Email already exists'));
        }
        $result = Ems::check($email, $captcha, 'changeemail');
        if (!$result) {
            $this->error(__('Captcha is incorrect'));
        }
        $verification = $user->verification;
        $verification->email = 1;
        $user->verification = $verification;
        $user->email = $email;
        $user->save();

        Ems::flush($email, 'changeemail');
        $this->success();
    }

    /**
     * 修改手机号
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function changemobile()
    {
        $user = $this->auth->getUser();
        $mobile = $this->request->post('mobile');
        $captcha = $this->request->post('captcha');
        if (!$mobile || !$captcha) {
            $this->error(__('Invalid parameters'));
        }
        if (!Validate::regex($mobile, "^1\d{10}$")) {
            $this->error(__('Mobile is incorrect'));
        }
        if (\app\common\model\User::where('mobile', $mobile)->where('id', '<>', $user->id)->find()) {
            $this->error(__('Mobile already exists'));
        }
        $result = Sms::check($mobile, $captcha, 'changemobile');
        if (!$result) {
            $this->error(__('Captcha is incorrect'));
        }
        $verification = $user->verification;
        $verification->mobile = 1;
        $user->verification = $verification;
        $user->mobile = $mobile;
        $user->save();

        Sms::flush($mobile, 'changemobile');
        $this->success();
    }

    /**
     * 第三方登录
     * @ApiMethod (POST)
     * @param string $platform 平台名称
     * @param string $code     Code码
     */
    public function third()
    {
        $url = url('user/index');
        $platform = $this->request->post("platform");
        $code = $this->request->post("code");
        $config = get_addon_config('third');
        if (!$config || !isset($config[$platform])) {
            $this->error(__('Invalid parameters'));
        }
        $app = new \addons\third\library\Application($config);
        //通过code换access_token和绑定会员
        $result = $app->{$platform}->getUserInfo(['code' => $code]);
        if ($result) {
            $loginret = \addons\third\library\Service::connect($platform, $result);
            if ($loginret) {
                $data = [
                    'userinfo'  => $this->auth->getUserinfo(),
                    'thirdinfo' => $result
                ];
                $this->success(__('Logged in successful'), $data);
            }
        }
        $this->error(__('Operation failed'), $url);
    }

    /**
     * 重置密码
     * @ApiMethod (POST)
     * @param string $mobile      手机号
     * @param string $newpassword 新密码
     * @param string $captcha     验证码
     */
    public function resetpwd()
    {
        $type = $this->request->post("type");
        $mobile = $this->request->post("mobile");
        $email = $this->request->post("email");
        $newpassword = $this->request->post("newpassword");
        $captcha = $this->request->post("captcha");
        if (!$newpassword || !$captcha) {
            $this->error(__('Invalid parameters'));
        }
        //验证Token
        if (!Validate::make()->check(['newpassword' => $newpassword], ['newpassword' => 'require|regex:\S{6,30}'])) {
            $this->error(__('Password must be 6 to 30 characters'));
        }
        if ($type == 'mobile') {
            if (!Validate::regex($mobile, "^1\d{10}$")) {
                $this->error(__('Mobile is incorrect'));
            }
            $user = \app\common\model\User::getByMobile($mobile);
            if (!$user) {
                $this->error(__('User not found'));
            }
            $ret = Sms::check($mobile, $captcha, 'resetpwd');
            if (!$ret) {
                $this->error(__('Captcha is incorrect'));
            }
            Sms::flush($mobile, 'resetpwd');
        } else {
            if (!Validate::is($email, "email")) {
                $this->error(__('Email is incorrect'));
            }
            $user = \app\common\model\User::getByEmail($email);
            if (!$user) {
                $this->error(__('User not found'));
            }
            $ret = Ems::check($email, $captcha, 'resetpwd');
            if (!$ret) {
                $this->error(__('Captcha is incorrect'));
            }
            Ems::flush($email, 'resetpwd');
        }
        //模拟一次登录
        $this->auth->direct($user->id);
        $ret = $this->auth->changepwd($newpassword, '', true);
        if ($ret) {
            $this->success(__('Reset password successful'));
        } else {
            $this->error($this->auth->getError());
        }
    }

    /**
     * 我的主页
     * @throws \think\Exception
     * @throws \think\exception\DbException
     */
    public function my()
    {
        $user_id = $this->auth->id;
        $user = \app\admin\model\User::get($user_id);
        //我的关注数
        $user['focus_1'] = Focus::where('user_id',$user_id)->count();
        //我的粉丝数
        $user['focus_2'] = Focus::where('focus_id',$user_id)->count();
        //代付款
        $user['order_0'] = \app\api\model\Order::where(['user_id'=>$user_id,'status'=>0])->count();
        //代发货
        $user['order_1'] = \app\api\model\Order::where(['user_id'=>$user_id,'status'=>1])->count();
        //待收货
        $user['order_2'] = \app\api\model\Order::where(['user_id'=>$user_id,'status'=>2])->count();
        //已完成
        $user['order_3'] = \app\api\model\Order::where(['user_id'=>$user_id,'status'=>3])->count();
        $this->success('获取成功',$user);
    }

    /**
     * 推荐关注
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function friend()
    {
        $user_id = $this->auth->id;
        $userids = Focus::where('user_id',$user_id)->column('focus_id');
        $user_ids = Focus::where(['focus_id'=>$user_id,'type'=>2])->column('user_id');
        $users = array_merge($user_ids,$userids);
        $input = input();
        $page = isset($input['page']) && !empty($input['page']) ? $input['page'] : 1;
        $pageSize = isset($input['pageSize']) && !empty($input['pageSize']) ? $input['pageSize'] : 10;
        $total = \app\admin\model\User::where('id','not in',$users)->where('status','normal')->count();
        $list = \app\admin\model\User::where('id','not in',$users)->where('status','normal')->limit(($page - 1)
            *$pageSize,$pageSize)->order('id desc')->select();
        $total_page = ceil($total/$pageSize);
        $this->success('获取成功',['total'=>$total,'list'=>$list,'pageSize'=>$pageSize,'current_page'=>$page,'total_page'=>$total_page]);
    }

    /**
     * 关注
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function focus()
    {
        $user_id = $this->auth->id;
        $uid = input('id');
        //查查这俩人的关注情况
        $focus = Focus::where("(user_id = ".$user_id." and focus_id = ".$uid.") or (focus_id = ".$user_id." and user_id = ".$uid.")")->find();
        //如果是互关
        if($focus['type'] == 2){
            //主动关注人事当前登录人  关注关系互换 变成被关注  如果是被关注的互关  就变成被关注
            $data = $user_id == $focus['user_id'] ? ['user_id'=>$focus['focus_id'],'focus_id'=>$focus['user_id'],'type'=>1] : ['type'=>1];
            $focus->save($data);
        }elseif ($focus['type'] == 1){
            //如果是当方面关注  当前登录人关注对方   删除关注关系
            if($user_id == $focus['user_id']){
                $focus->delete();
            }else{
                //如果是被关注   变成互关
                $focus->save(['type'=>2]);
            }
        }else{
            //如果没有关注关系  关注对方
            $focus = new Focus();
            $focus->save(['user_id'=>$user_id,'focus_id'=>$uid,'create_time'=>time()]);
        }
        $this->success('操作成功');
    }

    /**
     * 我的赞
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function zan()
    {
        //用户信息
        $user_id = $this->auth->id;
        //接受参数  和  分页信息
        $input = input();
        $page = isset($input['page']) && !empty($input['page']) ? $input['page'] : 1;
        $pageSize = isset($input['pageSize']) && !empty($input['pageSize']) ? $input['pageSize'] : 10;
        //总数和分页查询
        $total = Zan::where(['user_id'=>$user_id,'type'=>1,'status'=>1])->count();
        $zan = Zan::where(['user_id'=>$user_id,'type'=>1,'status'=>1])->limit(($page - 1)*$pageSize,$pageSize)->order('id desc')->select();
        foreach ($zan as $key=>$value){
            $zan[$key]['forum'] = Forum::where('id',$value['forum_id'])->find();
        }
        $total_page = ceil($total/$pageSize);
        $this->success('获取成功',['total'=>$total,'list'=>$zan,'total_page'=>$total_page,'pageSize'=>$pageSize,'current_page'=>$page]);
    }

    /**
     * 我的商品收藏和论坛收藏
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function favor()
    {
        $input = input();
        $user_id = $this->auth->id;
        $type = isset($input['type']) && !empty($input['type']) ? $input['type'] : 1;
        $page = isset($input['page']) && !empty($input['page']) ? $input['page'] : 1;
        $pageSize = isset($input['pageSize']) && !empty($input['pageSize']) ? $input['pageSize'] : 10;
        $model = $type == 1 ? new GoodsFavor() : new ForumFavor();
        $total = $model->where(['user_id'=>$user_id,'status'=>1])->count();
        $favor = $model->where(['user_id'=>$user_id,'status'=>1])->limit(($page - 1) * $pageSize,$pageSize)->order('id desc')->select();
        foreach ($favor as $key=>$value){
            $favor[$key]['value'] = $type == 1 ? \app\api\model\Goods::get($value['goods_id']) : Forum::get($value['forum_id']);
        }
        $total_page = ceil($total/$pageSize);
        $this->success('获取成功',['total'=>$total,'list'=>$favor,'total_page'=>$total_page,'pageSize'=>$pageSize,'current_page'=>$page]);
    }

    /**
     * 我的积分
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function score()
    {
        $user_id = $this->auth->id;
        $score = \app\admin\model\User::where('id',$user_id)->value('score');
        $input = input();
        $type = isset($input['type']) && !empty($input['type']) ? $input['type'] : 1;
        $page = isset($input['page']) && !empty($input['page']) ? $input['page'] : 1;
        $pageSize = isset($input['pageSize']) && !empty($input['pageSize']) ? $input['pageSize'] : 10;
        $total = ScoreLog::where(['user_id'=>$user_id,'type'=>$type])->count();
        $list = ScoreLog::where(['user_id'=>$user_id,'type'=>$type])->limit(($page - 1)*$pageSize,$pageSize)->order('id desc')->select();
        $total_page = ceil($total/$pageSize);
        $this->success('获取成功',['total'=>$total,'list'=>$list,'total_page'=>$total_page,'pageSize'=>$pageSize,'current_page'=>$page,'score'=>$score]);
    }

    /**
     * 我的钱包
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException+
     */
    public function money()
    {
        $user_id = $this->auth->id;
        $money = \app\admin\model\User::where('id',$user_id)->value('money');
        $input = input();
        $type = isset($input['type']) && !empty($input['type']) ? $input['type'] : 1;
        $page = isset($input['page']) && !empty($input['page']) ? $input['page'] : 1;
        $pageSize = isset($input['pageSize']) && !empty($input['pageSize']) ? $input['pageSize'] : 10;
        $total = MoneyLog::where(['user_id'=>$user_id,'type'=>$type])->count();
        $list = MoneyLog::where(['user_id'=>$user_id,'type'=>$type])->limit(($page - 1)*$pageSize,$pageSize)->order('id desc')->select();
        $total_page = ceil($total/$pageSize);
        $this->success('获取成功',['total'=>$total,'list'=>$list,'total_page'=>$total_page,'pageSize'=>$pageSize,'current_page'=>$page,'money'=>$money]);
    }

    /**
     * 下载记录
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function down()
    {
        $user_id = $this->auth->id;
        $input = input();
        $type = isset($input['type']) && !empty($input['type']) ? $input['type'] : 1;
        $page = isset($input['page']) && !empty($input['page']) ? $input['page'] : 1;
        $pageSize = isset($input['pageSize']) && !empty($input['pageSize']) ? $input['pageSize'] : 10;
        $total = MoneyLog::where(['user_id'=>$user_id,'type'=>$type])->count();
        $list = MoneyLog::where(['user_id'=>$user_id,'type'=>$type])->limit(($page - 1)*$pageSize,$pageSize)->order('id desc')->select();
        $total_page = ceil($total/$pageSize);
        $this->success('获取成功',['total'=>$total,'list'=>$list,'total_page'=>$total_page,'pageSize'=>$pageSize,'current_page'=>$page,'money'=>$money]);
    }

    /**
     * 提现设置的列表
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function withdraw()
    {
        $input = input();
        $user_id = $this->auth->id;
        $page = isset($input['page']) && !empty($input['page']) ? $input['page'] : 1;
        $pageSize = isset($input['pageSize']) && !empty($input['pageSize']) ? $input['pageSize'] : 10;
        $total = Withdraw::where('user_id',$user_id)->count();
        $list = Withdraw::where('user_id',$user_id)->limit(($page - 1)*$pageSize,$pageSize)->order('id desc')->select();
        $total_page = ceil($total/$pageSize);
        $this->success('获取成功',['total'=>$total,'list'=>$list,'total_page'=>$total_page,'pageSize'=>$pageSize,'current_page'=>$page]);
    }

    /**
     * 提现添加/编辑
     * @throws \think\exception\DbException
     */
    public function withdraw_add()
    {
        //用户信息
        $user_id = $this->auth->id;
        //接受参数
        $input = input();
        $id = isset($input['id']) && !empty($input['id']) ? $input['id'] : "";
        unset($input['id']);
        if($id){
            $withdraw = Withdraw::get($id);
        }else{
            $withdraw = new Withdraw();
            $input['user_id'] = $user_id;
            $input['create_time'] = time();
        }
        $withdraw->save($input);
        $this->success('编辑成功');
    }

    /**
     * 提现设置的删除
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function withdraw_del()
    {
        $user_id = $this->auth->id;
        $id = input('id');
        $withdraw = Withdraw::where(['id'=>$id,'user_id'=>$user_id])->find();
        if(!$withdraw){
            $this->error('不存在');
        }
        $withdraw->delete();
        $this->success('删除成功');
    }
}
