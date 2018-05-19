<?php
namespace app\common\model;
use think\Model;
class Deal extends Base
{
	public function getNormalDeals($data = []){
		$data['status'] =1;
		$order = ['id'=>'desc'];
		$res = $this->where($data)->order($order)->paginate();
		return $res;
	}
	/**
	 * 根据分类 以及 城市来获取 商品数据
	 * @param $id 分类
	 * @param $cityId 城市
	 * @param int $limit 条数
	 */
	public function getNormalDealByCategoryCityId($id, $cityId, $limit=10) {
		$data  = [
			'end_time' => ['gt', time()],
			'category_id' => $id,
			'se_city_id' => $cityId,
			'status' => 1,
		];

		$order = [
			'listorder'=>'desc',
			'id'=>'desc',
		];

		$result = $this->where($data)
			->order($order);
		if($limit) {
			$result = $result->limit($limit);
		}
		return $result->select();
	}

}