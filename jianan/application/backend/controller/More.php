<?php
namespace app\backend\controller;
use think\Controller;
use think\Db;
use think\Config;
use think\Request;
use app\backend\model\Customer;
class More extends Common
{

	/** 
     * 二维码页面
     * @access public 
     * @since dxf 
     * @return [type]  页面
     */
    public function qrcode(){
        return  $this->fetch();
    }
    /** 
     * 二维码生成
     * @access public 
     * @since dxf 
     * @return [json]
     */
    public function get_qrcode(){
        Vendor('phpqrcode.phpqrcode');
        $level=8;//容错级别 
        $size=10;//生成图片大小
        $time=time();
        $outfile="uploads/qrcode/$time.png";
        ob_clean(); 
        $object = new \QRcode();
        $url='http://www.baidu.com';
        $object->png($url,"$outfile", $level, $size, 2);
        ajaxReturn($this->errCode('OK'), '生成成功！保存路径 /public/uploads/qrcode/');   
    }
    /** 
     * 带LOGO二维码生成
     * @access public 
     * @since dxf 
     * @return [json]
     */
    public function get_qrcode_logo(){
        Vendor('phpqrcode.phpqrcode');
        $logo = 'static/backend/other/logo.png';//准备好的logo图片
        $QR = 'static/backend/other/qr.png';//已经生成的原始二维码图
        if ($logo !== FALSE) {
            $QR = imagecreatefromstring(file_get_contents($QR));
            $logo = imagecreatefromstring(file_get_contents($logo));
            $QR_width = imagesx($QR);//二维码图片宽度
            $QR_height = imagesy($QR);//二维码图片高度
            $logo_width = imagesx($logo);//logo图片宽度
            $logo_height = imagesy($logo);//logo图片高度
            $logo_qr_width = $QR_width / 5;
            $scale = $logo_width/$logo_qr_width;
            $logo_qr_height = $logo_height/$scale;
            $from_width = ($QR_width - $logo_qr_width) / 2;
            //重新组合图片并调整大小
            imagecopyresampled($QR, $logo, $from_width, $from_width, 0, 0, $logo_qr_width,
            $logo_qr_height, $logo_width, $logo_height);
        }
        $time=time();
        //输出图片
        imagepng($QR, "uploads/qrcode/$time.png");
        ajaxReturn($this->errCode('OK'), '生成成功！保存路径 /public/uploads/qrcode/');   
    }
    /** 
     * 获取经纬度页面
     * @access public 
     * @since dxf 
     * @return [type] 页面
     */
    public function long(){
        return  $this->fetch();
    }
    /** 
     * 邮件发送
     * @access public 
     * @since dxf 
     * @return [type] 页面
     */
    public function email(){
        if(var_export(Request::instance()->isAjax(), true)==='true'){
            $data=$this->dataAction();
            $subject='邮件留言主题';
            $content='欢迎使用邮件留言，祝您生活工作愉快！';
            $rr=send_email($data['email'],$subject,$content);
            if($rr['status']==0){
                ajaxReturn($this->errCode('OK'), $data['email']);
            }else{
                ajaxReturn($this->errCode('SQLError'), $rr['msg']);
            }
        }else{
            return  $this->fetch();
        }
        
    }
    /** 
     * 短信发送
     * @access public 
     * @since dxf 
     * @return [type] 页面
     */
    public function message(){
        if(var_export(Request::instance()->isAjax(), true)==='true'){
            ajaxReturn($this->errCode('SQLError'), '数据未更新！');
        }else{
            return  $this->fetch();
        }
    }
    /** 
     * 快递
     * @access public 
     * @since dxf 
     * @return [type] 页面
     */
    public function express(){
        $param=input('param.'); 
        if(!empty($param['sn'])){
            import('Kuaidiniao', EXTEND_PATH);
            $config=tpCache();
            if(!preg_match("/^\d*$/",$param['sn']))  {
                $this->error('快递单号不正确！');
            } 
            $obj = new  \Kuaidiniao($config['22'],$config['23']);
            $ress=$obj->getOrderTracesByJson('ZTO',"$param[sn]");
            $rtt=json_decode($ress,true);
            $this->assign('ress',$rtt);
            $this->assign('param',$param);
            return  $this->fetch();
        }else{
            return  $this->fetch();
        }
    }
    /** 
     * 统计图例子
     * @access public 
     * @since dxf 
     * @return [type] 页面
     */
    public function count()
    {      
        $c=new Customer;
        $param=input('param.');
        $day_count=$c->get_range_day_count($param);
        $data=[
            'day_count'=>$day_count,
        ];
        $this->assign('data',$data);
        return $this->fetch();
    }


}