<?php

namespace app\admin\controller;

use app\common\controller\AdminBase;
use app\admin\model\NoticeType;
use think\Request;

class Notices extends AdminBase
{
    /**
     *资讯列表
     * @param integer $p 页码
     */
    public function index($p = 1)
    {
        $map = [];
        $keywords = input('get.keywords') ? input('get.keywords') : null;
        if ($keywords) {
            $map['title'] = array('like', '%' . trim($keywords) . '%');
        }
        if (is_numeric(input('get.state'))) {
            $map['state'] = input('get.state');
        }
        $this->assign("info", model('Notice')->infoList($map, $p));
        $this->assign("state", model("Common/Dict")->showList('state'));//状态
        return $this->fetch();
    }

    /**
     * 资讯新增
     */
    public function add()
    {
        if (Request::instance()->isPost()) {
            return json(model('Notice')->saveInfo(input('post.')));
        }
        $NoticeType = new NoticeType();
        $list = $NoticeType->select();
        $info = ['id' => null, 'tid' => null, 'title' => null, 'content' => null];
        $this->assign('info', $info);
        $this->assign('list', $list);
        $this->assign('pagename', '添加资讯');
        return $this->fetch();
    }

    /**
     * 资讯修改
     */
    public function edits($id)
    {
        if (Request::instance()->isPost()) {
            return json(model('Notice')->changeState(input('post.')));
        }
        $NoticeType = new NoticeType();
        $list = $NoticeType->select();
        $this->assign("info", model('Notice')->noticeList($id));
        $this->assign('list', $list);
        $this->assign('pagename', '修改资讯');
        return $this->fetch('add');
    }

    /**
     * 资讯删除
     */
    public function delete()
    {
        if (Request::instance()->isPost()) {
            return json(model('Notice')->deleteInfo(input('post.id')));
        }
    }

}