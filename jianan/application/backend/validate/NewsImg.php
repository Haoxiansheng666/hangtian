<?php
namespace app\backend\validate;
use think\Validate;
class NewsImg extends Validate
{
    // 验证规则
    protected $rule = [
        ['name', 'require|unique:NewsImg', '图片名称不能为空|图片名称已经存在了'],
    ];
    
    
}