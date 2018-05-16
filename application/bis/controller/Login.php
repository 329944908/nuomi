<?php
namespace app\bis\controller;
use think\Controller;
class Login extends Controller
{
	public function index(){
		return $this->fetch();
	}
	public function doLogin(){
		if(request()->isPost()){
			$data = input('post.');
			$res = model('BisAccount')->where(array('username'=>$data['username']))->find()->toArray();
			if(!$res){
				$this->error('用户不存在');
			}
			if($res['status']!=1){
				$this->error('用户审核未通过');
			}
			if($res['password'] == md5($data['password'].$res['code'])){
				unset($res['password']);
				$status = model('BisAccount')->updateById(['last_login_time'=>time(),'last_login_ip'=>$_SERVER["REMOTE_ADDR"]],$res['id']);
				if($status){
					session('bisAccount',$res,'bis');
					$this->success('登陆成功','index/index');	
				}

			}else{
				$this->error('密码错误');
			}
		}else{
			$account = session('bisAccount', '', 'bis');
            if($account && $account['id']) {
                return $this->redirect(url('index/index'));
            }
			return $this->fetch('login/index');
		}	
	}
	public function logout() {
        // 清除session
        session(null, 'bis');
        // 跳出
        $this->redirect('login/index');
    }
}