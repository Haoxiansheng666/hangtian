<?phpnamespace app\backend\model;use think\Model;use think\Request;use think\Db;class LabourUser extends BaseModel{    protected $autoWriteTimestamp = 'create_time';    protected $createTime = 'create_time';    protected $updateTime = false;    protected $append = [        'create_time_text',        'profession_name',        'status_text'    ];    public function status(){        return [           // '未审核',          1=>  '待就业',          2=>  '未面试',          3=>  '面试通过',          4=>  '已就业',          5=>  '面试拒绝',          //  '-1' => '审核拒绝'        ];    }    public function work_exp(){        return [            '无工作经验',            '1年以下',            '1-3年',            '3-5年',            '5-10年',            '10年以上',        ];    }    public function getStatusTextAttr($value,$data){        $status = $this->status();        return !empty($status[$data['status']]) ? $status[$data['status']] : '未知';    }    public function getProfessionNameAttr($value,$data){        $profession_id = !empty($data['profession_id']) ? $data['profession_id'] : '';        if (empty($profession_id)){            return '';        }        $profession = Profession::get($profession_id);        if (empty($profession)){            return '';        }        $profession_top = Profession::get($profession['pid']);        if (empty($profession_top)){            return '';        }        return $profession_top['name'] . '--' . $profession['name'];    }    public function getCreateTimeTextAttr($value,$data){        return !empty($data['create_time']) ? date('Y-m-d H:i:s',$data['create_time']) : '';    }    public function payStudent(){        return $this->hasOne('PayStudent','id','pay_student_id');    }    public function profession(){        return $this->hasOne('Profession','id','profession_id');    }    public function salesman(){        return $this->hasOne('AdminUser','id','salesman_id');    }    public function work(){        return $this->hasMany('LabourUserWork','labour_user_id','id');    }    public function recommend(){        return $this->hasMany('LabourUserRecommend','labour_user_id','id');    }} 