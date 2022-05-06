<?php
namespace app\backend\validate;
use think\Validate;
class AuthRule extends Validate
{
    // 验证规则
    protected $rule = [
        ['title', 'require', '名称不能为空'],
        ['name', 'require|unique:AuthRule', '路由不能为空|路由已经存在'],
        ['status', 'require', '状态不能为空！'],
    ];
    
}