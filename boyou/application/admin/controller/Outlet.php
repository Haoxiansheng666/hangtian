<?php

namespace app\admin\controller;

use app\admin\model\Company;
use app\admin\model\User;
use app\api\model\CompanyDetail;
use app\common\controller\Backend;

/**
 * 排口信息
 *
 * @icon fa fa-circle-o
 */
class Outlet extends Backend
{

    /**
     * Outlet模型对象
     * @var \app\admin\model\Outlet
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\Outlet;
        $this->view->assign("isOpenList", $this->model->getIsOpenList());
    }



    /**
     * 默认生成的控制器所继承的父类中有index/add/edit/del/multi五个基础方法、destroy/restore/recyclebin三个回收站方法
     * 因此在当前控制器中可不用编写增删改查的代码,除非需要自己控制这部分逻辑
     * 需要将application/admin/library/traits/Backend.php中对应的方法复制到当前控制器,然后进行修改
     */
    public function index()
    {
        //当前是否为关联查询
        $this->relationSearch = true;
        //设置过滤方法
        $this->request->filter(['strip_tags', 'trim']);
        if ($this->request->isAjax()) {
            //如果发送的来源是Selectpage，则转发到Selectpage
            if ($this->request->request('keyField')) {
                return $this->selectpage();
            }
            list($where, $sort, $order, $offset, $limit) = $this->buildparams();

            $where1 = [];
            $id = input('id');
            if($id){
                $detail_id = CompanyDetail::where('company_id',$id)->value('id');
                $where1['detail_id'] = $detail_id;
            }

            $list = $this->model
                ->where($where)
                ->where($where1)
                ->order($sort, $order)
                ->paginate($limit)
                ->each(function ($val){
                    $width = json_decode($val['width'],true);
                    $val['width'] = "长：".$width['length']."  宽：".$width['width'];
                    $length = json_decode($val['length'],true);
                    $val['length'] = "长：".$length['length']."  宽：".$length['width'];
                    return $val;
                });

            $result = array("total" => $list->total(), "rows" => $list->items());

            return json($result);
        }
        return $this->view->fetch();
    }

    /**
     * @param string $ids
     * @return string
     * @throws \think\Exception
     * @throws \think\exception\DbException
     */
    public function edit($ids = "")
    {
        $row = $this->model->get($ids);
        $row->width = json_decode($row->width,true);
        $row->length = json_decode($row->length,true);
        $row->detail = json_decode($row->detail,true);
        if (!$row) {
            $this->error(__('No Results were found'));
        }
        $this->assign('row',$row);
        return $this->view->fetch();
    }

}
