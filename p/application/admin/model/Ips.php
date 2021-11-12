<?php
namespace app\admin\model;

use app\common\model\Base;
use think\Request;
use think\db;

class Ips extends Base
{
    protected $table = 'sn_ip';
    const PAGE_LIMIT = '10';//用户表分页限制
    const PAGE_SHOW = '10';//显示分页菜单数量

    /**
     * 获取列表
     * @param  array $map 查询条件
     * @param  string $p  页码
     * @return array      返回列表
     */
    public function infoList($map, $p)
    {

        $request= Request::instance();
        $list = $this->where($map)->order('id desc')->page($p, self::PAGE_LIMIT)->select()->toArray();

        $return['count'] = $this->where($map)->count();
        $return['list'] = $list;
        $return['page'] = boot_page($return['count'], self::PAGE_LIMIT, self::PAGE_SHOW, $p,$request->action());
        return $return;
    }
}