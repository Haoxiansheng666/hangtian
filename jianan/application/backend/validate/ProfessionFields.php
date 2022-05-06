<?php
namespace app\backend\validate;
use think\Validate;
class ProfessionFields extends Validate
{
    // 验证规则
    protected $rule = [
        ['title', 'require|unique:ProfessionFields', '报名资料不能为空|报名资料已经存在了'],
    ];
    
    
}