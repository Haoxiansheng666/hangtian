<?php

namespace app\api\controller;

use app\admin\model\Noise;
use app\admin\model\Score;
use app\api\model\Address;
use app\api\model\Article;
use app\api\model\Company;
use app\api\model\Complaint;
use app\api\model\Friend;
use app\api\model\NoiseRecord;
use app\api\model\Question;
use app\api\model\Record;
use app\api\model\Repair;
use app\api\model\RepairRecord;
use app\api\model\Search;
use app\common\controller\Api;
use function fast\e;

/**
 * 首页接口
 */
class Index extends Api
{
    protected $noNeedLogin = ['set_record','setRecords'];
    protected $noNeedRight = ['*'];

    /**
     * 首页
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
        if($user['type'] == 1){  //经营端
            $company = Company::where('user_id',$user_id)->find();
            $company_id = $company['id'];
            //最近一次检测时间
            $record = Record::where('company_id',$company_id)->order('id desc')->find();
            //最近一次的维护 和 清洗的时间
            $repair_1 = RepairRecord::where(['company_id'=>$company_id,'type'=>1,'status'=>1])->order('id desc')->find();
            $repair_2 = RepairRecord::where(['company_id'=>$company_id,'type'=>2,'status'=>1])->order('id desc')->find();
            //投诉的未整改的
            $count1 = Complaint::where(['company_id'=>$company_id,'status'=>0])->count();
            //需要整改的次数
            $count2 = Record::where(['company_id'=>$company_id,'is_change'=>1])->count();
            $list = ['id'=>$record['id'],'status'=>$record['status'],'record_time'=>date("Y-m-d H:i",$record['create_time']),
                'repair_time1'=>date("Y-m-d H:i",$repair_1['create_time']),'repair_time2'=>date("Y-m-d H:i",$repair_2['create_time'])
                ,'count'=>$count1 + $count2,'count1'=>$count1,'count2'=>$count2,'qrcode'=>$user['qrcode'],'company'=>$company['company']];
            $notice = \app\api\model\Message::where("user_id = ".$user_id." or user_id is null")->order('id desc')->find();
            $this->success('获取成功',['list'=>$list,'notice'=>$notice]);
        }elseif($user['type'] == 2){  //三方端
            //接收参数
            $address = isset($input['address']) && !empty($input['address']) ? $input['address'] : "";
            $order = isset($input['order']) && !empty($input['order']) ? $input['order'] : "id desc";
            $open = isset($input['open']) && !empty($input['open']) ? $input['open'] : "";
            //企业信息
            $company_ids = \app\api\model\User::where('id',$user_id)->value('friends');
            $where['user_id'] = ['in',$company_ids];
            //街道查询
            if($address){
                $where['address'] = ['like','"%"'.$address.'"%"'];
            }
            //营业状态
            if($open !== ''){
                $where['open'] = $open;
            }
            //分页
            $page = isset($input['page']) && !empty($input['page']) ? $input['page'] : 1;
            $pageSize = isset($input['pageSize']) && !empty($input['pageSize']) ? $input['pageSize'] : 10;
            //总数和分页查询
            $total =  Company::where($where)->count();
            $list = Company::where($where)->limit(($page - 1)*$pageSize,$pageSize)->order($order)->select();
            if($list){
                foreach ($list as $key=>$val){
                    //已维护维护次数
                    $count1 = RepairRecord::where(['company_id'=>$val['id'],'type'=>1,'status'=>1])->count();
                    $repair_time1 = \app\api\model\User::where('id',$val['user_id'])->value('repair_time');
                    //维护闹钟
                    $is_repair1 = $val['repair_1'] == 0 && time() < strtotime('+'.(($count1 + 1) * 3).' months',$repair_time1) && time() > $repair_time1 ? 1 : 0;
                    $repair1 = RepairRecord::where(['company_id'=>$val['id'],'type'=>1])->order('id desc')->find();
                    $list[$key]['is_repair1'] = $is_repair1 == 1 && $repair1['clarm'] == 1 ? 1 : 0;

                    //已清洗次数
                    $count2 = RepairRecord::where(['company_id'=>$val['id'],'type'=>2,'status'=>1])->count();
                    $repair_time2 = \app\api\model\User::where('id',$val['user_id'])->value('clean_time');
                    //清洗闹钟
                    $repair2 = RepairRecord::where(['company_id'=>$val['id'],'type'=>2])->order('id desc')->find();
                    $is_repair2 = $val['repair_2'] == 0 && time() < strtotime('+'.(($count2 + 1) * 3).' months',$repair_time2) && time() > $repair_time2 ? 1 : 0;
                    $list[$key]['is_repair2'] = $is_repair2 == 1 && $repair2['clarm'] == 1 ? 1 : 0;
                    //不用做正则判断  因为 如果你维护了  那你的次数已增加
                    $list[$key]['repair_time1'] = strtotime('+'.($count1 + 1).' months',$repair_time1);
                    $list[$key]['repair_time2'] = strtotime('+'.(($count2 + 1) * 3).' months',$repair_time2);
                }
            }
            //总页数
            $total_page = ceil($total/$pageSize);
            //消息
            $notice = \app\api\model\Message::where("user_id = ".$user_id." or user_id is null")->order('id desc')->find();
            $this->success('获取成功',['total'=>$total,'list'=>$list,'pageSize'=>$pageSize,'current_page'=>$page,'total_page'=>$total_page,'notice'=>$notice]);
        }else{  //监管端 3,4
            //接收参数
            $address = isset($input['address']) && !empty($input['address']) ? $input['address'] : "";
            $level = isset($input['level']) && !empty($input['level']) ? $input['level'] : "";
            $type = isset($input['type']) && !empty($input['type']) ? $input['type'] : "";
            //经营端 和 审核过的
            $where = ['type'=>1,'status'=>1];$where1 = [];
            //街道选择
            if($address){
                $where['address'] = ['like','"%"'.$address.'"%"'];
            }
            //二维码的颜色选择
            if($level !== ""){
                $where1['level'] = ['in',$level];
            }
            //维护清洗状态
            if($type == 1){ //未维护
                $where['repair_1'] = 0;
            }elseif ($type == 2){ //已维护
                $where['repair_1'] = 1;
            }elseif ($type == 3){ //未清洗
                $where['repair_2'] = 0;
            }elseif ($type ==4){ //已清洗
                $where['repair_2'] = 1;
            }
            //分页信息
            $page = isset($input['page']) && !empty($input['page']) ? $input['page'] : 1;
            $pageSize = isset($input['pageSize']) && !empty($input['pageSize']) ? $input['pageSize'] : 10;
            //查询全部 和 分页查询
            $total = Company::where($where)->where($where1)->count();
            $list = Company::where($where)->where($where1)->limit(($page - 1)*$pageSize , $pageSize)->order('id desc')->select();
            if($list){
                foreach ($list as $key=>$value){
                    $list[$key]['qrcode'] = \app\api\model\User::where('id',$value['user_id'])->value('qrcode');
                    $list[$key]['logo'] = request()->domain().$value['logo'];
                    $list[$key]['score'] = Record::where(['company'=>$value['id']])->order('id desc')->value('score');
                }
            }
            //总页数
            $total_page = ceil($total/$pageSize);
            //绿码
            $green = Company::where($where)->where('level',1)->count();
            //黄码
            $yellow = Company::where($where)->where('level',2)->count();
            //红码
            $red = Company::where($where)->where('level',3)->count();
            $all = $green + $yellow + $red;
            //消息
            $notice = \app\api\model\Message::where("user_id = ".$user_id." or user_id is null")->order('id desc')->find();
            $this->success('获取成功',['total'=>$total,'list'=>$list,'pageSize'=>$pageSize,'current_page'=>$page,'total_page'=>$total_page, 'green'=>$green,'yellow'=>$yellow,'red'=>$red,'all'=>$all,'notice'=>$notice]);
        }
    }

    /**
     * 经营端企业详情   监管端看到的
     * @throws \think\Exception
     * @throws \think\exception\DbException
     */
    public function company()
    {
        $id = input('id');
        $company = Company::get($id);
        $company['logo'] = request()->domain().$company['logo'];
        //投诉的未整改的
        $company['count1'] = Complaint::where(['company_id'=>$id,'status'=>0])->count();
        //需要整改的次数
        $company['count2'] = Record::where(['company_id'=>$id,'is_change'=>1])->count();
        $company['score'] = Record::where(['company_id'=>$id])->order('id desc')->value('score');
        $company['qrcode'] = Record::where(['company_id'=>$id])->order('id desc')->value('qrcode');
        $this->success('获取成功',$company);
    }
    /**
     * 监管端获取他的筛选街道
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function supervise()
    {
        $user_id = $this->auth->id;
        $user = \app\api\model\User::get($user_id);
        $user = \app\api\model\User::get($user_id);
        if($user['is_in'] == 0){
            $this->error('请先申请成为监管端');
        }
        if(!in_array($user['type'],[3,4])){
            $this->error('你没有权限');
        }
        $company = Company::where(['user_id'=>$user_id])->find();
        $list = [];
        if($company['area'] == "全区"){
            $address = Address::where('pid',0)->select();
            foreach ($address as $val){
                $child = Address::where('pid',$val['id'])->select();
                foreach ($child as $value){
                    array_push($list,$val['name'].'-'.$value['name']);
                }
            }
        }else{
            $list = explode(',',$company['area']);
        }
        $this->success('获取成功',$list);
    }

    /**
     * 注册审核
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function apply()
    {
        $user_id = $this->auth->id;
        $input = input();
        $company = Company::where(['user_id'=>$user_id])->where('status','<>',2)->find();
        if(!$company){
            $company = new Company();
            $input['create_time'] = time();
            $input['user_id'] = $user_id;
            $input['logo'] = isset($input['logo']) && !empty($input['logo']) ? $input['logo'] : '/logo.png';
        }
        $type = isset($company) && !empty($company['type']) ? $company['type'] : $input['type'];
        $company->save($input);
        \app\api\model\User::where(['id'=>$user_id])->update(['type'=>$type]);
        $this->success('提交审核成功');
    }

    /**
     * 我的企业详情
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function apply_detail()
    {
        $user_id = $this->auth->id;
        $company = Company::where(['user_id'=>$user_id])->find();
        $company['logo_url'] = request()->domain().$company['logo'];
        $this->success('获取成功',$company);
    }

    /**
     * 地址列表
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function address()
    {
        $address = Address::where('pid',0)->select();
        foreach ($address as $key=>$val){
            $address[$key]['child'] = Address::where('pid',$val['id'])->select();
        }
        $this->success('获取成功',$address);
    }

    /**
     * 问题反馈
     */
    public function question()
    {
        $user_id = $this->auth->id;
        $user = \app\api\model\User::get($user_id);
        if($user['is_in'] == 0){
            $this->error('请先申请成为其中一端');
        }
        $question = new Question();
        $input = input();
        $input['create_time'] = time();
        $input['user_id'] = $user_id;
        $question->save($input);
        $this->success('提交成功');
    }

