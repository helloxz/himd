<?php
	//加载cookie
	$mail = get_cookie('mail');
	$ukey = get_cookie('ukey');

	//获取主机名
    $domain = $_SERVER['SERVER_NAME'];

	//如果cookie不存在
	if(!isset($mail)) {
		echo 'cookie不存在';
        //header("location:http://$domain/user/login");
        exit;
	}
	//加载邮箱辅助函数
	
	//加载数据库
	$this->load->database();
	$sql = "SELECT * FROM `md_user` WHERE `mail` = '$mail'";
	$query = $this->db->query($sql);
	$row = $query->row();
	$this->db->close();
	$passwd = $row->passwd;
	$passwd = md5($mail.$passwd);

	//判断cookie是否正确
	if($ukey == $passwd) {
		echo '对头';
		return true;
	}
?>