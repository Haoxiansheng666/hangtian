<?php

namespace app\admin\controller;

use app\admin\model\Admin;
use app\admin\model\AuthGroup;
use app\admin\model\AuthGroupAccess;
use app\admin\model\User;
use app\common\controller\Backend;
use fast\Random;
use think\Db;
use think\exception\PDOException;
use think\exception\ValidateException;

/**
 * 经营三方端申请
 *
 * @icon fa fa-circle-o
 */
class Supervise extends Backend
{

    /**
     * 监管端模型对象
     * @var \app\admin\model\Supervise
     */
    protected $model = null;
    protected $address = [];

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\Supervise;
        //类型
        $this->view->assign("typeList", $this->model->getTypeList());
        //审核状态
        $this->view->assign("statusList", $this->model->getStatusList());
        //营业状态
        $this->view->assign("openList", $this->model->getOpenList());
        //街道管理
        $addr = \app\admin\model\Address::where(['pid'=>0,'status'=>1])->select();
        $address = [];
        foreach ($addr as $item){
            $add = \app\admin\model\Address::where(['pid'=>$item['id'],'status'=>1])->select();
            foreach ($add as $value){
                //array_push($address,['id'=>$value['id'],'name'=>$item['name'].'-'.$value['name']]);
                //array_push($address,[$value['id']=>$item['name'].'-'.$value['name']]);
                array_push($address,$item['name'].'-'.$value['name']);
            }
        }
        $this->address = $address;
        //角色组
        $access = collection(AuthGroup::where('id','in',[2,4])->select())->toArray();
        $this->assign('access',$access);
        $this->assign('address',$address);
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
                    ->where('fa_company.type',3)
                    ->order($sort, $order)
                    ->paginate($limit);

            foreach ($list as $row) {
                
                $row->getRelation('user')->visible(['username','mobile','type']);
            }

            $result = array("total" => $list->total(), "rows" => $list->items());

