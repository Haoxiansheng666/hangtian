<?php
namespace app\api\controller;

use app\api\model\Down;
use app\api\model\NetworkFavor;
use app\common\controller\Api;
/**
 *  网盘接口
 */
class Network extends Api
{
    protected $noNeedLogin = ['*'];
    protected $noNeedRight = ['*'];

    /**
     * 网盘的列表
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function index()
    {
        $user_id = $this->auth->id;
        $input = input();
        $type = isset($input['type']) && !empty($input['type']) ? $input['type'] : 1;
        $page = isset($input['page']) && !empty($input['page']) ? $input['page'] : 1;
        $pageSize = isset($input['pageSize']) && !empty($input['pageSize']) ? $input['pageSize'] : 10;
        $order = isset($input['order']) && !empty($input['order']) ? $input['order'] : "update_time desc";
        $where = $type == 1 ? ['user_id'=>$user_id,'type'=>$type,'pid'=>0] : ['type'=>$type,'pid'=>0];
        $total = \app\api\model\Network::where($where)->count();
        $list = \app\api\model\Network::where($where)->limit(($page - 1) * $pageSize,$pageSize)->order($order)->select();
        $total_page = ceil($total/$pageSize);
        $this->success('获取成功',['list'=>$list,'total'=>$total,'total_page'=>$total_page,'pageSize'=>$pageSize,'current_page'=>$page]);
    }

    public function add()
    {
        $user_id = $this->auth->id;
        $input = input();
        $input['user_id'] = $user_id;
        $network = new \app\api\model\Network();
        $input['pid'] = isset($input['pid']) && !empty($input['pid']) ? $input['pid'] : 0;
        $input['word_type'] = isset($input['word_type']) && !empty($input['word_type']) ? $input['word_type'] : 1;
        if($input['word_type'] == 1){
            $network->save();
        }else{
            
        }
        $network->save();
    }

    public function share()
    {
        $user_id = $this->auth->id;
    }

    public function copy()
    {
        $user_id = $this->auth->id;

    }

    /**
     * 文件重命名
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function rename()
    {
        //用户权限
        $user_id = $this->auth->id;
        //接受参数
        $input = input();
        $id = $input['id'];
        $name = isset($input['name']) && !empty($input['name']) ? $input['name'] : "";
        //判断
        if(empty($name)){
            $this->error('名字不能为空');
        }
        $network = \app\api\model\Network::where(['user_id'=>$user_id,'id'=>$id,'status'=>1])->find();
        if(!$network){
            $this->error('无此记录');
        }
        $network->save(['name'=>$name]);
        $this->success('重命名成功');
    }

    /**
     * 详细信息
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function detail()
    {
        $user_id = $this->auth->id;
        $input = input();
        $id = $input['id'];
        $network = \app\api\model\Network::where(['id'=>$id,'user_id'=>$user_id])->find();
        if(!$network){
            $this->error('无此记录');
        }
        $this->success('获取成功',$network);
    }

    public function remove()
    {
        $user_id = $this->auth->id;
    }

    /**
     * 删除到回收站
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function delete()
    {
        $user_id = $this->auth->id;
        $input = input();
        $id = $input['id'];
        $network = \app\api\model\Network::where(['user_id'=>$user_id,'id'=>$id,'status'=>1])->find();
        if(!$network){
            $this->error('无此记录');
        }
        $network->save(['status'=>2]);
        $this->success('删除成功');
    }

    /**
     * 收藏/取消收藏
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function favor_add()
    {
        $user_id = $this->auth->id;
        $input = input();
        $id = $input['id'];
        $favor = NetworkFavor::where(['user_id'=>$user_id,'net_id'=>$id])->find();
        if($favor){
            $data = $favor['status'] == 1 ? ['status'=>2] : ['status'=>1];
        }else{
            $favor = new NetworkFavor();
            $data = ['net_id'=>$id,'user_id'=>$user_id,'create_time'=>time()];
        }
        $favor->save($data);
        $msg = $data['status'] == 1 ? '收藏成功' : '取消收藏成功';
        $this->success($msg);
    }

    /**
     * 网盘下载
     */
    public function down()
    {
        $user_id = $this->auth->id;
        $input = input();
        $id = $input['id'];
        $down = new Down();
        $down->save(['net_id'=>$id,'user_id'=>$user_id,'create_time'=>time(),'type'=>2]);
        $this->success('下载成功');
    }

    public function rule()
    {
        $user_id = $this->auth->id;
    }

    /**
     * 回收站
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function recycle()
    {
        $user_id = $this->auth->id;
        $input = input();
        $page = isset($input['page']) && !empty($input['page']) ? $input['page'] : 1;
        $pageSize = isset($input['page']) && !empty($input['page']) ? $input['page'] : 1;
        $order = isset($input['order']) && !empty($input['order']) ? $input['order'] : 'update_time desc';
        $total = \app\api\model\Network::where(['user_id'=>$user_id,'status'=>2])->count();
        $list = \app\api\model\Network::where(['user_id'=>$user_id,'status'=>2])->limit(($page - 1) * $pageSize,$pageSize)->order($order)->select();
        $total_page = ceil($total/$pageSize);
        $this->success('获取成功',['total'=>$total,'list'=>$list,'total_page'=>$total_page,'current_page'=>$page,'pageSize'=>$pageSize]);
    }

    /**
     * 回收站恢复
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function recover()
    {
        $user_id = $this->auth->id;
        $input = input();
        $id = $input['id'];
        $network = \app\api\model\Network::where(['user_id'=>$user_id,'id'=>$id,'status'=>2])->find();
        if(!$network){
            $this->success('无此记录');
        }
        $network->save(['status'=>1]);
        $this->success('恢复成功');
    }

    /**
     * 回收站删除
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function del()
    {
        $user_id = $this->auth->id;
        $input = input();
        $id = $input['id'];
        $network = \app\api\model\Network::where(['user_id'=>$user_id,'id'=>$id,'status'=>2])->find();
        if(!$network){
            $this->error('无此记录');
        }
        $network->delete();
        $this->success('删除成功');
    }

    /**
     * 我的收藏
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function favor()
    {
        $user_id = $this->auth->id;
        $input = input();
        $page = isset($input['page']) && !empty($input['page']) ? $input['page'] : 1;
        $pageSize = isset($input['pageSize']) && !empty($input['pageSize']) ? $input['pageSize'] : 1;
        $order = isset($input['order']) && !empty($input['order']) ? $input['order'] : 'create_time desc';
        $total = \app\api\model\NetworkFavor::where(['user_id'=>$user_id,'status'=>1])->count();
        $list = \app\api\model\NetworkFavor::where(['user_id'=>$user_id,'status'=>1])->limit(($page - 1)*$pageSize,$pageSize)->order($order)->select();
        $total_page = ceil($total/$pageSize);
        $this->success('获取成功',['total'=>$total,'list'=>$list,'pageSize'=>$pageSize,'current_page'=>$page,'total_page'=>$total_page]);
    }
}
