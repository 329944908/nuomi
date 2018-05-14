<?php
namespace app\api\controller;
use think\Controller;
class City extends Controller
{
	private $obj;
	public function _initialize(){
		$this->obj=model('City');
	}
	public function getCitysByParentId(){
		$parent_id = input('post.id');
		if($parent_id){
			$citys = $this->obj->getCitysByParentId($parent_id);
			if($citys){
				return _res(1,'success',$citys);
			}else{
				return _res(0,'error');
			}
		}else{
			$this->error('参数不合法');
		}
	}
}