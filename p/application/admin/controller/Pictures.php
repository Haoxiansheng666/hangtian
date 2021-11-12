<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/10/8
 * Time: 11:46
 */

namespace app\admin\controller;

use app\common\controller\AdminBase;
use think\Request;

class Pictures extends AdminBase
{
    /**
     *许可资质列表
     * @param integer $p 页码
     */
    public function index($p = 1)
    {
        $where['type'] = 1;
        $this->assign("info", model('Picture')->infoList($p,$where));
        $this->assign("state", model("Common/Dict")->showList('state'));//状态
        return $this->fetch();
    }

    /**
     *许可资质新增
     */
    public function add()
    {
        if (Request::instance()->isPost()) {

            return json(model('Picture')->saveInfo(input('post.')));
        }
        $info = ['id' => null, 'name' => null, 'link' => null];
        $this->assign('info', $info);
        $this->assign('pagename', '添加许可资质');
        return $this->fetch('add');
    }

    /**
     * 产品介绍修改
     */
    public function edits($id)
    {
        if (Request::instance()->isPost()) {
            return json(model('Picture')->changeState(input('post.')));
        }
        $this->assign("info", model('Picture')->noticeList($id));
        $this->assign('pagename', '修改许可资质');
        return $this->fetch('add');
    }

    /**
     * 许可资质删除
     */
    public function delete()
    {
        if (Request::instance()->isPost()) {
            return json(model('Picture')->deleteInfo(input('post.id')));
        }
    }


    /**
     *视频列表
     * @param integer $p 页码
     */
    public function video($p = 1)
    {
        $map = [];
        $keywords = input('get.keywords') ? input('get.keywords') : null;
        if ($keywords) {
            $map['title'] = array('like', '%' . trim($keywords) . '%');
        }
        if (is_numeric(input('get.state'))) {
            $map['state'] = input('get.state');
        }
        $map['type'] = 3;
        $this->assign("info", model('Picture')->infoList($map, $p));
        $this->assign("state", model("Common/Dict")->showList('state'));//状态
        return $this->fetch();
    }

    /**
     * 视频新增
     */
    public function add_video()
    {
        if (Request::instance()->isPost()) {

            return json(model('Picture')->saveVideo(input('post.')));
        }
        $info = ['id' => null, 'title' => null, 'content' => null];
        $this->assign('info', $info);
        $this->assign('pagename', '添加产品介绍');
        return $this->fetch();
    }


    /**
     * 视频修改
     */
    public function edits_video($id)
    {
        if (Request::instance()->isPost()) {
            return json(model('Picture')->changeState(input('post.')));
        }
        $this->assign("info", model('Picture')->noticeList($id));
        $this->assign('pagename', '修改产品介绍');
        return $this->fetch('add_video');
    }


}