    /**
     * 关于我们
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function about()
    {
        $input = input();
        $page = isset($input['page']) && !empty($input['page']) ? $input['page'] : 1;
        $pageSize = isset($input['pageSize']) && !empty($input['pageSize']) ? $input['pageSize'] : 10;
        $count = Article::where('status',1)->count();
        $article = Article::where('status',1)->limit(($page -1)*$pageSize,$pageSize)->order('id desc')->select();
        $total_page = ceil($count/$pageSize);
        $this->success('获取成功',['list'=>$article,'total'=>$count,'total_page'=>$total_page,'pageSize'=>$pageSize,'current_page'=>$page]);
    }

    /**
     * 项目详情  或者 隐私协议详情
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function about_detail()
    {
        $id = input('id');
        $detail = Article::where('id',$id)->find();
        $detail['create_time'] = date('Y-m-d H:i',$detail['create_time']);
        $this->success('获取成功',$detail);
    }

    /**
     * 三方对某企业的维护或者清洗记录
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function repair_record()
    {
        $input = input();
        $user_id = $this->auth->id;
        //用户信息和权限判断
        $user = \app\api\model\User::get($user_id);
        if($user['is_in'] == 0){
            $this->error('请先申请成为三方端');
        }
        if($user['type'] != 2){
            $this->error('您无权限');
        }
        //要查询的企业
        $company_id = $input['company_id'];
        if(!$company_id){
            $this->error('请选择要查询的企业');
        }

        //类型  分页
        $type = isset($input['type']) && !empty($input['type']) ? $input['type'] : 1;
        $page = isset($input['page']) && !empty($input['page']) ? $input['page'] : 1;
        $pageSize = isset($input['pageSize']) && !empty($input['pageSize']) ? $input['pageSize'] : 10;
        //计算总数 并分页查询
        $total = RepairRecord::where(['user_id'=>$user_id,'type'=>$type,'status'=>1,'company_id'=>$company_id])->count();
        $record = RepairRecord::where(['user_id'=>$user_id,'type'=>$type,'status'=>1,'company_id'=>$company_id])
                ->limit(($page - 1)*$pageSize,$pageSize)->order('id desc')->select();
        foreach ($record as $key=>$item){
            $record[$key]['create_time'] = date('Y-m-d H:i',$item['create_time']);
            $record[$key]['content'] = json($item['content'],true);
            $record[$key]['user'] = Company::where('user_id',$item['user_id'])->field('id,company,contact')->find();
        }

        //总页数
        $total_page = ceil($total/$pageSize);


        $company = Company::get($company_id);
        //维护的次数
        $count1 = RepairRecord::where(['user_id'=>$user_id,'company_id'=>$company_id,'type'=>1])->count();
        //清洗的次数
        $count2 = RepairRecord::where(['user_id'=>$user_id,'company_id'=>$company_id,'type'=>2])->count();
        $repair_time1 = \app\api\model\User::where('id',$company['user_id'])->value('repair_time');
        //维护闹钟
        $is_repair = $company['repair_1'] == 0 && time() < strtotime('+'.($count1 + 1).' months',$repair_time1) && time() > $repair_time1 ? 1 : 0;
        $repair = RepairRecord::where(['company_id'=>$company_id,'type'=>1])->find();
        $is_repair = $is_repair == 1 && $repair['clarm'] == 1 ? 1 : 0;
        $repair_time2 = \app\api\model\User::where('id',$company['user_id'])->value('clean_time');
        //清洗闹钟
        $is_clean = $company['repair_2'] == 0 && time() > $repair_time2 && time() < strtotime('+'.(($count2 + 1) * 3).' months',$repair_time2) ? 1 : 0;
        $clean = RepairRecord::where(['company_id'=>$company_id,'type'=>2])->find();
        $is_clean = $is_clean == 1 && $clean['clarm'] == 1 ? 1 : 0;
        $this->success('获取成功',['list'=>$record,'total'=>$total,'total_page'=>$total_page,'current_page'=>$page,'pageSize'=>$pageSize,'company'=>$company,'is_repair'=>$is_repair,'is_clean'=>$is_clean]);
    }

    /**
     * 三方对某企业的维护或者清洗记录
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function repair_list()
    {
        $input = input();
        $user_id = $this->auth->id;
        //用户信息和权限判断
        $user = \app\api\model\User::get($user_id);
        if($user['is_in'] == 0){
            $this->error('请先申请成为监管端');
        }
        if(!in_array($user['type'],[3,4])){
            $this->error('您无权限');
        }
        //要查询的企业
        $company_id = $input['company_id'];
        if(!$company_id){
            $this->error('请选择要查询的企业');
        }

        //类型  分页
        $type = isset($input['type']) && !empty($input['type']) ? $input['type'] : 1;
        $page = isset($input['page']) && !empty($input['page']) ? $input['page'] : 1;
        $pageSize = isset($input['pageSize']) && !empty($input['pageSize']) ? $input['pageSize'] : 10;
        //计算总数 并分页查询
        $total = RepairRecord::where(['type'=>$type,'status'=>1,'company_id'=>$company_id])->count();
        $record = RepairRecord::where(['type'=>$type,'status'=>1,'company_id'=>$company_id])
            ->limit(($page - 1)*$pageSize,$pageSize)->order('id desc')->select();
        foreach ($record as $key=>$item){
            $record[$key]['create_time'] = date('Y-m-d H:i',$item['create_time']);
            $content = json_decode($item['content'],true);
            foreach ($content as $k=>$value){
                $content[$k]['before'] = array_url(explode(';',$value['before']));
                $content[$k]['after'] = array_url(explode(';',$value['after']));
            }
            $record[$key]['content'] = $content;
            $record[$key]['user'] = Company::where('user_id',$item['user_id'])->field('id,company,contact')->find();
        }

        //总页数
        $total_page = ceil($total/$pageSize);


        $company = Company::get($company_id);
        //维护的次数
        $count1 = RepairRecord::where(['user_id'=>$user_id,'company_id'=>$company_id,'type'=>1])->count();
        //清洗的次数
        $count2 = RepairRecord::where(['user_id'=>$user_id,'company_id'=>$company_id,'type'=>2])->count();
        $repair_time1 = \app\api\model\User::where('id',$company['user_id'])->value('repair_time');
        //维护闹钟
        $is_repair = $company['repair_1'] == 0 && time() > $repair_time1 && time() < strtotime('+'.($count1 + 1).' months',$repair_time1) ? 1 : 0;
        $repair = RepairRecord::where(['company_id'=>$company_id,'type'=>1])->find();
        $is_repair = $is_repair == 1 && $repair['clarm'] == 1 ? 1 : 0;

        $repair_time2 = \app\api\model\User::where('id',$company['user_id'])->value('clean_time');
        //清洗闹钟
        $is_clean = $company['repair_2'] == 0 && time() < strtotime('+'.(($count2 + 1) * 3).' months',$repair_time2) && time() > $repair_time2 ? 1 : 0;
        $clean = RepairRecord::where(['company_id'=>$company_id,'type'=>2])->find();
        $is_clean = $is_clean == 1 && $clean['clarm'] == 1 ? 1 : 0;

        $this->success('获取成功',['list'=>$record,'total'=>$total,'total_page'=>$total_page,'current_page'=>$page,'pageSize'=>$pageSize,'company'=>$company,'is_repair'=>$is_repair,'is_clean'=>$is_clean]);
    }

    /**
     * 经营端  第三方的公司选择
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function third()
    {
        $user_id = $this->auth->id;
        $input = input();
        $user = \app\api\model\User::get($user_id);
        if($user['is_in'] == 0){
            $this->error('请先申请成为经营端');
        }
        if($user['type'] != 1){
            $this->error('您无权限');
        }
        $type = $input['type'] ?? 1;
        //1维护  2清理
        $where['type'] = $type == 1 ? ['in','1,3'] : ['in','2,3'];
        //添加
        $to_ids = Friend::where("user_id = ".$user_id." and is_delete = 1")->where($where)->column('to_id');
        //被添加
        $user_ids = Friend::where("to_id = ".$user_id." and is_delete = 1")->where($where)->column('user_id');
        //合并
        $company_ids = array_merge($user_ids,$to_ids);
        //企业
        $company = Company::where('user_id','in',$company_ids)->field('id,company')->select();
        $this->success('获取成功',$company);
    }

    /**
     * 经营端   三放端的维护或者清洗记录
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function repair_records()
    {
        $input = input();
        $user_id = $this->auth->id;
        //用户信息和权限判断
        $user = \app\api\model\User::get($user_id);
        if($user['is_in'] == 0){
            $this->error('请先申请成为经营端');
        }
        if($user['type'] != 1){
            $this->error('您无权限');
        }

        //类型   1维护  2清洗
        $type = isset($input['type']) && !empty($input['type']) ? $input['type'] : 1;
        $company_id = Company::where('user_id',$user_id)->value('id');
        $where = ['type'=>$type,'status'=>1,'company_id'=>$company_id];
        //筛选条件三方
        $uid = $input['company_id'];
        if($uid){
           $where['user_id'] = Company::where('id',$uid)->value('user_id');
        }

        //  分页
        $page = isset($input['page']) && !empty($input['page']) ? $input['page'] : 1;
        $pageSize = isset($input['pageSize']) && !empty($input['pageSize']) ? $input['pageSize'] : 1;
        $order = isset($input['order']) && !empty($input['order']) ? $input['order'] : "id desc";
        //计算总数 并分页查询
        $total = RepairRecord::where($where)->count();
        $record = RepairRecord::where($where)->limit(($page - 1)*$pageSize,$pageSize)->order($order)->select();
        foreach ($record as $key=>$value){
            $record[$key]['content'] = json($value['content'],true);
            if($value['create_time']){
                $record[$key]['create_time'] = date('Y-m-d H:i',$value['create_time']);
            }
            $users = \app\api\model\User::get($value['user_id']);
            $uid = $users['pid'] == 0 ? $value['user_id'] : $users['pid'];
            $item['user'] = Company::where('user_id',$uid)->field('id,company,contact')->find();
        }
        //总页数
        $total_page = ceil($total/$pageSize);
        $this->success('获取成功',['list'=>$record,'total'=>$total,'total_page'=>$total_page,'current_page'=>$page,'pageSize'=>$pageSize]);
    }

    /**
     * 修护 或者  清洗记录详情
     * @throws \think\exception\DbException
     */
    public function repair_detail()
    {
        $id = input('id');
        $user_id = $this->auth->id;
        $user = \app\api\model\User::get($user_id);
        if($user['is_in'] == 0){
            $this->error('请先申请成为其中一端');
        }
        $detail = RepairRecord::get($id);
        //内容详情
        $content = json_decode($detail['content'],true);
        foreach ($content as $key=>$value){
            //前后的图集
            $content[$key]['before'] = array_url(explode(';',$value['before']));
            $content[$key]['after'] = array_url(explode(';',$value['after']));
            $content[$key]['repair'] = Repair::get($value['id']);
        }
        $detail['content'] = $content;
        //纸质图片
        $detail['image'] = array_url(explode(';',$detail['image']));
        //维护的企业
        $detail['company'] = Company::where('id',$detail['company_id'])->value('company');
        $user_detail = \app\api\model\User::get($detail['user_id']);
        $detail['user_name'] = $user_detail['username'];
        $detail['create_time'] = date('Y-m-d H:i',$detail['create_time']);
        $this->success('获取成功',$detail);
    }

