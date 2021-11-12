<?php

namespace app\admin\controller;

use app\common\controller\AdminBase;
use think\Request;

class NoticeTypes extends AdminBase
{
    /**
     *资讯类型列表
     * @param integer $p 页码
     */
    public function index($p = 1)
    {
        $this->assign("info", model('NoticeType')->infoList($p));
        $this->assign("state", model("Common/Dict")->showList('state'));//状态
        return $this->fetch();
    }

    /**
     * 资讯类型新增
     */
    public function add()
    {
        if (Request::instance()->isPost()) {

            return json(model('NoticeType')->saveInfo(input('post.')));
        }
        $info = ['id' => null, 'title' => null, 'content' => null];
        $this->assign('info', $info);
        $this->assign('pagename', '添加资讯类型');
        return $this->fetch();
    }

    /**
     * 资讯类型修改
     */
    public function edits($id)
    {
        if (Request::instance()->isPost()) {
            return json(model('NoticeType')->changeState(input('post.')));
        }
        $this->assign("info", model('NoticeType')->noticeList($id));
        $this->assign('pagename', '修改资讯类型');
        return $this->fetch('add');
    }

    /**
     * 资讯类型删除
     */
    public function delete()
    {
        if (Request::instance()->isPost()) {
            return json(model('NoticeType')->deleteInfo(input('post.id')));
        }
    }

}