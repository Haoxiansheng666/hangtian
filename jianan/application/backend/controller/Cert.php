<?php
namespace app\backend\controller;
use app\backend\logic\CertLogic;
use app\backend\model\Company;
use app\backend\model\PayStudent as C;
use app\backend\model\ProfessionCate;
use think\exception\DbException;
use think\Request;
use app\backend\model\AdminUser;
use app\backend\model\Grade as G;

class Cert extends Common
{
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        // 班主任
        $aulist=AdminUser::all(['group_id' => 4]);
        $this->assign('aulist',$aulist);
        // 工种分类
        $pro_cate_list= ProfessionCate::all();
        $this->assign('pro_cate_list',$pro_cate_list);
        // 状态
        $status = (new G)->getStatusArray();
        $this->assign('status_list',$status);
    }

    /**
     * 线上班级列表页面
     * @return mixed
     */
    public function index_audit(){
        $param = input();
        $batch = isset($param['batch']) && !empty($param['batch']) ? $param['batch'] : '' ;
        $this->assign('batch',$batch);
        $this->assign('ware_id',1);
        return $this->fetch();
    }

    /**
     * 获取线上班级数据
     * @throws DbException
     */
    public function getAuditData(){
        $param = $this->request->param();
        $where = CertLogic::selectParam($param,$this->ausess());
        if (!empty($this->campus_id)){
            $where['campus_id'] = $this->campus_id;
        }else{
            //添加人 没有校区的  添加到第一个校区里面
            $campus = \app\backend\model\Campus::all();
            $where['campus_id'] = array_column($campus,'id')[0];
        }
        if(isset($param['batch']) && !empty($param['batch'])){
            $where['batch_number'] = $param['batch'];
        }
        //已领证 未领证
        if (isset($param['status']) && !empty($param['status'])) {
            $where['status'] = ['in',explode(',',$param['status'])];
        }
        $list = (new \app\backend\model\Cert())
            ->with('payStudent.admin')
            ->where($where)
            ->paginate($this->request->param('limit'));
        $data = $list->items();
        layuiReturn($this->errCode('OK'), '获取成功', $list->count(), $data);
    }

    /**
     * 线上班级列表页面
     * @return mixed
     */
    public function qiye_audit(){
        $this->assign('ware_id',1);
        return $this->fetch();
    }

    /**
     * 获取线上班级数据
     * @throws DbException
     */
    public function qiyeAuditData(){
        $input = input();
        $status = isset($input['status']) && !empty($input['status']) ? $input['status'] : 0;
        $keyword = isset($input['keyword']) && !empty($input['keyword']) ? $input['keyword'] : "";
        $pay_log = \app\backend\model\Cert::where('status','in',$status)->where('batch_number is not null')->where(function ($query)use($keyword){
            if($keyword){
                $company_id = Company::where('mobile like "%'.$keyword.'%" or company like "%'.$keyword.'%"')->column('id');
                $where = 'batch_number like "%'.$keyword.'%"';
                if($company_id){
                    $where .= " or company_id in (".implode(',',$company_id).")";
                }
                $query->where($where);
            }
        })->group('batch_number')->paginate($input['limit']);
        //})->group('batch_number')->fetchSql()->select();
        foreach ($pay_log as $key=>$value){
            $company = Company::get($value['company_id']);
            $pay_log[$key]['company'] = $company['company']; $pay_log[$key]['contact'] = $company['contact'];  $pay_log[$key]['mobile'] = $company['mobile'];
        }
        layuiReturn($this->errCode('OK'), '获取成功',$pay_log->count(),$pay_log->items());
    }

    /**
     * 领证申请已通过
     * @throws DbException
     */
    public function consent(){
        $input = input();
        $id = $input['id'] ?? 0;
        $batch = $input['batch'] ?? 0;
        //个人审核
        if($id){
            $cert = \app\backend\model\Cert::get($id);
            $student = C::get($cert['pay_student_id']);
            if ($this->request->isPost()){
                // 修改学员状态
                $student->save([
                    'status' => 8
                ]);
                $cert->save([
                    'status' => 1,
                    'expressage_number' => $this->request->param('expressage_number'),
                    'address' => $this->request->param('address')
                ]);
                $this->success('领证申请已通过');
            }
            $profession =  \app\backend\model\Profession::get($student['profession_id']);
            $this->assign([
                'id' => $id,
                'cert' => $cert,
                'profession' => $profession,
                'student' => $student
            ]);
        }elseif($batch){
            //批次审核
            $cert = \app\backend\model\Cert::where('batch_number',$batch)->find();
            $student = Company::where('id',$cert['company_id'])->field('contact as name,mobile')->find();
            $this->assign(['batch' => $batch, 'cert' => $cert,'student'=>$student]);
            if ($this->request->isPost()){
                $pay_student_id = \app\backend\model\Cert::where('batch_number',$batch)->column('pay_student_id');
                // 修改学员状态
                \app\backend\model\PayStudent::where('id','in',$pay_student_id)->update(['status' => 8]);
                \app\backend\model\Cert::where('batch_number',$batch)->update([
                    'status' => 1,
                    'expressage_number' => $this->request->param('expressage_number'),
                    'address' => $this->request->param('address')
                ]);
                $this->success('领证申请已通过');
            }
        }
        return $this->fetch();
    }


    /**
     * 领证申请已拒绝
     * @throws DbException
     */
    public function refuse(){
        $input = input();
        $id = $input['id'] ?? 0;
        $batch = $input['batch'] ?? 0;
        if($id){
            if ($this->request->isPost()){
                $post = input();
                // 修改学员状态
                $cert = \app\backend\model\Cert::get($id);
                $cert->save(['status' => '-1','feedback'=>$post['feedback']]);
                $this->success('领证申请已拒绝');
            }
            $this->assign('id',$id);
        }elseif ($batch){

            if ($this->request->isPost()){
                $post = input();
                // 修改学员状态
                \app\backend\model\Cert::where('batch_number', $batch)->update(['status' => '-1', 'feedback' => $post['feedback']]);
                $this->success('领证申请已拒绝');
            }
            $this->assign('batch',$batch);
        }
        return $this->fetch();
    }

    /**
     * @param $data
     */
    public function after_add($data){

    }

    /**
     * @param $data
     */
    protected function write_log($data){

    }

    /**
     * @param $data
     */
    protected function after_del($data){

    }
}