    /**
     * 不再提醒
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function repair_cancel()
    {
        //权限问题
        $user_id = $this->auth->id;
        $user = \app\api\model\User::get($user_id);
        if($user['is_in'] == 0){
            $this->error('请先申请成为三方端');
        }
        if($user['type'] != 2){
            $this->error('您无权限');
        }
        $input = input();
        $id = $input['id'];
        $type = isset($input['type']) && !empty($input['type']) ? $input['type'] : 1;
        $record = RepairRecord::where(['company_id'=>$id,'type'=>$type])->order('id desc')->find();
        $record->save(['clarm'=>2]);
        $this->success('设置成功');
    }

    /**
     * 计算两个经纬度之间的距离
     * @throws \think\exception\DbException
     */
    public function distance()
    {
        //权限问题
        $user_id = $this->auth->id;
        $user = \app\api\model\User::get($user_id);
        if($user['is_in'] == 0){
            $this->error('请先申请成为其中一端');
        }
        //定位的经纬度
        $input = input();
        $point = explode(',', $input['point']);
        $id = $input['id'];
        //获取企业
        $company = Company::get($id);
        if ($company['open'] == 0) {
            $this->error('停业中');
        }
        if ($company['status'] != 1) {
            $this->error('状态不对');
        }
        //计算两个经纬度的距离
        $com_point = explode(',', $company['point']);
        $distance = getDistance($point[0],$point[1],$com_point[0],$com_point[1]);
        $flag = $distance['meters'] < 100 ? 1 : 0;
        $this->success('获取成功',['flag'=>$flag]);
    }

