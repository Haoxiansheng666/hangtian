<?php
namespace app\backend\model;
use think\Model;
use think\Request;
use think\Db;
class Warehouse extends BaseModel
{
    // 类型转换
    protected $type = array(
        'create_time' => 'timestamp:Y-m-d H:i:s',
        'next_contact_time' => 'timestamp:Y-m-d',
        'end_time' => 'timestamp:Y-m-d'
    );
    //写入当前创建时间
    protected function setCreateTimeAttr()
    {
        return time();
    }
    
    //模型关联部门
    public function hasGroupone()
    {
        return $this->hasOne('AuthGroup','id','group_id')->field('group_name,rules');
    }
    //模型关联员工
    public function hasAuone()
    {
        return $this->hasOne('AdminUser','id','auid')->field('real_name');
    }
    //模型关联客户分类
    public function hasCateone()
    {
        return $this->hasOne('customer_cate','id','cate_id')->field('name');
    }
    //模型关联客户分类
    public function hasFromone()
    {
        return $this->hasOne('customer_from','id','from')->field('name');
    }
    /**
     * 客户数据
     * @access public 
     * @param array   $where 查询条件
     * @param string   $ord  排序
     * @param string   $perPage  每页大小
     * @since dxf 
     * @return [obj]
     */
    static public function stDate($where='1=1',$ord="status desc,ord desc,id desc",$perPage=15){
        $ress=Customer::where($where)->order($ord)->paginate($perPage);
        return $ress;
    }
    /**
     * 全部客户数据
     * @access public 
     * @param array   $where 查询条件
     * @param string   $ord  排序
     * @since dxf 
     * @return [obj]
     */
    static public function getAll($where='1=1',$ord="status desc,ord desc,id desc"){
        $ress=Customer::where($where)->order($ord)->select();
        return $ress;
    }
    /**
     * [get_list 获取列表数据]
     * @param  [type] $where  [条件值]
     * @param  [type] $order  [排序规则]
     * @param  [type] $offset [offset]
     * @param  [type] $limit  [limit]
     * @return [type]         [二维数组]
     */
    public function get_list($param,$where='1=1',$order="status desc,ord desc,id desc"){
        $offset=($param['page'] - 1) * $param['limit'];
        $rs = parent::get_list_base($this->tableName,$where,$order,$offset,$param['limit']);
        $count=$this->get_count_for_table($where);
        return ['list'=>$rs,'count'=>$count];
    }
    /**
     * [get_count_for_table 后台管理表单列表总数]
     * @param array $map [where条件合集]
     * @return [type]      [int]
     */
    public function get_count_for_table($map = [])
    {
        $rs = parent::get_count_for_table_base($map, $this->tableName);
        return $rs;
    }
    /**
     * [update_updata 更新数据]
     * @param  [type] $data [数据]
     * @return [type]       [bool]
     */
    public function update_data($data){
        $rs = parent::update_base($data, $this->tableName);
        return $rs;
    }



    public function get_join_list($param,$where=[]){
        $res =  $this
            ->with('admin,authGroup,cate')
            ->where($where)
            ->order('id DESC')
            ->paginate($param['limit']);
        return [
            'count' => $res->total(),
            'list' => $res->items()
        ];
    }

    public function admin(){
        return $this->hasOne('AdminUser','id','auid');
    }

    public function authGroup()
    {
        return $this->hasOne('AuthGroup','id','group_id');
    }

    public function cate(){
        return $this->hasOne('CustomerCate','id','cate_id');
    }

