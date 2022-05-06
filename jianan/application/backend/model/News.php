<?php
namespace app\backend\model;
use think\Model;
use think\Request;
use think\Db;
class News extends BaseModel
{   
    protected $tableName = 'news';
    protected $tableName1 = 'news_cate';
    // 类型转换
    protected $type = array(
        'ctime' => 'timestamp:Y-m-d H:i:s',
        'uptime'=> 'timestamp:Y-m-d H:i:s',
    );
    //自动写入
    protected $insert = array(
       'ctime',
    );
    //自动更新
    protected $update = array(
       'uptime',
    );
    //写入当前创建时间
    protected function setCtimeAttr()
    {
        return time();
    }
    //更新时间
    protected function setUptimeAttr()
    {
        return time();
    }
    //写入数据判断，默认赋值
    protected function setauthorAttr($value)
    {
        if(empty($value)){
            return '三言';
        }else{
            return $value;
        }
    }
    // 内容（转html实体）
    public function setContentsAttr($value){
        return htmlspecialchars_decode($value);
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
    
    /**
     * 新闻数据
     * @access public 
     * @param array   $where 查询条件
     * @param string   $ord  排序
     * @param string   $perPage  每页大小
     * @since dxf 
     * @return [obj]
     */
    static public function stDate($where='1=1',$ord="status desc,ord desc,id desc",$perPage=15){
        $ress=News::where($where)->order($ord)->paginate($perPage);
        return $ress;
    }
    /**
     * 全部新闻数据
     * @access public 
     * @param array   $where 查询条件
     * @param string   $ord  排序
     * @since dxf 
     * @return [obj]
     */
    static public function getAll($where='1=1',$ord="status desc,ord desc,id desc"){
        $ress=News::where($where)->order($ord)->select();
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
     * 新闻数据
     * @access public 
     * @param array   $param 查询参数
     * @param array   $where  查询条件
     * @since dxf 
     * @return [array]
     */
    public function get_join_list($param,$where='1=1'){
        $offset=($param['page'] - 1) * $param['limit'];
        $tb1=$this->tableName1;
        $rs=Db::name($this->tableName)->alias('t')
            ->join("$tb1 t1",'t.cate_id=t1.id','LEFT')
            ->join("admin_user t2",'t.auid=t2.id','LEFT')
            ->field('t.*,t1.name,t2.real_name')
            ->where($where)
            ->order('t.status desc,t.ord desc,t.id desc')
            ->limit($offset,$param['limit'])
            ->select();
        //数据赋值修改
        $news_status=config('news_status');
        foreach ($rs as $k => $v) {
            $rs[$k]['ctime']=change_date($v['ctime'],2);
            $rs[$k]['status']=$news_status[$v['status']];
        }
        //总数
        $count =Db::name($this->tableName)->alias('t')
            ->join("$tb1 t1",'t.cate_id=t1.id','LEFT')
            ->field('t.*,t1.name')
            ->where($where)
            ->count();
        return ['list'=>$rs,'count'=>$count];
    }
    
     
}
 
