<?php
namespace app\index\controller;
use think\Controller;
class Pay extends Base
{
    public function index() {
        if(!$this->getLoginUser()) {
            $this->error('请登录', 'user/login');
        }
        $orderId = input('get.id', 0, 'intval');
        if(empty($orderId)) {
            $this->error('请求不合法');
        }
        $order = model('Order')->get($orderId);
        if(empty($order) || $order->status != 1 || $order->pay_status !=0 ) {
            $this->error('无法进行该项操作');
        }
        // 严格判定 订单是否 是用户 本人
        $user = $this->getLoginUser();
        if($order->user_name != $user['username']) {
           $this->error('不是你的订单你瞎点个啥，做人要厚道');
        }
        $deal = model('Deal')->get($order->deal_id);
        return $this->fetch('', [
            'deal' => $deal,
            'order' => $order,
            'user' =>$user,
        ]);
    }
    public function paysuccess()
    {
        if(!$this->getLoginUser()) {
            $this->error('请登录', 'user/login');
        }
        return $this->fetch();    
    }

}
