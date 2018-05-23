<?php
namespace app\admin\controller;
use think\Controller;
class Order extends Common
{
	private $obj;
	public function _initialize(){
		$this->obj=model('Order');
	}
	public function index(){
		$orders = $this->obj->where('status',1)->paginate();
		return $this->fetch('',['orders'=>$orders]);
	}
}