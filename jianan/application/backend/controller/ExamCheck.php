<?php
namespace app\backend\controller;
use app\backend\logic\GradeLogic;
use app\backend\model\ExamStudent;
use app\backend\model\GradeStudent;
use app\backend\model\PayStudent as C;
use app\backend\model\ProfessionCate;
use think\Db;
use think\db\exception\DataNotFoundException;
use think\db\exception\ModelNotFoundException;
use think\Exception;
use think\exception\DbException;
use think\Log;
use think\Request;
use app\backend\model\AdminUser;
use app\backend\model\Grade as G;
class ExamCheck  extends Common
{
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        // 班主任
//        $aulist=AdminUser::all(['group_id' => 4]);
        $aulist=AdminUser::all(['group_id' => 13]);
        $this->assign('aulist',$aulist);
        // 工种分类
        $pro_cate_list= ProfessionCate::all();
        $this->assign('pro_cate_list',$pro_cate_list);
        // 状态
        $status = (new G)->getStatusArray();
        $this->assign('status_list',$status);
    }

    /**
     * 异常管理列表
     * @return mixed
     */
    public function index(){
        return $this->fetch();
    }

    /**
     * 异常管理数据
     * @throws DbException
     */
    public function getData(){
        $where = [
            'status' => 0
        ];
        $list = (new \app\backend\model\ExamCheck())
            ->with('student,teacher,admin,profession,exam')
            ->where($where)
            ->order('id DESC')
            ->paginate($this->request->param('limit','15'))
            ->each(function ($item){
                $profession_top = \app\backend\model\Profession::get($item['profession']['pid']);
                $item['profession_name_text'] = $profession_top['name'] . ' - - ' .$item['profession']['name'];
                return $item;
            });
        $data = $list->items();
        layuiReturn($this->errCode('OK'), '获取成功', $list->count(), $data);
    }

    /**
     * 异常审核-同意
     * @throws DbException|Exception
     */
    public function consent(){
        $loss = \app\backend\model\ExamCheck::get($this->request->param('id'));
        // 修改学员状态
        $student = C::get($loss['student_id']);
        $student->status = "-1";
        $student->save();
        // 删除班级里学员信息
        $g_student = ExamStudent::get([
            'exam_id' => $loss['exam_id'],
            'pay_student_id' => $loss['student_id']
        ]);
        if (!empty($g_student) ) {
            $g_student->save([
                'status' => '-1'
            ]);
        }
        // 班级学员人数减少
//        $grade = \app\backend\model\Exam::get($loss['exam_id']);
//        $grade->setDec('actual_student_num',1);
        // 修改异常审核状态
        $loss->check_time = time();
        $loss->status = 1;
        $loss->check_admin_id = $this->ausess()['auid'];
        $loss->save();
        $this->success('异常审核已同意');
    }

    /**
     * 异常审核-拒绝
     * @throws DbException
     */
    public function refuse(){
        if ($this->request->isPost()){
            $loss = \app\backend\model\ExamCheck::get($this->request->param('id'));
            $loss->check_time = time();
            $loss->status = 2;
            $loss->feedback = $this->request->param('feedback');
            $loss->check_admin_id = $this->ausess()['auid'];
            $loss->save();
            $this->success('异常申请已拒绝');
        }
        $this->assign([
            'id' => $this->request->param('id')
        ]);
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
