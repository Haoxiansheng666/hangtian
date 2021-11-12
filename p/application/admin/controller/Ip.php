<?php

namespace app\admin\controller;

use app\common\controller\AdminBase;
use think\Request;
use think\Db;

class Ip extends AdminBase {

    /**
     * 协议
     * @param integer $p 页码
     */
    public function index($p = 1) {
        $map=array();
        $this->assign("info", model('Ips')->infoList($map, $p));
        return $this->fetch();
    }

}
