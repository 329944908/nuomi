<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
/**
 * @author Yanyuxuan
 * @email    329944908@qq.com
 * @DateTime 2018-05-10
 * @param    [int]           $status [状态 1正常 0待审 -1删除]
 * @return   [string]                   [返回样式]
 */
function status($status){
	if($status==1){
		$str = "<span class='label label-success radius'>正常</span>";
	}elseif($status==0){
		$str = "<span class='label label-danger radius'>待审</span>";
	}else{
		$str = "<span class='label label-danger radius'>删除</span>";
	}
	return $str;
}
/**
 * @author Yanyuxuan
 * @email    329944908@qq.com
 * @DateTime 2018-05-13
 * @param    str           $url  
 * @param    integer          $type 1 post 0 get
 * @param    array            $data [description]
 * @return   [type]                 [description]
 */
function doCurl($url,$type=0,$data=[]){
	$ch = curl_init();//初始化
	//设置选项
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_HEADER,0);
	if($type == 1){
		curl_setopt($ch, CURLOPT_POST,1);
		curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
	}
	//执行获取内容
	$output = curl_exec($ch);
	curl_close($ch);
	return $output;
}
/**
 * 通用分页样式
 */
function pagination($obj){
	if($obj){
		return '<div class="cl pd-5 bg-1 bk-gray mt-20 tp5-nuomi">'.
					$obj->render().
				'</div>';
	}else{
		return '';
	}
}
//分割字符串得到当前二级城市
function getSeCityName($path){
	if(!empty($path)){
		$citys = explode(',', $path);
		if(!empty($citys[1])){
			$city_id = $citys[1];
		}else{
			$city_id = $citys[0];
		}
		return model('City')->where('id',$city_id)->value('name');
	}
}
function getSeCategoryName($path){
	if(!empty($path)){
		$categorys = explode(',', $path);
		if(!empty($categorys[1])){
			$category_childs = $categorys[1];
			$category_childs_ids = explode('|', $category_childs);
			$str = '';
			foreach ($category_childs_ids as $value) {
				$name = model('Category')->where('id',$value)->value('name');
				$str=$str.'||'.$name;
			}
			return $str;
		}else{
			$category_id = $categorys[0];
			return model('Category')->where('id',$category_id)->value('name');
		}
	}
}
//根据Location_ids获取名字
function getLocationsName($path){
	if(!empty($path)){
		$locations = explode(',', $path);
		$str = '';
		foreach ($locations as $value) {
			$name = model('BisLocation')->where('id',$value)->value('name');
			$str=$str.'|-|'.$name;
		}
		return $str;
	}
}