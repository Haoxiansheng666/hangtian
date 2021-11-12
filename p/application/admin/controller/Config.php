<?php
namespace app\admin\controller;

use app\common\controller\AdminBase;
use think\Request;
use think\Db;

class Config extends AdminBase
{

    public function index()
    {
        if (Request::instance()->isPost()) {
            $datas = input('post.');
            return json(model('Config')->saveConfig($datas));
        }
        $this->assign("list", model("Config")->configPage('index'));
        return $this->fetch();
    }

    public function info()
    {
        $this->assign("list", model("Config")->configPage('info'));
        return $this->fetch();
    }
    /**
     * 获取状态
     */
    public function data()
    {
        $tabs = db()->query('show table status');
        $total = 0;
        foreach ($tabs as $k => $v) {
            $tabs[$k]['size'] = byteFormat($v['Data_length'] + $v['Index_length']);
            $total += $v['Data_length'] + $v['Index_length'];
        }
        $this->assign("list", $tabs);
        $this->assign("total", byteFormat($total));
        $this->assign("tables", count($tabs));
        return $this->fetch();
    }

    public function setting($p = 1)
    {
        $this->assign("info", model("Config")->infoList(array(), $p));
        return $this->fetch();
    }
    /**
     * 添加
     */
    public function add()
    {
        if (Request::instance()->isPost()) {
            return json(model('Config')->saveInfo(input('post.')));
        }
        $this->assign("info", array('id' => null, 'key' => null, 'info' => null, 'url' => 'index', 'type' => '0'));
        $this->assign("url", model("Common/Dict")->showList('config_url'));
        $this->assign("type", model("Common/Dict")->showList('config_type'));
        return $this->fetch();
    }
    /**
     * 修改
     */
    public function edit($id)
    {
        $this->assign("info", model("Config")->listInfo($id));
        $this->assign("url", model("Common/Dict")->showList('config_url'));
        $this->assign("type", model("Common/Dict")->showList('config_type'));
        return $this->fetch('add');
    }
    /**
     * 邮箱设置
     */
    public function email()
    {
        if (Request::instance()->isPost()) {
            $datas = input('post.');
            return json(model('Config')->saveConfig($datas));
        }
        $this->assign("list", model("Config")->configPage('email'));
        return $this->fetch();
    }
}