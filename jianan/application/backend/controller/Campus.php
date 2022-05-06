<?php
namespace app\backend\controller;
use think\Controller;
use think\Db;
use think\Config;
use think\Exception;
use think\exception\DbException;
use think\Request;
use app\backend\model\Link as L;
use think\response\View;

class Campus extends Common
{
    /**
     * 首页
     * @return View
     */
    public function index(){
        return view();
    }

    /**
     * 添加
     * @return View
     */
    public function add(){
        if(request()->isAjax()){
            $param = $this->request->param();
            (new \app\backend\model\Campus())->allowField(true)->save($param);
            $this->success('添加成功');
        }
        return view();
    }

    /**
     * 修改
     * @return View
     * @throws DbException
     */
    public function edit(){
        if(request()->isAjax()){
            $param = $this->request->param();
            $model = \app\backend\model\Campus::get($param['id']);
            $model->allowField(true)->save($param);
            $this->success('修改成功');
        }
        $id=input('id');
        return view('add',[
            'link' => \app\backend\model\Campus::get($id)
        ]);
    }

    /**
     * 新闻数据的获取
     * @access public
     * @return void [json]
     * @throws DbException
     */
    public function getData(){
        $list = (new \app\backend\model\Campus())
            ->paginate($this->request->param('limit'));
        $data = $list->items();
        layuiReturn($this->errCode('OK'), '获取成功', $list->total(), $data);
    }

    /**
     * 删除数据
     * @throws Exception
     */
    public function delData(){
        $campus = \app\backend\model\Campus::get($this->request->param('id'));
        if (empty($campus)){
            $this->error('服务器错误');
        }
        $campus->delete();
        $this->success('删除成功');
    }
}