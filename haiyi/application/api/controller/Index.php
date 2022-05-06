<?php

namespace app\api\controller;

use app\api\model\Comment;
use app\api\model\Feedback;
use app\api\model\Focus;
use app\api\model\Forum;
use app\api\model\ForumFavor;
use app\api\model\ForumType;
use app\api\model\Report;
use app\api\model\Search;
use app\api\model\Zan;
use app\common\controller\Api;

/**
 * 首页接口
 */
class Index extends Api
{
    protected $noNeedLogin = ['*'];
    protected $noNeedRight = ['*'];

    /**
     * 话题类
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function topic()
    {
        //最新
        $new = ForumType::where(['type'=>1,'status'=>1])->order('id desc')->select();
        //最热
        $hot = ForumType::where(['type'=>2,'status'=>1])->order('id desc')->select();
        //必看
        $must = ForumType::where(['type'=>3,'status'=>1])->order('id desc')->select();
        //常用
        $always = ForumType::where(['type'=>4,'status'=>1])->order('id desc')->select();
        $this->success('获取成功',['new'=>$new,'hot'=>$hot,'must'=>$must,'alwways'=>$always]);
    }

    /**
     * 论坛
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function forum()
    {
        $user_id = $this->auth->id;
        //我关注的
        $a = Focus::where("user_id = ".$user_id)->column('focus_id');
        //我被关注后 回关
        $b = Focus::where("type = 2 and focus_id = ".$user_id)->column('user_id');
        $focus_id = array_merge($a,$b);
        $input = input();
        //话题id
        $forum_type = isset($input['forum_type']) ? $input['forum_type'] : "";
        $where = ['status'=>1];
        //话题
        if($forum_type){
            $where['topic'] = $forum_type;
        }
        //分页信息
        $page = isset($input['page']) && $input['page']!= "" ? $input['page'] : 1;
        $pageSize = isset($input['pageSize']) && $input['pageSize']!= "" ? $input['pageSize'] : 10;
         //公开的  是发布者粉丝的   自己发的
        $where1 = "(is_open = 1) or (is_open = 2 and user_id in ".$focus_id.") or (is_open = 3 and user_id = ".$user_id.")";
        //查总数
        $total = Forum::where($where)->where($where1)->count();
        //分页查
        $list = Forum::where($where)->where($where1)->order(['sticky' => 'desc','create_time'=>'desc'])->limit(($page - 1)*$pageSize,$pageSize)->select();
        //总页数
        $total_page = ceil($total/$pageSize);
        $this->success('获取成功',['list'=>$list,'total'=>$total,'total_page'=>$total_page,'page'=>$page,'pageSize'=>$pageSize]);
    }

    /**
     * 话题类型
     */
    public function forum_type()
    {
        $type = [1=>"常规",2=>"规则",3=>"通知",4=>"教程",5=>"流程"];
        $this->success('获取成功',$type);
    }

    /**
     * 论坛添加
     */
    public function forum_add()
    {
        $user_id = $this->auth->id;
        $input = input();
        $input['user_id'] = $user_id;$input['create_time'] = time();
        $forum = new Forum();
        $forum->save($input);
    }

    /**
     * 评论
     */
    public function comment()
    {
        $user_id = $this->auth->id;
        //TODO 权限  普通用户没有权限
        $input = input();
        $type = isset($input['type']) && $input['type'] != ''? $input['type'] : 1;
        $id = $input['id'];
        $comment = htmlspecialchars_decode($input['comment']);
        $model = new Comment();
        $model->save(['type'=>$type,'user_id'=>$user_id,'forum_id'=>$id,'comment'=>$comment]);
        //如果是评论论坛的话  给论坛文章加评论数
        if($type == 1){
            Forum::where('id',$id)->setInc('comment',1);
        }
        $this->success('评论成功');
    }

