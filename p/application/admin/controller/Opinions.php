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

class Opinions extends AdminBase
{
    /**
     *咨询信息
     * @param integer $p 页码
     */
    public function index($p = 1)
    {
        $this->assign("info", model('Opinion')->infoList($p));
        $this->assign("state", model("Common/Dict")->showList('state'));//状态
        return $this->fetch();
    }

}