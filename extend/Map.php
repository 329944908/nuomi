<?php
/**
* 百度地图业务封装
*/
class Map
{
	/*
	根据地址获取经纬度
	 */
	public static function getLngLat($address){
		$data = [
			'address'=>$address,
			'ak'=>config('map.ak'),
			'output'=>'json',
		];
		$url = config('map.baidu_map_url').config('map.geocoder').'?'.http_build_query($data);
		$result = doCurl($url);
		return $result;
	}
	/*
	http://api.map.baidu.com/staticimage/v2
	根据经纬度或者地址来获取百度地图
	 */
	public static function staticimage($center){
		$data = [
			'ak'	=>config('map.ak'),
			'width' =>config('map.width'),
			'height' =>config('map.height'),
			'center' =>$center,
			'markers'=>$center,
		];
		$url = config('map.baidu_map_url').config('map.staticimage').'?'.http_build_query($data);
		$result = doCurl($url);
		return $result;
	}
}