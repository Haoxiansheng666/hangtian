<?php
namespace app\backend\validate;
use think\Validate;
class Profession extends Validate
{
    // 验证规则
    protected $rule = [
        ['name' , 'checkDiffName','此工种名称已存在']
    ];

    protected function checkDiffName($value,$rule,$data){
        $where = [
            'name' => $value,
            'pid' => 0
        ];
        if (!empty($data['id'])){
            $where['id'] = ['<>',$data['id']];
        }
        $is = (new \app\backend\model\Profession())
            ->where($where)
            ->find();
        return !empty($is) ? false : true ;
    }
    
}