    /**
     * 添加维护/清洗记录
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function repair_add()
    {
        $input = input();
        $user_id = $this->auth->id;
        $user = \app\api\model\User::get($user_id);
        if($user['is_in'] == 0){
            $this->error('请先申请成为三方端');
        }
        if($user['type'] != 2){
            $this->error('您无权限');
        }
        //维护或者清洗的企业
        $uid = Company::where('id',$input['company_id'])->value('user_id');
        if(!$uid){
            $this->error('无该企业');
        }

        //判断是否是服务商
        $friend_time = Friend::where(['user_id'=>$user_id,'to_id'=>$uid,'status'=>1])->whereOr(['to_id'=>$user_id,'user_id'=>$uid,'status'=>1])->value('friend_time');
        if(!$friend_time){
            $this->error('您不是该企业的服务商');
        }

        $input['clarm'] = 2;
        //排口信息
        $input['content'] = json_encode($input['content'],JSON_UNESCAPED_UNICODE);

        //维护或者清洗次数
        $repair_count = RepairRecord::where(['user_id'=>$user_id,'company_id'=>$input['company_id'],'type'=>$input['type']])->count();
        //本次维护或者清洗的开始结束时间
        $end_time = $input['type'] == 1 ? strtotime('+'.($repair_count+1).' months',$friend_time) : strtotime('+'.(($repair_count+1)*3).' months',$friend_time);
        $start_time = $input['type'] == 1 ? strtotime('+'.$repair_count.' months',$friend_time) : strtotime('+'.($repair_count*3).' months',$friend_time);
        $repair_record = RepairRecord::where(['user_id'=>$user_id,'company_id'=>$input['company_id'],'type'=>$input['type']])->where('create_time','between',[$start_time,$end_time])->find();
        if($repair_record['status'] == 1){
            $this->error('您已'.$input['type'] == 1 ? '维护':'清洗');
        }
        if(!$repair_record){
            //添加维护或者清洗记录
            $record = new RepairRecord();
            $input['create_time'] = time();
            $input['user_id'] = $user_id;
            $record->save($input);
        }else{
            //修改维修状态
            $input['status'] = 1;
            $repair_record->save($input);
        }
        //维护的话 更新维护  清洗 更新清洗
        $data = $input['type'] == 1 ? ['repair_1'=>1] : ['repair_2'=>1];
        Company::where('id',$input['company_id'])->update($data);
        $this->success('添加成功');
    }

    /**
     * TODO 定时器   暂时不用
     * 定时添加空的维护或者清洗记录
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function set_record()
    {
        //所有添加过的  设置关系的好友
        $friend = Friend::where('status',1)->where('type','<>',0)->select();
        foreach ($friend as $key=>$value) {
            if($value['type'] != 3){
                //维护或者清洗次数
                $repair_count = RepairRecord::where(['company_id'=>Company::where('user_id',$value['to_id'])->value('id'),'type'=>$value['type']])
                    ->whereOr(['company_id'=>Company::where('user_id',$value['user_id'])->value('id'),'type'=>$value['type']])->count();
                //维护结束时间//维护或者清洗结束结束时间
                $end_time = $value['type'] == 1 ? strtotime('+'.($repair_count+1).' months',$value['friend_time']) : strtotime('+'.(($repair_count+1)*3).' months',$value['friend_time']);
                //维护或者清洗的开始结束时间
                $start_time = $value['type'] == 2 ? strtotime('+'.$repair_count.' months',$value['friend_time']) : strtotime('+'.($repair_count*3).' months',$value['friend_time']);
                $repair_record = RepairRecord::where(['user_id'=>$value['user_id'],'company_id'=>Company::where('user_id',$value['to_id'])->value('id'),'type'=>$value['type'],'status'=>1])
                    ->whereOr(['user_id'=>$value['to_id'],'company_id'=>Company::where('user_id',$value['user_id'])->value('id'),'type'=>$value['type'],'status'=>1])
                    ->where('create_time','between',[$start_time,$end_time])->find();
                //如果没有记录 大于维修结束时间
                if(!$repair_record && time() > $end_time){
                    $record = new RepairRecord();
                    //田家人的身份类型
                    $user_type = \app\api\model\User::where('id',$value['user_id'])->value('type');
                    $data['user_id'] = $user_type == 1 ? $value['to_id'] : $value['user_id'];
                    $data['company_id'] = $user_type == 1 ? Company::where('user_id',$value['user_id'])->value('id') : Company::where('user_id',$value['to_id'])->value('id');
                    $data['status'] = 0;$data['type'] = $value['type'];$data['create_time'] = $end_time - 1; $data['clarm'] = 1;
                    $record->save($data);
                }
            }else{
                //维护的次数
                $count1 = RepairRecord::where(['company_id'=>Company::where('user_id',$value['to_id'])->value('id'),'type'=>1])
                    ->whereOr(['company_id'=>Company::where('user_id',$value['user_id'])->value('id'),'type'=>1])->count();
                //清洗的次数
                $count2 = RepairRecord::where(['company_id'=>Company::where('user_id',$value['to_id'])->value('id'),'type'=>2])
                    ->whereOr(['company_id'=>Company::where('user_id',$value['user_id'])->value('id'),'type'=>2])->count();
                //维护或者清洗结束结束时间
                $end_time =  strtotime('+'.($count1+1).' months',$value['friend_time']); $end = strtotime('+'.(($count2+1)*3).' months',$value['friend_time']);
                //清洗或者清洗的开始时间
                $start_time =strtotime('+'.$count1.' months',$value['friend_time']); $start = strtotime('+'.($count2*3).' months',$value['friend_time']);
                //这次的维护记录
                $repair1 = RepairRecord::where("company_id = ".Company::where('user_id',$value['to_id'])->value('id')." and type = 1 and status = 1 and 
                    create_time between (".$start_time.",".$end_time.")")->whereOr("company_id = ". Company::where('user_id',$value['user_id'])->value('id')."
                     and type = 1 and status = 1 and create_time between (".$start_time.",".$end_time.")")->find();
                //如果没有记录 大于维修结束时间
                if(!$repair1 && time() > $end_time){
                    $repair_record = new RepairRecord();
                    //田家人的身份类型
                    $user_type = \app\api\model\User::where('id',$value['user_id'])->value('type');
                    $data['user_id'] = $user_type == 1 ? $value['to_id'] : $value['user_id'];
                    $data['company_id'] = $user_type == 1 ? Company::where('user_id',$value['user_id'])->value('id') : Company::where('user_id',$value['to_id'])->value('id');
                    $data['status'] = 0;$data['type'] = 1;$data['create_time'] = $end_time - 1;$data['clarm'] = 1;
                    $repair_record->save($data);
                }
                //本次的清洗记录
                $repair2 = RepairRecord::where("company_id = ".Company::where('user_id',$value['to_id'])->value('id')." and type = 2 and status = 1 and 
                        create_time between (".$start.",".$end.")")->whereOr("user_id = ".$value['to_id']." and company_id = ". Company::where('user_id',$value['user_id'])
                        ->value('id')." and type = 2 and status = 1 and create_time between (".$start.",".$end.")")->find();
                //如果没有记录 大于清洗结束时间
                if(!$repair2 && time() > $end){
                    $repair_record = new RepairRecord();
                    //田家人的身份类型
                    $user_type = \app\api\model\User::where('id',$value['user_id'])->value('type');
                    $data['user_id'] = $user_type == 1 ? $value['to_id'] : $value['user_id'];
                    $data['company_id'] = $user_type == 1 ? Company::where('user_id',$value['user_id'])->value('id') : Company::where('user_id',$value['to_id'])->value('id');
                    $data['status'] = 0;$data['type'] = 2;$data['create_time'] = $end - 1;$data['clarm'] = 1;
                    $repair_record->save($data);
                }
            }
        }
    }

    /**
     * TODO 定时器
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function setRecords()
    {
        //所有经营端  设置过维护时间  或者  清洗时间
        $users = \app\api\model\User::where(['status'=>'normal','type'=>1])->where("repair_time is not null or clean_time id not null")->select();
        foreach ($users as $val) {
            //经营端对应的  企业id
            $company_id = Company::where('user_id', $val['id'])->value('id');
            //如果有维修时间
            if ($val['repair_time'] != null) {
                $count = RepairRecord::where(['type' => 1, 'company_id' => $company_id])->count();
                //维护开始结束时间
                $start_time = strtotime('+' . $count . ' months', $val['repair_time']);
                $end_time = strtotime('+' . ($count + 1) . ' months', $val['repair_time']);
                //是否有维护记录
                $repair = RepairRecord::where(['type' => 1, 'company_id' => $company_id])->where('create_time', 'between', [$start_time, $end_time])->find();
                //if (!$repair && time() > $end_time) {
                if (!$repair && time() > $start_time) {
                    $repair_record = new RepairRecord();
                    //找到这个朋友关系
                    $friend = Friend::where(['user_id' => $val['id'], 'type' => 1])->whereOr(['to_id' => $val['id'], 'type' => 1])->whereOr(['user_id' => $val['id'], 'type' => 3])->whereOr(['to_id' => $val['id'], 'type' => 3])->find();
                    //查三方端的id
                    $data['user_id'] = $val['user_id'] == $friend['user_id'] ? $friend['to_id'] : $friend['user_id'];
                    $data['company_id'] = $company_id;
                    //没维护  添加时间是到期的前一秒
                    $data['status'] = 0;
                    $data['type'] = 1;$data['clarm'] = 1;
                    //$data['create_time'] = $end_time - 1;
                    $data['create_time'] = $start_time + 1;
                    $repair_record->save($data);
                    Company::where('id',$company_id)->update(['repair_1'=>0]);
                }
            }
            if ($val['clean_time'] != null) {
                $count = RepairRecord::where(['type' => 2, 'company_id' => $company_id])->count();
                //清洗的开始结束时间
                $start = strtotime('+' . ($count * 3) . ' months', $val['clean_time']);
                $end = strtotime('+' . (($count + 1) * 3) . ' months', $val['clean_time']);
                //是否有清洗
                $repair = RepairRecord::where(['type' => 2, 'company_id' => $company_id])->where('create_time', 'between', [$start, $end])->find();
                //if (!$repair && time() > $end) {
                if (!$repair && time() > $start) {
                    $repair_record = new RepairRecord();
                    //找到这个朋友关系
                    $friend = Friend::where(['user_id' => $val['id'], 'type' => 2])->whereOr(['to_id' => $val['id'], 'type' => 2])->whereOr(['user_id' => $val['id'], 'type' => 3])->whereOr(['to_id' => $val['id'], 'type' => 3])->find();
                    //查三方端的id
                    $data['user_id'] = $val['user_id'] == $friend['user_id'] ? $friend['to_id'] : $friend['user_id'];
                    $data['company_id'] = $company_id;
                    $data['status'] = 0;
                    $data['type'] = 2;$data['clarm'] = 1;
                    //$data['create_time'] = $end - 1;
                    $data['create_time'] = $start + 1;
                    $repair_record->save($data);
                    Company::where('id',$company_id)->update(['repair_2'=>0]);
                }
            }
        }
    }

    /**
     * 维护/清洗类型
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function repair()
    {
        $input = input();
        $type = isset($input['type']) && !empty($input['type']) ? $input['type'] : 1;
        $user_id = $this->auth->id;
        $user = \app\api\model\User::get($user_id);
        if($user['is_in'] == 0){
            $this->error('请先申请成为三方端');
        }
        if($user['type'] != 2){
            $this->error('您无权限');
        }

        $repair = Repair::where(['type'=>$type,'status'=>1])->select();
        $this->success('获取成功',$repair);
    }

    /**
     * 噪音的方位  和  数值
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function noise()
    {
        $noise = Noise::where(['type'=>1,'status'=>1])->select();
        $noises = Noise::where(['type'=>2,'status'=>1])->select();
        foreach ($noises as $key=>$value){
            $noises[$key]['value'] = json_decode($value['value'],true);
        }
        $this->success('获取成功',['noice'=>$noise,'noises'=>$noises]);
    }

    /**
     * 提交噪音检测
     * @throws \think\exception\DbException
     */
    public function noise_add()
    {
        $input = input();
        $user_id = $this->auth->id;
        //权限问题
        $user = \app\api\model\User::get($user_id);
        if($user['is_in'] == 0){
            $this->error('请先申请成为监管端');
        }
        if(!in_array($user['type'],[3,4])){
            $this->error('你无权限');
        }
        $company_id = isset($input['company_id']) && !empty($input['company_id']) ? $input['company_id'] : '';
        if(!$company_id){
            $this->error('请选择噪音检测企业');
        }
        $record = new NoiseRecord();
        //检测人员  和  创建时间
        $input['user_id'] = $user_id;$input['create_time'] = time();$input['company_id'] = $company_id;
        //检测的内容   合格与否
        $input['status'] = 1;
        //$content = json_decode(htmlspecialchars_decode($input['noises']),true);
        $content = $input['noises'];
        foreach ($content as $key=>$val){
            $noise = Noise::where('id',$val['value_id'])->value('value');
            if($val['value'] > json_decode($noise,true)['value']){
                $content[$key]['status'] = 0;
                $input['status'] = 0;
            }else{
                $content[$key]['status'] = 1;
            }
        }
        //添加操作
        $input['noises'] = json_encode($content,true);
        $record->save($input);
        $this->success('提交成功');
    }

