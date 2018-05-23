<?php
namespace app\index\controller;
use think\Controller;
class Walletpay extends Base
{
    public function index() {
        if(!request()->isPost()){
        	$this->error('请求错误');
        }
        $outTradeTo = input('post.out_trade_no');
        $pay_password = input('post.pay_password');
        $total_price = input('post.total_price');
        $user_id = input('post.user_id');
        $order = model('Order')->get(['out_trade_no' => $outTradeTo]);
        $user = model('User')->get(['id' => $user_id]);
        if(!$order || $order->pay_status == 1) {
            $this->error('订单不存在');
        }
        if($pay_password!=$user->pay_password){
        	$this->error('支付密码错误');
        }
        $new_total_price=intval($total_price*100);
        if($new_total_price>$user->wallet){
        	$this->error('余额不足');
        }
        //更新表 订单表  商品表
        $data = [
        	'pay_time'=>time(),
        	'pay_status'=>1,
        ];
        $new_wallet = $user->wallet-$new_total_price;
        $orderRes = model('Order')->updateOrderByOutTradeNo($outTradeTo, $data);
        $userRes = model('User')->where(['id'=>$user_id])->setField('wallet', $new_wallet); 
        $dealRes = model('Deal')->updateBuyCountById($order->deal_id, $order->deal_count);
        if($orderRes&&$userRes&&$dealRes){
            $coupons = [
                'sn' => $outTradeTo,
                'password' => rand(10000,99999),
                'user_id' => $order->user_id,
                'deal_id' => $order->deal_id,
                'order_id' => $order->id,
            ];
            $res = model('Coupons')->add($coupons);
            $title = '商品通知';
            $content='订单号：'.$outTradeTo.'密码：'.$coupons['password'];
            if($res){
                \phpmailer\Email::send($user['email'],$title, $content);
                $this->success('',url('pay/paysuccess'));  
            }
            $this->error('失败');
        }
    }
}
