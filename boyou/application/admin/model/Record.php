<?php

namespace app\admin\model;

use think\Model;


class Record extends Model
{

    

    

    // 表名
    protected $name = 'record';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = false;
    protected $deleteTime = false;

    // 追加属性
    protected $append = [
        'status_text',
        'create_time_text',
        'is_change_text'
    ];
    

    
    public function getStatusList()
    {
        return ['1' => __('Status 1'), '2' => __('Status 2'), '3' => __('Status 3')];
    }

    public function getIsChangeList()
    {
        return ['1' => __('Is_change 1'), '2' => __('Is_change 2')];
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


    public function getIsChangeTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['is_change']) ? $data['is_change'] : '');
        $list = $this->getIsChangeList();
        return isset($list[$value]) ? $list[$value] : '';
    }

    protected function setCreateTimeAttr($value)
    {
        return $value === '' ? null : ($value && !is_numeric($value) ? strtotime($value) : $value);
    }


    public function user()
    {
        return $this->belongsTo('User', 'id', 'id', [], 'LEFT')->setEagerlyType(0);
    }
}
