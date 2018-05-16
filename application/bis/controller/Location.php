<?php
namespace app\bis\controller;
use think\Controller;
use think\Session;
class Location extends Base
{
	private $obj;
	public function _initialize(){
		$this->obj=model('BisLocation');
	}
    public function index()
    {
    	$user = session('bisAccount', '', 'bis');
    	$bisId = $user['bis_id'];
    	$locations = $this->obj->where(array('bis_id'=>$bisId))->paginate(20);
		return $this->fetch('',['locations'=>$locations]);
    }
    public function add(){
    	if(request()->isPost()){
    		$data = input('post.');
    		$user = session('bisAccount', '', 'bis');
    		$bisId = $user['bis_id'];
    		$data['cat'] = '';
        	if(!empty($data['se_category_id'])) {
            $data['cat'] = implode('|', $data['se_category_id']);
        	}
        	$lnglat = \Map::getLngLat($data['address']);
        		if(empty($lnglat) || $lnglat['status'] !=0 || $lnglat['result']['precise'] !=1) {
            //$this->error('无法获取数据，或者匹配的地址不精确');
        	}
    		$locationData = [
	            'bis_id' => $bisId,
	            'name' => $data['name'],
	            'logo' => $data['logo'],
	            'tel' => $data['tel'],
	            'contact' => $data['contact'],
	            'category_id' => $data['category_id'],
	            'category_path' => $data['category_id'] . ',' . $data['cat'],
	            'city_id' => $data['city_id'],
	            'city_path' => empty($data['se_city_id']) ? $data['city_id'] : $data['city_id'].','.$data['se_city_id'],
	            'api_address' => $data['address'],
	            'open_time' => $data['open_time'],
	            'content' => empty($data['content']) ? '' : $data['content'],
	            'is_main' => 0,
	            'xpoint' => empty($lnglat['result']['location']['lng']) ? '' : $lnglat['result']['location']['lng'],
	            'ypoint' => empty($lnglat['result']['location']['lat']) ? '' : $lnglat['result']['location']['lat'],
        	];
        	$locationId = model('BisLocation')->add($locationData);
        	if($locationId){
        			$this->success('成功');
        	}else{
        			$this->error('失败');
        	}
    	}else{
    		$citys = model('City')->getCitysByParentId();
			$categorys = model('Category')->getCategorys();
			return $this->fetch('',['citys'=>$citys,'categorys'=>$categorys]);
    	}
    }
    public function detail(){
        $id = input('get.id');
        $citys = model('City')->getCitysByParentId();
        $categorys = model('Category')->getCategorys();
        $locationData = $this->obj->where(['id'=>$id])->find();
        return $this->fetch('',['locationData'=>$locationData,'citys'=>$citys,'categorys'=>$categorys]);
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
}
