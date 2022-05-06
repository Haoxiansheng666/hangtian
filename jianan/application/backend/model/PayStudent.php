<?php
namespace app\backend\model;
use think\Model;
use think\Request;
use think\Db;
class PayStudent extends BaseModel
{   
    protected $tableName = 'customer';
    protected $tableName1 = 'pay_student';
    protected $autoWriteTimestamp = true;
    protected $createTime = 'create_time';
    protected $updateTime = false;
    // 类型转换
    protected $type = array(
        'create_time' => 'timestamp:Y-m-d H:i:s',
        'action_train_time' => 'timestamp:Y-m-d',
//        'pay_time' => 'timestamp:Y-m-d',
        'recheck_time' => 'timestamp:Y-m-d',
        'end_time' => 'timestamp:Y-m-d'
    );
    //自动写入
    protected $insert = array(
       'create_time',
    );
    //自动更新
    protected $update = array(

    );
    protected $append = [
        'status_text',
        'ol_status_text',
        'offline_status_text',
        'ol_of_status_text',
        'from_text',
        'user_type_text',
        'pay_type_text',
        'pay_way_text',
        'pay_site_text',
        'proceeds_type_text',
        'recommend_job_text',
        'apply_type_text',
        'pay_end_time_text',
//        'pay_time_text',
        'pay_status_text',
        'create_time_text',
    ];
    public function getActionTrainTimeAttr($value){
        return !empty($value) ? date('Y-m-d',$value) : '';
    }
    public function getPayEndTimeTextAttr($value,$data){
        return !empty($data['pay_end_time']) ? date('Y-m-d',$data['pay_end_time']) : '';
    }
    public function getCreateTimeTextAttr($value,$data){
        return !empty($data['create_time']) ? date('Y-m-d',$data['create_time']) : '';
    }
    public function getPayStatusTextAttr($value,$data){
        $status = [
            '1' => '已结清',
            '2' => '未结清',
            '0' => '未缴费',
        ];
        return !empty($status[$data['pay_status']]) ? $status[$data['pay_status']] : '';
    }
    public function getUserTypeTextAttr($value,$data){
        $user_type = [
            '1' => '新办',
            '2' => '复审'
        ];
        return attrCheck($user_type,$value,$data,'user_type');
    }
    public function getApplyTypeTextAttr($value,$data){
        $apply_type = [
            '1' => '普通培训',
            '2' => '职业提升'
        ];
        return attrCheck($apply_type,$value,$data,'apply_type');
    }
    public function getFromTextAttr($value,$data){
        $from = [
            '1' => '个人',
            '2' => '企业'
        ];
        return attrCheck($from,$value,$data,'from');
    }
    public function getPayTypeTextAttr($value,$data){
        $pay_type = [
            '1' => '定金',
            '2' => '全款'
        ];
        return attrCheck($pay_type,$value,$data,'pay_type');
    }
    public function getPayWayTextAttr($value,$data){
        $pay_way = [
            '1' => '对公',
            '2' => '对私'
        ];
        return attrCheck($pay_way,$value,$data,'pay_way');
    }
    public function getPaySiteTextAttr($value,$data){
        $pay_site = [
            '1' => '线上',
            '2' => '线下'
        ];
        return attrCheck($pay_site,$value,$data,'pay_site');
    }
    public function getRecommendJobTextAttr($value,$data){
        $recommend_job = [
            '1' => '是',
            '0' => '否'
        ];
        return attrCheck($recommend_job,$value,$data,'recommend_job');
    }
    public function getProceedsTypeTextAttr($value,$data){
        $proceeds_type = [
            '1' => '支付宝',
            '2' => '微信',
            '3' => '银行卡转账',
            '4' => '现金'
        ];
        return attrCheck($proceeds_type,$value,$data,'proceeds_type');
    }
    public function getNextContactTimeAttr($value){
        return !empty($value) ? date('Y-m-d',$value) : '暂无跟进计划';
    }
    public function getEndTimeAttr($value){
        return !empty($value) ? date('Y-m-d',$value) : '暂无已完成跟进计划';
    }
//    public function getPayTimeTextAttr($value,$data){
//        return !empty($data['pay_time']) ? date('Y-m-d',$data['pay_time']) : '';
//    }

    // 状态列表
    public function statusList(){
        return [
            '-1' => '异常',
            '-2' => '考试未通过',
            '-3' => '审核未通过',
            '1' => '待审核',
            '2' => '已报名未培训',
            '3' => '正在培训中',
            '4' => '已培训未考试',
            '5' => '考试中',
            '6' => '已考试未出证',
            '7' => '已出证未领证',
            '8' => '已出证已领证',
            '11' => '待财务审核',
            '9' => '已退费',
        ];
    }

