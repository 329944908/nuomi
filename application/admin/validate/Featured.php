<?php
namespace app\admin\validate;
use think\Validate;
class Featured extends Validate
{
	protected $rule = [
		['title','require'],
    	['image','require'],
    	['type','require'],
    	['url','require'],
    	['description','require'],
	];
	    //场景
    protected $scene = [
        'add'    => ['title','image','type','url','description'],//添加状态
    ];
}