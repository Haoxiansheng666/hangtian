<?php
namespace app\backend\validate;
use think\Validate;
class AuthGroup extends Validate
{
    // 验证规则
    protected $rule = [
        ['group_name', 'require|unique:AuthGroup', '部门不能为空|部门已经存在'],
        ['rules', 'require', '操作权限不能为空！'],
        ['status', 'require', '状态不能为空！'],
    ];
    protected $scene = [
        'edit'  =>  ['rules','status'],
    ];
    
}