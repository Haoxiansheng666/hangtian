<?php

namespace app\admin\controller\noice;

use app\admin\model\Company;
use app\admin\model\Noise;
use app\admin\model\User;
use app\common\controller\Backend;
use think\Db;
use think\exception\PDOException;
use think\exception\ValidateException;

/**
 * 噪音记录管理
 *
 * @icon fa fa-circle-o
 */
class Record extends Backend
{

    /**
     * Record模型对象
     * @var \app\admin\model\noise\Record
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\noise\Record;
        $this->view->assign("statusList", $this->model->getStatusList());
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
                $where1['company_id'] = $id;
            }
            $list = $this->model
                ->where($where)
                ->where($where1)
                ->order($sort, $order)
                ->paginate($limit);

            foreach ($list as $row) {
                $row->company_id = Company::where('id',$row->company_id)->value('company');
                $row->user_id = User::where('id',$row->user_id)->value('username');
            }

            $result = array("total" => $list->total(), "rows" => $list->items());

            return json($result);
        }
        return $this->view->fetch();
    }

    /**
     * @param string $ids
     * @return string|void
     * @throws \think\Exception
     * @throws \think\exception\DbException
     */
    public function edit($ids = '')
    {
        $row = $this->model->get($ids);
        if (!$row) {
            $this->error(__('No Results were found'));
        }
        $noises = json_decode($row->noises,true);
        foreach ($noises as $key=>$val){
            $noises[$key]['id_text'] = Noise::where('id',$val['id'])->value('value');
            $value = Noise::where('id',$val['value_id'])->value('value');
            $noises[$key]['values'] = json_decode($value,true);
        }
        $row->company_id = Company::where('id',$row->company_id)->value('company');
        $row->user_id = User::where('id',$row->user_id)->value('username');
        $row->noises = $noises;
        $this->assign('row',$row);
        return $this->view->fetch();
    }
}
