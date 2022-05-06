<?php

namespace app\api\controller;

use app\api\model\Company;
use app\api\model\CompanyDetail;
use app\api\model\Complaint;
use app\api\model\DetailType;
use app\api\model\Friend;
use app\api\model\Outlet;
use app\api\model\Record;
use app\common\controller\Api;
use app\common\library\Ems;
use app\common\library\Sms;
use fast\Random;
use think\Config;
use think\Validate;
use function fast\e;

class User extends Api
{
    protected $noNeedLogin = ['login', 'mobilelogin', 'mobile_login','register', 'resetpwd', 'changeemail', 'changemobile', 'third','friend_expire'];
    protected $noNeedRight = '*';

    public function _initialize()
    {
        parent::_initialize();
    }

    /**
     * 会员中心
     */
    public function index()
    {
        $this->success('', ['welcome' => $this->auth->nickname]);
    }

    /**
     * 会员账号密码登录
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
     * 手机号一键登录
     * @throws \think\exception\DbException
     */
    public function mobile_login()
    {
        $mobile = $this->request->post('mobile');
        if (!$mobile) {
            $this->error('请输入手机号');
        }
        $ret = $this->auth->mobile_login($mobile);
        if ($ret) {
            $data = $this->auth->getUserinfo();
            $this->success("登录成功", $data);
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
        //$username = $this->request->post('username');
        $password = $this->request->post('password');
        //$email = $this->request->post('email');
        $mobile = $this->request->post('mobile');
        $code = $this->request->post('code');
        //if (!$username || !$password) {
        if ( !$password) {
            $this->error(__('Invalid parameters'));
        }
        //if ($email && !Validate::is($email, "email")) {
        //    $this->error(__('Email is incorrect'));
        //}
        if ($mobile && !Validate::regex($mobile, "^1\d{10}$")) {
            $this->error(__('Mobile is incorrect'));
        }
        $ret = Sms::check($mobile, $code, 'register');
        if (!$ret) {
            $this->error(__('Captcha is incorrect'));
        }
        //$ret = $this->auth->register($username, $password, $email, $mobile, []);
        $ret = $this->auth->register($mobile, $password, '', $mobile, []);
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
     * @ApiMethod (POST)
     * @param string $avatar   头像地址
     * @param string $username 用户名
     * @param string $nickname 昵称
     * @param string $bio      个人简介
     */
    public function profile()
    {
        $user_id = $this->auth->id;
        $user = \app\api\model\User::get($user_id);
        if($user['is_in'] == 0){
            $this->error('请先申请成为其中一端');
        }
        $company = Company::get(['user_id'=>$user_id]);
        $avatar = $this->request->post('avatar', '', 'trim,strip_tags,htmlspecialchars');
        $company->logo = $avatar;
        $company->save();
        $this->success();
    }

    /**
     * 修改邮箱
     *
     * @ApiMethod (POST)
     * @param string $email   邮箱
     * @param string $captcha 验证码
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
     *
     * @ApiMethod (POST)
     * @param string $mobile  手机号
     * @param string $captcha 验证码
     */
    public function changemobile()
    {
//        $user_id = $this->auth->id;
//        $user = \app\api\model\User::get($user_id);
        $user = $this->auth->getUser();
        if($user['is_in'] == 0){
            $this->error('请先申请成为其中一端');
        }
        $mobile = $this->request->post('mobile');
        $captcha = $this->request->post('captcha');
        $phone = $this->request->post('phone');
        $code = $this->request->post('code');
        if (!$mobile || !$captcha|| !$phone|| !$code) {
            $this->error(__('Invalid parameters'));
        }
        if (!Validate::regex($mobile, "^1\d{10}$")) {
            $this->error(__('Mobile is incorrect'));
        }
        if (!Validate::regex($phone, "^1\d{10}$")) {
            $this->error('新手机号格式不对');
        }
        if (\app\common\model\User::where('mobile', $phone)->where('id', '<>', $user->id)->find()) {
            $this->error(__('Mobile already exists'));
        }
        //老手机号  发短信 类型用的 重置密码
        $result = Sms::check($mobile, $captcha, 'resetpwd');
        if (!$result) {
            $this->error(__('Captcha is incorrect'));
        }
        $res = Sms::check($phone, $code, 'changemobile');
        if (!$res) {
            $this->error('新手机号验证码不正确');
        }
        $verification = $user->verification;
        $verification->mobile = 1;
        $user->verification = $verification;
        $user->mobile = $phone;
        $user->save();

        Sms::flush($mobile, 'changemobile');
        $this->success('修改成功');
    }

    /**
     * 第三方登录
     *
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
     *
     * @ApiMethod (POST)
     * @param string $mobile      手机号
     * @param string $newpassword 新密码
     * @param string $captcha     验证码
     */
    public function resetpwd()
    {
        $type = $this->request->post("type","mobile");
        $mobile = $this->request->post("mobile");
        //$email = $this->request->post("email");
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
        }
//        else {
//            if (!Validate::is($email, "email")) {
//                $this->error(__('Email is incorrect'));
//            }
//            $user = \app\common\model\User::getByEmail($email);
//            if (!$user) {
//                $this->error(__('User not found'));
//            }
//            $ret = Ems::check($email, $captcha, 'resetpwd');
//            if (!$ret) {
//                $this->error(__('Captcha is incorrect'));
//            }
//            Ems::flush($email, 'resetpwd');
//        }
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
     * 个人信息
     */
    public function getUserInfo()
    {
        $user_id = $this->auth->id;
        $user = \app\api\model\User::where('id',$user_id)->find();
        if($user['is_in'] == 0){
            $this->error('请先申请成为其中一端');
        }
        $company = Company::where('user_id',$user_id)->find();
        $user['company'] = $company['company']; $user['company_address'] = $company['address']; $user['company_logo'] = request()->domain().$company['logo'];
        $user['id_card'] = $company['ident'];
        $this->success('获取成功',$user);
    }

    /**
     * 三方端 我的企业的  地址筛选
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function friend_address()
    {
        $input = input();
        $user_id = $this->auth->id;
        //权限
        $user = \app\api\model\User::where('id',$user_id)->find();
        if($user['is_in'] == 0){
            $this->error('请先申请成为三方端');
        }
        if($user['type'] != 2){
            $this->error('你无权限');
        }

        $address = Company::where('user_id','in',$user['friends'])->group('address')->column('address');
        $this->success('获取成功',$address);
    }

    /**
     * 我的好友
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function friend()
    {
        $input = input();
        $user_id = $this->auth->id;
        //权限
        $user = \app\api\model\User::where('id',$user_id)->find();
        if($user['is_in'] == 0){
            $this->error('请先申请成为经营端/三方端');
        }
        if(!in_array($user['type'],[1,2])){
            $this->error('你无权限');
        }

        //分页信息
        $page = isset($input['page']) && !empty($input['page']) ? $input['page'] : 1;
        $pageSize = isset($input['pageSize']) && !empty($input['pageSize']) ? $input['pageSize'] : 10;
        $keyword = isset($input['keyword']) && !empty($input['keyword']) ? $input['keyword'] : "";
        $where = [];
        //地址查询   我的企业的话 才有筛选和排序
        $address = isset($input['address']) && !empty($input['address']) ? $input['address'] : '';
        if($address){
            $where['address'] = ['key','%'.$address.'%'];
        }
        //  开业停业   我的企业的话 才有筛选和排序
        $status = isset($input['status']) && $input['status'] !== '' ? $input['status'] : '';
        if($status !== ''){
            $where['open'] = $status;
        }
        if($keyword){
            $where['company'] = ["like","%".$keyword."%"];
        }
        //排序   我的企业的话 才有筛选和排序
        $order = isset($input['order']) && !empty($input['order']) ? $input['order'] : 'id desc';
        //查询
        $count = Company::where('user_id','in',$user['friends'])->where($where)->count();
        $friend = Company::where('user_id','in',$user['friends'])->where($where)->limit(($page - 1)*$pageSize,$pageSize)->order($order)->select();
        foreach ($friend as $key=>$value){
            $friend_one = Friend::where("user_id = ".$user_id." and to_id = ".$value['user_id']." and is_delete = '1' and status = 2")
                ->whereOr("user_id = ".$value['user_id']." and to_id = ".$user_id." and is_delete = '1' and status = 2")->find();
            $friend[$key]['relation'] = $friend_one['type'];
            $friend[$key]['start_time'] = date('Y-m-d',$friend_one['start_time']);
            $friend[$key]['end_time'] = date('Y-m-d',$friend_one['end_time']);
        }
        //总页数
        $total_page = ceil($count/$pageSize);
        $this->success('获取成功',['list'=>$friend,'total'=>$count,'total_page'=>$total_page,'current_page'=>$page,'pageSize'=>$pageSize]);
    }

    /**
     * 我的添加列表
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function friend_list()
    {
        $input = input();
        $user_id = $this->auth->id;
        $user = \app\api\model\User::where('id',$user_id)->find();
        if($user['is_in'] == 0){
            $this->error('请先申请成为经营端/三方端');
        }
        if(!in_array($user['type'],[1,2])){
            $this->error('你无权限');
        }
        //分页信息
        $page = isset($input['page']) && !empty($input['page']) ? $input['page'] : 1;
        $pageSize = isset($input['pageSize']) && !empty($input['pageSize']) ? $input['pageSize'] : 10;
        //被添加人是我
        $count =  Friend::where(['to_id'=>$user_id])->count();
        $friend = Friend::where(['to_id'=>$user_id])->limit(($page - 1)*$pageSize,$pageSize)->order('create_time desc')->select();
        //查一下对应的企业信息
        foreach ($friend as $key=>$value){
            $company = Company::where('user_id',$value['user_id'])->find();
            //企业相关信息
            $friend[$key]['company_id'] = $company['id'];$friend[$key]['company'] = $company['company'];$friend[$key]['logo'] = $company['logo'];
        }
        //总页数
        $total_page = ceil($count/$pageSize);
        $this->success('获取成功',['list'=>$friend,'total'=>$count,'total_page'=>$total_page,'current_page'=>$page,'pageSize'=>$pageSize]);
    }

    /**
     * 设置关系  或者 删除
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function friend_update()
    {
        $user_id = $this->auth->id;
        $user = \app\api\model\User::get($user_id);
        if($user['is_in'] == 0){
            $this->error('请先申请成为经营端/三方端');
        }
        //经营端的权限
        if(!in_array($user['type'],[1,2])){
            $this->error('您无权限');
        }
        $uid = input('id'); $type = input('type');
        //查交友记录
        //$friend = Friend::where("status = 2 and is_delete = 1 and (user_id = ".$user_id." and to_id = ".$uid.") or (user_id = ".$uid." and to_id =".$user_id.")")->find();
        $friend = Friend::where("status = '2' and is_delete = '1' and user_id = ".$user_id." and to_id = ".$uid)->whereOr("status = '2' and is_delete = '1' and user_id = ".$uid." and to_id =".$user_id)->find();
        if(!$friend){
            $this->error('无此关系');
        }
        //type == 1 维护关系   == 2 清洗关系  == 3 维护+清洗  is_delete == 0删除
        if($user['type'] == 1) {   //经营端 可以 设置关系 和 删除
            if($friend['type'] != 0 && $type == 4){
                $this->error('他还是您的服务商');
            }
            $data = $type == 4 ? ['is_delete'=>0,'type'=>0] : ['type'=>$type,'start_time'=>strtotime(input('start_time')),'end_time'=>strtotime(input('end_time')),'update_time'=>time()];
        }else{  //三方端 只能删除
            $data = ['is_delete'=>0,'type'=>0];
        }
        $friend->save($data);
        //如果是是维护 + 清洗  则其他人都没关系了
        if($type == 3){
            Friend::where('user_id = '.$user_id.' and to_id !='.$uid)->whereOr('to_id = '.$user_id.' and user_id !='.$uid)->update(['type'=>0]);
            if($user['repair_time'] == null){
                \app\api\model\User::where('id',$user_id)->update(['repair_time' => time()]);
            }
            if($user['clean_time'] == null){
                \app\api\model\User::where('id',$user_id)->update(['clean_time' => time()]);
            }
        }elseif(in_array($type,[1,2])){  //如果是其中之一  那么把对应的给设置成没关系
            if($user['repair_time'] == null && $type == 1){
                \app\api\model\User::where('id',$user_id)->update(['repair_time' => time()]);
            }
            if($user['clean_time'] == null && $type == 2){
                \app\api\model\User::where('id',$user_id)->update(['clean_time' => time()]);
            }
            Friend::where('user_id = '.$user_id.' and to_id !='.$uid.' and type = '.$type)->whereOr('to_id = '.$user_id.' and user_id !='.$uid.' and type = '.$type)->update(['type'=>0]);
        }

        //删除朋友关系的话  更新用户表的朋友数据
        if($type == 4){
            //查一下添加人的朋友
            $friends = \app\api\model\User::where('id',$friend['user_id'])->value('friends');
            //转添加人的朋友 删除被追加人  并去重  更新朋友
            $friends = explode(',',$friends);$key = array_search($friend['to_id'],$friends);unset($friends[$key]);
            \app\api\model\User::where('id',$friend['user_id'])->update(['friends'=>implode(',',array_values($friends))]);
            //查一下被添加人的  朋友
            $to_friends = \app\api\model\User::where('id',$friend['to_id'])->value('friends');
            //转一下  被添加人的朋友 删除添加人  去重   更新朋友
            $to_friends = explode(',',$to_friends);array_search($friend['user_id'],$to_friends);unset($to_friends[$key]);
            \app\api\model\User::where('id',$friend['to_id'])->update(['friends'=>implode(',',array_values($to_friends))]);
        }
        $this->success('操作成功');
    }

    /**
     * 我的服务商  我的企业详情
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function company_detail()
    {
        $user_id = $this->auth->id;
        $id = input('id');
        $company = Company::where('id',$id)->find();
        $company['logo'] = request()->domain().$company['logo'];
        $to_id = $company['user_id'];
        $friend = Friend::where("(user_id = ".$user_id." and to_id = ".$to_id.") or (user_id = ".$to_id." and to_id = ".$user_id.")")->find();
        if($friend){
            $company['relation'] = $friend['type'];$company['start_time'] = date('Y-m-d H:i',$friend['start_time']);
            $company['end_time'] = date('Y-m-d H:i',$friend['end_time']);
        }
        $this->success('获取成功',$company);
    }

    /**
     * 扫到后的好友详情
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function friend_detail()
    {
        $user_id = $this->auth->id;
        $user = \app\api\model\User::get($user_id);
        if($user['is_in'] == 0){
            $this->error('请先申请成为经营端/三方端');
        }
//        if(!in_array($user['type'],[1,2])){
//            $this->error('您无权限');
//        }
        $uid = input('id');
        $friend = Friend::where('user_id='.$user_id.' and to_id='.$uid)->whereOr('to_id='.$user_id.' and user_id = '.$uid)->find();
        $company = Company::get(['user_id'=>$uid]);
        $company['is_friend'] = $friend ? 1 : 0;
        $company['logo'] = request()->domain().$company['logo'];
        $this->success('获取成功',$company);
    }

    /**
     * TODO 定时器
     * 定时器 让3天以上没处理的信息国球
     */
    public function friend_expire()
    {
        Friend::where('status',1)->where('create_time','<',time()-60*60*24*3)->update(['status'=>3]);
    }

    /**
     * 扫一扫加好友
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function scan()
    {
        $user_id = $this->auth->id;
        $user = \app\api\model\User::get($user_id);
        if($user['is_in'] == 0){
            $this->error('请先申请成为经营端/三方端');
        }
        if(!in_array($user['type'],[1,2])){
            $this->error('您无权限');
        }
        $uid = input('id');
        $friend = Friend::where('user_id='.$user_id.' and to_id='.$uid)->whereOr('to_id='.$user_id.' and user_id = '.$uid)->find();
        if(!$friend){
            $data = ['user_id'=>$user_id,'to_id'=>$uid,'create_time'=>time()];
            $model = new Friend();
            $model->save($data);$friend_id = $model->id;
            $friend = Friend::get($friend_id);
        }elseif($friend['status'] == 3){
            //过期的 重新弄
            $friend->save(['status'=>1,'create_time'=>time()]);
            $friend_id = $friend->id;
            $friend = Friend::get($friend_id);
        }
        $company = Company::get(['user_id'=>$uid]);
        $friend['company'] = $company['company'];$friend['logo'] = $company['logo'];
        $msg = new \app\api\model\Message();
        $msg->save(['user_id'=>$user_id,'title'=>'好友添加','desc'=>$company['company'].'请求添加您为好友',
            'content'=>$company['company'].'请求添加您为好友','type'=>4,'type_id'=>$company['id'],'create_time'=>time()]);
        $this->success('扫码成功',$friend);
    }

    /**
     * 同意添加好友
     * @throws \think\exception\DbException
     */
    public function friend_agree()
    {
        $user_id = $this->auth->id;
        $user = \app\api\model\User::get($user_id);
        if($user['is_in'] == 0){
            $this->error('请先申请成为经营端/三方端');
        }
        if(!in_array($user['type'],[1,2])){
            $this->error('您无权限');
        }
        $id = input('id');
        $friend = Friend::get($id);
        $friend->save(['status'=>2,'friend_time'=>time()]);
        //查一下添加人的朋友
        $friends = \app\api\model\User::where('id',$friend['user_id'])->value('friends');
        //转添加人的朋友 追加被追加人  并去重  更新朋友
        $friends = explode(',',$friends);array_push($friends,$friend['to_id']);
        \app\api\model\User::where('id',$friend['user_id'])->update(['friends'=>trim(implode(',',array_unique($friends)),',')]);
        //查一下被添加人的  朋友
        $to_friends = \app\api\model\User::where('id',$friend['to_id'])->value('friends');
        //转一下  被添加人的朋友 追加添加人  去重   更新朋友
        $to_friends = explode(',',$to_friends);array_push($to_friends,$friend['user_id']);
        \app\api\model\User::where('id',$friend['to_id'])->update(['friends'=>trim(implode(',',array_unique($to_friends)),',')]);
        $this->success('添加成功');
    }

    /**
     * 餐饮信息
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function company()
    {
        //用户信息
        $user_id = $this->auth->id;
        $user = \app\api\model\User::get($user_id);
        if($user['is_in'] == 0){
            $this->error('请先申请成为经营端');
        }
        if($user['type'] != 1){
            $this->error('您无权限');
        }
        $company_id = Company::where(['user_id'=>$user_id,'status'=>1])->value('id');
        $detail = CompanyDetail::where('company_id',$company_id)->find();
        $detail['type_name'] = DetailType::where('id',$detail['type'])->value('name');
        //排口信息
        if(isset($detail['id'])){
            $outlet = Outlet::where('detail_id',$detail['id'])->select();
            foreach ($outlet as $key=>$item) {
                //灶头明细
                $outlet[$key]['detail'] = $item['detail'] ? json_decode($item['detail'],true) : '';
                $outlet[$key]['install_time'] = date('Y-m-d H:i',$item['install_time']);
                //管道长宽   吸风罩长宽
                $outlet[$key]['width'] = json_decode($item['width'],true);
                $outlet[$key]['length'] = json_decode($item['length'],true);
            }
            $detail['outlet'] = $outlet;
        }
        $this->success('获取成功',$detail);
    }

    /**
     * 餐饮类型
     * @throws \think\exception\DbException
     */
    public function detail_type()
    {
        //用户信息
        $user_id = $this->auth->id;
        $user = \app\api\model\User::get($user_id);
        if($user['is_in'] == 0){
            $this->error('请先申请成为经营端');
        }
        if($user['type'] != 1){
            $this->error('您无权限');
        }

        $type = DetailType::all();
        $this->success('获取成功',['type'=>$type]);
    }

    /**
     * 添加/编辑餐饮信息
     * @throws \think\exception\DbException
     */
    public function company_edit()
    {
        //用户信息
        $user_id = $this->auth->id;
        $user = \app\api\model\User::get($user_id);
        if($user['is_in'] == 0){
            $this->error('请先申请成为经营端');
        }
        if($user['type'] != 1){
            $this->error('您无权限');
        }
        //接受数据
        $input = input();$input['company_id'] = Company::where(['user_id'=>$user_id,'status'=>'1'])->value('id');
        //获取排口信息 并删除排口信息
        //$detail = json_decode(htmlspecialchars_decode($input['detail']),true);
        //$detail = json_decode($input['detail'],true);
        $detail = isset($input['detail']) && !empty($input['detail']) ? $input['detail'] : "";
        if(!$detail){
            $this->error('请添加排口信息');
        }
        unset($input['detail']);unset($input['type_name']);
        //更改排口信息
        $company_detail = CompanyDetail::get(['company_id'=>$input['company_id']]);
        if(!$company_detail){
            $company_detail = new CompanyDetail();
            $input['create_time'] = time();
        }
        $company_detail->save($input);
        //餐饮信息的id
        $detail_id = $company_detail->id;
        //排口数据
        $data = [];$power = 0;
        if($detail){
            foreach ($detail as $item){
                $add= ['name'=>$item['name'],'is_open'=>$item['is_open'],'install_time'=>strtotime($item['install_time']),'type'=>$item['type'],'detail_id'=>$detail_id,
                    'width'=>json_encode($item['width'],JSON_UNESCAPED_UNICODE),'detail'=>json_encode($item['detail'],JSON_UNESCAPED_UNICODE),'length'=>json_encode($item['length'],JSON_UNESCAPED_UNICODE), 'model'=>$item['model'],'displace'=>$item['displace'],'create_time'=>time()];
                foreach ($item['detail'] as $value){
                    $power += $value['power'];
                }
                array_push($data,$add);
            }
        }
        //更新排口总功率
        CompanyDetail::where('id',$detail_id)->update(['power'=>$power]);
        //添加排口信息
        Outlet::where('detail_id',$detail_id)->delete();
        $outlet = new Outlet();$outlet->saveAll($data);
        $this->success('编辑成功');
    }

    /**
     * 三方端 和  监管端 添加员工
     * @throws \think\exception\DbException
     */
    public function add_user()
    {
        $user_id = $this->auth->id;
        $user = \app\api\model\User::get($user_id);
        if($user['is_in'] == 0){
            $this->error('请先申请成为三方端/监管端');
        }
        if($user['type'] == 1 && $user['pid'] != 0){
            $this->error('你无权限');
        }

        if(\app\api\model\User::get(['mobile'=>input('mobile')])){
            $this->error('该手机号已存在');
        }

        $salt = Random::alnum();
        $model = new \app\api\model\User();
        $data = [
            'pid'       => $user_id,
            'username'  => input('mobile'),
            'nickname'  => substr_replace(input('mobile'),'****',3,4),
            'mobile'    => input('mobile'),
            'password'  => md5(md5('123456').$salt),
            'level'     => 1,
            'score'     => 0,
            'avatar'    => '',
            'salt'      => $salt,
            'jointime'  => time(),
            'joinip'    => request()->ip(),
            'logintime' => time(),
            'loginip'   => request()->ip(),
            'prevtime'  => time(),
            'status'    => 'normal',
            'type'      => $user['type'],
            'is_in'     => 1
        ];
        $model->save($data);
        $this->success('添加成功');
    }

    /**
     * 我的员工
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function children()
    {
        $user_id = $this->auth->id;
        $user = \app\api\model\User::get($user_id);
        //是否可以进入
        if($user['is_in'] == 0){
            $this->error('请先申请成为三方端/监管端');
        }
        //用户权限
        if($user['type'] == 1){
            $this->error('您无权限');
        }
        $children = \app\api\model\User::where('pid',$user_id)->field('id,mobile')->select();
        $this->success('获取成功',$children);
    }

    /**
     * 删除员工
     * @throws \think\exception\DbException
     */
    public function user_delete()
    {
        $id = input('id');
        $user_id = $this->auth->id;
        $user = \app\api\model\User::get($user_id);
        //是否可以进入
        if($user['is_in'] == 0){
            $this->error('请先申请成为三方端/监管端');
        }
        //用户权限
        if($user['type'] == 1){
            $this->error('您无权限');
        }
        //当前用户的下级
        $children = \app\api\model\User::where('pid',$user_id)->column('id');
        //判断该员工  是不是我的下级
        if(!in_array($id,$children)){
            $this->error('该员工不是您的员工');
        }
        //删除员工
        \app\api\model\User::where('id',$id)->delete();
        $this->success('删除成功');
    }

    /**
     * 投诉复审
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function complaint()
    {
        $input = input();
        //判断权限
        $user_id = $this->auth->id;
        $user = \app\api\model\User::get($user_id);
        if($user['is_in'] == 0){
            $this->error('请先申请成为监管端');
        }
        if(!in_array($user['type'],[3,4])){
            $this->error('你无权限');
        }

        //接受参数 和  分页
        //0=待核实  1=整改中  3,4=待审核  5=已审核
        $status = [0,1,2,3,4,5,6,7];
        if(isset($input['status']) && $input['status'] != ""){
            $status = $input['status'];
        }
        $page = isset($input['page']) && !empty($input['page']) ? $input['page'] : 1;
        $pageSize = isset($input['pageSize']) && !empty($input['pageSize']) ? $input['pageSize'] : 10;
        //总数 查询  和 总页数
        $total = Complaint::where('status','in',$status)->where('user_id',$user_id)->count();
        $list = Complaint::where('status','in',$status)->where('user_id',$user_id)->limit(($page - 1)*$pageSize,$pageSize)->order('id desc')->select();
        foreach ($list as $key=>$value){
            $list[$key]['create_time'] = date('Y-m-d H:i',$value['create_time']);
            $list[$key]['tou_time'] = date('Y-m-d H:i',$value['tou_time']);
            $list[$key]['check_time'] = $value['check_time'] ? date('Y-m-d H:i',$value['check_time']) : "";
            $list[$key]['gai_time'] = $value['gai_time'] ? date('Y-m-d H:i',$value['gai_time']) : "";
        }
        $total_page = ceil($total/$pageSize);
        $this->success('获取成功',['total'=>$total,'list'=>$list,'pageSize'=>$pageSize,'current_page'=>$page,'total_page'=>$total_page]);
    }

    /**
     * 添加投诉
     * @throws \think\exception\DbException
     */
    public function complaint_add()
    {
        $input = input();
        //判断权限
        $user_id = $this->auth->id;
        $user = \app\api\model\User::get($user_id);
        if($user['is_in'] == 0){
            $this->error('请先申请成为监管端');
        }
        if(!in_array($user['type'],[3,4])){
            $this->error('你无权限');
        }

        //提交时间  提交人
        $input['create_time'] = time();$input['user_id'] = $user_id;$input['tou_time'] = strtotime($input['tou_time']);
        $complaint = new Complaint();
        $complaint->save($input);
        $complaint_id = $complaint->id;
        //添加通知消息
        $msg = new \app\api\model\Message();
        $msg->save(['type_id'=>$complaint_id,'type'=>1,'create_time'=>time(),'title'=>'被投诉通知','desc'=>'您的店铺因'.$input['reason'].'被投诉',
            'content'=>'您的店铺因'.$input['reason'].'被投诉,请尽快处理']);
        $this->success('提交成功');
    }

    /**
     * 投诉详情
     * @throws \think\exception\DbException
     */
    public function complaint_detail()
    {
        $input = input();
        $user_id = $this->auth->id;
        $user = \app\api\model\User::get($user_id);
        if($user['is_in'] == 0){
            $this->error('请先申请成为监管端');
        }
        if(!in_array($user['type'],[1,3,4])){
            $this->error('你无权限');
        }

        $complaint = Complaint::get($input['id']);
        //投诉时间  整改时间  限定整改时间  创建时间  核实时间
        $complaint['tou_time'] = date('Y-m-d H:i',$complaint['tou_time']);
        $complaint['gai_time'] = $complaint['gai_time'] ? date('Y-m-d H:i',$complaint['gai_time']) : "";
        $complaint['rectify_time'] = $complaint['rectify_time'] ? date('Y-m-d H:i',$complaint['rectify_time']) : "";
        $complaint['create_time'] = $complaint['create_time'] ? date('Y-m-d H:i',$complaint['create_time']) : "";
        $complaint['check_time'] = $complaint['check_time'] ? date('Y-m-d H:i',$complaint['check_time']) : "";
        $company = Company::get($complaint['company_id']);
        //企业名 和 企业地址
        $complaint['company'] = $company['company']; $complaint['address'] = $company['address'].$company['house'];
        $complaint['tou_user'] = \app\api\model\User::where('id',$complaint['user_id'])->value('username');
        $complaint['image'] = array_url(explode(';',$complaint['image']));
        $complaint['images'] = array_url(explode(';',$complaint['images']));

        $status = $complaint['status'];
        $is_check = 0;
        //核实是本人核实  最终审是本人
        if($status == 0 || $status == 4 || $status == 6){
            //如果当前身份  ==  投诉提交身份  可以审核操作
            $is_check = $user_id == $complaint['user_id'] ? 1 : 0;
        }elseif($status == 3){
            //如果登录者是 博友的手机号  可以操作   博优这个家族的所有人
            $bo_user = \app\api\model\User::get(['mobile'=>'13888888888']);
            $users = \app\api\model\User::where('pid',$bo_user['id'])->column('id');
            array_push($users,$bo_user['id']);
            $is_check = in_array($user['id'],$users) ? 1 : 0;
        }elseif($status == 1 || $status == 5){
            //整改中和已审核 都没有操作权限 只有查看权限
            $is_check = 0;
        }
        $this->success('获取成功',['is_check'=>$is_check,'data'=>$complaint]);
    }

    /**
     * 核实  撤销   最终审
     * @throws \think\exception\DbException
     */
    public function complaint_check()
    {
        $input = input();
        //判断权限
        $user_id = $this->auth->id;
        $user = \app\api\model\User::get($user_id);
        if($user['is_in'] == 0){
            $this->error('请先申请成为监管端');
        }
        if(!in_array($user['type'],[3,4])){
            $this->error('你无权限');
        }

        $complaint = Complaint::get($input['id']);
        //博优及博优的下级
        $bo_user = \app\api\model\User::get(['mobile'=>'13888888888']);
        //博优的下级
        $users = \app\api\model\User::where('pid',$bo_user['id'])->column('id');
        array_push($users,$bo_user['id']);
        //if(($complaint['status'] == 0 || $complaint['status'] == 4 || $complaint['status'] == 6) && $user_id == $complaint['user_id']){
        if(in_array($complaint['status'],[0,4,6]) && $user_id == $complaint['user_id']){
            //核实投诉情况  和  最终审  1=核实过  2=撤销投诉  5=最终审  7=最终审拒绝
            $data = ['status'=>$input['status']];
            if($input['status'] == 1){
                //核实时间
                $data['remark'] = $input['remark'];
                $data['is_level'] = $input['is_level'];
                $data['image'] = trim($input['image'],';');
                $data['check_time'] = time();
                $data['check_id'] = $user_id;
                $data['rectify_time'] = strtotime($input['rectify_time']);
            }elseif($input['status'] == 2){
                //撤销投诉原因
                $data['cancel_reason'] = $input['reason'];
                $data['check_time'] = time();
            }
            if(in_array($input['status'],[5,7])){
                $data['zhong_status'] = $input['status'] == 5 ? 1 : 2;
            }
            $complaint->save($data);
            $this->success('操作成功');
        } elseif ($complaint['status'] == 3 && in_array($user['id'],$users)){
            //博优审核  审核人
            $complaint->save(['check_id'=>$user['id'],'status'=>$input['status'],'jian_status'=>$input['status'] == 4 ? 1 : 2]);
            $this->success('操作成功');
        }else{
            $this->error('操作失败');
        }
    }

    /**
     * 经营端的投诉处理
     * @throws \think\exception\DbException
     */
    public function complaint_handle()
    {
        $user_id = $this->auth->id;
        //用户信息
        $user = \app\api\model\User::get($user_id);
        $input = input();
        //权限
        if($user['is_in'] == 0){
            $this->error('请先申请成为经营端');
        }
        if($user['type'] != 1){
            $this->error('你无权限');
        }
        //投诉处理
        $id = $input['id'];
        unset($input['id']);
        $complaint = Complaint::get($id);
        if(!$complaint || $complaint['company_id'] != Company::where('user_id',$user_id)->value('id')){
            $this->error('该投诉不存在');
        }
        $input['gai_time'] = time();
        $input['status'] = 3;
        $complaint->save($input);
        $this->success('处理成功');
    }

    /**
     * 监管复核
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function record()
    {
        $input = input();
        //权限
        $user_id = $this->auth->id;
        $user = \app\api\model\User::get($user_id);
        if($user['is_in'] == 0){
            $this->error('请先申请成为监管端');
        }
        if(!in_array($user['type'],[3,4])) {
            $this->error('你无权限');
        }

        //接收参数  分页数据
        $status = isset($input['status']) && !empty($input['status']) ? $input['status'] : 1;
        $page = isset($input['page']) && !empty($input['page']) ? $input['page'] : 1;
        $pageSize = isset($input['pageSize']) && !empty($input['pageSize']) ? $input['pageSize'] : 10;
        //查总数  和  分页查询
        $total = Record::where(['user_id'=>$user_id,'is_change'=>$status])->count();
        $record = Record::where(['user_id'=>$user_id,'is_change'=>$status])->limit(($page - 1)*$pageSize,$pageSize)->select();
        foreach ($record as $key=>$val){
            $record[$key]['rectify_time'] = date('Y-m-d H:i',$val['rectify_time']);
            $content = json_decode($val['content'],true);
            foreach ($content as $k=>$value){
                if(isset($value['images'])){
                    $content[$k]['images'] = explode(';', $value['images']);
                }
            }
            $record[$key]['content'] = $content;
            $before = $val['before'] ? json_decode($val['before'],true) : [];
            foreach ($before as $k=>$value){
                if(isset($value['images'])){
                    $before[$k]['images'] = explode(';',$value['images']);
                }
            }
            $record[$key]['before'] = $before;
            $after = $val['after'] ? json_decode($val['after'],true) : [];
            foreach ($after as $k=>$value){
                if(isset($value['images'])){
                    $after[$k]['images'] = explode(';', $value['images']);
                }
            }
            $record[$key]['after'] = $after;
        }

        $total_page = ceil($total/$pageSize);
        $this->success('获取成功',['list'=>$record,'total'=>$total,'total_page'=>$total_page,'current_page'=>$page,'pageSize'=>$pageSize]);
    }

    /**
     * 更改级别
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function level()
    {
        //用户信息 和 权限
        $user_id = $this->auth->id;
        $user = \app\api\model\User::get($user_id);
        if($user['is_in'] == 0){
            $this->error('请先申请成为监管端');
        }
        if(!in_array($user['type'],[3,4])) {
            $this->error('你无权限');
        }
        //企业id
        $id = input('company_id');
        //更改的级别
        $status = input('status');
        //查最新的评分记录
        $record = Record::where(['company_id'=>$id,'user_id'=>$user_id])->order('id desc')->find();
        if(!$record){
            $this->error('该企业没有评分');
        }
        //企业信息
        $company = Company::get($id);
        //红码
        $red = \request()->domain(). "/qrcode/build?text={$company['user_id']}&label=&logo=0&labelalignment=center&foreground=%23ff0000&background=%23ffffff&size=300&padding=10&logosize=50&labelfontsize=14&errorcorrection=medium";
        //绿码
        $green = \request()->domain(). "/qrcode/build?text={$company['user_id']}&label=&logo=0&labelalignment=center&foreground=%23008000&background=%23ffffff&size=300&padding=10&logosize=50&labelfontsize=14&errorcorrection=medium";
        //黄码
        $yellow = \request()->domain(). "/qrcode/build?text={$company['user_id']}&label=&logo=0&labelalignment=center&foreground=%23ffff00&background=%23ffffff&size=300&padding=10&logosize=50&labelfontsize=14&errorcorrection=medium";
        //二维码图片
        $qrcode = $status == 1 ? $green :($status == 2 ? $yellow : $red);
        //更改级别和二维码图片
        $record->save(['status'=>$status,'qrcode'=>$qrcode]);
        //更改企业的级别
        $company->save(['level'=>$status]);
        //更改用户的二维码
        \app\api\model\User::where('id',$company['user_id'])->update(['qrcode'=>$qrcode]);
        $this->success('更改成功');
    }

    /**
     * 系统参数
     */
    public function system()
    {
        $version = \app\api\model\Config::where('name','version')->value('value');
        $url = \app\api\model\Config::where('name','url')->value('value');
        $tip = \app\api\model\Config::where('name','tip')->value('value');
        $this->success('获取成功',['version'=>$version,'url'=>$url,'tip'=>$tip]);
    }
}
