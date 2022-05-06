<?php

namespace app\api\controller;

use app\api\model\Company;
use app\api\model\MessageRecord;
use app\api\model\Msg;
use app\api\model\MsgRecord;
use app\api\model\Record;
use app\common\controller\Api;

class Message extends Api
{
    protected $noNeedLogin = [];
    protected $noNeedRight = ['*'];

    /**
     * 消息
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function index()
    {
        $input = input();
        $user_id = $this->auth->id;
        $user = \app\api\model\User::get($user_id);
        if($user['is_in'] == 0){
            $this->error('请先申请成为其中一端');
        }
        //类型 和 分页数据
        $type = isset($input['type']) && !empty($input['type']) ? $input['type'] : 1;
        $page = isset($input['page']) && !empty($input['page']) ? $input['page'] : 1;
        $pageSize = isset($input['pageSize']) && !empty($input['pageSize']) ? $input['pageSize'] : 10;

        //整改和监管消息
        $where = "user_id = ".$user_id." or user_id is null";
        if($type == 3){
            $type = [3,4];
        }
        //总数和查询
        $total = \app\api\model\Message::where(['status'=>1])->where('type','in',$type)->where($where)->count();
        $msg = \app\api\model\Message::where(['status'=>1])->where('type','in',$type)->where($where)->limit(($page - 1)*$pageSize,$pageSize)->order('id desc')->select();
        if($msg){
            foreach ($msg as $key=>$value){
                $msg[$key]['create_time'] = date('Y-m-d H:i',$value['create_time']);
                $record = MessageRecord::where(['message_id'=>$value['id'],'user_id'=>$value['user_id']])->find();
                $msg[$key]['is_read'] = $record ? 1 : 0;
            }
        }
        $total_page = ceil($total/$pageSize);

        $is_read = [];
        //三方端没有投诉 和 整改
        if($user['type'] != 2){
            //type == 1的未读数量    投诉
            $type_1 = \app\api\model\Message::where(['type'=>1,'status'=>1,'user_id'=>$user_id])->count();
            $ids_1 = \app\api\model\Message::where(['type'=>1,'status'=>1,'user_id'=>$user_id])->column('id');
            $read_1 = MessageRecord::where(['user_id'=>$user_id])->where('id','in',$ids_1)->count();
            $is_read['type_1'] = $type_1 - $read_1;

            //type  == 2 的未读数量  监管
            $type_2 = \app\api\model\Message::where(['type'=>2,'status'=>1,'user_id'=>$user_id])->count();
            $ids_2 = \app\api\model\Message::where(['type'=>2,'status'=>1,'user_id'=>$user_id])->column('id');
            $read_2 = MessageRecord::where(['user_id'=>$user_id])->where('id','in',$ids_2)->count();
            $is_read['type_2'] = $type_2 - $read_2;
        }

        //type  == 3 的未读数量   系统消息
        $type_3 = \app\api\model\Message::where(['type'=>3,'status'=>1])->count();
        $ids_3 = \app\api\model\Message::where(['type'=>3,'status'=>1])->column('id');
        $read_3 = MessageRecord::where(['user_id'=>$user_id])->where('id','in',$ids_3)->count();
        $is_read['type_3'] = $type_3 - $read_3;
        $this->success('获取成功',['list'=>$msg,'total'=>$total,'current_page'=>$page,'pageSize'=>$pageSize,'total_page'=>$total_page,'is_read'=>$is_read]);
    }

    /**
     * 未读消息数量
     * @throws \think\Exception
     * @throws \think\exception\DbException
     */
    public function msg_count()
    {
        $input = input();
        $user_id = $this->auth->id;
        $user = \app\api\model\User::get($user_id);
        if($user['is_in'] == 0){
            $this->error('请先申请成为其中一端');
        }
        $is_read = [];
        //三方端没有投诉 和 整改
        if($user['type'] != 2){
            //type == 1的未读数量    投诉
            $type_1 = \app\api\model\Message::where(['type'=>1,'status'=>1,'user_id'=>$user_id])->count();
            $ids_1 = \app\api\model\Message::where(['type'=>1,'status'=>1,'user_id'=>$user_id])->column('id');
            $read_1 = MessageRecord::where(['user_id'=>$user_id])->where('id','in',$ids_1)->count();
            $is_read['type_1'] = $type_1 - $read_1;

            //type  == 2 的未读数量  监管
            $type_2 = \app\api\model\Message::where(['type'=>2,'status'=>1,'user_id'=>$user_id])->count();
            $ids_2 = \app\api\model\Message::where(['type'=>2,'status'=>1,'user_id'=>$user_id])->column('id');
            $read_2 = MessageRecord::where(['user_id'=>$user_id])->where('id','in',$ids_2)->count();
            $is_read['type_2'] = $type_2 - $read_2;
        }

        //type  == 3 的未读数量   系统消息
        $type_3 = \app\api\model\Message::where(['type'=>3,'status'=>1])->count();
        $ids_3 = \app\api\model\Message::where(['type'=>3,'status'=>1])->column('id');
        $read_3 = MessageRecord::where(['user_id'=>$user_id])->where('id','in',$ids_3)->count();
        $is_read['type_3'] = $type_3 - $read_3;
        $count = array_sum($is_read);
        $this->success('获取成功',['is_read'=>$is_read,'count'=>$count]);
    }

