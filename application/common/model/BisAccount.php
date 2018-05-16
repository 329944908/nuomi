<?php
namespace app\common\model;
use think\Model;
class BisAccount extends Base
{
	public function updateById($data,$id){
		return $this->save($data,['id'=>$id]);
	}
}