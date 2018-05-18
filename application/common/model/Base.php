<?php
namespace app\common\model;
use think\Model;
class Base extends Model
{
	/**
	 * @author Yanyuxuan
	 * @email    329944908@qq.com
	 * @DateTime 2018-05-14
	 * @param    [array]           $data [description]
	 * @return 插入当亲数据的id 
	 */
	public function add($data){
		$data['status'] = 0;
		$this->save($data);
		return $this->id;
	}
	public function updateById($data, $id) {
        return $this->allowField(true)->save($data, ['id'=>$id]);
    }
}