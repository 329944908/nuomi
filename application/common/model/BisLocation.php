<?php
namespace app\common\model;
use think\Model;
class BisLocation extends Base
{
	public function getNormalLocationByBisId($bis_id){
		return $this->where(['bis_id'=>$bis_id,'status'=>1])->select();
	}
	public function getNormalLocationById($id){
		return $this->where(['id'=>$id,'status'=>1])->select();
	}
}