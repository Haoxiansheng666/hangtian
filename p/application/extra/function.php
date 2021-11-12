<?php

define('REG_PASSWORD', '/^[0-9A-Za-z]{6,20}$/');
define('POSITIVE_INTEGER', '/^[1-9]\d*$/');
define("REG_BANKCARD", '/^(\d{16}|\d{19})$/');
define('CHINESE_NAME', '/[\x80-\xff]{3,30}/');
define("REG_CARD", '/^(\d{6})(\d{4})(\d{2})(\d{2})(\d{3})([0-9]|X)$/');
define('REG_NUMBER', '/^(?![^a-zA-Z]+$)(?!\D+$).{6,12}$/');
define('REG_PHONE', '/^1[3|4|5|8|7|6|9][0-9]\d{8}$/');
define('REG_QQ', '/^[1-9][0-9]{4,9}$/');
define('REG_EMAIL', '/^[a-zA-Z0-9][a-zA-Z0-9._-]*\@[a-zA-Z0-9]+\.[a-zA-Z0-9\.]+$/A');
define('REG_NAME', '/^(?![0-9]+$)(?![a-zA-Z]+$)[0-9A-Za-z]{6,12}$/');
define('REG_NAME_CHAIN', '/^[\u4e00-\u9fa5]{4,10}|[0-9A-Za-z]{6,12}$/');
define('REG_PASSWORDS', '/^[\\~!@#$%^&*()-_=+|{}\[\],.?\/:;\'\"\d\w]{6,16}$/');
/* * 提示信息
 * @param $info
 * @param $status
 * @return array
 */
//判断价格或数量长度
    function lenth($pass) {
        if(is_int($pass)){
            $len = 0;
        }else{
            $y=explode(".",$pass);
            $len=strlen($y['1']);
        }
        return $len;
    }
/**
 * 创建TOKEN
 * @return string
 */
function createToken() {
    $code = chr(mt_rand(0xB0, 0xF7)) . chr(mt_rand(0xA1, 0xFE)) .
            chr(mt_rand(0xB0, 0xF7)) . chr(mt_rand(0xA1, 0xFE)) .
            chr(mt_rand(0xB0, 0xF7)) . chr(mt_rand(0xA1, 0xFE));
    $token = authCode($code);
    session('token', $token);
    return $token;
}
/**
 * 把jsonp转为php数组
 * @param string $jsonp jsonp字符串
 * @param boolean $assoc 当该参数为true时，将返回array而非object
 * @return array
 */
function jsonp_decode($jsonp, $assoc = true)
{
    $jsonp = trim($jsonp);
    if (isset($jsonp[0]) && $jsonp[0] !== '[' && $jsonp[0] !== '{') {
        $begin = strpos($jsonp, '(');
        if (false !== $begin) {
            $end = strrpos($jsonp, ')');
            if (false !== $end) {
                $jsonp = substr($jsonp, $begin + 1, $end - $begin - 1);
            }
        }
    }
    return json_decode($jsonp, $assoc);
}
/**
 * 加密TOKEN
 * @param $str
 * @return string
 */
function authCode($str) {
    $key = "andiamon";
    $str = substr(md5($str), 8, 10);
    return md5($key . $str);
}

/*
 * 验证手机号码是否正确
 * $phone 手机号
 */

function pregPhone($phone) {
    if (strlen($phone) == "11") {
        //上面部分判断长度是不是11位
        $n = preg_match_all("/^1[3456789]\d{9}$/", $phone, $array);
        if (!$n) {
            $r = msg_handle('手机号码格式不正确!!', 0);
        } else {
            $r = msg_handle('验证成功!!', 1, $array);
        }
    } else {
        $r = msg_handle('号码长度必须是11位', 0);
    }
    return $r;
}

function address_handling($bank) {
    $len = strlen($bank);
    if ($bank) {
        return substr($bank, 0, 4) . '*****' . substr($bank, $len - 4);
    }
}

/**
 * 邮箱检查
 * @param $password
 * @return int
 */
function reg_email($email) {
    return preg_match(REG_EMAIL, $email);
}

/**
 * 手机号码检查
 * @param $phone string 手机号码
 * @return int
 */
function reg_phone($phone) {
    return preg_match(REG_PHONE, $phone);
}

function msg_handle($msg, $code, $data = array()) {
    $r = array('msg' => $msg, 'code' => $code, 'data' => $data);
    return $r;
}

function phone_handling($phone) {
    return substr($phone, 0, 3) . '****' . substr($phone, 7);
}

function bank_handling($bank) {
    if ($bank) {
        return substr($bank, 0, 4) . '***********' . substr($bank, 15);
    }
}

/**
 * 省略时间
 * @param $time
 * @return false|string
 */
function omit_time($time) {
    if ($time) {
        return date("Y.m.d H:i:s", $time);
    } else {
        return '/';
    }
}

/**
 * 分页处理
 * @param $total int 总量
 * @param $num int 分页数量
 * @return int
 */
function page_num($total, $num) {
    if ($total % $num) {
        $page = intval($total / $num) + 1;
    } else {
        $page = intval($total / $num);
    }
    return $page;
}

/**
 * * 生成唯一的订单号 G20180328140950929538067
 * @param $type int
 * @return string
 */
function createOrderNum($type = 1) {
    $yCode = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z',);
    list($usec, $sec) = explode(" ", microtime());
    $usec = substr(str_replace('0.', '', $usec), 0, 4);
    $str = rand(10000, 99999);
    if ($type == 2) {
//        $a = $yCode[rand(0, 23)] . rand(1000000, 9999999);
        $a =  rand(1000000, 9999999);
        $len = strlen($a);
        if ($len < 8) {
            $str = str_pad($a, 8, 0, STR_PAD_RIGHT);
        } else {
            $str = $a;
        }
        return $str;
    } elseif ($type == 3) {
        return $yCode[rand(0, 15)] . $yCode[rand(0, 15)] . rand(100, 999) . $str;
    } elseif ($type == 4) {
        return $yCode[rand(0, 24)] . $yCode[rand(0, 15)] . $yCode[rand(0, 15)] . $yCode[rand(0, 15)] . $yCode[rand(0, 15)];
    } else {
        return $yCode[rand(0, 15)] . $usec . date("YmdHis") . $usec . $str;
    }
}

/**
 * 当日时间
 * @return false|int
 */
function day_time() {
    return strtotime(date('Ymd', time()));
}

/**
 * 获取创建策略时续费时间
 */
function get_renew_time() {
    if (date('w', day_time()) == 5) {
        $map['renew_time'] = day_time() + 86400 * 4;
    } else {
        $map['renew_time'] = day_time() + 2 * 86400;
    }
    return $map['renew_time'];
}

?>