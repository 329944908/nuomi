<?php
namespace app\admin\controller;
use think\Controller;
class Bis extends Common
{
	private $obj;
	public function _initialize(){
		$this->obj=model('Bis');
	}
	public function index(){
		$bises = $this->obj->where('status',1)->paginate();
		return $this->fetch('',['bises'=>$bises]);
	}
	public function apply(){
		$bises = $this->obj->where('status',0)->paginate();
		return $this->fetch('',['bises'=>$bises]);
	}
	public function status(){
        $data = input('get.');
        $validate = validate('Bis');
        if(!$validate->scene('status')->check($data)){
            $this->error($validate->getError());
        }
        $res1 = $this->obj->save(['status'=>$data['status']],['id'=>$data['id']]);
        $res2 = model('BisLocation')->save(['status'=>$data['status']],['bis_id'=>$data['id'],'is_main'=>1]);
        $res3 = model('BisAccount')->save(['status'=>$data['status']],['bis_id'=>$data['id'],'is_main'=>1]);
        if($res1&&$res2&&$res3){
        	 // 发送邮件
	        $url = request()->domain().url('bis/register/waiting', ['id'=>$data['id']]);
	        $title = "申请结果通知";
	        $bis = $this->obj->get($data['id']);
	        if($bis['status']==1){
	        	$content = "您提交的入驻申请平台方审核通过";
	        }elseif ($bis['status']==2) {
	        	$content = "您提交的入驻申请平台方审核不通过";
	        }
	        \phpmailer\Email::send($bis['email'],$title, $content);
            $this->success('更新成功');
        }else{
             $this->success('更新失败');
        }
    }
    public function detail(){
    	$id = input('get.id');
    	if(isset($id)&&!empty($id)){
    		$citys = model('City')->getCitysByParentId();
    		$categorys = model('Category')->getCategorys();
    		$bisData = $this->obj->get($id);
    		$locationData = model('BisLocation')->get(['bis_id'=>$id,'is_main'=>1]);
    		$accountData = model('BisAccount')->get(['bis_id'=>$id,'is_main'=>1]);
    		return $this->fetch('',['citys'=>$citys,'categorys'=>$categorys,'bisData'=>$bisData,'locationData'=>$locationData,'accountData'=>$accountData]);
    	}else{
    		return $this->error('参数错误');
    	}
    }
}