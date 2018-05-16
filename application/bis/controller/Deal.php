<?php
namespace app\bis\controller;
use think\Controller;
use think\Session;
class Deal extends Base
{
	public function index(){
		return $this->fetch();
	}
	public function add(){
		$citys = model('City')->getCitysByParentId();
		$categorys = model('Category')->getCategorys();
		return $this->fetch('',['citys'=>$citys,'categorys'=>$categorys]);
	}
}