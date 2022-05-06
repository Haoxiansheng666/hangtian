<?php
namespace app\backend\validate;
use think\Validate;
class WarehouseGoods extends Validate
{
    // 验证规则
    protected $rule = [
        ['name', 'require', '客户名称不能为空'],
        'mobile|客户手机号' => 'unique:customer'
    ];
    
    
}