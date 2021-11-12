<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/10/8
 * Time: 11:16
 */
namespace app\admin\controller;

use app\common\controller\AdminBase;
use think\Request;

class Partners extends AdminBase
{
    /**
     *合作伙伴列表
     * @param integer $p 页码
     */
    public function index($p = 1)
    {
        $this->assign("info", model('Partner')->infoList($p));
        $this->assign("state", model("Common/Dict")->showList('state'));//状态
        return $this->fetch();
    }

    /**
     * 合作伙伴新增
     */
    public function add()
    {
        if (Request::instance()->isPost()) {

            return json(model('Partner')->saveInfo(input('post.')));
        }
        $info = ['id' => null, 'title' => null, 'content' => null];
        $this->assign('info', $info);
        $this->assign('pagename', '添加合作伙伴');
        return $this->fetch();
    }

    /**
     * 合作伙伴修改
     */
    public function edits($id)
    {
        if (Request::instance()->isPost()) {
            return json(model('Partner')->changeState(input('post.')));
        }
        $this->assign("info", model('Partner')->noticeList($id));
        $this->assign('pagename', '修改合作伙伴');
        return $this->fetch('add');
    }

    /**
     * 合作伙伴删除
     */
    public function delete()
    {
        if (Request::instance()->isPost()) {
            return json(model('Partner')->deleteInfo(input('post.id')));
        }
    }

}