            return json($result);
        }
        return $this->view->fetch();
    }

    /***
     * @return string
     * @throws \think\Exception
     */
    public function add()
    {
        if ($this->request->isPost()) {
            $params = $this->request->post("row/a");
            if ($params) {
                $params = $this->preExcludeFields($params);

                if ($this->dataLimit && $this->dataLimitFieldAutoFill) {
                    $params[$this->dataLimitField] = $this->auth->id;
                }
                Db::startTrans();
                try {
                    //是否采用模型验证
                    if ($this->modelValidate) {
                        $name = str_replace("\\model\\", "\\validate\\", get_class($this->model));
                        $validate = is_bool($this->modelValidate) ? ($this->modelSceneValidate ? $name . '.add' : $name) : $this->modelValidate;
                        $this->model->validateFailException(true)->validate($validate);
                    }

                    if(User::where(['mobile'=>$params['username'],'status'=>'normal'])->find()){
                        $this->error('该用户名已存在');
                    }
                    //添加前端用户
                    $salt = Random::alnum(6);
                    $add = ['username'=>$params['username'],'mobile'=>$params['username'],'nickname'=>$params['username'],'salt'=>$salt,'password'=>md5(md5($params['password']).$salt)
                        ,'joinip'=>request()->ip(),'jointime'=>time(),'createtime'=>time(),'type'=>4,'is_in'=>1,'status'=>'normal'];
                    $user = new User();
                    $user->save($add);

                    if(Admin::where(['username'=>$params['username'],'status'=>'normal'])->find()){
                        $this->error('该用户名已存在');
                    }
                    //添加后台用户
                    $data = ['username'=>$params['username'],'nickname'=>$params['username'],'salt'=>$salt,'password'=>md5(md5($params['password']).$salt),'createtime'=>time(),'status'=>'normal'];
                    $admin = new Admin();
                    $admin->save($data);
                    //添加角色用户  对应的权限
                    $access = new AuthGroupAccess();
                    $access->save(['uid'=>$admin->id,'group_id'=>$params['juese']]);

                    unset($params['username']);unset($params['password']);unset($params['juese']);
                    $params['user_id'] = $user->id;$params['type'] = 3;$params['status'] = 1;

                    $result = $this->model->allowField(true)->save($params);
                    Db::commit();
                } catch (ValidateException $e) {
                    Db::rollback();
                    $this->error($e->getMessage());
                } catch (PDOException $e) {
                    Db::rollback();
                    $this->error($e->getMessage());
                } catch (Exception $e) {
                    Db::rollback();
                    $this->error($e->getMessage());
                }
                if ($result !== false) {
                    $this->success();
                } else {
                    $this->error(__('No rows were inserted'));
                }
            }
            $this->error(__('Parameter %s can not be empty', ''));
        }
        return $this->view->fetch();
    }

    /**
     * 编辑
     * @param string $ids
     * @return string
     * @throws \think\Exception
     * @throws \think\exception\DbException
     */
    public function edit($ids = "")
    {
        $row = $this->model->get($ids);
        if (!$row) {
            $this->error(__('No Results were found'));
        }
        if ($this->request->isPost()) {
            $params = $this->request->post("row/a");
            $input = input();
            if ($params) {
                $params = $this->preExcludeFields($params);
                if ($this->dataLimit && $this->dataLimitFieldAutoFill) {
                    $params[$this->dataLimitField] = $this->auth->id;
                }
                Db::startTrans();
                try {
                    //是否采用模型验证
                    if ($this->modelValidate) {
                        $name = str_replace("\\model\\", "\\validate\\", get_class($this->model));
                        $validate = is_bool($this->modelValidate) ? ($this->modelSceneValidate ? $name . '.add' : $name) : $this->modelValidate;
                        $this->model->validateFailException(true)->validate($validate);
                    }
                    $area = $input['area'];$address = [];
                    foreach ($area as $value){
                        array_push($address,$this->address[$value]);
                    }
                    $params['area'] = implode(',',$address);

                    //是否有对应的数据
                    if(isset($params['username'])){
                        $admin = Admin::where(['username'=>$params['username'],'status'=>'normal'])->find();
                        if($params['password'] != ''){
                            //如果密码不为空
                            $salt = Random::alnum(6);
                            //修改后台密码
                            $admin->save(['password'=>md5(md5($params['password']).$salt),'salt'=>$salt]);
                            $user = User::where(['mobile'=>$params['username'],'status'=>'normal'])->find();
                            $data = ['password'=>md5(md5($params['password']).$salt),'salt'=>$salt];
                            if($params['status'] == 1){
                                $data['is_in'] = 1;
                            }
                            //修改前端密码
                            User::where(['mobile'=>$params['username'],'status'=>'normal'])->update($data);
                        }
                        //修改权限
                        $access = AuthGroupAccess::where('uid',$admin['id'])->find();
                        $access->save(['group_id'=>$params['juese']]);
                    }

                    //用户名 密码  角色权限
                    unset($params['username']);unset($params['password']);unset($params['juese']);
                    $result = $row->allowField(true)->save($params);
                    Db::commit();
                } catch (ValidateException $e) {
                    Db::rollback();
                    $this->error($e->getMessage());
                } catch (PDOException $e) {
                    Db::rollback();
                    $this->error($e->getMessage());
                } catch (Exception $e) {
                    Db::rollback();
                    $this->error($e->getMessage());
                }
                if ($result !== false) {
                    $this->success();
                } else {
                    $this->error(__('No rows were inserted'));
                }
            }
        }
        $area = explode(',',$row->area);
        $address = [];
        foreach ($area as $value){
            $key = array_search($value,$this->address);
            array_push($address,$key);
        }
        $row->area = $address;
        $this->assign('row',$row);
        $row->user = User::get($row->user_id);
        $admin_id = Admin::where('username',$row->user->mobile)->value('id');
        $row->juese = AuthGroupAccess::where('uid',$admin_id)->value('group_id');
        return $this->view->fetch();
    }
}
