<?php
function _res($status,$message = '',$data=[]){
	return [
		'status'	=> intval($status),
		'message'   => $message,
		'data'		=> $data,
	];
}