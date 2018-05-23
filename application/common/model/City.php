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
	public function getNormalCitys() {
        $data = [
            'status' => 1,
            'parent_id' => ['gt', 0],
        ];

        $order = ['id'=>'desc'];

        return $this->where($data)
            ->order($order)
            ->select();

    }
    public function getCitys($parent_id=0){
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
	public function add($data){
		$data['status'] = 1;
		return $this->save($data);
	}
}