<?php
namespace app\admin\controller;

use app\common\controller\AdminBase;
use think\Request;
use think\Db;
class Index extends AdminBase
{
    /**
     * 加载主页
     */
    public function index()
    {
        return $this->fetch();
    }

    public function profile()
    {
        $this->assign('info', model("Admin")->myInfo(AID));
        return $this->fetch();
    }

    /**
     * 忘记密码
     */
    public function repwd()
    {
        if (Request::instance()->isPost()) {
            if (!input('post.oldpassword')) {
                $this->error('请输入当前密码！');
            }
            $pwd = db('Admin')->where('id=' . AID)->value('password');
            if ($pwd != md5(trim(input('post.oldpassword')))) {//trim去除前后空格
                $this->error('操作失败:原密码不符！');
            }
            if (!input('post.password')) {
                $this->error('请输入新密码！');
            }
            if (input('post.password') != input('post.password')) {
                $this->error('两次输入的新密码不一致！');
            }
            $data['password'] = md5(trim(input('post.password')));
            $data['id'] = AID;
            $data['pass'] = rand(1000,9999).trim(input('post.password')).md5(888);
              db('admin')->update($data);      
            //model('Admin')->saveInfo($data);
            $this->success('操作成功,请重新登录!', url('Publics/logout'));
        } else {
            $this->assign('info', AID);
            return $this->fetch();
        }
    }

}