    /**
     * 数据导出
     * @access public 
     * @param array   $param 查询参数
     * @param array   $where  查询条件
     * @since dxf 
     * @return [array]
     */
    public function get_down_list($param,$where='1=1'){
        $tb1=$this->tableName1;
        $ress=Db::name($this->tableName)->alias('t')
            ->join("$tb1 t1",'t.cate_id=t1.id','LEFT')
            ->join("admin_user t3",'t.auid=t3.id','LEFT')
            ->join("auth_group t4",'t.group_id=t4.id','LEFT')
            ->field('t.*,t1.name as cate_name,t3.real_name,t4.group_name')
            ->where($where)
            ->order('t.status desc,t.ord desc,t.id desc')
            ->select();
        //数据赋值修改
        $from = ['1' => '个人','2' => '企业'];
        $rs['0']['id']='编号';
        $rs['0']['from_name']='客户分类';
        $rs['0']['cate_name']='客户分类';
        $rs['0']['name']='客户名称';
        $rs['0']['mobile']='手机号';
        $rs['0']['address']='地址';
        $rs['0']['create_time']='创建时间';
        $rs['0']['real_name']='创建人';
        foreach ($ress as $k => $v) {
            $k=$k+1;
            $rs[$k]['id']=$v['id'];
            $rs[$k]['from_name'] = $from[$v['from']];
            $rs[$k]['cate_name'] = empty($v['cate_name']) ? '普通客户' : $v['cate_name'];
            $rs[$k]['name']=$v['name'];
            $rs[$k]['mobile']=$v['mobile'];
            $rs[$k]['address']=$v['address'];
            $rs[$k]['create_time']=change_date($v['create_time'],1);
            $rs[$k]['real_name']=$v['real_name'].'('.$v['group_name'].')';
        }    
        return $rs;
    }
    /**
     * 首页数据的统计
     * @access public 
     * @param array   $where  查询条件
     * @since dxf 
     * @return [array]
     */
    public function get_count($where='1=1'){
        $tb1=$this->tableName1;
        $count=Db::name($this->tableName)->alias('t')
            ->join("$tb1 t1",'t.cate_id=t1.id','LEFT')
            ->field('count(t.id) as count,t1.name')
            ->where($where)
            ->order('t1.ord desc,t1.id desc')
            ->group('t.cate_id')
            ->select();
        return $count;
    }
    /**
     * 首页数据百分比统计
     * @access public 
     * @param array   $data 查询参数
     * @since dxf 
     * @return [array]
     */
    public function get_per($data){
        $ress['data']='';
        foreach ($data as $k => $v) {
            $ress['data'].="{value:$v[count],name:'$v[name]'},";
            
        }
        $ress['name']=join(',', array_map(function($v) {return "'$v'";}, array_column($data,'name')));
        
        return $ress;
    }
    /**
     * 按日期查询统计录入客户个数
     * @access public 
     * @param array   $param 查询参数
     * @since dxf 
     * @return [array]
     */
    public function get_range_day_count($param=''){
        $ress=array();
        if(!empty($param['start']) && !empty($param['end'])){
            $start=strtotime($param['start']);
            $end=strtotime($param['end']);
        }else{
            //默认最近30天数据 
            $start=time()-2592000;
            $end=mktime(0,0,0,date('m'),date('d')+1,date('Y'))-1;
        }
        $pstart=date('Y-m-d H:i',$start);
        $pend=date('Y-m-d H:i',$end);

        $param=['start'=>$pstart,'end'=>$pend];

        $sql="SELECT count(id) as ocount, date_format(FROM_UNIXTIME( `ctime`),'%m月%d日') odate  FROM `n_customer` where   `ctime`>$start and `ctime`<$end group by odate";
        $order_uday=Db::query($sql); //按月份分组的用户
        $ress1=array();
        foreach ($order_uday as $k => $v) {
            $ress1[$v['odate']]=$v;
            if(isset($ress1[$v['odate']]) && !empty($ress1[$v['odate']])){
                $ress1[$v['odate']]['oicount']=&$ress2[$v['odate']]['oicount'];    
            }else{
                $ress1[$v['odate']]['oicount']='0';
            }
        }
        $data['date']=join(',', array_map(function($v) {return "'$v'";}, array_column($ress1,'odate')));
        $data['count']=implode(',',array_column($ress1,'ocount'));
        return ['data'=>$data,'param'=>$param];
    }
    
     
}
 
