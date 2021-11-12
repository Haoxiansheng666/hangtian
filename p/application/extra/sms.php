<?php

define('ACCESS_KEY', 'RYZItP7w1mIvbaiO');
define('SECRET', '8AwoUsexe7PSNzKcYVFahGh1M7pCJ7eY');

/**
 * 30667
 * 验证码
 * 点币网验证码
 * 您的验证码为{1}，请不要告诉他人，如非本人操作，请忽略
 * @param $code
 * @param $phone
 */
function msg_code($phone, $code) {
    $url = 'http://api.1cloudsp.com/api/v2/single_send';
    $data['accesskey'] = ACCESS_KEY;
    $data['secret'] = SECRET;
    $data['sign'] = '【点币网】';
    $data['templateId'] = '30667'; //A链注册验证码
    $data['mobile'] = $phone;
    $data['content'] = $code;
    return json_decode(postForm($url, $data), true);
}

/**
 * POST请求
 * @param $url
 * @param $data
 * @return mixed
 */
function postForm($url, $data) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}
