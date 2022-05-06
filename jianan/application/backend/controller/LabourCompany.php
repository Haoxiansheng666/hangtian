<?php
namespace app\backend\controller;

use app\backend\logic\LabourLogic;
use app\backend\model\AdminUser;
use app\backend\model\ExamStudent;
use app\backend\model\GradeStudent;
use app\backend\model\LabourCompanyDemand;
use app\backend\model\LabourCompanyRefund;
use app\backend\model\LabourCompanyReturned;
use app\backend\model\LabourUserRecommend;
use app\backend\model\ProfessionCate;
use app\backend\model\ServiceContact;
use think\db\exception\DataNotFoundException;
use think\db\exception\ModelNotFoundException;
use think\Exception;
use think\exception\DbException;
use app\backend\model\LabourCompany as L;
use think\Log;
use think\Request;
use think\Db;

class LabourCompany extends Common{
    private $id;
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        // 工种分类
        $pro_cate_list= ProfessionCate::all();
        $this->assign('pro_cate_list',$pro_cate_list);
        // 业务员
        $admin_list = AdminUser::all([
            'group_id' => 8
        ]);
        $this->assign('admin_list',$admin_list);
        $status = (new L)->status();
        $work_exp = (new \app\backend\model\LabourUser)->work_exp();
        $xz = [
            '面议',
            '3000 - 5000',
            '5000 - 8000',
            '8000 - 12000',
            '12000以上'
        ];
        $this->assign([
            'status' => $status,
            'work_exp' => $work_exp,
            'xz' => $xz
        ]);
        $this->id = $this->request->param('id');
    }
    /** 用人企业 */
    /**
     * 就业学员列表
     * @return mixed
     */
    public function index(){
        return $this->fetch();
    }

    /**
     * 就业学员数据
     * @throws DbException
     */
    public function getData(){
        $param = $this->request->param();
        $where = LabourLogic::selectCompanyParam($param,$this->ausess());
        $grade_student = (new L())
            ->with('salesman,admin')
            ->where($where)
            ->order('id DESC')
            ->paginate($this->request->param('limit','15'));
        $data = $grade_student->items();
        layuiReturn($this->errCode('OK'),'',$grade_student->total(),$data);

    }

    /**
     * 增加就业人员
     * @return mixed
     * @throws DataNotFoundException
     * @throws DbException
     * @throws ModelNotFoundException
     */
    public function add(){
        if ($this->request->isPost()){
            $param = $this->request->param();
            $param['admin_id'] = $this->ausess()['auid'];
            // 增加校区字段
            if (!empty($this->ausess()['campus_id'])){
                $param['campus_id'] = $this->ausess()['campus_id'];
            }else{
                //添加人 没有校区的  添加到第一个校区里面
                $campus = \app\backend\model\Campus::all();
                $param['campus_id'] = array_column($campus,'id')[0];
            }
//            //权限组
//            $group_id = $this->ausess()['group_id'];
//            //部门   业务部 和  admin可有权限
//            $department = $this->ausess()['department_id'];
//            if ($department != 8 && $group_id != 1){
//                $this->error('只有就业部权限可添加用人单位');
//            }
            $model = new L();
            if (!empty($param['id'])){
                $model = $model->find(['id' => $param['id']]);
            }
            $model->allowField(true)->save($param);
            $this->success('保存成功');
        }
        $this->assign([
            'data' => [
                'cate_id' => 0,
            ]
        ]);
        return $this->fetch();
    }

    /**
     * 修改
     * @return mixed
     * @throws DataNotFoundException
     * @throws DbException
     * @throws ModelNotFoundException
     */
    public function edit(){
        if ($this->request->isPost()){
            $param = $this->request->param();
            $param['admin_id'] = $this->ausess()['auid'];
            // 增加校区字段
            if (!empty($this->ausess()['campus_id'])){
                $param['campus_id'] = $this->ausess()['campus_id'];
            }else{
                //添加人 没有校区的  添加到第一个校区里面
                $campus = \app\backend\model\Campus::all();
                $param['campus_id'] = array_column($campus,'id')[0];
            }
            $model = new L();
            if (!empty($param['id'])){
                $model = $model->find(['id' => $param['id']]);
            }
            $model->allowField(true)->save($param);
            $this->success('保存成功');
        }
        $user = (new L())->where('id',$this->id)->find();
        $this->assign([
            'data' => $user
        ]);
        return $this->fetch();
    }

    /**
     * 详情
     * @return mixed
     * @throws DataNotFoundException
     * @throws DbException
     * @throws ModelNotFoundException
     */
    public function detail(){
        $user = (new L())
            ->with('salesman,admin')
            ->where('id',$this->id)
            ->find();
        // 回款记录
        $returned_list = (new LabourCompanyReturned)
            ->with('admin')
            ->where(['company_id' => $this->id])
            ->select();
        // 退款记录
        $refund_list = (new LabourCompanyRefund)
            ->with('admin')
            ->where(['company_id' => $this->id])
            ->select();
        $this->assign([
            'user' => $user,
            'returned_list' => $returned_list,
            'refund_list' => $refund_list
        ]);
        return $this->fetch();
    }

    /**
     * 退款记录
     * @return mixed
     */
    public function refund(){
        if ($this->request->isPost()){
            $param = $this->request->param();
            // 增加校区字段
            if (!empty($this->ausess()['campus_id'])){
                $param['campus_id'] = $this->ausess()['campus_id'];
            }else{
                //添加人 没有校区的  添加到第一个校区里面
                $campus = \app\backend\model\Campus::all();
                $param['campus_id'] = array_column($campus,'id')[0];
            }
            $param['admin_id'] = $this->ausess()['auid'];
            $refund = LabourCompanyRefund::where('company_id',$param['id'])->find();
            if($refund && $refund['status'] == 0){
                //审核中覆盖
                $refund->save($param);
            }elseif(!$refund || ($refund && $refund['status'] == 2)){
                //没有或者拒绝 添加
                (new LabourCompanyRefund())->allowField(true)->save($param);
            }
            $this->success('退款记录添加成功');
        }
        $this->assign([
            'id' => $this->id,
            'name'=> \app\backend\model\LabourUser::where('id',$this->id)->value('name')
        ]);
        return $this->fetch();
    }

    /**
     * 回款记录
     * @return mixed
     */
    public function returned(){
        if ($this->request->isPost()){
            $param = $this->request->param();
            // 增加校区字段
            if (!empty($this->ausess()['campus_id'])){
                $param['campus_id'] = $this->ausess()['campus_id'];
            }else{
                //添加人 没有校区的  添加到第一个校区里面
                $campus = \app\backend\model\Campus::all();
                $param['campus_id'] = array_column($campus,'id')[0];
            }
            $param['admin_id'] = $this->ausess()['auid'];
            (new LabourCompanyReturned())->allowField(true)->save($param);
            $this->success('回款记录添加成功');
        }
        $this->assign([
            'id' => $this->id
        ]);
        return $this->fetch();
    }

    /**
     * 删除
     * @throws DbException
     */
    public function delete(){
        $user = L::get($this->id);
        $user->delete();
        $this->success('删除成功');
    }
    /** 用人企业 end */

    /** 企业需求 */
    /**
     * 企业需求列表
     * @return mixed
     */
    public function demand(){
        $this->assign([
            'id' => $this->id
        ]);
        return $this->fetch();
    }

    /**
     * 企业需求数据
     * @throws DbException
     */
    public function getDemandData(){
        $where = LabourLogic::selectDemandParam($this->request->param(),$this->ausess());
        $list = (new LabourCompanyDemand())
            ->with('profession')
            ->where($where)
            ->paginate($this->request->param('limit'));
        $data = $list->items();
        foreach ($data as $k => $v){
            if (!empty($v['profession']['name'])){
                $profession_top = \app\backend\model\Profession::get($v['profession']['pid']);
                $data[$k]['profession_name_text'] = $profession_top['name'] . ' - - ' . $v['profession']['name'];
            }
        }
        layuiReturn(0,'',$list->count(),$data);
    }

    /**
     * 创建需求
     * @return mixed
     */
    public function add_demand(){
        if ($this->request->isPost()){
            $param = $this->request->param();
            if (empty($param['profession_id'])){
                $this->error('请选择工种');
            }
            (new LabourCompanyDemand())->allowField(true)->save($param);
            $this->success('创建需求成功');
        }
        $company_id = $this->request->param('company_id');

        $this->assign([
            'company_id' => $company_id
        ]);
        return $this->fetch();
    }

    /**
     * 修改需求
     * @return mixed
     * @throws DbException
     */
    public function edit_demand(){
        if ($this->request->isPost()){
            $param = $this->request->param();
            if (empty($param['profession_id'])){
                $this->error('请选择工种');
            }
            $demand = LabourCompanyDemand::get($this->id);
            if (empty($demand)){
                $this->error('参数错误');
            }
            $demand->allowField(true)->save($param);
            $this->success('修改需求成功');
        }
        $data = LabourCompanyDemand::get($this->id);
        $profession = \app\backend\model\Profession::get($data['profession_id']);
        $data['cate_id'] = $profession['cate_id'];
        $data['pid'] = $profession['pid'];
        $this->assign([
            'data' => $data
        ]);
        return $this->fetch();
    }

    /**
     * 删除需求
     * @throws DbException
     */
    public function delete_demand(){
        $demand = LabourCompanyDemand::get($this->id);
        if (empty($demand)){
            $this->error('参数错误');
        }
        $demand->delete();
        $this->success('删除成功');
    }
    /** 企业需求 end */

    /** 推荐 */
    /**
     * 可推荐人员列表
     * @return mixed
     */
    public function recommend(){
        $this->assign([
            'company_id' => $this->request->param('company_id'),
            'demand_id' => $this->id
        ]);
        return $this->fetch('student');
    }

    /**
     * 可推荐人员数据
     * @throws DbException
     */
    public function getRecommendData(){
        $where = LabourLogic::selectRecommendParam($this->request->param(),$this->ausess());
        $list = (new \app\backend\model\LabourUser())
            ->where($where)
            ->where('status','1')
            ->paginate($this->request->param('limit'));
        $data = $list->items();
        layuiReturn(0,'',$list->count(),$data);
    }

    /**
     * 推荐人员去面试
     */
    public function recommend_add(){
        $param = $this->request->param();

        Db::startTrans();
        try{
            // 修改就业人员状态
            $user = \app\backend\model\LabourUser::get($param['labour_user_id']);
            $user->save([
                'status' => 2
            ]);
            // 增加推荐人数
            $demand = LabourCompanyDemand::get($param['demand_id']);
            $company = L::get($param['company_id']);
            $demand->setInc('recommend_num',1);
            $company->setInc('recommend_num',1);
            // 增加推荐记录
            $data = [
                'labour_user_id' => $param['labour_user_id'],
                'company_id' => $param['company_id'],
                'demand_id' => $param['demand_id']
            ];
            (new LabourUserRecommend())->allowField(true)->save($data);
            Db::commit();
        }catch(Exception $exception){
            Log::write('推荐面试:'.json_encode($exception->getMessage()));
            Db::rollback();
            $this->error('服务器错误');
        }
        $this->success('推荐成功');
    }

    /**
     * 推荐记录列表
     * @return mixed
     */
    public function recommend_log(){
        $this->assign([
            'company_id' => $this->request->param('company_id'),
            'demand_id' => $this->id,
            'status' => [
                '未面试',
                '面试成功',
                '已面试',
                '面试失败',
            ]
        ]);
        return $this->fetch();
    }

    /**
     * 推荐记录数据
     * @throws DbException
     */
    public function getRecommendLogData(){
        $where = LabourLogic::selectCompanyParam($this->request->param(),$this->ausess());
        $list = (new LabourUserRecommend())
            ->with('company,user,demand')
            ->where($where)
            ->paginate($this->request->param('limit'));
        $data = $list->items();
        foreach ($data as $k => $v){
            $v = $v->toArray();
            $user = $v['user'];
            unset($user['id']);
            unset($v['user']);
            $data[$k] = array_merge($user,$v);
        }
        layuiReturn(0,'',$list->count(),$data);
    }

    public function recommend_log_edit(){
        $param = $this->request->param();
        if ($this->request->isPost()){
            $log = LabourUserRecommend::get($param['id']);
            $user = \app\backend\model\LabourUser::get($log['labour_user_id']);
            // 修改记录状态和就业人员状态
            switch ($param['status']){
                case 2:
                    $status = 3;
                    break;
                case 3:
                    $status = 5;
                    break;
                case 1:
                    $status = 4;
                    break;
                default:
                    $status = 2;
                    break;
            }
            $user_data['status'] = $status;
            $log->save([
                'status' => $param['status']
            ]);
            $user->save($user_data);
            $this->success('就业人员状态修改成功');
        }

        $user = (new LabourUserRecommend())
            ->with('user,company,demand.profession')
            ->where([
                'id' => $param['labour_user_id'],
                'company_id' => $param['company_id'],
                'demand_id' => $param['demand_id'],
            ])
            ->find();
        $this->assign([
            'data' => $user
        ]);
        return $this->fetch();
    }
    /** 推荐 end */
}