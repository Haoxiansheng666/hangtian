<?php

namespace app\admin\controller;

use app\common\controller\AdminBase;
use app\admin\model\NoticeType;
use think\Request;

class Footers extends AdminBase
{
    /**
     *底部备案列表
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
        $this->assign("info", model('Footer')->infoList($map, $p));
        $this->assign("state", model("Common/Dict")->showList('state'));//状态
        return $this->fetch();
    }

    /**
     * 底部备案新增
     */
    public function add()
    {
        if (Request::instance()->isPost()) {
            return json(model('Footer')->saveInfo(input('post.')));
        }
        $NoticeType = new NoticeType();
        $list = $NoticeType->select();
        $info = ['id' => null, 'type' => null,  'name' => null, 'url' => null, 'sort' => null];
        $this->assign('info', $info);
        $this->assign('list', $list);
        $this->assign('pagename', '添加底部备案');
        return $this->fetch();
    }

    /**
     * 底部备案修改
     */
    public function edits($id)
    {
        if (Request::instance()->isPost()) {
            return json(model('Footer')->changeState(input('post.')));
        }
        $this->assign("info", model('Footer')->noticeList($id));
        $this->assign('pagename', '修改底部备案');
        return $this->fetch('add');
    }

    /**
     * 底部备案删除
     */
    public function delete()
    {
        if (Request::instance()->isPost()) {
            return json(model('Footer')->deleteInfo(input('post.id')));
        }
    }

}