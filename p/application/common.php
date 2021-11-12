<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------
error_reporting(E_ERROR | E_WARNING | E_PARSE);
// 应用公共文件
/**
 * 原样输出print_r的内容
 * @param string $content 待print_r的内容
 */
function pre($content)
{
    echo "<pre>";
    print_r($content);
    echo "</pre>";
}
function validation_filter_id_card($id_card){
    if(strlen($id_card)==18){
        return idcard_checksum18($id_card);
    }elseif((strlen($id_card)==15)){
        $id_card=idcard_15to18($id_card);
        return idcard_checksum18($id_card);
    }else{
        return false;
    }
}
// 计算身份证校验码，根据国家标准GB 11643-1999
function idcard_verify_number($idcard_base){
    if(strlen($idcard_base)!=17){
        return false;
    }
    //加权因子
    $factor=array(7,9,10,5,8,4,2,1,6,3,7,9,10,5,8,4,2);
    //校验码对应值
    $verify_number_list=array('1','0','X','9','8','7','6','5','4','3','2');
    $checksum=0;
    for($i=0;$i<strlen($idcard_base);$i++){
        $checksum += substr($idcard_base,$i,1) * $factor[$i];
    }
    $mod=$checksum % 11;
    $verify_number=$verify_number_list[$mod];
    return $verify_number;
}
// 将15位身份证升级到18位
function idcard_15to18($idcard){
    if(strlen($idcard)!=15){
        return false;
    }else{
        // 如果身份证顺序码是996 997 998 999，这些是为百岁以上老人的特殊编码
        if(array_search(substr($idcard,12,3),array('996','997','998','999')) !== false){
            $idcard=substr($idcard,0,6).'18'.substr($idcard,6,9);
        }else{
            $idcard=substr($idcard,0,6).'19'.substr($idcard,6,9);
        }
    }
    $idcard=$idcard.idcard_verify_number($idcard);
    return $idcard;
}
// 18位身份证校验码有效性检查
function idcard_checksum18($idcard){
    if(strlen($idcard)!=18){
        return false;
    }
    $idcard_base=substr($idcard,0,17);
    if(idcard_verify_number($idcard_base)!=strtoupper(substr($idcard,17,1))){
        return false;
    }else{
        return true;
    }
}
/**
 * 随机
 */
function generate_code($length = 4) {
    return rand(pow(10,($length-1)), pow(10,$length)-1);
}
/**
 * 加密密码
 * @param string $data 待加密字符串
 * @return string 返回加密后的字符串
 */
function encrypt($data)
{
    return md5(config('DATA_AUTH_KEY') . md5($data));
}

/**
 * 时间戳格式化
 * @param int $time
 * @return string 完整的时间显示
 * @author huajie <banhuajie@163.com>
 */
function time_format($time = NULL, $format = 'Y-m-d H:i')
{
    $time = $time === NULL ? NOW_TIME : intval($time);
    return date($format, $time);
}

/**
 * 检测是否为手机号
 */
function is_mobile($str)
{
    $pattern = "/^(13|14|15|17|18)\d{9}$/";
    if (preg_match($pattern, $str)) {
        return true;
    } else {
        return false;
    }
}

/**
 * 检测是否为邮箱
 */
function is_email($str)
{
    $pattern = '/^[a-z0-9][a-z\.0-9-_]+@[a-z0-9_-]+(?:\.[a-z]{0,3}\.[a-z]{0,2}|\.[a-z]{0,3}|\.[a-z]{0,2})$/i';
    if (preg_match($pattern, $str)) {
        return true;
    } else {
        return false;
    }
}

/**
 * 获取格式化的IP
 */
function get_format_ip()
{
    return get_client_ip(1);
}

/**
 * +----------------------------------------------------------
 * 功能：字符串截取指定长度
 * leo.li hengqin2008@qq.com
 * +----------------------------------------------------------
 * @param string $string 待截取的字符串
 * @param int $len 截取的长度
 * @param int $start 从第几个字符开始截取
 * @param boolean $suffix 是否在截取后的字符串后跟上省略号
 * +----------------------------------------------------------
 * @return string               返回截取后的字符串
 * +----------------------------------------------------------
 */
function cutStr($str, $len = 100, $start = 0, $suffix = 1)
{
    $str = strip_tags(trim(strip_tags($str)));
    $str = str_replace(array("\n", "\t", "/ /"), "", $str);
    if (strlen($str) < $len * 3) {//strlen统计字符长度 UFT-8占用三个字符
        return $str;
    } else {
        $strlen = mb_strlen($str);
        while ($strlen) {
            $array[] = mb_substr($str, 0, 1, "utf8");
            $str = mb_substr($str, 1, $strlen, "utf8");
            $strlen = mb_strlen($str);
        }
        $end = $len + $start;
        $str = '';

        for ($i = $start; $i < $end; $i++) {
            $str .= $array[$i];
        }
        return count($array) > $len ? ($suffix == 1 ? $str . "..." : $str) : $str;
    }
}

/**
 * 功能：获取唯一邀请码
 */
function generateOrderNumber()
{
    return date('Ymd') . substr(implode('', array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
}


/**
*获取当月之间时间戳
*/
function getthemonth()
{
    $today = date("Y-m-d");
    $firstday = date('Y-m-01', strtotime($today));
    $lastday = date('Y-m-d', strtotime("$firstday +1 month -1 day"));
    return array(strtotime($firstday),strtotime($lastday));
}
