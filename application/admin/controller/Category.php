<?php
namespace app\admin\controller;
use think\Controller;
class Category extends Common
{
	private $obj;
	public function _initialize(){
		$this->obj=model('Category');
	}
    public function index()
    {
    	$parent_id = input('get.parent_id',0,'intval');
    	$categorys = $this->obj->getCategorys($parent_id);
        return $this->fetch('',['categorys'=>$categorys]);
    }
    public function add(){
    	$categorys = $this->obj->getNormalFirstCategory();
    	return $this->fetch('',['categorys'=>$categorys]);
    }
    public function save(){
    	if(!request()->isPost()){
    		$this->error('请求失败');
    	}
    	$data = input('post.');
    	$validate = validate('Category');
    	if(!$validate->scene('add')->check($data)){
    		$this->error($validate->getError());
    	}
    	if(isset($data['id'])&&!empty($data['id'])){
    		return $this->update($data);
    	}
    	$res =$this->obj->add($data);
    	if($res){
    		$this->success('成功');
    	}else{
    		$this->error('失败');
    	}
    }
    public function edit($id=0){
     	$category = $this->obj->get($id);
    	$categorys = $this->obj->getNormalFirstCategory();
    	return $this->fetch('',['categorys'=>$categorys,'category'=>$category]);
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
