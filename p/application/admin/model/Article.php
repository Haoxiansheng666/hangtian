<?php

namespace app\admin\model;

use app\common\model\Base;
use think\Request;
use think\db;

class Article extends Base
{

    const PAGE_LIMIT = '10';//用户表分页限制
    const PAGE_SHOW = '10';//显示分页菜单数量

    /**
     * 获取列表
     * @param $map
     * @param $page
     * @return array
     * @throws \think\exception\DbException
     * @throws db\exception\DataNotFoundException
     * @throws db\exception\ModelNotFoundException
     */
    public function infoList($map, $page)
    {
        $request = Request::instance();
        $list = $this->where($map)->order('id desc')->page($page, self::PAGE_LIMIT)->select()->toArray();
        foreach ($list as $k => $v) {
            $name = db('Category')->where('id', $v['category'])->field('name')->find();
            $list[$k]['type'] = $name['name'];
        }
        $return['count'] = $this->where($map)->count();
        $return['list'] = $list;
        $return['page'] = boot_page($return['count'], self::PAGE_LIMIT, self::PAGE_SHOW, $page, $request->action());
        return $return;
    }

    /**
     * 新增/修改
     * @param $data
     * @return array
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
        $article = new Article();
        if (empty($id)){
            $data['createtime'] = time();
        }
        $result = $this->allowField(true)->isUpdate($where)->save($data);
        if (false === $result) {
            return ['status' => 0, 'info' => $article->getError()];
        } else {
            return array('status' => 1, 'info' => '保存成功', 'url' => url('index'));
        }
    }

    /**
     * 改变显示状态
     * @param $data
     * @return array
     */
    public function changeState($data)
    {
        if ($this->where(array('id' => $data['id']))->update(array('status' => $data['status']))) {
            return array('status' => 1, 'info' => '更改状态成功');
        } else {
            return array('status' => 0, 'info' => '更改状态失败');
        }
    }

    /**
     * 删除
     * @param $id
     * @return array
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
     * @param $id
     * @return array|bool|\PDOStatement|string|\think\Model|null
     * @throws \think\exception\DbException
     * @throws db\exception\DataNotFoundException
     * @throws db\exception\ModelNotFoundException
     */
    public function menuList($id)
    {
        $list = $this->where('id', $id)->find();
        return $list;
    }

    /**
     * 根据查询条件获取信息
     * @param $id
     * @return array|bool|\PDOStatement|string|\think\Model|null
     * @throws \think\exception\DbException
     * @throws db\exception\DataNotFoundException
     * @throws db\exception\ModelNotFoundException
     */
    public function articleList($id)
    {
        $list = $this->where('id', $id)->find();
        return $list;
    }
}