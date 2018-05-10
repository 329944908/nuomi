<?php
namespace app\admin\validate;
use think\Validate;
class Category extends Validate
{
    protected $rule = [
    	['name','require|max:10','分类名不能为空|分类名太长'],
    	['parent_id','number'],
    	['parent_id','number'],
    	['id','number'],
    	['status','number|in:-1,0,1','状态必须为数字|状态范围不合法'],
    	['listorder','number'],
    ];
    //场景
    protected $scene = [
    	'add'       => ['name','parent_id','id'],//添加
    	'listorder' => ['id','parent_id'],//排序
        'status'    => ['id','parent_id'],//更新状态
    ];
}
