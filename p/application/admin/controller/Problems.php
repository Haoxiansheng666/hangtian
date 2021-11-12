<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/10/9
 * Time: 9:32
 */

namespace app\admin\controller;

use app\common\controller\AdminBase;
use think\Request;

class Problems extends AdminBase
{
    /**
     *解决方案列表
     * @param integer $p 页码
     */
    public function index($p = 1)
    {
        $map = array();
        $this->assign("info", model('Problem')->infoList($map, $p));
        $this->assign("state", model("Common/Dict")->showList('state'));//状态
        return $this->fetch();
    }

    /**
     * 解决方案新增
     */
    public function add()
    {
        if (Request::instance()->isPost()) {

            return json(model('Problem')->saveInfo(input('post.')));
        }
        $info = ['id' => null, 'name' => null, 'link' => null, 'content' => null];
        $this->assign('info', $info);
        $this->assign('pagename', '添加解决方案');
        return $this->fetch();
    }

    /**
     * 解决方案修改
     */
    public function edits($id)
    {
        if (Request::instance()->isPost()) {
            return json(model('Problem')->changeState(input('post.')));
        }
        $this->assign("info", model('Problem')->noticeList($id));
        $this->assign('pagename', '修改解决方案');
        return $this->fetch('add');
    }

    /**
     *服务支持列表
     * @param integer $p 页码
     */
    public function service($p = 1)
    {
        $map = array();
        $this->assign("info", model('Problem')->infoList($map, $p));
        $this->assign("state", model("Common/Dict")->showList('state'));//状态
        return $this->fetch();
    }

    /**
     * 服务支持新增/修改
     */
    public function service_add()
    {
        if (Request::instance()->isPost()) {
            return json(model('Problem')->serviceSaveInfo(input('post.')));
        }
        $info = ['id' => null, 'name' => null, 'link' => null, 'content' => null];
        $this->assign('info', $info);
        $this->assign('pagename', '添加服务支持');
        return $this->fetch();
    }

    /**
     * 服务支持修改
     */
    public function service_edits($id)
    {
        if (Request::instance()->isPost()) {
            return json(model('Problem')->changeState(input('post.')));
        }
        $this->assign("info", model('Problem')->noticeList($id));
        $this->assign('pagename', '修改服务支持');
        return $this->fetch('service_add');
    }

    /**
     *服务支持列表
     * @param integer $p 页码
     */
    public function problem($p = 1)
    {
        $map = array();
        $this->assign("info", model('Problem')->infoList($map, $p));
        $this->assign("state", model("Common/Dict")->showList('state'));//状态
        return $this->fetch();
    }

    /**
     * 解决方案新增/修改
     */
    public function problem_add()
    {
        if (Request::instance()->isPost()) {
            return json(model('Problem')->problemSaveInfo(input('post.')));
        }
        $info = ['id' => null, 'name' => null, 'link' => null, 'content' => null];
        $this->assign('info', $info);
        $this->assign('pagename', '添加解决方案');
        return $this->fetch();
    }

    /**
     * 解决方案修改
     */
    public function problem_edits($id)
    {
        if (Request::instance()->isPost()) {
            return json(model('Problem')->changeState(input('post.')));
        }
        $this->assign("info", model('Problem')->noticeList($id));
        $this->assign('pagename', '修改解决方案');
        return $this->fetch('problem_add');
    }

    /**
     * 解决方案/服务支持删除
     */
    public function delete()
    {
        if (Request::instance()->isPost()) {
            return json(model('Problem')->deleteInfo(input('post.id')));
        }
    }

}