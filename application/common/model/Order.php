<?php
namespace app\common\model;
use think\Model;
class Order extends Base
{
	public function add($data){
		$data['status'] = 1;
		$this->save($data);
		return $this->id;
	}
	public function updateOrderByOutTradeNo($outTradeTo, $data) {
        return $this->allowField(true)
            ->save($data, ['out_trade_no' => $outTradeTo]);
    }
}