<?php
namespace app\admin\controller;
use think\Controller;
class City extends Common
{
	private $obj;
	public function _initialize(){
		$this->obj=model('City');
	}
    public function index()
    {
    	$parent_id = input('get.parent_id',0,'intval');
    	$citys = $this->obj->getCitys($parent_id);
        return $this->fetch('',['citys'=>$citys]);
    }
    public function add(){
    	$citys = $this->obj->getCitysByParentId();
    	return $this->fetch('',['citys'=>$citys]);
    }
    public function save(){
    	if(!request()->isPost()){
    		$this->error('请求失败');
    	}
    	$data = input('post.');
    	// $validate = validate('Category');
    	// if(!$validate->scene('add')->check($data)){
    	// 	$this->error($validate->getError());
    	// }
    	// if(isset($data['id'])&&!empty($data['id'])){
    	// 	return $this->update($data);
    	// }
    	$res =$this->obj->add($data);
    	if($res){
    		$this->success('成功');
    	}else{
    		$this->error('失败');
    	}
    }
    public function edit($id=0){
     	$city = $this->obj->get($id);
    	$citys = $this->obj->getCitysByParentId();
    	return $this->fetch('',['citys'=>$citys,'city'=>$city]);
    }
    public function update($data){
    	$res =$this->obj->save($data,['id'=>$data['id']]);
    	if($res){
    		$this->success('更新成功');
    	}else{
    		$this->error('更新失败');
    	}
    }
}
