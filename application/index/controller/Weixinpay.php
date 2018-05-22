<?php
namespace app\index\controller;
use think\Controller;
class Weixinpay extends Base
{
	public function notify(){
		$data = file_get_contents("php://input");
		file_put_contents('/var/tmp/1.txt',$data,FILE_APPEND);
	}
}