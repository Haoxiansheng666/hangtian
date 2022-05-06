<?php
namespace app\backend\validate;
use think\Validate;
class ProfessionCate extends Validate
{
    // 验证规则
    protected $rule = [
        ['name', 'require|unique:ProfessionCate', '工种分类不能为空|工种分类已经存在了'],
    ];
    
    
}