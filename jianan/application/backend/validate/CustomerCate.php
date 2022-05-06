<?php
namespace app\backend\validate;
use think\Validate;
class CustomerCate extends Validate
{
    // 验证规则
    protected $rule = [
        ['name', 'require|unique:CustomerCate', '等级名称不能为空|等级名称已经存在了'],
        ['status', 'require', '状态不能为空！'],
    ];
    
    
}