<?php
namespace app\common\model;
use think\Model;
class Category extends Model
{
	public function add($data){
		$data['status'] = 1;
		return $this->save($data);
	}
	/**
	 * @author Yanyuxuan
	 * @email    329944908@qq.com
	 * @DateTime 2018-05-10
	 * @return   [obj]           [一级分类]
	 */
	public function getNormalFirstCategory(){
		$where = [
			'parent_id' =>0,
			'status'    =>1,
		];
		$order = [
			'id' =>'desc'
		];
		return $this->where($where)->order($order)->select();
	}
	public function getCategorys($parent_id=0){
		$where = [
			'parent_id' =>$parent_id,
			'status'    =>['neq',-1],
		];
		$order = [
			'listorder'=>'desc',
			'id' =>'desc'
		];
		return $this->where($where)->order($order)->paginate();
	}
	public function getCategorysByParentId($parent_id=0){
		$where = [
			'parent_id' =>$parent_id,
			'status'    =>['neq',-1],
		];
		$order = [
			'id' =>'desc'
		];
		return $this->where($where)->order($order)->select();
	}
}