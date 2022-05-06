<?php

namespace app\api\controller;

use app\common\controller\Api;

/**
 *  购物车接口
 */
class Cart extends Api
{
    protected $noNeedLogin = ['*'];
    protected $noNeedRight = ['*'];

    /**
     * 购物车列表
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function index()
    {
        //用户信息
        $user_id = $this->auth->id;
        $input = input();
        //分页信息
        $page = isset($input['page']) && !empty($input['page']) ? $input['page'] : 1;
        $pageSize = isset($input['pageSize']) && !empty($input['pageSize']) ? $input['pageSize'] : 10;
        //总数 分页查询  总页数  未删除的
        $total = \app\api\model\Cart::where(['user_id'=>$user_id,'is_delete'=>2])->count();
        $list = \app\api\model\Cart::where(['user_id'=>$user_id,'is_delete'=>2])->limit(($page - 1)*$pageSize,$pageSize)->order('id desc')->select();
        $total_page = ceil($total/$pageSize);
        $this->success('获取成功',['list'=>$list,'total'=>$total,'total_page'=>$total_page,'pageSize'=>$pageSize,'current_page'=>$page]);
    }

    /**
     * 添加购物车
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function add_cart()
    {
        //用户信息
        $user_id = $this->auth->id;
        //接受参数
        $input = input();
        //查是否存在购物车
        $cart = \app\api\model\Cart::where(['goods_id'=>$input['goods_id'],'user_id'=>$user_id,'sku'=>$input['sku'],'is_delete'=>2])->find();
        //如果不存在 添加购物车
        if(!$cart){
            $cart = new \app\api\model\Cart();
            $cart->save(['user_id'=>$user_id,'num'=>$input['number'],'goods_id'=>$input['goods_id'],'sku'=>$input['sku'],'create_time'=>time()]);
        }
        //存在 增加数量
        \app\api\model\Cart::where('id',$cart['id'])->setInc('num',$input['number']);
        $this->success('加入购物车成功');
    }

    /**
     * 购物车删除
     */
    public function cart_del()
    {
        //用户信息
        $user_id = $this->auth->id;
        //接受要删除的参数
        $input = input();
        $id = $input['ids'];
        //删除购物车id中 属于你的购物车
        \app\api\model\Cart::where(['user_id'=>$user_id])->where('id','in',$id)->update(['is_delete'=>1,'delete_time'=>time()]);
        $this->success('删除成功');
    }
}
