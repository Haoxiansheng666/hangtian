<?php
namespace app\backend\validate;
use think\Validate;
class News extends Validate
{
    // 验证规则
    protected $rule = [
        ['title', 'require|unique:News', '标题不能为空|标题已经存在了'],
        ['status', 'require', '状态不能为空！'],
    ];
    
    
}