<?php
namespace app\backend\model;
use think\Model;
class ProfessionFields extends BaseModel
{
    protected $tableName = 'profession_fields';
    protected $order = "status desc,ord desc,id desc";
}
 
