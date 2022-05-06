<?php
namespace app\backend\controller;
use app\backend\logic\WarehouseGoodsLogic;
use app\backend\model\AdminUser;
use app\backend\model\WarehouseGoodsLoad;
use app\backend\model\WarehouseGoodsLoss;
use app\backend\model\WarehouseGoodsScrap;
use think\Db;
use think\Exception;
use think\exception\DbException;
use think\Log;
use think\Request;
use app\backend\model\CustomerCate;
use app\backend\model\CustomerFrom;
use app\backend\model\WarehouseGoods as C;
class WarehouseGoods extends Common
{
    protected $id;
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $ware_list = \app\backend\model\Warehouse::all();
        $this->id = $this->request->param('id');
        $this->assign('ware_list',$ware_list);
    }

    /**
     * 客户列表数据的获取
     * @access public
     * @return void
     */
    public function getData(){
        $model=new C;
        $param=input('param.');
        $where=WarehouseGoodsLogic::selectParam($param,$this->ausess());
        $rs=$model->get_join_list($param,$where);
        layuiReturn($this->errCode('OK'), '获取成功', $rs['count'], $rs['list']);
    }

    /**
     * 客户添加和修改
     * @access public
     * @return mixed|void
     * @throws DbException
     */
    public function add(){
      if(var_export(Request::instance()->isAjax(), true)==='true'){
          $param = $this->request->param();
          $param['admin_id'] = $this->ausess()['auid'];
          // 增加库存并增加入库记录
          Db::startTrans();
          try {
              // 添加库存
              $goods = (new C)->where('name',$param['name'])->find();
              if (empty($goods)){
                  (new C())->allowField(true)->save($param);
                  $goods = C::get((new C)->getLastInsID());
                  $goods_num = 0;
              }else{
                  // 修改库存
                  $goods_num = $goods['num'];
                  $goods->setInc('num',$param['num']);
              }
            // 增加入库记录
            $load_data = array_merge($param,[
                'goods_type' => $goods['type'],
                'goods_id' => $goods['id'],
                'before_num' => $goods_num,
            ]);
              (new WarehouseGoodsLoad())->allowField(true)->save($load_data);
              Db::commit();
          }catch (Exception $exception){
              Db::rollback();
              Log::write('入库:'.json_encode($exception->getMessage()));
              $this->error('服务器错误');
          }
          $this->success('货品入库成功');
      }else{
          $param=input('param.');
          $catelist=CustomerCate::getAll(['status'=>1]);
          $fromlist=CustomerFrom::getAll(['status'=>1]);
          if(!empty($param['id'])){
              $ress= C::get($param['id']);
          }else{
              $ress=[
                  'cate_id'=>'',
                  'province'=>'110000',
                  'city'=>'110100',
                  'county'=>'110113',
                  'from'=>''
              ];
          }
          $data=['ress'=>$ress,'fromlist'=>$fromlist,'catelist'=>$catelist];
          $this->assign('data',$data);
          return  $this->fetch();
      }
    }

    /**
     * 申请出库
     * @return mixed
     * @throws DbException
     */
    public function apply_remove(){
        if ($this->request->isPost()){
            $param = $this->request->param();
            if (empty($param['num'])){
                $this->error('申请数量不能小于1');
            }
            $goods = C::get($param['id']);
            $loss_data = [
                'goods_id' => $goods['id'],
                'goods_type' => $goods['type'],
                'num' => $param['num'],
                'unit' => $goods['unit'],
                'price' => $goods['price'],
                'mark' => $param['mark'],
                'admin_id' => $this->ausess()['auid']
            ];
            (new WarehouseGoodsLoss())->allowField(true)->save($loss_data);
            $this->success('出库申请已提交');
        }
        $goods = C::get($this->id);
        $this->assign([
            'id' => $this->id,
            'goods' => $goods
        ]);
        return $this->fetch();
    }

    /**
     * 出库
     * @return mixed
     * @throws DbException|Exception
     */
    public function remove(){
        if ($this->request->isPost()){
            $param = $this->request->param();
            if (empty($param['num'])){
                $this->error('申请数量不能小于1');
            }
            $goods = C::get($param['id']);
            $loss_data = [
                'goods_id' => $goods['id'],
                'goods_type' => $goods['type'],
                'unit' => $goods['unit'],
                'price' => $goods['price'],
                'num' => $param['num'],
                'mark' => $param['mark'],
                'check_time' => time(),
                'status' => 1,
                'check_admin_id' => $this->ausess()['auid'],
                'admin_id' => !empty($param['admin_id']) ? $param['admin_id'] : $this->ausess()['auid']
            ];
            if ($goods['num'] < $loss_data['num']){
                $this->error('库存不够，请增加库存');
            }
            (new WarehouseGoodsLoss())->allowField(true)->save($loss_data);
            // 减少库存
            $goods->setDec('num',$loss_data['num']);
            $this->success('货品出库成功');
        }
        $goods = C::get($this->id);
        $admin_list = (new AdminUser())->select();
        $this->assign([
            'id' => $this->id,
            'goods' => $goods,
            'admin_list' => $admin_list
        ]);
        return $this->fetch();
    }

    /**
     * 报废
     * @return mixed
     * @throws DbException|Exception
     */
    public function scrap(){
        if ($this->request->isPost()){
            $param = $this->request->param();
            if (empty($param['num'])){
                $this->error('申请数量不能小于1');
            }
            $goods = C::get($param['id']);
            $loss_data = [
                'goods_id' => $goods['id'],
                'goods_type' => $goods['type'],
                'unit' => $goods['unit'],
                'price' => $goods['price'],
                'num' => $param['num'],
                'mark' => $param['mark'],
                'admin_id' => !empty($param['admin_id']) ? $param['admin_id'] : $this->ausess()['auid']
            ];
            if ($goods['num'] < $loss_data['num']){
                $this->error('库存不够，请增加库存');
            }
            (new WarehouseGoodsScrap())->allowField(true)->save($loss_data);
            // 减少库存
            $goods->setDec('num',$loss_data['num']);
            $this->success('货品报废操作成功');
        }
        $goods = C::get($this->id);
        $admin_list = (new AdminUser())->select();
        $this->assign([
            'id' => $this->id,
            'goods' => $goods,
            'admin_list' => $admin_list
        ]);
        return $this->fetch();
    }

    /**
     * 删除
     */
    public function delete(){
        //(new C())->where('id',$this->id)->delete();
        (new C())->where('id',$this->id)->update(['is_delete'=>0]);
        $this->success('删除成功');
    }

    /**
     * 增加库存
     * @return mixed|void
     * @throws DbException
     */
    public function stockpile(){
        if(var_export(Request::instance()->isAjax(), true)==='true'){
            $param = $this->request->param();
            $param['admin_id'] = $this->ausess()['auid'];
            // 增加库存并增加入库记录
            Db::startTrans();
            try {
                // 添加库存
                $goods = C::get($param['id']);
                if (empty($goods)){
                    (new C())->allowField(true)->save($param);
                    $goods = C::get((new C)->getLastInsID());
                    $goods_num = 0;
                }else{
                    // 修改库存
                    $goods_num = $goods['num'];
                    $goods->setInc('num',trim($param['num']));
                }
                // 增加入库记录
                $load_data = [
                    'goods_id' => $goods['id'],
                    'name' => $goods['name'],
                    'unit' => $goods['unit'],
                    'goods_type' => $goods['type'],
                    'num' => $param['num'],
                    'price' => $goods['price'],
                    'before_num' => $goods_num,
                    'mark' => $param['mark'],
                    'admin_id' => $param['admin_id']
                ];
                if (!empty($load_data['id'])){
                    unset($load_data['id']);
                }
                (new WarehouseGoodsLoad())->allowField(true)->save($load_data);
                Db::commit();
            }catch (Exception $exception){
                Db::rollback();
                Log::write('入库:'.json_encode($exception->getMessage()));
                $this->error('服务器错误');
            }
            $this->success('货品入库成功');
        }else{
            $goods = C::get($this->request->param('id'));
            if (empty($goods)){
                $this->error();
            }else{
                $this->assign('goods',$goods);
            }
            return  $this->fetch();
        }
    }

    /**
     * 仓库审核消息列表
     * 目前只有出库审核
     */
    public function loss_audit(){
        return $this->fetch();
    }

    /**
     * 仓库审核消息数据
     */
    public function getLossAuditData(){
        $where = [
            'status' => 0
        ];
        $param = $this->request->param();
        if (!empty($param['status'])){
            $where['status'] = $param['status'];
        }
        // 如果非仓库管理员
        $list = (new WarehouseGoodsLoss())
            ->with('goods,admin,checkAdmin')
            ->where($where)
            ->paginate($this->request->param('limit','15'));
        layuiReturn($this->errCode('OK'),'',$list->count(),$list->items());
    }

    /**
     * 出库审核-同意
     * @throws DbException
     */
    public function consent(){
        $loss = WarehouseGoodsLoss::get($this->id);
        $loss->check_time = time();
        $loss->status = 1;
        $loss->check_admin_id = $this->ausess()['auid'];
        $loss->save();
        $goods = C::get($loss['goods_id']);
        if($goods['num'] < $loss['num']){
            $this->error('库存不够');
        }
        $goods->setDec('num',$loss['num']);
        $this->success('出库申请已同意');
    }

    /**
     * 出库审核-拒绝
     * @throws DbException
     */
    public function refuse(){
        if ($this->request->isPost()){
            $loss = WarehouseGoodsLoss::get($this->id);
            $loss->check_time = time();
            $loss->status = 2;
            $loss->feedback = $this->request->param('feedback');
            $loss->check_admin_id = $this->ausess()['auid'];
            $loss->save();
            $this->success('出库申请已拒绝');
        }
        $this->assign([
            'id' => $this->id
        ]);
        return $this->fetch();
    }
}