    /**
     * 噪音检测列表
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function noise_list()
    {
        $input = input();
        $user_id = $this->auth->id;
        //权限问题
        $user = \app\api\model\User::get($user_id);
        if($user['is_in'] == 0){
            $this->error('请先申请成为监管端');
        }
        if(!in_array($user['type'],[3,4])){
            $this->error('你无权限');
        }

        //分页数据
        $page = isset($input['page']) && !empty($input['page']) ? $input['page'] : 1;
        $pageSize = isset($input['pageSize']) && !empty($input['pageSize']) ? $input['pageSize'] : 10;
        $company_id = $input['company_id'];
        //总数和查询

        $total = NoiseRecord::where('user_id',$user_id)->where('company_id',$company_id)->count();
        $record = NoiseRecord::where('user_id',$user_id)->where('company_id',$company_id)->limit(($page - 1) * $pageSize,$pageSize)->order('id desc')->select();
        foreach ($record as $key=>$val){
            $record[$key]['check_name'] = \app\api\model\User::where('id',$val['user_id'])->value('username');
            $record[$key]['create_time'] = date('Y-m-d H:i',$val['create_time']);
        }
        //总页数
        $total_page = ceil($total/$pageSize);
        $this->success('获取成功',['total'=>$total,'list'=>$record,'total_page'=>$total_page,'pageSize'=>$pageSize,'current_page'=>$page]);
    }

    /**
     * 噪音记录详情
     * @throws \think\exception\DbException
     */
    public function noise_detail()
    {
        $user_id = $this->auth->id;
        //权限问题
        $user = \app\api\model\User::get($user_id);
        if($user['is_in'] == 0){
            $this->error('请先申请成为监管端');
        }
        if(!in_array($user['type'],[3,4])){
            $this->error('你无权限');
        }

        $id = input('id');
        $noise = NoiseRecord::get($id);
        //检测 数据
        $noises = json_decode($noise['noises'],true);
        foreach($noises as $key=>$val){
            $noises[$key]['id_key'] = Noise::where('id',$val['id'])->value('value');
            $noise_value = Noise::where('id',$val['value_id'])->value('value');
            $noise_value = json_decode($noise_value,true);
            $noises[$key]['key'] = $noise_value['key'];
            $noises[$key]['val'] = $noise_value['value'];
        }
        $noise['noises'] = $noises;
        $user = \app\api\model\User::get($noise['user_id']);
        //如果她是员工 就是她的上级
        $uid = $user['pid'] == 0 ? $noise['user_id'] : $user['pid'];
        $company = Company::where('user_id',$uid)->find();
        //检测公司和检测人员
        $noise['company'] = $company['company'];$noise['contact'] = $user['username'];$noise['create_time'] = date('Y-m-d H:i',$noise['create_time']);
        $this->success('获取成功',$noise);
    }

