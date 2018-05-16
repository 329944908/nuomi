<?php
namespace app\common\validate;
use think\Validate;
class BisLocation extends Validate
{
    protected $rule = [
        'id'   =>'require',
        'status'=>'require',
        'name' => 'require|max:25',
        'logo' => 'require',
        'tel' => 'require',
        'contact' => 'require',
        'category_id' => 'require',
        'city_id' => 'require',
        'open_time'=>'require',
        'content'=>'require',
        'xpoint'=>'require',
        'ypoint'=>'require',
    ];
    // 场景设置
    protected  $scene = [
        'add' => ['name','logo', 'category_id', 'city_id', 'open_time', ],
        'status'=> ['id','status' ],
    ];
}