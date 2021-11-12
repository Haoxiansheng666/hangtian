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

class Overviews extends AdminBase
{
    /**
     *产品概括列表
     * @param integer $p 页码
     */
    public function index($p = 1)
    {
        $map = array();
        $map['type'] = 1;
        $this->assign("info", model('Overview')->infoList($map, $p));
        $this->assign("state", model("Common/Dict")->showList('state'));//状态
        return $this->fetch();
    }
    
        //产品图片
    public function picture($p = 1)
    {
        $where['type'] = 2;
        $this->assign("info", model('Picture')->infoList($p, $where));
        $this->assign("state", model("Common/Dict")->showList('state'));//状态
        return $this->fetch();
    }

    /**
     *产品图片新增
     */
    public function picture_add()
    {
        if (Request::instance()->isPost()) {
            return json(model('Picture')->saveInfo(input('post.')));
        }
        $info = ['id' => null, 'name' => null, 'link' => null];
        $this->assign('info', $info);
        $this->assign('pagename', '添加产品图片');
        return $this->fetch('picture_add');
    }

    /**
     *产品图片修改
     */
    public function picture_edits($id)
    {
        $this->assign("info", model('Picture')->noticeList($id));
        $this->assign('pagename', '修改产品图片');
        return $this->fetch('picture_add');
    }


    /**
     *产品概括新增
     */
    public function add()
    {
        if (Request::instance()->isPost()) {
            return json(model('Overview')->saveInfo(input('post.')));
        }
        $info = ['id' => null, 'name' => null,'url'=>nill, 'title' => null, 'content' => null];
        $this->assign('info', $info);
        $this->assign('pagename', '添加产品概括');
        return $this->fetch();
    }

    /**
     * 产品概括修改
     */
    public function edits($id)
    {
        if (Request::instance()->isPost()) {
            return json(model('Overview')->changeState(input('post.')));
        }
        $this->assign("info", model('Overview')->noticeList($id));
        $this->assign('pagename', '修改产品概括');
        return $this->fetch('add');
    }


    /**
     *产品优势列表
     * @param integer $p 页码
     */
    public function adva($p = 1)
    {
        $map = array();
        $map['type'] = 2;
        $this->assign("info", model('Overview')->infoList($map, $p));
        $this->assign("state", model("Common/Dict")->showList('state'));//状态
        return $this->fetch();
    }

    /**
     *产品优势新增
     */
    public function adva_add()
    {
        if (Request::instance()->isPost()) {
            return json(model('Overview')->advaSaveInfo(input('post.')));
        }
        $info = ['id' => null, 'name' => null, 'title' => null, 'content' => null];
        $this->assign('info', $info);
        $this->assign('pagename', '添加产品优势');
        return $this->fetch();
    }

    /**
     * 产品优势修改
     */
    public function adva_edits($id)
    {
        if (Request::instance()->isPost()) {
            return json(model('Overview')->changeState(input('post.')));
        }
        $this->assign("info", model('Overview')->noticeList($id));
        $this->assign('pagename', '修改产品优势');
        return $this->fetch('adva_add');
    }


    /**
     *产品理念列表
     * @param integer $p 页码
     */
    public function ldea($p = 1)
    {
        $map = array();
        $map['type'] = 3;
        $this->assign("info", model('Overview')->infoList($map, $p));
        $this->assign("state", model("Common/Dict")->showList('state'));//状态
        return $this->fetch();
    }

    /**
     *产品优势新增
     */
    public function ldea_add()
    {
        if (Request::instance()->isPost()) {
            return json(model('Overview')->ldeaSaveInfo(input('post.')));
        }
        $info = ['id' => null, 'name' => null, 'title' => null, 'content' => null];
        $this->assign('info', $info);
        $this->assign('pagename', '添加产品理念');
        return $this->fetch();
    }

    /**
     * 产品优势修改
     */
    public function ldea_edits($id)
    {
        if (Request::instance()->isPost()) {
            return json(model('Overview')->changeState(input('post.')));
        }
        $this->assign("info", model('Overview')->noticeList($id));
        $this->assign('pagename', '修改产品理念');
        return $this->fetch('ldea_add');
    }

    /**
     * 删除
     */
    public function delete()
    {
        if (Request::instance()->isPost()) {
            return json(model('Overview')->deleteInfo(input('post.id')));
        }
    }

}