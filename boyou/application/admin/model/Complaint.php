<?php

namespace app\admin\model;

use think\Model;


class Complaint extends Model
{

    

    

    // 表名
    protected $name = 'complaint';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = false;
    protected $deleteTime = false;

    // 追加属性
    protected $append = [
        'tou_time_text',
        'is_level_text',
        'check_time_text',
        'gai_time_text',
        'status_text',
        'create_time_text'
    ];
    

    
    public function getIsLevelList()
    {
        return ['0' => __('Is_level 0'), '1' => __('Is_level 1')];
    }

    public function getStatusList()
    {
        return ['0' => __('Status 0'), '1' => __('Status 1'), '2' => __('Status 2'), '3' => __('Status 3'), '4' => __('Status 4'), '5' => __('Status 5')];
    }


    public function getTouTimeTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['tou_time']) ? $data['tou_time'] : '');
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }


    public function getIsLevelTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['is_level']) ? $data['is_level'] : '');
        $list = $this->getIsLevelList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function getCheckTimeTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['check_time']) ? $data['check_time'] : '');
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }


    public function getGaiTimeTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['gai_time']) ? $data['gai_time'] : '');
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }


    public function getStatusTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['status']) ? $data['status'] : '');
        $list = $this->getStatusList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function getCreateTimeTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['create_time']) ? $data['create_time'] : '');
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }

    protected function setTouTimeAttr($value)
    {
        return $value === '' ? null : ($value && !is_numeric($value) ? strtotime($value) : $value);
    }

    protected function setCheckTimeAttr($value)
    {
        return $value === '' ? null : ($value && !is_numeric($value) ? strtotime($value) : $value);
    }

    protected function setGaiTimeAttr($value)
    {
        return $value === '' ? null : ($value && !is_numeric($value) ? strtotime($value) : $value);
    }

    protected function setCreateTimeAttr($value)
    {
        return $value === '' ? null : ($value && !is_numeric($value) ? strtotime($value) : $value);
    }


    public function company()
    {
        return $this->belongsTo('Company', 'company_id', 'id', [], 'LEFT')->setEagerlyType(0);
    }
}
