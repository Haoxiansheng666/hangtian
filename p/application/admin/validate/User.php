<?php

namespace app\admin\validate;

use think\Validate;

class User extends Validate
{
    /**
     * 验证规则
     */
    protected $rule = [
        'username'  =>  'require',
        'password' =>  'require',
        'accout'  =>  'require',
    ];

    /**
     * 提示消息
     */
    protected $message = [
        'username.require'  =>  '请输入用户名必须',
        'password.require' =>  '请输入密码',
        'accout.require' =>  '请输入账号',
    ];
    /**
     * 验证场景
     */
    protected $scene = [
        'add'   =>  ['username','password','accout'],
        'edit'  =>  [],
    ]; 
    
}
