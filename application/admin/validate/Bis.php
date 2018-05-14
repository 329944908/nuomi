<?php
namespace app\admin\validate;
use think\Validate;
class Bis extends Validate
{
	protected $rule = [
		['id','number'],
    	['status','number|in:-1,0,1','状态必须为数字|状态范围不合法'],
	];
	    //场景
    protected $scene = [
        'status'    => ['id','parent_id'],//更新状态
    ];
}