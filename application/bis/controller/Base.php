<?php
namespace app\bis\controller;
use think\Controller;
class Base extends  Controller
{
    public function _initialize() {
        // 判定用户是否登录
        $user = session('bisAccount', '', 'bis');
        if(!$user) {
            return $this->error('','login/index');
        }
    }
}
