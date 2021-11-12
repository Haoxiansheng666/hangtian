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

class Products extends AdminBase
{
    /**
     *产品介绍列表
     * @param integer $p 页码
     */
    public function index($p = 1)
    {
        $this->assign("info", model('Product')->infoList($p));
        $this->assign("state", model("Common/Dict")->showList('state'));//状态
        return $this->fetch();
    }

    /**
     *产品介绍新增
     */
    public function add()
    {
        if (Request::instance()->isPost()) {

            return json(model('Product')->saveInfo(input('post.')));
        }
        $info = ['id' => null, 'title' => null, 'content' => null];
        $this->assign('info', $info);
        $this->assign('pagename', '添加产品介绍');
        return $this->fetch();
    }

    /**
     * 产品介绍修改
     */
    public function edits($id)
    {
        if (Request::instance()->isPost()) {
            return json(model('Product')->changeState(input('post.')));
        }
        $this->assign("info", model('Product')->noticeList($id));
        $this->assign('pagename', '修改产品介绍');
        return $this->fetch('add');
    }

    /**
     * 产品介绍删除
     */
    public function delete()
    {
        if (Request::instance()->isPost()) {
            return json(model('Product')->deleteInfo(input('post.id')));
        }
    }

}