    /**
     * 检测的问题
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function score()
    {
        $score = Score::where('status',1)->select();
        $this->success('获取成功',$score);
    }

    /**
     * 评分的添加和编辑
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function score_add()
    {
        $input = input();
        //权限问题
        $user_id = $this->auth->id;
        $user = \app\api\model\User::get($user_id);
        if($user['is_in'] == 0){
            $this->error('请先申请成为监管端');
        }
        if(!in_array($user['type'],[3,4])){
            $this->error('你无权限');
        }
        //评委
        $input['user_id'] = $user_id;
        //企业信息
        $company_id = isset($input['company_id']) && !empty($input['company_id']) ? $input['company_id'] : "";
        $content = isset($input['content']) && !empty($input['content']) ? $input['content'] : "";
        if(!$company_id){
            $this->error('请选择要测评的企业');
        }
        if(!$content){
            $this->error('请提交测评结果');
        }
        $company = Company::where('id',$company_id)->find();
        $input['company'] = $company['company']; $input['contact'] = $company['contact'];
        //限定整改时间
        $input['rectify_time'] = isset($input['rectify_time']) && !empty($input['rectify_time']) ? strtotime($input['rectify_time']) : null;
        $input['before'] = json_encode($input['before'],JSON_UNESCAPED_UNICODE);
        if(isset($input['id']) && !empty($input['id'])){
            $record = Record::get($input['id']);
            unset($input['id']);
        }else{
            $record = new Record();
            $input['create_time'] = time();
        }
        //评分结果
        //得分和是否需要整改
        $score = 20;$is_change = 2;$contents = [];
        //是否是修改
        if(isset($record['content'])){
            //查到原来的提交内容
            $contents = json_decode($record['content'],true);
            //查原来的值
            $content_score = array_column($content,'score','id');
            $content_change = array_column($content,'is_change','id');
            $content_reason = array_column($content,'reason','id');
            //查key
            $content_id = array_column($content,'id');
            //var_dump($contents,$content_id,$content_reason,$content_change,$content_score);exit;
            //重新编辑他的内容
            foreach ($contents as $key=>$value){
                if(in_array($value['id'],$content_id)){
                    $con_score = $content_score[$value['id']];
                    $con_change = $content_change[$value['id']];
                    $con_reason = $content_reason[$value['id']];
                    if($con_change == 1){
                        $contents[$key]['score'] = $con_score = 0;
                        $is_change = 1;
                        $contents[$key]['reason'] = $value['score'] = $con_reason;
                    }else{
                        //该题的最大得分
                        $question = Score::get($value['id']);
                        $contents[$key]['score'] = $value['score'] = $value['score'] > $question['score'] ? $question['score'] : $con_score;
                    }
                }
                //如果不是修改的  就加上他原来的分
                $score += $value['score'];
                $contents[$key]['is_change'] = $is_change;
            }
        }else{
            //新增
            foreach ($content as $key=>$value){
                if($value['is_change'] == 1){
                    $content[$key]['score'] = $value['score'] = 0;
                    $is_change = 1;
                }else{
                    //该题的最大得分
                    $question = Score::get($value['id']);
                    if($value['score'] > $question['score']){
                        $content[$key]['score'] = $value['score'] = $question['score'];
                    }
                }
                $score += $value['score'];
            }
        }
        //保存修改
        $input['score'] = $score;$input['is_change'] = $is_change;
        $input['content'] = isset($record['content']) ? json_encode($contents,JSON_UNESCAPED_UNICODE) : json_encode($content,JSON_UNESCAPED_UNICODE);
        //需要整改 就是红码   不需要 只要分大于70  绿码  否则黄码
        $input['status'] = $is_change == 1 ? 3 : ($score > 70 ? (isset($record['content']) ? 4 : 1) : (isset($record['content']) ? 5 : 2));
        //TODO 检测后的二维码
        //红码
        $red = \request()->domain(). "/qrcode/build?text={$company['user_id']}&label=&logo=0&labelalignment=center&foreground=%23ff0000&background=%23ffffff&size=300&padding=10&logosize=50&labelfontsize=14&errorcorrection=medium";
        //绿码
        $green = \request()->domain(). "/qrcode/build?text={$company['user_id']}&label=&logo=0&labelalignment=center&foreground=%23008000&background=%23ffffff&size=300&padding=10&logosize=50&labelfontsize=14&errorcorrection=medium";
        //黄码
        $yellow = \request()->domain(). "/qrcode/build?text={$company['user_id']}&label=&logo=0&labelalignment=center&foreground=%23ffff00&background=%23ffffff&size=300&padding=10&logosize=50&labelfontsize=14&errorcorrection=medium";
        //二维码图片
        $input['qrcode'] = $input['status'] == 1 ? $green :($input['status'] == 2 ? $yellow : $red);
        \app\api\model\User::where('id',$company['user_id'])->update(['qrcode'=>$input['qrcode']]);
        $company->save(['level'=>$input['status']]);
        $record->save($input);
        $this->success('提交成功',['qrcode'=>$input['qrcode'],'status'=>$input['status'],'score'=>$input['score']]);
    }

    /**
     * 查经营端  测评记录
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function score_record()
    {
        $input = input();
        //权限问题
        $user_id = $this->auth->id;
        $user = \app\api\model\User::get($user_id);
        if($user['is_in'] == 0){
            $this->error('请先申请成为经营端');
        }
        if($user['type'] != 1){
            $this->error('你无权限');
        }

        //分页 总数
        $page = isset($input['page']) && !empty($input['page']) ? $input['page'] : 1;
        $pageSize = isset($input['pageSize']) && !empty($input['pageSize']) ? $input['pageSize'] : 10;
        $company_id = Company::where('user_id',$user_id)->value('id');
        $status = 1;
        if(isset($input['status']) && !empty($input['status'])){
            $status = $input['status'] == 2 ? 3 : ($input['status'] == 3 ? 2 : 1);
        }
        $total = Record::where('company_id',$company_id)->where('is_change',$status)->count();
        //查询
        $record = Record::where('company_id',$company_id)->where('is_change',$status)->limit(($page - 1)*$pageSize,$pageSize)->order('id desc')->select();
        foreach ($record as $key=>$value){
            $content = json_decode($value['content'],true);
            foreach ($content as $k =>$val){
                if(isset($val['images'])){
                    $content[$k]['images'] = explode(';',$val['images']);
                }
                if(isset($val['image'])) {
                    $content[$k]['image'] = explode(';', $val['image']);
                }
            }
            $record[$key]['content'] = $content;
            $before = json_decode($value['before'],true);
            foreach ($before as $k =>$val){
                if($val['is_change'] == 1 && isset($val['images'])){
                    $before[$k]['images'] = explode(';',$val['images']);
                }
            }
            $record[$key]['before'] = $before;
            $record[$key]['after'] = json_decode($value['after'],true);
            $record[$key]['rectify_time'] = date('Y-m-d H:i',$value['rectify_time']);
            $record[$key]['create_time'] = date('Y-m-d H:i',$value['create_time']);
            $user = \app\api\model\User::where('id',$value['user_id'])->find();
            $record[$key]['ping_name'] = $user['username'];
            $record[$key]['ping_company'] = $user['pid'] == 0 ? Company::where('user_id',$user['id'])->value('company') :
                Company::where('user_id',$user['pid'])->value('company');
        }
        //总页数
        $total_page = ceil($total/$pageSize);
        $this->success('获取成功',['list'=>$record,'total'=>$total,'current_page'=>$page,'pageSize'=>$pageSize,'total_page'=>$total_page]);
    }

    /**
     * 经营端的整改
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function record_edit()
    {
        //用户信息
        $user_id = $this->auth->id;
        $user = \app\api\model\User::get($user_id);
        $input = input();
        $id = $input['id'];
        //权限
        if($user['is_in'] == 0){
            $this->error('请先申请成为经营端');
        }
        if($user['type'] != 1){
            $this->error('您有无权限');
        }
        //整改详情 并修改
        $record = Record::where('id',$id)->find();
        if(!$record){
            $this->error('无此整改记录');
        }
        $after = json_encode($input['after'],JSON_UNESCAPED_SLASHES);
        $record->save(['after'=>$after,'is_change'=>3,'gai_time'=>time()]);
        $this->success('整改成功');
    }

    /**
     * 经营端  投诉整改
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function complaint()
    {
        $user_id = $this->auth->id;
        $input = input();
        //分页信息
        $page = isset($input['page']) && !empty($input['page']) ? $input['page'] : 1;
        $pageSize = isset($input['pageSize']) && !empty($input['pageSize']) ? $input['pageSize'] : 10;
        //状态值
        $status = isset($input['status']) && !empty($input['status']) ? $input['status'] : 1;
        //企业信息
        $company_id = Company::where('user_id',$user_id)->value('id');
        //总数
        $total = Complaint::where(['company_id'=>$company_id])->where('status','in',$status)->count();
        //分页查询
        $list = Complaint::where(['company_id'=>$company_id])->where('status','in',$status)->limit(($page - 1)*$pageSize,$pageSize)->order('id desc')->select();
        foreach ($list as $key=>$item){
            $list[$key]['create_time'] = date('Y-m-d H:i',$item['create_time']);
            $list[$key]['tou_time'] = date('Y-m-d H:i',$item['tou_time']);
            $list[$key]['check_time'] = $item['check_time'] ? date('Y-m-d H:i',$item['check_time']) : "";
            $list[$key]['gai_time'] = $item['gai_time'] ? date('Y-m-d H:i',$item['gai_time']) : "";
            $list[$key]['rectify_time'] = $item['rectify_time'] ? date('Y-m-d H:i',$item['rectify_time']) : "";
        }
        //总页数
        $total_page = ceil($total/$pageSize);
        $this->success('获取成功',['list'=>$list,'total'=>$total,'total_page'=>$total_page,'current_page'=>$page,'pageSize'=>$pageSize]);
    }

    /**
     * 监管端 投诉整改
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function complaint_list()
    {
        $user_id = $this->auth->id;
        $input = input();
        //分页信息
        $page = isset($input['page']) && !empty($input['page']) ? $input['page'] : 1;
        $pageSize = isset($input['pageSize']) && !empty($input['pageSize']) ? $input['pageSize'] : 10;
        //状态值
        $status = isset($input['status']) && !empty($input['status']) ? $input['status'] : 1;
        $company_id = $input['company_id'];
        //总数
        $total = Complaint::where(['user_id'=>$user_id])->where('company_id',$company_id)->where('status','in',$status)->count();
        //分页查询
        $list = Complaint::where(['user_id'=>$user_id])->where('company_id',$company_id)->where('status','in',$status)->limit(($page - 1)*$pageSize,$pageSize)->order('id desc')->select();
        foreach ($list as $key=>$item){
            $list[$key]['create_time'] = date('Y-m-d H:i',$item['create_time']);
            $list[$key]['tou_time'] = date('Y-m-d H:i',$item['tou_time']);
            $list[$key]['check_time'] = $item['check_time'] ? date('Y-m-d H:i',$item['check_time']) : "";
            $list[$key]['gai_time'] = $item['gai_time'] ? date('Y-m-d H:i',$item['gai_time']) : "";
            $list[$key]['rectify_time'] = $item['rectify_time'] ? date('Y-m-d H:i',$item['rectify_time']) : "";
        }
        //总页数
        $total_page = ceil($total/$pageSize);
        $this->success('获取成功',['list'=>$list,'total'=>$total,'total_page'=>$total_page,'current_page'=>$page,'pageSize'=>$pageSize]);
    }

    /**
     * 查监管端  测评记录
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function score_list()
    {
        $input = input();
        //权限问题
        $user_id = $this->auth->id;
        $user = \app\api\model\User::get($user_id);
        if($user['is_in'] == 0){
            $this->error('请先申请成为监管端');
        }
        if(!in_array($user['type'],[3,4])){
            $this->error('你无权限');
        }

        //分页 总数
        $page = isset($input['page']) && !empty($input['page']) ? $input['page'] : 1;
        $pageSize = isset($input['pageSize']) && !empty($input['pageSize']) ? $input['pageSize'] : 10;
        $status = isset($input['status']) && $input['status'] !== "" ? $input['status'] : "";
        $company_id = isset($input['company_id']) && $input['company_id'] !== "" ? $input['company_id'] : "";
        $where = [];
        if($status !== ""){
            $where['is_change'] = $status;
        }
        if($company_id !== ""){
            $where['company_id'] = $company_id;
        }
        $total = Record::where('user_id',$user_id)->where($where)->count();
        //查询
        $record = Record::where('user_id',$user_id)->where($where)->limit(($page - 1)*$pageSize,$pageSize)->order('id desc')->select();
        foreach ($record as $key=>$value){
            $content = json_decode($value['content'],true);
            if(!empty($content)){
                foreach ($content as $k =>$val){
                    if(isset($val['images'])){
                        $content[$k]['images'] = array_url(explode(';',$val['images']));
                    }
                    if(isset($val['image'])) {
                        $content[$k]['image'] = array_url(explode(';', $val['image']));
                    }
                }
            }
            $record[$key]['content'] = $content;
            $before = json_decode($value['before'],true);
            if(!empty($before)){
                foreach ($before as $k =>$val){
                    if($val['is_change'] == 1 && isset($val['images'])){
                        $before[$k]['images'] = array_url(explode(';',$val['images']));
                    }
                }
            }
            $record[$key]['before'] = $before;
            $record[$key]['after'] = json_decode($value['after'],true);
            $record[$key]['rectify_time'] = date('Y-m-d H:i',$value['rectify_time']);
            $record[$key]['create_time'] = date('Y-m-d H:i',$value['create_time']);
            $user = \app\api\model\User::where('id',$value['user_id'])->find();
            $record[$key]['ping_name'] = $user['username'];
            $record[$key]['ping_company'] = $user['pid'] == 0 ? Company::where('user_id',$user['id'])->value('company') :
                Company::where('user_id',$user['pid'])->value('company');
        }
        //总页数
        $total_page = ceil($total/$pageSize);
        $this->success('获取成功',['list'=>$record,'total'=>$total,'current_page'=>$page,'pageSize'=>$pageSize,'total_page'=>$total_page]);
    }

    /**
     * 整改详情
     * @throws \think\exception\DbException
     */
    public function score_detail()
    {
        $id = input('id');
        $record = Record::get($id);
        if(!$record){
            $this->error('没有整改记录');
        }
        //提交时间   和   限定整改时间
        $record['create_time'] = date('Y-m-d H:i',$record['create_time']);
        $record['rectify_time'] = date('Y-m-d H:i',$record['rectify_time']);
        //提交的答案
        $content = json_decode($record['content'],true);
        foreach ($content as $k =>$val){
            $content[$k]['question'] = Score::where('id',$val['id'])->value('question');
            $content[$k]['tip'] = Score::where('id',$val['id'])->value('tip');
            if(isset($val['images'])){
                $content[$k]['images'] = array_url(explode(';',$val['images']));
            }
            if(isset($val['image'])) {
                $content[$k]['image'] = array_url(explode(';', $val['image']));
            }
        }
        $record['content'] = $content;
        //整改前的
        $before = json_decode($record['before'],true) ?? [];
        foreach ($before as $k =>$val){
            $before[$k]['question'] = Score::where('id',$val['id'])->value('question');
            $before[$k]['tip'] = Score::where('id',$val['id'])->value('tip');
            if($val['is_change'] == 1 && isset($val['images'])){
                $before[$k]['images'] = array_url(explode(';',$val['images']));
            }
        }
        //整改后的
        $after = json_decode($record['after'],true) ?? [];
        foreach ($after as $k =>$val){
            if(isset($val['images'])){
                $after[$k]['images'] = $val['images'] = array_url(explode(';',$val['images']));
                $before[$k]['after_images'] = $val['images'];
            }
        }
        $record['before'] = $before;
        $record['after'] = $after;
        $user = \app\api\model\User::where('id',$record['user_id'])->find();
        $record['ping_name'] = $user['username'];
        $record['gai_time'] = $record['gai_time'] ? date('Y-m-d H:i',$record['gai_time']) : $record['gai_time'];
        $record['ping_company'] = $user['pid'] == 0 ? Company::where('user_id',$user['id'])->value('company') :
            Company::where('user_id',$user['pid'])->value('company');
        $this->success('获取成功',$record);
    }

