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

class Courses extends AdminBase
{
    /**
     *公司历程列表
     * @param integer $p 页码
     */
    public function index($p = 1)
    {
        $this->assign("info", model('Course')->infoList($p));
        $this->assign("state", model("Common/Dict")->showList('state'));//状态
        return $this->fetch();
    }

    /**
     * 公司历程新增
     */
    public function add()
    {
        if (Request::instance()->isPost()) {
            return json(model('Course')->saveInfo(input('post.')));
        }
        $info = ['id' => null, 'name' => null, 'title' => null];
        $this->assign('info', $info);
        $this->assign('pagename', '添加资讯');
        return $this->fetch();
    }

    /**
     * 公司历程信息修改
     */
    public function edits($id)
    {
        if (Request::instance()->isPost()) {
            return json(model('Course')->changeState(input('post.')));
        }
        $this->assign("info", model('Course')->noticeList($id));
        $this->assign('pagename', '修改信息');
        return $this->fetch('add');
    }
    /**
     * 公司历程删除
     */
    public function delete()
    {
        if (Request::instance()->isPost()) {
            return json(model('Course')->deleteInfo(input('post.id')));
        }
    }
}