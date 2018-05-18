<?php
namespace app\common\model;
use think\Model;
class Deal extends Base
{
	public function getNormalDeals($data = []){
		$data['status'] =1;
		$order = ['id'=>'desc'];
		$res = $this->where($data)->order($order)->paginate();
		return $res;
	}
}