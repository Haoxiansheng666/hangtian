<?php

namespace app\api\controller;

use app\api\model\Cate;
use app\api\model\CateParam;
use app\api\model\Forum;
use app\api\model\GoodsFavor;
use app\api\model\Images;
use app\api\model\Search;
use app\common\controller\Api;

/**
 * 商品接口
 */
class Goods extends Api
{
    protected $noNeedLogin = ['*'];
    protected $noNeedRight = ['*'];

    /**
     * 商城首页
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function index()
    {
        $cate = Cate::where(['pid'=>0,'status'=>1])->select();
        foreach ($cate as $key=>$item){
            $cate[$key]['child'] = Cate::where('pid',$item['id'])->select();
        }
        $recommend = Cate::where(['status'=>1,'recommend'=>1])->select();
        //分类  加  推荐
        $data = array_merge($recommend,$cate);
        //banner轮播
        $banner = Images::where(['type'=>3,'status'=>1])->select();
        //热卖推荐
        $hot = \app\api\model\Goods::where(['recommend'=>1,'status'=>1,'switch'=>1])->order('id desc')->limit(5)->select();
        //新品推荐
        $new = \app\api\model\Goods::where(['new'=>1,'status'=>1,'switch'=>1])->order('id desc')->limit(5)->select();
        //首页推荐
        $index = \app\api\model\Goods::where(['index'=>1,'status'=>1,'switch'=>1])->order('id desc')->limit(8)->select();
        //首页广告
        $image_1 = Images::where(['type'=>4,'status'=>1])->order('id desc')->find();
        //推荐模块图
        $image_2 = Images::where(['type'=>5,'status'=>1])->order('id desc')->find();
        $this->success('获取成功',['data'=>$data,'banner'=>$banner,'hot'=>$hot,'new'=>$new,'index'=>$index,'img_1'=>$image_1,'img_2'=>$image_2]);
    }

    /**
     * 分类的参数筛选
     */
    public function condition()
    {
        $id = input('id');
        //产品分类的参数筛选
        $param = CateParam::where(['cate_id'=>$id,'status'=>1])->select();
        foreach ($param as $key=>$value){
            $param[$key]['value'] = json_decode($value['value'],true);
        }
        //升降序
        $order = [
            ['name'=>'最新上架','value'=>'id desc'],
            ['name'=>'价格升序','value'=>'price asc'],
            ['name'=>'价格降序','value'=>'price desc'],
            ['name'=>'销量','value'=>'sales desc'],
        ];
        $this->success('获取成功',[''=>$param,'order'=>$order]);
    }

    /**
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function list()
    {
        //接受参数
        $input = input();
        //商品分类
        $cate_id = $input['cate_id'];
        //参数的筛选
        $param_id = isset($input['param_id']) && !empty($input['param_id']) ? $input['param_id'] : "";
        //分页
        $page = isset($input['page']) && !empty($input['page']) ? $input['page'] : 1;
        $pageSize = isset($input['pageSize']) && !empty($input['pageSize']) ? $input['pageSize'] : 10;
        //排序
        $order = isset($input['order']) && !empty($input['order']) ? $input['order'] : 'id asc';
        //价格区间筛选
        $price_array = isset($input['price_arr']) && !empty($input['price_arr']) ? explode(';',$input['']) : "";
        //where条件
        $where = ['cate_id'=>$cate_id,'switch'=>1,'status'=>1];
        //价格区间查询
        if($price_array){
            $where['price'] = ['between',$price_array];
        }
        //参数查询
        $where1 = "";
        if($param_id){

        }
        //总数
        $total = \app\api\model\Goods::where($where)->where($where1)->count();
        //分页查询
        $list = \app\api\model\Goods::where($where)->where($where1)->order($order)->limit(($page - 1)*$pageSize)->select();
        //总页数
        $total_page = ceil($total/$pageSize);
        $this->success('获取成功',['total'=>$total,'list'=>$list,'pageSize'=>$pageSize,'current_page'=>$page,'total_page'=>$total_page]);
    }

    /**
     * 商品详情
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function detail()
    {
        $id = input('id');
        //详情查找
        $detail = \app\api\model\Goods::where(['id'=>$id,'switch'=>1,'status'=>1])->find();
        if(!$detail){
            $this->error('该商品不存在');
        }
        //主图
        $detail['image'] = array_url(explode(';',$detail['image']));
        //图集
        $detail['images'] = array_url(explode(';',$detail['images']));
        //参数
        $detail['param'] = json_decode($detail['param'],true);
        //创建时间
        $detail['create_time'] = date('Y-m-d H:i',$detail['create_time']);
        $this->success('获取成功',$detail);
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
        $total = \app\api\model\Goods::where(['switch'=>1,'status'=>1,'user_id'=>$user_id])->where("name like %'.$keyword.'%")->count();
        $goods = \app\api\model\Goods::where(['switch'=>1,'status'=>1,'user_id'=>$user_id])->where("name like %'.$keyword.'%")->limit(($page - 1)*$pageSize,$pageSize)->order('id desc')->select();
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
        $log = Search::where(['status'=>1,'user_id'=>$user_id,'type'=>2])->order('update_time desc')->limit(6)->select();
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
        $user_id = $this->auth->id;
        $id = input('id');
        $log = Search::where(['id'=>$id,'user_id'=>$user_id,'type'=>2])->find();
        $log->save(['status'=>2,'delete_time'=>time()]);
        $this->success('删除成功');
    }

    /**
     * 商品收藏
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function goods_favor()
    {
        $user_id = $this->auth->id;
        $id = input('id');
        $favor = GoodsFavor::where(['user_id'=>$user_id,'id'=>$id])->find();
        $data['status'] = isset($favor) && $favor['status'] == 1 ? 2 : 1;
        if(!$favor){
            $favor = new GoodsFavor();
            $data['create_time'] = time();$data['user_id'] = $user_id;$data['goods_id'] = $id;
        }
        $favor->save($data);
        $msg = $data['status'] == 1 ? "收藏成功" : "取消收藏成功";
        $this->success($msg);
    }

    /**
     * 批量取消收藏
     */
    public function cancel_favor()
    {
        $user_id = $this->auth->id;
        $ids = input('ids');
        GoodsFavor::where('id','in',$ids)->where('user_id',$user_id)->update(['status'=>2]);
        $this->success('操作成功');
    }
}
