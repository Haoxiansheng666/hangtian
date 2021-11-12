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

class Banners extends AdminBase
{
    /**
     *轮播信息
     * @param integer $p 页码
     */
    public function index($p = 1)
    {
        $this->assign("info", model('Banner')->infoList($p));
        $this->assign("state", model("Common/Dict")->showList('state'));//状态
        return $this->fetch();
    }

    /**
     * 轮播信息新增
     */
    public function add()
    {
        if (Request::instance()->isPost()) {
            return json(model('Banner')->saveInfo(input('post.')));
        }
        $info = ['id' => null, 'title' => null, 'content' => null, 'link' => ''];
        $this->assign('info', $info);
        $this->assign('pagename', '添加轮播');
        return $this->fetch();
    }

    /**
     * 轮播信息修改
     */
    public function edits($id)
    {
        if (Request::instance()->isPost()) {
            return json(model('Notice')->changeState(input('post.')));
        }
        $this->assign("info", model('Banner')->noticeList($id));
        $this->assign('pagename', '修改轮播');
        return $this->fetch('add');
    }

    /**
     * 轮播信息删除
     */
    public function delete()
    {
        if (Request::instance()->isPost()) {
            return json(model('Banner')->deleteInfo(input('post.id')));
        }
    }

}