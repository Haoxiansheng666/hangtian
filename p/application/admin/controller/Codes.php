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

class Codes extends AdminBase
{
    /**
     *轮播信息
     * @param integer $p 页码
     */
    public function index($p = 1)
    {
        $this->assign("info", model('Code')->infoList($p));
        $this->assign("state", model("Common/Dict")->showList('state'));//状态
        return $this->fetch();
    }

    /**
     * 轮播信息新增
     */
    public function add()
    {
        if (Request::instance()->isPost()) {
            return json(model('Code')->saveInfo(input('post.')));
        }
        $info = ['id' => null, 'title' => null, 'content' => null, 'link' => ''];
        $this->assign('info', $info);
        $this->assign('pagename', '添加二维码');
        return $this->fetch();
    }

    /**
     * 轮播信息修改
     */
    public function edits($id)
    {
        if (Request::instance()->isPost()) {
            return json(model('Code')->changeState(input('post.')));
        }
        $this->assign("info", model('Code')->noticeList($id));
        $this->assign('pagename', '修改二维码');
        return $this->fetch('add');
    }

    /**
     * 轮播信息删除
     */
    public function delete()
    {
        if (Request::instance()->isPost()) {
            return json(model('Code')->deleteInfo(input('post.id')));
        }
    }

}