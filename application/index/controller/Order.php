<?php
namespace app\index\controller;
use think\Controller;
class Order extends Base
{
	public function confirm(){
		if(!$this->getLoginUser()){
			$this->error('请登录','user/login');
		}
		$id = input('get.id',0,'intval');
		if(!$id){
			$this->error('参数不合法');
		}
		$count = input('get.count',1,'intval');
		$deal = model('Deal')->find($id);
		if(!$deal||$deal->status!=1){
			$this->error('商品不存在');
		}
		$deal = $deal->toArray();
		return $this->fetch('',[
			'count'=>$count,
			'deal'=>$deal,
		]);
	}
	public function index(){
		$user = $this->getLoginUser();
		if(!$user){
			$this->error('请登录','user/login');
		}
		$id = input('get.id',0,'intval');
		if(!$id){
			$this->error('参数错误');
		}
		$deal = model('Deal')->find($id);
		if(!$deal||$deal->status!=1){
			$this->error('商品不存在');
		}
		$deal_count = input('get.deal_count',0,'intval');
		$total_price = input('get.total_price',0,'intval');
		if(empty($_SERVER['HTTP_REFERER'])){
			$this->error('请求不合法');
		}
		$out_trade_no = setOrderSn();
		$data = [
			'out_trade_no'	=>	$out_trade_no,
			'user_id'		=>	$user['id'],
			'user_name'		=>	$user['username'],
			'deal_id'		=>	$deal->id,
			'deal_count'	=>	$deal_count,
			'total_price'	=>	$total_price,
			'referer'		=>	$_SERVER['HTTP_REFERER'],
		];
		try{
			$orderId = model('Order')->add($data);
		}catch(\Exception $e){
			$this->error('订单处理异常');
		}
		$this->redirect(url('pay/index',['id'=>$id]));
	}
}