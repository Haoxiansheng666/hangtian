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

class Teams extends AdminBase
{
    /**
     *团队照片列表
     * @param integer $p 页码
     */
    public function index($p = 1)
    {
        $this->assign("info", model('Team')->infoList($p));
        $this->assign("state", model("Common/Dict")->showList('state'));//状态
        return $this->fetch();
    }

    /**
     * 团队照片新增
     */
    public function add()
    {
        if (Request::instance()->isPost()) {

            return json(model('Team')->saveInfo(input('post.')));
        }
        $info = ['id' => null, 'title' => null, 'content' => null];
        $this->assign('info', $info);
        $this->assign('pagename', '添加团队照片');
        return $this->fetch();
    }

    /**
     * 团队照片修改
     */
    public function edits($id)
    {
        if (Request::instance()->isPost()) {
            return json(model('Notice')->changeState(input('post.')));
        }
        $this->assign("info", model('Team')->noticeList($id));
        $this->assign('pagename', '修改团队照片');
        return $this->fetch('add');
    }

    /**
     * 团队照片删除
     */
    public function delete()
    {
        if (Request::instance()->isPost()) {
            return json(model('Team')->deleteInfo(input('post.id')));
        }
    }

}