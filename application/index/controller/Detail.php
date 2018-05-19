<?php
namespace app\index\controller;
use think\Controller;
class Detail extends Base
{
    public function index($id)
    {
    	if(!intval($id)){
    		$this->error('',url('index/index'));
    	}
    	$category = model('Deal')->where()->find();
    	$deal = model('Deal')->where(['id'=>$id])->find();
    	if(!$deal||$deal->status!=1){
    		$this->error('该商品不存在',url('index/index'));
    	}
    	return $this->fetch('',['deal'=>$deal,'title'=>$deal->name]);
    }
}