    /**
     * 评论删除
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function comment_del()
    {
        $user_id = $this->auth->id;
        $input = input();
        $id = $input['id'];
        $comment = Comment::where('id',$id)->find();
        if($comment['user_id'] != $user_id){
            $this->error('只能删自己的评论');
        }
        $type = $comment['type'];$forum_id = $comment[''];
        $comment->delete();
        //删除评论的话  要删除对应的评论数
        if($type == 1){
            Forum::where('id',$forum_id)->setDec('comment',1);
        }
        $this->success('删除评论成功');
    }

    /**
     * 点赞  取消赞
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function zan()
    {
        $user_id = $this->auth->id;
        $input = input();
        $type = isset($input['type']) && $input['type'] != ''? $input['type'] : 1;
        $id = $input['id'];
        $zan = Zan::where(['user_id'=>$user_id,'id'=>$id,'type'=>$type])->find();
        //给论坛文章 或者 评论加赞的数量
        if($type == 1){
            if($zan['status'] == 1){
                Forum::where('id',$id)->setDec('zan',1);
            }else{
                Forum::where('id',$id)->setInc('zan',1);
            }
        }else{
            if($zan['status'] == 1){
                Comment::where('id',$id)->setDec('zan',1);
            }else{
                Comment::where('id',$id)->setInc('zan',1);
            }
        }
        //zan存在
        $data['status'] = isset($zan) && $zan['status'] == 1 ? 2 : 1;
        //添加或者修改zan的记录
        if(!$zan){
            $zan = new Zan();
            $data['create_time'] = time();
            //点赞类型  点赞用户  点赞id
            $data['type'] = $type;$data['user_id'] = $user_id;$data['forum_id'] = $id;
        }
        $zan->save($data);
        $msg = $data['status'] == 1 ? "点赞成功" : "取消赞成功";
        $this->success($msg);
    }

    /**
     * 置顶操作
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function sticky()
    {
        $user_id = $this->auth->id;
        //TODO 据冯胜杰说  置顶是特定人的权限
        $id = input('id');
        $forum = Forum::where('id',$id)->find();
        //如果已经是置顶状态   改成不置顶
        $data['sticky'] = $forum['sticky'] == 1 ? 2 : 1;
        $forum->save($data);
        $this->success('设置成功');
    }

    /**
     * 举报 取消举报
     */
    public function report()
    {
        $user_id = $this->auth->id;
        $id = input('id');
        $type = isset($input['type']) && $input['type'] != ''? $input['type'] : 1;
        //1举报  2取消举报
        if($type == 1){
            $report = new Report();
            $report->save(['user_id'=>$user_id,'forum_id'=>$id,'create_time'=>time()]);
            $msg = "举报成功";
        }else{
           Report::where('id',$id)->update(['status'=>3]);
           $msg = '取消举报成功';
        }
        $this->success($msg);
    }

    /**
     * 论坛文章的收藏 和 取消收藏
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function forum_favor()
    {
        $user_id = $this->auth->id;
        $id = input('id');
        $favor = ForumFavor::where(['user_id'=>$user_id,'forum_id'=>$id])->find();
        $data['status'] = isset($favor) && $favor['status'] == 1 ? 2 : 1;
        if(!$favor){
            $favor = new ForumFavor();
            $data['forum_id'] = $id;$data['user_id'] = $user_id;$data['create_time'] = time();$data['status'] = 1;
        }
        $favor->save($data);
        $msg = $data['status'] == 1 ? "点赞成功" : "取消赞成功";
        $this->success($msg);
    }

    /**
     * 论坛文章删除
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function forum_del()
    {
        $user_id = $this->auth->id;
        $id = input('id');
        $forum = Forum::where('id',$id)->find();
        if($user_id != $forum['user_id']){
            $this->error('不能删除别人的文章');
        }
        $forum->delete();
        $this->success('删除成功');
    }

    /**
     * 搜索
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function search()
    {
        //用户信息
        $user_id = $this->auth->id;
        $input = input();
        $keyword = $input['keyword'];
        if($keyword){
            $this->error('请输入搜索关键词');
        }
        //分页信息
        $page = isset($input['page']) && !empty($input['page']) ? $input['page'] : 1;
        $pageSize = isset($input['pageSize']) && !empty($input['pageSize']) ? $input['pageSize'] : 10;
        //总数  分页查询
        $total = \app\api\model\Forum::where(['status'=>1,'user_id'=>$user_id])->where("content like %'.$keyword.'%")->count();
        $goods = \app\api\model\Forum::where(['status'=>1,'user_id'=>$user_id])->where("content like %'.$keyword.'%")->limit(($page - 1)*$pageSize,$pageSize)->order('id desc')->select();
        //总页数
        $total_page = ceil($total/$pageSize);

        //查询搜索记录
        $search = Search::where(['search'=>$keyword,'type'=>2,'user_id'=>$user_id])->find();
        $data = [];
        if($search){
            //修改搜索记录
            $data = ['status'=>1,'update_time'=>time()];
        }else{
            //新增搜索的记录
            $search = new Search();
            $data['create_time'] = time();$data['search'] = $keyword;$data['user_id'] = $user_id;$data['type'] = 2;
        }
        $search->save($data);
        $this->success('获取成功',['total'=>$total,'list'=>$goods,'total_page'=>$total_page,'current_page'=>$page,'pageSize'=>$pageSize]);
    }

    /**
     * 搜索记录
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function log()
    {
        $user_id = $this->auth->id;
        $log = Search::where(['status'=>1,'user_id'=>$user_id,'type'=>1])->order('update_time desc')->limit(6)->select();
        $this->success('获取成功',$log);
    }

    /**
     * 删除搜索记录
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function log_del()
    {
        //用户信息
        $user_id = $this->auth->id;
        $id = input('id');
        //查到搜索记录
        $log = Search::where(['id'=>$id,'user_id'=>$user_id,'type'=>1])->find();
        $log->save(['status'=>2,'delete_time'=>time()]);
        $this->success('删除成功');
    }

    /**
     * 问题反馈
     */
    public function feedback()
    {
        //用户信息
        $user_id = $this->auth->id;
        $input = input();
        $input['user_id'] = $user_id;
        //添加问题反馈
        $feedback = new Feedback();
        $feedback->save($input);
        $this->success('反馈成功');
    }
}
