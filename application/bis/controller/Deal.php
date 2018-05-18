<?php
namespace app\bis\controller;
use think\Controller;
use think\Session;
class Deal extends Base
{
	private $obj;
	public function _initialize(){
		$this->obj=model('Deal');
	}
	public function index(){
		$user = session('bisAccount', '', 'bis');
    	$bisId = $user['bis_id'];
    	$deals = $this->obj->where(array('bis_id'=>$bisId))->paginate(20);
		return $this->fetch('',['deals'=>$deals]);
	}
	public function add(){
		$user = session('bisAccount', '', 'bis');
    	$bisId = $user['bis_id'];
        if(request()->isPost()){
            $data = input('post.');
            $location = model('BisLocation')->get($data['location_ids'][0]);
            $deals = [
                'bis_id' => $bisId,
                'name' => $data['name'],
                'image' => $data['image'],
                'category_id' => $data['category_id'],
                'se_category_id' => empty($data['se_category_id']) ? '' : implode(',', $data['se_category_id']),
                'city_id' => $data['city_id'],
                'location_ids' => empty($data['location_ids']) ? '' : implode(',', $data['location_ids']),
                'start_time' => strtotime($data['start_time']),
                'end_time' => strtotime($data['end_time']),
                'total_count' => $data['total_count'],
                'origin_price' => $data['origin_price'],
                'current_price' => $data['current_price'],
                'coupons_begin_time' => strtotime($data['coupons_begin_time']),
                'coupons_end_time' => strtotime($data['coupons_end_time']),
                'notes' => $data['notes'],
                'description' => $data['description'],
                'bis_account_id' => $bisId,
                'xpoint' => $location->xpoint,
                'ypoint' => $location->ypoint,
            ];
            $id = $this->obj->add($deals);
            if($id) {
                $this->success('添加成功', url('deal/index'));
            }else {
                $this->error('添加失败');
            }
		}else{
			$citys = model('City')->getCitysByParentId();
			$categorys = model('Category')->getCategorys();
			$bislocations = model('BisLocation')->getNormalLocationByBisId($bisId);
			return $this->fetch('',['citys'=>$citys,'categorys'=>$categorys,'bislocations'=>$bislocations]);
		}
	}
	public function status(){
        $data = input('get.');
        $validate = validate('BisLocation');
        if(!$validate->scene('status')->check($data)){
            $this->error($validate->getError());
        }
        $res = $this->obj->save(['status'=>$data['status']],['id'=>$data['id']]);
        if($res){
            $this->success('更新成功');
        }else{
             $this->success('更新失败');
        }
    }
    public function detail(){
        $id = input('get.id');
        $citys = model('City')->getCitysByParentId();
        $categorys = model('Category')->getCategorys();
        $dealData = $this->obj->where(['id'=>$id])->find();
        return $this->fetch('',['dealData'=>$dealData,'citys'=>$citys,'categorys'=>$categorys,]);
    }
}