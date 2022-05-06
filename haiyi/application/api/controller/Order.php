<?php

namespace app\api\controller;

use app\api\model\Address;
use app\api\model\OrderGoods;
use app\common\controller\Api;
use EasyWeChat\Kernel\Messages\Transfer;
use fast\Random;

/**
 * 订单接口
 */
class Order extends Api
{
    protected $noNeedLogin = ['*'];
    protected $noNeedRight = ['*'];

    /**
     * 订单列表
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function index()
    {
        //用户id
        $user_id = $this->auth->id;
        //接受参数
        $input = input();
        $status = isset($input['status']) && $input['status'] !== "" ? $input['status'] : "";
        $where['user_id'] = $user_id;
        if($status !== ""){
            $where['status'] = $status;
        }
        //分页信息
        $page = isset($input['page']) && !empty($input['page']) ? $input['page'] : 1;
        $pageSize = isset($input['pageSize']) && !empty($input['pageSize']) ? $input['pageSize'] : 1;
        //查询总数
        $total = \app\api\model\Order::where($where)->count();
        $list = \app\api\model\Order::where($where)->limit(($page - 1)*$pageSize,$pageSize)->order('id desc')->select();
        foreach ($list as $key=>$value){
            //支付时间
            $list[$key]['pay_time'] = date('Y-m-d H:i',$value['pay_time']);
            //提交时间
            $list[$key]['create_time'] = date('Y-m-d H:i',$value['create_time']);
            //取消时间
            $list[$key]['cancel_time'] = date('Y-m-d H:i',$value['cancel_time']);
            //发货时间
            $list[$key]['deliver_time'] = date('Y-m-d H:i',$value['deliver_time']);
            //确认收货时间
            $list[$key]['confirm_time'] = date('Y-m-d H:i',$value['confirm_time']);
        }
        //总页数
        $total_page = ceil($total/$pageSize);
        $this->success('获取成功',['total'=>$total,'list'=>$list,'pageSize'=>$pageSize,'current_page'=>$page,'total_page'=>$total_page]);
    }

    /**
     * 添加订单
     * @throws \think\exception\DbException
     */
    public function add_order()
    {
        //用户id 和 接受参数
        $user_id = $this->auth->id;
        $input = input();
        //订单编号  和 创建时间
        $input['order_sn'] = date('YmdHis').Random::alnum(6);
        $input['create_time'] = time();
        $order = new \app\api\model\Order();
        //把订单商品信息解析 并unset掉
        $goods = json_decode($input['goods'],true);unset($input['goods']);
        //添加订单  和 获取订单id
        $order->save($input);
        $order_id = $order->id;
        $data = [];$total_price = 0;$pay_money = 0;$freight = 0;
        //获取订单商品的添加参数
        foreach ($goods as $val){
            //商品信息
            $goods = \app\api\model\Goods::get($val['goods_id']);
            //订单商品信息
            $add = ['user_id'=>$user_id,'order_id'=>$order_id,'goods_id'=>$val['goods_id'],'sku'=>$val['sku'],'goods_name'=>$goods['name'],'price'=>$goods['price'],
                'number'=>$val['number'],'total_price'=>round($goods['price'] * $val['number'],2),'freight'=>10,'create_time'=>time()];
            //商品金额 和 订单支付金额
            $total_price += $add['total_price'];$pay_money += ($add['total_price'] + $add['freight']);$freight += $add['freight'];
            array_push($add);
        }
        //添加订单商品
        $order_goods = new OrderGoods();
        $order_goods->saveAll($data);
        //更改订单的商品金额  和  支付金额
        \app\api\model\Order::where('id',$order_id)->update(['total_price'=>$total_price,'pay_money'=>$pay_money]);
        $this->success('添加成功');
    }

