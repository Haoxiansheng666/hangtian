<?php

namespace app\admin\controller;

use app\admin\model\User;
use app\common\controller\Backend;

/**
 * 投诉管理
 *
 * @icon fa fa-circle-o
 */
class Complaint extends Backend
{

    /**
     * Complaint模型对象
     * @var \app\admin\model\Complaint
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\Complaint;
        $this->view->assign("isLevelList", $this->model->getIsLevelList());
        $this->view->assign("statusList", $this->model->getStatusList());
    }



    /**
     * 默认生成的控制器所继承的父类中有index/add/edit/del/multi五个基础方法、destroy/restore/recyclebin三个回收站方法
     * 因此在当前控制器中可不用编写增删改查的代码,除非需要自己控制这部分逻辑
     * 需要将application/admin/library/traits/Backend.php中对应的方法复制到当前控制器,然后进行修改
     */


    /**
     * 查看
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

            $where1 = [];$id = input('id');
            if($id){
                $where1['fa_company.id'] = $id;
            }
            $list = $this->model
                    ->with(['company'])
                    ->where($where)
                    ->where($where1)
                    ->order($sort, $order)
                    ->paginate($limit);

            foreach ($list as $row) {
                $row->getRelation('company')->visible(['company','address']);
                $row->user_id = \app\admin\model\Company::where('user_id',$row->user_id)->value('contact');
                $row->check_id = \app\admin\model\Company::where('user_id',$row->user_id)->value('contact');
            }

            $result = array("total" => $list->total(), "rows" => $list->items());

            return json($result);
        }
        return $this->view->fetch();
    }

}
