<?php
namespace app\backend\controller;
use think\Controller;
use think\Db;
use think\Config;
use think\Request;
use app\backend\model\Link as L;

class Link extends Common
{
    public function index(){
        return view();
    }
    public function add(){
        if(request()->isAjax()){
            $data=[
                'title' => input('post.title'),
                'url' => input('url'),
                'ord' => input('ord'),
                'add_time' => time()
            ];
            if($data['title'] && $data['url']){
                $res=L::save($data);
            }else{
                ajaxReturn($this->errCode('validError'), '参数不全');
            }
            if($res){
                ajaxReturn($this->errCode('OK'), '添加成功');
            }else{
                ajaxReturn($this->errCode('validError'), '服务器繁忙，请稍后重试');
            }
        }
        return view();
    }
    public function edit(){
        if(request()->isAjax()){
            $data=[
                'title' => input('post.title'),
                'url' => input('url'),
                'ord' => input('ord'),
                'id' => input('id')
            ];
            if($data['title'] && $data['url'] && $data['id']){
                $link = L::get($data['id']);
                $res=$link->save($data);
            }else{
                ajaxReturn($this->errCode('validError'), '参数不全');
            }
            if($res !== false){
                ajaxReturn($this->errCode('OK'), '修改成功');
            }else{
                ajaxReturn($this->errCode('validError'), '服务器繁忙，请稍后重试');
            }
        }
        $id=input('id');
        return view('add',[
            'link' => L::get($id)
        ]);
    }
    /**
     * 新闻数据的获取
     * @access public
     * @since dxf
     * @return [json]
     */
    public function getData(){
        $offset=(input('page') - 1) * input('limit');
        $link_list=db('link')->limit($offset,input('limit'))->select();
        foreach ($link_list as $k=>$v){
            $link_list[$k]['add_time']=date('Y-m-d',$v['add_time']);
        }
        $count=db('link')->count();
        layuiReturn($this->errCode('OK'), '获取成功', $count, $link_list);
    }
    /**
     * 删除数据
     * @throws \think\Exception
     */
    public function delData(){
        $param=request()->param();
        try {
            if(empty($param['id'])){
                ajaxReturn($this->errCode('validError'), '请选择要删除的项');
            }
            $res = db('link')->whereIn('id',$param['id'])->delete();
        }catch (\think\Exception\DbException $exception){
            $this->error($exception->getMessage());
        }
        return json(['code' => 0,'msg'=>'删除成功']);
    }
}