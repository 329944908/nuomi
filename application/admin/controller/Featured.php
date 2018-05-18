<?php
namespace app\admin\controller;
use think\Controller;
class Featured extends Common
{
	private  $obj;
    public function _initialize() {
        $this->obj = model("Featured");
    }
    public function index() {
    	// 获取推荐位类别
        $types = config('featured.featured_type');
        $type = input('get.type', 0 ,'intval');
        $featureds = $this->obj->getFeaturedsByType($type);
        return $this->fetch('', [
            'types' => $types,
            'featureds' => $featureds,
        ]);
    }
    public function add(){
        if(request()->isPost()){
            $data = input('post.');
            $validate = validate('Featured');
            if(!$validate->scene('add')->check($data)) {
                $this->error($validate->getError());
            }
            $res = $this->obj->add($data);
            if($res) {
                $this->success('添加成功');
            }else{
                $this->error('添加失败');
            }
        }else{
            $types = config('featured.featured_type');
            return $this->fetch('',['types'=>$types]);
        }
    }
}