<?phpnamespace app\backend\model;use think\Model;class OccuProfession extends BaseModel{    // 类型转换    protected $type = array(        'create_time' => 'timestamp:Y-m-d H:i:s'    );    //自动写入    protected $insert = array(       'create_time',    );    //自动更新    protected $update = array();    //写入当前创建时间    protected function setCreateTimeAttr()    {        return time();    }} 