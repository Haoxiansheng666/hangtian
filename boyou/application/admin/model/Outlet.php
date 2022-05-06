<?php

namespace app\admin\model;

use think\Model;


class Outlet extends Model
{

    

    

    // 表名
    protected $name = 'outlet';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = false;
    protected $deleteTime = false;

    // 追加属性
    protected $append = [
        'is_open_text',
        'install_time_text',
        'create_time_text'
    ];
    

    
    public function getIsOpenList()
    {
        return ['1' => __('Is_open 1'), '0' => __('Is_open 0')];
    }


    public function getIsOpenTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['is_open']) ? $data['is_open'] : '');
        $list = $this->getIsOpenList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function getInstallTimeTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['install_time']) ? $data['install_time'] : '');
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }


    public function getCreateTimeTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['create_time']) ? $data['create_time'] : '');
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }

    protected function setInstallTimeAttr($value)
    {
        return $value === '' ? null : ($value && !is_numeric($value) ? strtotime($value) : $value);
    }

    protected function setCreateTimeAttr($value)
    {
        return $value === '' ? null : ($value && !is_numeric($value) ? strtotime($value) : $value);
    }


}