    /**
     * 全局搜索
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function search()
    {
        $user_id = $this->auth->id;
        //权限
        $user = \app\api\model\User::get($user_id);
        if($user['is_in'] == 0){
            $this->error('请先申请成为三方端/监管端');
        }
        if($user['type'] == 1){
            $this->error('您无权限');
        }
        //搜索
        $keyword = input('keyword');
        $company = Company::where("company like '%".$keyword."%'")->select();
        foreach ($company as $key=>$item){
            $company[$key]['logo'] = request()->domain().$item['logo'];
            $company[$key]['score'] = Record::where('company_id',$item['id'])->order('id desc')->value('score');
            $company[$key]['qrcode'] = Record::where('company_id',$item['id'])->order('id desc')->value('qrcode');
        }

        //是否有搜索记录
        $search = Search::where(['user_id'=>$user_id,'keyword'=>$keyword])->find();
        if(!$search){
            //没有搜索记录的话  添加搜索记录
            $model = new Search();
            $model->save(['user_id'=>$user_id,'keyword'=>$keyword,'create_time'=>time()]);
        }

        $this->success('获取成功',$company);
    }

    /**
     * 历史搜索
     * @throws \think\exception\DbException
     */
    public function search_log()
    {
        $user_id = $this->auth->id;
        //权限
        $user = \app\api\model\User::get($user_id);
        if($user['is_in'] == 0){
            $this->error('请先申请成为三方端/监管端');
        }
        if($user['type'] == 1){
            $this->error('您无权限');
        }

        $search = Search::where('user_id',$user_id)->where('is_delete',0)->column('keyword');
        $this->success('获取成功',$search);
    }

    /**
     * 搜索记录删除
     * @throws \think\exception\DbException
     */
    public function search_del()
    {
        $user_id = $this->auth->id;
        //权限
        $user = \app\api\model\User::get($user_id);
        if($user['is_in'] == 0){
            $this->error('请先申请成为三方端/监管端');
        }
        if($user['type'] == 1){
            $this->error('您无权限');
        }

        Search::where('user_id',$user_id)->update(['is_delete'=>1]);
        $this->success('删除成功');
    }
}
