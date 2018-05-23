<?php
namespace app\common\model;
use think\Model;
class User extends Base
{
	public function add($data){
		$data['status'] = 1;
		return $this->data($data)->allowField(true)->save();
	}
	public function getUserByName($name){
		$user = $this->where(['username'=>$name])->find();
		if($user){
			$user =$user->toArray();
		}
		return $user;
	}
}