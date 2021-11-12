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

class Messages extends AdminBase
{
    /**
     *创始人信息
     * @param integer $p 页码
     */
    public function index($p = 1)
    {
        $this->assign("info", model('Message')->infoList($p));
        $this->assign("state", model("Common/Dict")->showList('state'));//状态
        return $this->fetch();
    }

    /**
     * 创始人信息新增
     */
    public function add()
    {
        if (Request::instance()->isPost()) {
            return json(model('Message')->saveInfo(input('post.')));
        }
        $info = ['id' => null, 'tid' => null, 'name' => null, 'title' => null, 'content' => null];
        $this->assign('info', $info);
        $this->assign('pagename', '添加资讯');
        return $this->fetch();
    }

    /**
     * 创始人信息修改
     */
    public function edits($id)
    {
        if (Request::instance()->isPost()) {
            return json(model('Message')->changeState(input('post.')));
        }
        $this->assign("info", model('Message')->noticeList($id));
        $this->assign('pagename', '修改信息');
        return $this->fetch('add');
    }

}