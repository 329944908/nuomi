<?php
namespace app\common\model;
use think\Model;
class Order extends Base
{
	public function add($data){
		$data['status'] = 1;
		return $this->save($data);
	}
}