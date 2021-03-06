<?php
namespace app\index\controller;
use think\Controller;
use think\Session;
use app\common\model\User as UserM;
class User extends Controller
{
    public function login()
    {
        // 获取session
        $user = session('user','', 'nuomi');
        //var_dump($user);die();
        if($user && $user['id']) {
           $this->redirect(url('index/index'));
        }
        return $this->fetch();
    }
    public function register()
    {
    	if(request()->isPost()){
    		$data = input('post.');
    		if(empty($data)){
    			$this->error();
    		}else{
    			$status = model('User')->getUserByName($data['username']);
    			if($status){
    				return $this->error('用户名已存在');
    			}
    			if($data['password']==$data['repassword']){
    				if(captcha_check($data['verifycode'])){
    					$data['code'] = mt_rand(100, 10000);
            			$data['password'] = md5($data['password'].$data['code']);
    					$res = model('User')->add($data);
    					if($res){
    						$this->success('注册成功',url('user/login'));
    					}else{
    						$this->error('注册失败');
    					}
    				}else{
    					$this->error('验证码错误');
    				}
    			}else{
    				$this->error('密码不一致');
    			}
    		}
    	}else{
    		return $this->fetch();
    	}
    }
    public function loginCheck() {
        if(!request()->isPost()) {
           $this->error('提交不合法');
        }
        $data = input('post.');
        try {
            $user = model('User')->getUserByName($data['username']);
        }catch (\Exception $e){
            $this->error($e->getMessage());
        }
        if(!$user || $user['status'] != 1) {
            $this->error('该用户不存在');
        }
        if(md5($data['password'].$user['code']) != $user['password']) {
            $this->error('密码不正确');
        }
        model('User')->updateById(['last_login_time'=>time(),'last_login_ip'=>$_SERVER['REMOTE_ADDR'],], $user['id']);
        session('user', $user, 'nuomi');
        $this->success('登录成功', url('index/index'));
    }
    public function logout() {
        session(null, 'nuomi');
        $this->redirect(url('user/login'));
    }

    public function a () {
        $userM = new UserM;
        $user = $userM->where(array('id'=>1))->find();
        $data = serialize($user);
        $new = unserialize($data);
        session('user', $data, 'nuomi');
        var_dump($new->username);die();
    }

    public function b() {
         $user = session('user','', 'nuomi');
         $user = unserialize($user);
         var_dump($user->username);
    }
}
