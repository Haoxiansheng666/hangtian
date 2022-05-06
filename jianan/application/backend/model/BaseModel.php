<?php
namespace app\backend\model;

use think\Model;
use think\Db;

class BaseModel extends Model
{
	/**
	 * [get_list_base 获取列表数据]
	 * @param  [type] $tableName [表名]
	 * @param  [type] $where 	 [查询条件]
	 * @param  array  $order     [排序]
	 * @return [type]            [二维数组]
	 */
	 public function get_list_base($tableName,$where='1=1',$order=['id'=>'desc'],$offset='',$limit=''){
		$rs = Db::name($tableName)->where($where)->order($order)->limit($offset,$limit)->select();
		return $rs;
	}
	/**
	 * [get_count_for_table_base 为表单列表数据获取总数]
	 * @param  [type] $map       [where条件集合]
	 * @param  [type] $tableName [表名]
	 * @return [type]            [int]
	 */
	public function get_count_for_table_base($map,$tableName){
		if(empty($map)){
			$rs = Db::name($tableName)->count();
		}else{
			$rs = Db::name($tableName)->where($map)->count();
		}
		return $rs;
	}
	/**
	 * [update_base 根据id更新数据]
	 * @param  [type] $data      [更新数据包，必须包含id]
	 * @param  [type] $tableName [表名]
	 * @return [type]            [bool]
	 */
	public function update_base($data,$tableName){
		$rs = Db::name($tableName)->update($data);
		return $rs;
	}
	
}