    /**
     * 通知消息详情
     * @throws \think\exception\DbException
     */
    public function detail()
    {
        $id = input('id');
        $user_id = $this->auth->id;
        $user = \app\api\model\User::get($user_id);
        if($user['is_in'] == 0){
            $this->error('请先申请成为其中一端');
        }
        $msg = \app\api\model\Message::get($id);
        $msg['create_time'] = date('Y-m-d H:i',$msg['create_time']);
        $record = MessageRecord::where(['user_id'=>$user_id,'message_id'=>$id])->find();
        if(!$record){
            $record = new MessageRecord();
            $record->save(['user_id'=>$user_id,'message_id'=>$id,'create_time'=>time()]);
        }
        if($msg['type_id'] && $msg['type'] == 2){
            $uid = Record::where(['id'=>$msg['type_id']])->value('user_id');
            $company = Company::get(['user_id'=>$uid]);
            $msg['company'] = $company['company'];$msg['logo'] = $company['logo'];
        }
        if($msg['type_id'] && $msg['type'] == 4){
            $company = Company::get($msg['type_id']);
            $msg['company'] = $company['company'];$msg['logo'] = $company['logo'];
        }
        $this->success('获取成功',$msg);
    }

    /**
     * 留言列表
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function msg()
    {
        $user_id = $this->auth->id;
        $user = \app\api\model\User::get($user_id);
        if($user['is_in'] == 0){
            $this->error('请先申请成为经营端/监管端');
        }
        if($user['type'] == 2){
            $this->error('你无权限');
        }
        $where = [];
        if(!in_array($user['type'],[3,4])){
            $where = ['user_id'=>$user_id];
        }
        $page = isset($input['page']) && !empty($input['page']) ? $input['page'] : 1;
        $pageSize = isset($input['pageSize']) && !empty($input['pageSize']) ? $input['pageSize'] : 10;

        $total = Msg::where($where)->count();
        $msg = Msg::where($where)->limit(($page - 1)*$pageSize,$pageSize)->order('id desc')->select();
        if($msg){
            foreach ($msg as $key=>$val){
                $record = MsgRecord::where(['message_id'=>$val['id'],'user_id'=>$val['user_id']])->find();
                $msg[$key]['is_read'] = $record ? 1 : 0;
                $msg[$key]['create_time'] = date('Y-m-d H:i',$val['create_time']);
                $msg[$key]['company'] = Company::where('user_id',$val['user_id'])->value('company');
            }
        }

        $total_page = ceil($total/$pageSize);
        $this->success('获取成功',['list'=>$msg,'total'=>$total,'current_page'=>$page,'pageSize'=>$pageSize,'total_page'=>$total_page]);
    }

    /**
     * 用户留言
     */
    public function msg_add()
    {
        $user_id = $this->auth->id;
        $user = \app\api\model\User::get($user_id);
        if($user['is_in'] == 0){
            $this->error('请先申请成为经营端/监管端');
        }
        if($user['type'] == 2){
            $this->error('你无权限');
        }
        $input = input();
        $input['user_id'] = $user_id;
        $msg = new Msg();
        $input['create_time'] = time();
        $msg->save($input);
        $this->success('留言成功');
    }

    /**
     * 留言详情
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function msg_detail()
    {
        $user_id = $this->auth->id;
        $user = \app\api\model\User::get($user_id);
        if($user['is_in'] == 0){
            $this->error('请先申请成为经营端/监管端');
        }
        if($user['type'] == 2){
            $this->error('你无权限');
        }
        $id = input('id');
        $msg = Msg::get($id);
        $msg['create_time'] = date('Y-m-d H:i',$msg['create_time']);
        //TODO 这些写啥呢 好像是那个博优吧
//        $com_address = Company::where('user_id',$user_id)->value('address');
//        $company = Company::where('','')->select();
        $msg['to_user'] = "博优";
        if(in_array($user['type'],[3,4])){
            $company = Company::where(['user_id'=>$msg['user_id']])->find();
            $msg['company'] = $company['company'];$msg['mobile'] = $company['mobile'];
            $record = new MsgRecord();
            $record->save(['user_id'=>$user_id,'message_id'=>$id,'create_time'=>time()]);
        }
        $this->success('获取成功',$msg);
    }
}
