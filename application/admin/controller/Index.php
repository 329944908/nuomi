<?php
namespace app\admin\controller;
use think\Controller;
class Index extends Controller
{
    public function index()
    {
        return $this->fetch();
    }
    public function welcome(){
    	return "欢迎来到后台！";
    }
    // public function test(){
    // 	var_dump(\Map::getLngLat('山西太原清徐县孟封镇'));
    // }
    public function test(){
    	return \Map::staticimage('山西太原清徐县孟封镇');
    }
}
