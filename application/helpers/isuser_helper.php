<?php
	$current = date('YmdHi',time()).rand(1000,9999);
	//MD5加密
	$current = substr(md5($current),8,16);
	//不存在cookie
	if(!isset(get_cookie('user'))) {
		set_cookie('user',$current,3600);
	}
?>