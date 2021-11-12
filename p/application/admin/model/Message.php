<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/9/30
 * Time: 11:31
 */

namespace app\admin\model;

use app\common\model\Base;
use think\Request;
use think\db;

class Message extends Base
{

    const PAGE_LIMIT = '10';//用户表分页限制
    const PAGE_SHOW = '10';//显示分页菜单数量

    /**
     * 获取列表
     * @param  array $map 查询条件
     * @param  string $p 页码
     * @return array      返回列表
     */
    public function infoList($p)
    {

        $request = Request::instance();
        $list = $this->order('id desc')->page($p, self::PAGE_LIMIT)->select()->toArray();
        $return['count'] = $this->count();
        $return['list'] = $list;
        $return['page'] = boot_page($return['count'], self::PAGE_LIMIT, self::PAGE_SHOW, $p, $request->action());
        return $return;
    }

    /**
     * 新增/修改
     * @param array $data 传入信息
     */
    public function saveInfo($data)
    {
        if (array_key_exists('id', $data)) {
            $id = $data['id'];
            if (!empty($id)) {
                $where = true;
            } else {
                $where = false;
            }
        } else {
            $where = false;
        }
        $AuthGroup = new AuthGroup();
        $data['time'] = time();
        $result = $this->allowField(true)->isUpdate($where)->save($data);
        if (false === $result) {
            return ['status' => 0, 'info' => $AuthGroup->getError()];
        } else {
            return array('status' => 1, 'info' => '保存成功', 'url' => url('index'));
        }
    }

    /**
     * 改变显示状态 is_show
     */
    public function changeState($data)
    {
        if ($this->where(array('id' => $data['id']))->update(array('is_show' => $data['status']))) {
            return array('is_show' => 1, 'info' => '更改状态成功');
        } else {
            return array('is_show' => 0, 'info' => '更改状态失败');
        }
    }

    /**
     * 删除
     * @param  string $id ID
     */
    public function deleteInfo($id)
    {
        if ($this->where(array('id' => $id))->delete()) {
            return ['status' => 1, 'info' => '删除成功'];
        } else {
            return ['status' => 0, 'info' => '删除失败,请重试'];
        }
    }

    /**
     * 根据查询条件获取信息
     */
    public function menuList($id)
    {
        $list = $this->where('id', $id)->find();
        return $list;
    }

    /**
     * 根据查询条件获取信息
     * @param string $map [查询条件]
     * @return mixed
     */
    public function noticeList($id)
    {
        $list = $this->where('id', $id)->find();
        return $list;
    }
}