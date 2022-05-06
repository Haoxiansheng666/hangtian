<?php
namespace app\backend\validate;
use think\Validate;
class NewsCate extends Validate
{
    // 验证规则
    protected $rule = [
        ['name', 'require|unique:NewsCate', '分类名称不能为空|分类名称已经存在了'],
        ['status', 'require', '状态不能为空！'],
    ];
    
    
}