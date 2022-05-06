<?php
namespace app\backend\validate;
use think\Validate;
class ProceedsType extends Validate
{
    // 验证规则
    protected $rule = [
        ['title', 'unique:proceeds_type'],
    ];
    
    
}