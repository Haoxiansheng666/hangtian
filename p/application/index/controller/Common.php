<?php

namespace app\index\controller;

use \think\Controller;
use app\index\model\Config;
use app\index\model\Code;
use app\index\model\Top;
use app\index\model\Footer;

class Common extends Controller
{

    private $Config;

    public function __construct(\think\Request $request = null)
    {
        parent::__construct($request);
        $this->Config = new Config();
        $this->Code = new Code();
        $this->Top = new Top();
        $this->Footer = new Footer();
        $server = 'http://' . $_SERVER['HTTP_HOST'];
        $top = $this->Top->query_list();//顶部导航
        $data['tel'] = $this->Config->query_one(['key' => 'tel']);
        $data['email'] = $this->Config->query_one(['key' => 'EMAIL']);
        $data['address'] = $this->Config->query_one(['key' => 'ADDRESS']);
        $data['gzh'] = $this->Config->query_one(['key' => 'GZH']);
        $data['work_time'] = $this->Config->query_one(['key' => 'WORK_TIME']);
        $data['email_id'] = $this->Config->query_one(['key' => 'EMAIL_ID']);
        $data['description'] = $this->Config->query_one(['key' => 'DESC']);
        $data['keyword'] = $this->Config->query_one(['key' => 'KEYWORD']);
        $data['up'] = $this->Code->query_one(['id' => 1]);
        $data['down'] = $this->Code->query_one(['id' => 2]);
        $footer_up = $this->Footer->query_list(['type' => 1]);//底部备案
        $footer_down = $this->Footer->query_list(['type' => 2]);//底部备案
        $this->assign('server', $server);
        $this->assign('top', $top);
        $this->assign('data', $data);
        $this->assign('footer_up', $footer_up);
        $this->assign('footer_down', $footer_down);
    }

}
