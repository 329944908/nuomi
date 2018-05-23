<?php
namespace app\api\controller;
use think\Controller;
class Order extends Controller
{
    private  $obj;
    public function _initialize() {
        $this->obj = model("Order");
    }
    public function payStatus() {
        $id = input('post.id', 0, 'intval');
        if(!$id) {
            return _res(0, 'error');
        }
        //判定是否登录
        $order = $this->obj->get($id);

        if($order->pay_status == 1) { // 支付成功
            return _res(1, 'success');
        }
        return _res(0, 'error');
    }
}
