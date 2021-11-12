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

class Tops extends AdminBase
{
    /**
     *顶部导航信息
     * @param integer $p 页码
     */
    public function index($p = 1)
    {
        $this->assign("info", model('Top')->infoList($p));
        $this->assign("state", model("Common/Dict")->showList('state'));//状态
        return $this->fetch();
    }

    /**
     * 顶部导航信息新增
     */
    public function add()
    {
        if (Request::instance()->isPost()) {
            return json(model('Top')->saveInfo(input('post.')));
        }
        $info = ['id' => null, 'title' => null, 'url' => null];
        $this->assign('info', $info);
        $this->assign('pagename', '添加顶部导航');
        return $this->fetch();
    }

    /**
     * 顶部导航信息修改
     */
    public function edits($id)
    {
        if (Request::instance()->isPost()) {
            return json(model('Notice')->changeState(input('post.')));
        }
        $this->assign("info", model('Top')->noticeList($id));
        $this->assign('pagename', '修改顶部导航');
        return $this->fetch('add');
    }

    /**
     * 顶部导航信息删除
     */
    public function delete()
    {
        if (Request::instance()->isPost()) {
            return json(model('Top')->deleteInfo(input('post.id')));
        }
    }

}