<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/9/30
 * Time: 11:30
 */

namespace app\admin\controller;

use app\common\controller\AdminBase;
use think\Request;

class Recruits extends AdminBase
{
    /**
     *招聘列表
     * @param integer $p 页码
     */
    public function index($p = 1)
    {
        $this->assign("info", model('Recruit')->infoList($p));
        $this->assign("state", model("Common/Dict")->showList('state'));//状态
        return $this->fetch();
    }

    /**
     * 招聘新增
     */
    public function add()
    {
        if (Request::instance()->isPost()) {
            return json(model('Recruit')->saveInfo(input('post.')));
        }
        $info = ['id' => null, 'name' => null, 'content' => null, 'sort' => null];
        $this->assign('info', $info);
        $this->assign('pagename', '添加招聘公告');
        return $this->fetch();
    }

    /**
     * 招聘修改
     */
    public function edits($id)
    {
        $this->assign("info", model('Recruit')->noticeList($id));
        $this->assign('pagename', '修改招聘公告');
        return $this->fetch('add');
    }

    /**
     * 招聘删除
     */
    public function delete()
    {
        if (Request::instance()->isPost()) {
            return json(model('Recruit')->deleteInfo(input('post.id')));
        }
    }

}