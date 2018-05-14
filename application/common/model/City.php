<?php
namespace app\common\model;

use think\Model;

class City extends Model
{
	public function getCitysByParentId($parent_id=0){
		$where = [
			'parent_id' =>$parent_id,
			'status'    =>1,
		];
		$order = [
			'id' =>'desc'
		];
		return $this->where($where)->order($order)->select();
	} 
}