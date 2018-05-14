<?php
namespace app\api\controller;
use think\Controller;
class Category extends Controller
{
	private $obj;
	public function _initialize(){
		$this->obj=model('Category');
	}
	public function getCategorysByParentId(){
		$parent_id = input('post.id');
		if($parent_id){
			$categorys = $this->obj->getCategorysByParentId($parent_id);
			if($categorys){
				return _res(1,'success',$categorys);
			}else{
				return _res(0,'error');
			}
		}else{
			$this->error('参数不合法');
		}
	}
}