    public function gradeStatusList(){
        return [
            '1' => '培训完成',
            '2' => '待培训',
            '3' => '培训中',
            '0' => '不用培训',
        ];
    }

    public function getStatusTextAttr($value,$data){
        $status = $this->statusList();
        //工种 考试次数
        $profession = Profession::where('id',$data['profession_id'])->find();
        $count = ExamStudent::where('pay_student_id',$data['id'])->count();
        //return !empty($status[$data['status']]) ? $status[$data['status']] : '未知';
        return !empty($status[$data['status']]) ? ($data['status'] == -2 && $profession['cate_id'] == 1 && $count < 2 ? "待补考" : $status[$data['status']]) : '未知';
    }
    public function getOlStatusTextAttr($value,$data){
        $status = $this->gradeStatusList();
        return !empty($status[$data['ol_status']]) ? $status[$data['ol_status']] : '未知';
    }
    public function getOfflineStatusTextAttr($value,$data){
        $status = $this->gradeStatusList();
        return !empty($status[$data['offline_status']]) ? $status[$data['offline_status']] : '未知';
    }
    public function getOlOfStatusTextAttr($value,$data){
        $status = $this->gradeStatusList();
        return !empty($status[$data['ol_of_status']]) ? $status[$data['ol_of_status']] : '未知';
    }
    public function getActionTrainTimeTextAttr($value,$data){
        return !empty($data['action_train_time']) ? date('Y-m-d H:i:s',$data['action_train_time']) : '未进入培训阶段';
    }
    public function getExamTimeAttr($value,$data){
        return !empty($data['exam_time']) ? date('Y-m-d H:i:s',$data['exam_time']) : '未进入考试阶段';
    }
    //写入当前创建时间
    protected function setCtimeAttr()
    {
        return time();
    }
    protected function setUptimeAttr()
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

    /**
     * @param $param
     * @param array $where
     * @return array
     * @throws \think\exception\DbException
     */
    public function get_join_list($param,$where=[]){
        $res =  $this
            ->with('admin,authGroup,profession,professionTop')
            ->where($where)
            ->order('id DESC')
            ->paginate($param['limit'])
            ->each(function ($item){
                if (!empty($item['profession_top']['name'])){
                    $item['profession_name_text'] = $item['profession_top']['name'] . ' - - ' .$item['profession']['name'];
                }
                $item['exam_count'] = ExamStudent::where('pay_student_id',$item['id'])->count();
                $pay_price =  PayLog::where('pay_student_id',$item['id'])->value('pay_price');
                $item['pay_price'] = in_array($item['status'],[-1,-2,2,3,4,5,6,7,8]) ? $item['total_price'] : $pay_price;
//                $item['price'] = $pay_price - $item['total_price'];
                return $item;
            });
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
    public function profession(){
        return $this->hasOne('Profession','id','profession_id');
    }
    public function professionTop(){
        return $this->hasOne('Profession','id','profession_top_id');
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
    public function get_down_list($param,$where=[]){
        $ress=$this
            ->with('profession,admin')
            ->where($where)
            ->order('id desc')
            ->select();
        //数据赋值修改
        $rs['0']['id']='编号';
        $rs['0']['user_type']='客户类型';
        $rs['0']['apply_type']='报名类型';
        $rs['0']['name']='客户名称';
        $rs['0']['mobile']='手机号';
        $rs['0']['from']='客户分类';
        $rs['0']['profession_id']='工种';
        $rs['0']['recommend_job']='推荐就业';
        $rs['0']['pay_status']='缴费状态';
        $rs['0']['status']='状态';
        $rs['0']['pay_end_time']='支付结清时间';
        $rs['0']['create_time']='创建时间';
        $rs['0']['real_name']='业务员';
        foreach ($ress as $k => $v) {
            $k=$k+1;
            $rs[$k]['id']=$v['id'];
            $rs[$k]['user_type']= $v['user_type_text'];
            $rs[$k]['apply_type']=$v['apply_type_text'];
            $rs[$k]['name']=$v['name'];
            $rs[$k]['mobile']=$v['mobile'];
            $rs[$k]['from']=$v['from_text'];
            $rs[$k]['profession_id']=$v['profession']['name'];
            $rs[$k]['recommend_job']=$v['recommend_job_text'];
            $rs[$k]['pay_status']=$v['pay_status_text'];
            $rs[$k]['status']=$v['status_text'];
            $rs[$k]['pay_end_time']=$v['pay_end_time_text'];
            $rs[$k]['create_time']=$v['create_time_text'];
            $rs[$k]['real_name']=$v['admin']['real_name'];
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
 
