<?php

namespace app\api\controller;

use app\api\model\Article;
use app\api\model\ArticleRecord;
use app\common\controller\Api;
use function fast\e;

/**
 *  企业新闻接口
 */
class Message extends Api
{
    protected $noNeedLogin = ['*'];
    protected $noNeedRight = ['*'];

    /**
     * 企业新闻
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function index()
    {
        $input = input();
        //类型  分页信息
        $type = isset($input['type']) && !empty($input['type']) ? $input['type'] : 1;
        $page = isset($input['page']) && !empty($input['page']) ? $input['page'] : 1;
        $pageSize = isset($input['pageSize']) && !empty($input['pageSize']) ? $input['pageSize'] : 10;
        //查总数  分页查询  和 总页数
        $total = Article::where(['status'=>1,'type'=>$type])->count();
        $list = Article::where(['status'=>1,'type'=>$type])->limit(($page - 1)*$pageSize,$pageSize)->order('id desc')->select();
        foreach ($list as $key=>$value){
            $list[$key]['image'] = request()->domain().$value['image'];
            $list[$key]['create_time'] = date('Y-m-d H:i',$value['create_time']);
            $record = ArticleRecord::where(['user_id'=>$this->auth->id,'article_id'=>$value['id']])->find();
            $list[$key]['is_read'] = $record ? 1 : 0;
        }
        $total_page = ceil($total/$pageSize);
        $this->success('获取成功',['list'=>$list,'total'=>$total,'total_page'=>$total_page,'pageSize'=>$pageSize,'current_page'=>$page]);
    }

    /**
     * 新闻详情
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function detail()
    {
        $user_id = $this->auth->id;
        $input = input();
        $id = $input['id'];
        //文章详情
        $article = Article::get($id);
        if(!$article){
            $this->error('该新闻不存在');
        }
        //读取记录
        if(!ArticleRecord::where(['user_id'=>$user_id,'article_id'=>$id])->find()){
            $record = new ArticleRecord();
            $record->save(['user_id'=>$user_id,'article_id'=>$id,'create_time'=>time()]);
        }
        //文章图片 和  创建时间
        $article['image'] = request()->domain().$article['image'];
        $article['create_time'] = date('Y-m-d H:i',$article['create_time']);
        //侧边的文章推荐
        $list = Article::where(['type'=>$article['type'],'status'=>1])->where('id','<>',$id)->limit(6)->order('id desc')->select();
        foreach ($list as $key=>$value){
            $list[$key]['image'] = request()->domain().$value['image'];
            $record = ArticleRecord::where(['user_id'=>$this->auth->id,'article_id'=>$value['id']])->find();
            $list[$key]['is_read'] = $record ? 1 : 0;
        }
        $this->success('获取成功',[''=>$article,'list'=>$list]);
    }
}
