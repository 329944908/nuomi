<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
/**
 * @author Yanyuxuan
 * @email    329944908@qq.com
 * @DateTime 2018-05-10
 * @param    [int]           $status [状态 1正常 0待审 -1删除]
 * @return   [string]                   [返回样式]
 */
function status($status){
	if($status==1){
		$str = "<span class='label label-success radius'>正常</span>";
	}elseif($status==0){
		$str = "<span class='label label-danger radius'>待审</span>";
	}else{
		$str = "<span class='label label-danger radius'>删除</span>";
	}
	return $str;
}