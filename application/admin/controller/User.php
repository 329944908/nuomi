<?php
namespace app\admin\controller;
use think\Controller;
class User extends Common
{
	private $obj;
	public function _initialize(){
		$this->obj=model('User');
	}
	public function index(){
		$users = $this->obj->where(['status'=>['neq',-1]])->paginate();
		return $this->fetch('',['users'=>$users]);
	}
	public function show(){
		var_dump($_GET);
	}
	public function status() {
        // 获取值
        $data = input('get.');
        // 利用tp5 validate 去做严格检验  id  status
        if(empty($data['id'])) {
            $this->error('id不合法');
        }
        if(!is_numeric($data['status'])) {
            $this->error('status不合法');
        }
        // 获取控制器
        $model = request()->controller();
        $res = $this->obj->save(['status'=>$data['status']], ['id'=>$data['id']]);
    }
}