    /**
     * 订单详情
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function detail()
    {
        //用户id  和  订单id
        $user_id = $this->auth->id;
        $id = input('id');
        //订单详情
        $order = \app\api\model\Order::where(['id'=>$id,'user_id'=>$user_id])->find();
        if($order){
            //订单商品
            $order_goods = OrderGoods::where(['order_id'=>$order['id']])->select();
            foreach ($order_goods as $key=>$item){
                $goods = \app\api\model\Goods::where(['id'=>$item['goods_id']])->field('id,name,image')->find();
                $goods['image'] = array_url(explode(';',$goods['image']));
                $order_goods[$key]['goods'] = $goods;
            }
            $order['order_goods'] = $order_goods;
        }
        //地址信息
        $order['address'] = Address::get($order['address_id']);
        $this->success('获取成功',$order);
    }

    /**
     * 订单删除
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function order_del()
    {
        //订单id
        $id = input('id');
        $user_id = $this->auth->id;
        //订单查询
        $order = \app\api\model\Order::where(['user_id'=>$user_id,'id'=>$id])->find();
        if(!$order){
            $this->error('无此订单');
        }
        //修改订单状态
        $order->save(['is_delete'=>2,'delete_time'=>time()]);
        $this->success('删除成功');
    }

    /**
     * 取消订单
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function cancel_order()
    {
        //订单id
        $id = input('id');
        $user_id = $this->auth->id;
        //订单查询
        $order = \app\api\model\Order::where(['user_id'=>$user_id,'id'=>$id])->find();
        if(!$order){
            $this->error('无此订单');
        }
        //修改订单状态
        $order->save(['status'=>4,'cancel_time'=>time()]);
        $this->success('删除成功');
    }

    /**
     * 确认收货
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function confirm_order()
    {
        //订单id
        $id = input('id');
        $user_id = $this->auth->id;
        //订单查询
        $order = \app\api\model\Order::where(['user_id'=>$user_id,'id'=>$id])->find();
        if(!$order){
            $this->error('无此订单');
        }
        //修改订单状态
        $order->save(['status'=>3,'confirm_time'=>time()]);
        $this->success('删除成功');
    }

    /**
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function address()
    {
        //用户信息
        $user_id = $this->auth->id;
        //接受参数
        $input = input();
        //分页信息
        $page = isset($input['page']) && !empty($input['page']) ? $input['page'] : 1;
        $pageSize = isset($input['pageSize']) && !empty($input['pageSize']) ? $input['pageSize'] : 10;
        //总数
        $total = Address::where(['user_id'=>$user_id,'status'=>1])->count();
        //分页查询
        $list = Address::where(['user_id'=>$user_id,'status'=>1])->limit(($page - 1)*$pageSize,$pageSize)->order('id desc')->select();
        //总页数
        $total_page = ceil($total/$pageSize);
        //返回数据
        $this->success('获取成功',['total'=>$total,'list'=>$list,'pageSize'=>$pageSize,'current_page'=>$page,'total_page'=>$total_page]);
    }

    /**
     * 地址详情
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function address_detail()
    {
        //用户信息
        $user_id = $this->auth->id;
        //地址id
        $id = input('id');
        //查找地址
        $address = Address::where(['id'=>$id,'user_id'=>$user_id])->find();
        if(!$address){
            $this->error('无此地址');
        }
        $this->success('获取成功',$address);
    }

    /**
     * 添加/编辑地址
     * @throws \think\exception\DbException
     */
    public function address_edit()
    {
        //用户id
        $user_id = $this->auth->id;
        $input = input();
        //地址id
        $id = isset($input['id']) && !empty($input['id']) ? $input['id'] : "";
        if($id){
            $address = Address::get($id);
            unset($input['id']);
        }else{
            $address = new Address();
            $input['create_time'] = time();
            $input['user_id'] = $user_id;
        }
        //编辑
        $address->save($input);
        $this->success('编辑成功');
    }

    /**
     * 删除地址
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function address_del()
    {
        //用户id  和  地址id
        $user_id = $this->auth->id;
        $id = input('id');
        //查找
        $address = Address::where(['user_id'=>$user_id,'id'=>$id])->find();
        if(!$address){
            $this->error('无此地址');
        }
        //删除操作
        Address::where(['user_id'=>$user_id,'id'=>$id])->delete();
        $this->success('删除成功');
    }

    /**
     * 支付
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function pay()
    {
        $input = input();
        $id = $input['id'];
        $user_id = $this->auth->id;
        $order = \app\api\model\Order::where(['id'=>$id,'user_id'=>$user_id])->find();
        if(!$order){
            $this->error('该订单不存在');
        }
        if($order['status'] != 0){
            $this->error('订单状态不对');
        }
        if($input['money'] != $order['pay_money']){
            $this->error('支付金额不正确');
        }
        $trade_type = isset($input['trade_type']) && !empty($input['trade_type']) ? $input['trade_type'] : 1;
        //支付宝
        if($trade_type == 1){

        }elseif ($trade_type == 2){  //微信

        }elseif ($trade_type == 3){  //银行卡

        }
        $this->success('支付成功');
    }
}
