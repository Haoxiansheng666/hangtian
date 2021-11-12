<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/10/8
 * Time: 10:50
 */

namespace app\admin\controller;

use app\common\controller\AdminBase;
use think\Request;

class Services extends AdminBase
{
    /**
     *我们的特色列表
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
        $this->assign("info", model('Service')->infoList($map, $p));
        $this->assign("state", model("Common/Dict")->showList('state'));//状态
        return $this->fetch();
    }

    /**
     * 我们的特色新增
     */
    public function add()
    {
        if (Request::instance()->isPost()) {

            return json(model('Service')->saveInfo(input('post.')));
        }
        $info = ['id' => null, 'title' => null, 'content' => null];
        $this->assign('info', $info);
        $this->assign('pagename', '添加新闻');
        return $this->fetch();
    }

    /**
     * 我们的特色修改
     */
    public function edits($id)
    {
        if (Request::instance()->isPost()) {
            return json(model('Service')->changeState(input('post.')));
        }
        $this->assign("info", model('Service')->noticeList($id));
        $this->assign('pagename', '修改用户');
        return $this->fetch('add');
    }

    /**
     * 我们的特色删除
     */
    public function delete()
    {
        if (Request::instance()->isPost()) {
            return json(model('Service')->deleteInfo(input('post.id')));
        }
    }

}