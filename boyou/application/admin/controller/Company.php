<?php

namespace app\admin\controller;

use app\admin\model\User;
use app\api\model\CompanyDetail;
use app\api\model\DetailType;
use app\api\model\Outlet;
use app\common\controller\Backend;
use app\common\model\ScoreLog;

/**
 * 经营三方端申请
 *
 * @icon fa fa-circle-o
 */
class Company extends Backend
{

    /**
     * Company模型对象
     * @var \app\admin\model\Company
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\Company;
        $this->view->assign("typeList", $this->model->getTypeList());
        $this->view->assign("statusList", $this->model->getStatusList());
        $this->view->assign("openList", $this->model->getOpenList());
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

            $list = $this->model
                    ->with(['user'])
                    ->where($where)
                    ->where('fa_company.type',1)
                    ->order($sort, $order)
                    ->paginate($limit);

            foreach ($list as $row) {
                
                $row->getRelation('user')->visible(['username','mobile']);
            }

            $result = array("total" => $list->total(), "rows" => $list->items());

            return json($result);
        }
        return $this->view->fetch();
    }

    /**
     * 基本信息
     * @return string
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function base()
    {
        $id = input('ids');
        $company = \app\admin\model\Company::get($id);
        $company['user'] = User::get($company['user_id']);
        $detail = CompanyDetail::get(['company_id'=>$id]);
        if($detail){
            $detail['count'] = Outlet::where('detail_id',$detail['id'])->count();
            $detail['type_text'] = DetailType::where('id',$detail['type'])->value('name');
        }
        $company['detail'] = $detail;
        $this->assign('row',$company);
        return $this->view->fetch();
    }

    /**
     * 业务员/财务审核
     * @param string $ids
     * @throws \think\exception\DbException
     */
    public function agree($ids = '')
    {
        $row = $this->model->get($ids);
        $status = $this->request->param('status');
        $row->status = $status;
        $row->save();
        if($status == 1){
            User::where(['id'=>$row['user_id']])->update(['is_in'=>1]);
        }
        $this->success('操作成功');
    }

}
