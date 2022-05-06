<?php
namespace app\web\controller;
use think\Request;
use think\Controller;
use think\Db;
use think\Session;
class Common   extends Controller
{
    public $OK = 0;                 //正常
    public $paramMiss = 101;        //参数缺失
    public $paramEmpty = 102;       //有参数，但值为空
    public $paramIllegal = 103;     //参数内容不合法
    public $validError = 104;       //验证不通过
    public $exceptionData = 105;    //数据异常
    public $resEmpty = 201;         //结果集为空
    public $noMoreData = 202;       //无更多结果集
    public $requestError = 301;     //curl等请求失败
    public $SQLError = 501;         //SQL错误
    public $repeatError = 601;      //重复操作
    public $spillError = 602;       //超过最大限度
    public $failed = 701;           //操作失败
    public $privilegeError = 901;   //权限不足
    public $invalidToken = 1001;    //token验证失败
    public $unknowError = -1;       //未知错误
    public $dateNow;
    /**
     * [errCode 错误码调用方法]
     * @param  [type] $para [错误码名称]
     * @return [type]       [错误码编号]
     */
    public function errCode( $para ){
        return $this->$para;
    }

    public function _initialize(){
        parent::_initialize();
        $this->assign('config',tpCache());
    }
    public function writeLog($content){
        $ausess=$this->ausess();
        $data=array(
            'admin_id'=>$ausess['auid'],
            'content'=>$content,
            'created_t'=>time(),
            'ip'=>Request::instance()->ip()
        );
        Db::name('log')->insert($data);
    }
    //数据提交处理移除空格
    public function dataAction(){
        $ress='';
        $data=input('post.');
        foreach ($data as $k => $v) {
            $ress[$k]=trim($v);
        }
        return $ress;
    }
    //数据提交数据库处理
    protected function addAction($model){
        $data=$this->before_add($this->dataAction());
        if(empty($data['id'])){
            $ausess=$this->ausess();
            $data['auid']=$ausess['auid'];
            $data['group_id']=$ausess['group_id'];
            if($model->allowField(true)->validate(true)->save($data)) {
                $this->write_log($data);
                $this->after_add($this->dataAction());
                ajaxReturn($this->errCode('OK'), '信息提交成功');
            }else{
                ajaxReturn($this->errCode('SQLError'), $model->getError());
            }
        }else{
            if($model->allowField(true)->validate(true)->save($data,['id' =>$data['id']])){
                $this->write_log($data);
                $this->after_add($this->dataAction());
                ajaxReturn($this->errCode('OK'), '信息修改成功');
            }else{
                ajaxReturn($this->errCode('SQLError'), $model->getError());
            }
        }
    }
    
}
