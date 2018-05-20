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
    	$deal = model('Deal')->where(['id'=>$id])->find();
    	$category = model('Category')->where(['id'=>$deal->category_id])->find();
    	$location_ids_arr = explode(',',$deal->location_ids);
    	foreach ($location_ids_arr as $key => $value) {
    		$locations[] = model('BisLocation')->where(['id'=>$value])->find();
    	}
    	if(!$deal||$deal->status!=1){
    		$this->error('该商品不存在',url('index/index'));
    	}
    	$flag = 0;
    	if($deal->start_time>time()){
    		$flag = 1;
	    	$dtime = $deal->start_time-time();
	    	$timedate = '';
	    	$d = floor($dtime/(3600*24));
	    	if($d){
	    		$timedate = $d.' 天 ';
	    	}
	    	$h = floor($dtime%(3600*24)/3600);
	    	if($h){
	    		$timedate .= $h.' 时 ';
	    	}
	    	$m = floor($dtime%(3600*24)%3600/60);
	    	if($m){
	    		$timedate .= $m.' 分 ';
	    	}
	    	$this->assign('timedate',$timedate);
    	}
    	return $this->fetch('',[
    							'deal'=>$deal,
    							'title'=>$deal->name,
    							'category'=>$category,
    							'locations'=>$locations,
    							'overplus' => $deal->total_count-$deal->buy_count,
           						'flag' => $flag,
                                'mapstr' => $locations[0]['xpoint'].','.$locations[0]['ypoint'],
    						]);
    }
}