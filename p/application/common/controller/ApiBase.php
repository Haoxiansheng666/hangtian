<?php
/**
 * api接口基类
 */
namespace app\common\controller;
use app\common\controller\Base;

class ApiBase extends Base
{
    public function _initialize()
    {
        parent::_initialize();
    }

    /*
     * 统一返回json格式
     * */
    public function rtn($code = 0, $msg = '', $data = array())
    {
        return array(
            'code' => $code,
            'msg' => $msg,
            'data' => $data
        );
    }
}

