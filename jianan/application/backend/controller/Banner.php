<?php
namespace app\backend\controller;
use think\Controller;
use think\Db;
use think\Config;
use think\Request;
use app\backend\model\Banner as B;
class Banner extends Common
{
    public function index(){
        return view();
    }
    public function add(){
        if(request()->isAjax()){
            $data=[
                'title' => input('post.title'),
                'eng_attr' => input('post.eng_attr'),
                'img_url' => input('main_img'),
                'type' => input('type'),
                'url' => input('url'),
                'ord' => input('ord'),
                'add_time' => time()
            ];
            $b=new B();
            if($data['title'] && $data['img_url']){
                try {
                    $b->save($data);
                    ajaxReturn($this->errCode('OK'), '添加成功');
                }catch (\think\Exception\DbException $e){
                    ajaxReturn($this->errCode('validError'), '服务器繁忙，请稍后重试');
                }
            }else{
                ajaxReturn($this->errCode('validError'), '参数不全');
            }
        }
        return view();
    }
    public function edit(){
        if(request()->isAjax()){
            $data=[
                'title' => input('post.title'),
                'eng_attr' => input('post.eng_attr'),
                'img_url' => input('main_img'),
                'type' => input('type'),
                'url' => input('url'),
                'ord' => input('ord'),
                'id' => input('id')
            ];
            if($data['title'] && $data['img_url'] && $data['id']){
                try {
                    $banner=B::get($data['id']);
                    $banner->save($data);
                    ajaxReturn($this->errCode('OK'), '添加成功');
                }catch (\think\Exception\DbException $e){
                    ajaxReturn($this->errCode('validError'), '服务器繁忙，请稍后重试');
                }
            }else{
                ajaxReturn($this->errCode('validError'), '参数不全');
            }
        }
        $id=input('id');
        return view('add',[
            'banner' => db('banner')->find($id)
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
        $banner_list=db('banner')->limit($offset,input('limit'))->select();
        foreach ($banner_list as $k=>$v){
            $banner_list[$k]['add_time']=date('Y-m-d',$v['add_time']);
        }
        $count=db('banner')->count();
        layuiReturn($this->errCode('OK'), '获取成功', $count, $banner_list);
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
            $res = db('banner')->whereIn('id',$param['id'])->delete();
        }catch (\think\Exception\DbException $exception){
            $this->error($exception->getMessage());
        }
        return json(['code' => 0,'msg'=>'删除成功']);
    }
}