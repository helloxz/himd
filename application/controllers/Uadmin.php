<?php
	class Uadmin extends CI_Controller {
		public function index() {
			
			$row = $this->chklogin();
			$data['title'] = '管理中心';
			$data['user'] = $row->user;

			//gravatar地址
			$data['mail'] = $row->mail;
			$mail = $data['mail'];
			$gaurl = md5( strtolower( trim( "$mail " ) ) );
			$data['gurl'] = "https://cn.gravatar.com/avatar/".$gaurl."?s=60";

			$sql = "SELECT * FROM `md_docs` WHERE `mail` = '$row->mail'";
			$query = $this->db->query($sql);
			$redata = $query->row();
			$data['cnum'] = $query->num_rows();
			$data['num'] = 20;
			$this->db->close();

			
			
			//加载视图
			$this->load->view('uadmin/header');
			$this->load->view('uadmin/menu',$data);
			$this->load->view('uadmin/leftmenu',$data);
			$this->load->view('uadmin/home',$data);
			$this->load->view('uadmin/footer');
			
		}
		//撰写文档
		public function write() {
			error_reporting(0);
			$row = $this->chklogin();
			$data['title'] = '撰写文档';
			$data['user'] = $row->user;
			$mail = $row->mail;

			//初始化session
			$this->load->library('session');
			$utime = date('Y-m-d H:i:s',time());
			//$current = substr(md5($current),8,16);
			$fileid = md5($mail.$utime);
			$fileid = substr($fileid,8,16);
			//设置session
			$this->session->set_userdata('fileid', $fileid);

			$data['fileid'] = $fileid;
			
			
			//加载视图
			$this->load->view('uadmin/header');
			$this->load->view('uadmin/menu',$data);
			$this->load->view('uadmin/leftmenu',$data);
			$this->load->view('uadmin/write',$data);
			$this->load->view('uadmin/footer');
		}
		//保存文档
		public function savedoc() {
			error_reporting(0);
			//初始化session
			$this->load->library('session');
			
			$row = $this->chklogin();
			//获取post数据
			$user = $row->user;
			$mail = $row->mail;
			
			//最后更新时间
			$utime = date('Y-m-d H:i:s',time());
			$fileid = $this->session->fileid;
			

			$title = $this->input->post('title');
			$content = $this->input->post('content');
			$choose = $this->input->post('choose');

			//对标题进行处理
			if($title == '') {
				$title = '草稿';
			}
			//XSS过滤
			$title = $this->security->xss_clean($title);

			//对用户的选择过滤一下
			//if(($choose != 0) || ($choose != 1)) {
			//	echo '类型不对！';
			//	exit;
			//}
			
			//保存文件路径
			$myfile = getcwd().'/docs/'.$user.'/'.$fileid.'.md';

			//查询下fileid是否存在
			$query = $this->db->query("SELECT * FROM `md_docs` WHERE `fileid`='$fileid'");
			$row = $query->row();
			

			//查询不存在，写入数据
			if(!$row) {
				$sql = "INSERT INTO `md_docs`(`user`, `mail`, `title`, `utime`, `fileid`, `status`) VALUES ('$user','$mail','$title','$utime','$fileid','$choose')";
				$this->db->query($sql);
				$num = $this->db->affected_rows();
				if($num == 1) {
					$mdfile = fopen($myfile,"w") or die ("权限不足！");
		            fwrite($mdfile,$content);
		            fclose($mdfile);
					echo '200';
					exit;
				}
			}
			//如果存在的话，那就更新数据
			//返回查询后的ID
			$id = $row->id;
			$sql = "UPDATE `md_docs` SET `id`='$id',`mail`='$mail',`title`='$title',`utime`='$utime',`fileid`='$fileid',`status`='$choose',`user`='$user' WHERE `id`=$id";
			$this->db->query($sql);
			$num = $this->db->affected_rows();
			
			if($num == 1) {
				$mdfile = fopen($myfile,"w") or die ("权限不足！");
	            fwrite($mdfile,$content);
	            fclose($mdfile);
				echo '201';
				exit;
			}
		}
		//临时预览
		public function tpre($fileid) {
			error_reporting(0);
			
			$fileid = $fileid;

			//如果fileid不存在，则使用session作为ID
			if((!isset($fileid)) || ($fileid == '')) {
				//初始化session
				$this->load->library('session');
				$fileid = $this->session->fileid;
				header("location:./tpre/$fileid");
			}
			//判断fileid
			if(strlen($fileid) != 16) {
				show_404();
				exit;
			}
			$row = $this->chklogin();
			$user = $row->user;
			
			$myfile = getcwd().'/docs/'.$user.'/'.$fileid.'.md';
			$content = file_get_contents($myfile);

			if(!$content) {
				show_404();
				exit;
			}
			
			$this->load->helper('parser');
			$parser = new HyperDown\Parser;
			$data['content'] = $parser->makeHtml($content);

			$data['content'] = str_replace("<em>_</em>","<hr>",$data['content']);
            $this->load->view('preview',$data);
			
		}
		//编辑文档
		public function edit() {
			error_reporting(0);
			$row = $this->chklogin();
			//获取用户
			$user = $row->user;

			$fileid = $this->input->get('fid');

			if(strlen($fileid) != 16) {
				echo 'ID不对';
				exit;
			}

			$sql = "SELECT * FROM `md_docs` WHERE `fileid` = '$fileid'";

			$query = $this->db->query($sql);
			$row = $query->row();
			$this->db->close();
			if($row != 1) {
				echo '文件不存在';
				exit;
			}
			//获取文章标题
			$data['dtitle'] = $row->title;

			$myfile = getcwd().'/docs/'.$user.'/'.$fileid.'.md';
			$data['content'] = file_get_contents($myfile);
			$data['fid'] = $fileid;
			

			//加载视图
			$this->load->view('uadmin/header');
			$this->load->view('uadmin/menu',$data);
			$this->load->view('uadmin/leftmenu',$data);
			$this->load->view('uadmin/edit',$data);
			$this->load->view('uadmin/footer');
			
		}
		//文档更新
		public function updoc() {
			error_reporting(0);
			
			$row = $this->chklogin();
			//获取文件ID
			$fileid = $this->input->get('fid');
			if(strlen($fileid) != 16) {
				echo 'ID错误';
				exit;
			}
			//获取post数据
			$user = $row->user;
			$mail = $row->mail;
			
			//最后更新时间
			$utime = date('Y-m-d H:i:s',time());
			
			

			$title = $this->input->post('title');
			$content = $this->input->post('content');
			$choose = $this->input->post('choose');

			//对标题进行处理
			if($title == '') {
				$title = '草稿';
			}
			//XSS过滤
			$title = $this->security->xss_clean($title);

			//对用户的选择过滤一下
			//if(($choose != 0) || ($choose != 1)) {
			//	echo '类型不对！';
			//	exit;
			//}
			
			//保存文件路径
			$myfile = getcwd().'/docs/'.$user.'/'.$fileid.'.md';

			//查询下fileid是否存在
			$query = $this->db->query("SELECT * FROM `md_docs` WHERE `fileid`='$fileid'");
			$row = $query->row();
			

			//如果存在的话，那就更新数据
			//返回查询后的ID
			$id = $row->id;
			$sql = "UPDATE `md_docs` SET `id`='$id',`mail`='$mail',`title`='$title',`utime`='$utime',`fileid`='$fileid',`status`='$choose',`user`='$user' WHERE `id`=$id";
			
			if($row == 1) {
				$this->db->query($sql);
				$num = $this->db->affected_rows();
				$mdfile = fopen($myfile,"w") or die ("权限不足！");
	            fwrite($mdfile,$content);
	            fclose($mdfile);
				echo '201';
				exit;
			}
		}
		//删除文档
		public function delete($fileid) {
			error_reporting(0);
			$row = $this->chklogin();
			$user = $row->user;
			$fileid = $fileid;
			//文件路径
			$myfile = getcwd().'/docs/'.$user.'/'.$fileid.'.md';
			
			
			
			if(strlen($fileid) != 16) {
				echo 'ID有误';
				exit;
			}
			
			$sql = "DELETE FROM `md_docs` WHERE `fileid` = '$fileid'";
			$query = $this->db->query($sql);
			$this->db->close();
			unlink($myfile);
			$upurl = $_SERVER['HTTP_REFERER'];
			header("location:$upurl");
			//加载视图
			
		}
		//我的文档
		public function mydocs() {
			error_reporting(0);
			$row = $this->chklogin();
			$data ['user'] = $row->user;
			$data['mail'] = $row->mail;
			$status = $this->input->get('status');
			if((strlen($status) != 1) || ($status == 'all')) {
				$sql = "SELECT * FROM `md_docs` WHERE `mail` = '$row->mail' ORDER BY `id` DESC";
			}
			if($status == 'public') {
				$sql = "SELECT * FROM `md_docs` WHERE `mail` = '$row->mail' AND `status` = 1 ORDER BY `id` DESC";
			}
			if($status == 'private') {
				$sql = "SELECT * FROM `md_docs` WHERE `mail` = '$row->mail' AND `status` = 0 ORDER BY `id` DESC";
			}
			
			$query = $this->db->query($sql);
			$data['result'] = $query->result_array();
			//print_r($data['result']);
			//加载视图
			$this->load->view('uadmin/header');
			$this->load->view('uadmin/menu',$data);
			$this->load->view('uadmin/leftmenu',$data);
			$this->load->view('uadmin/mydocs',$data);
			$this->load->view('uadmin/footer');
		}
		//验证cookie
		private function chklogin() {
			$this->load->helper('cookie');
			//加载cookie
			$mail = get_cookie('mail');
			$ukey = get_cookie('ukey');

			//获取主机名
   			$domain = $_SERVER['SERVER_NAME'];
   			//如果cookie不存在
			if((!isset($mail)) || (!isset($ukey))) {
				echo 'cookie不存在';
		        header("location:http://$domain/user/login");
		        exit;
			}
			//加载邮箱辅助函数
			$this->load->helper('email');
			if (!valid_email($mail))
			{
			    header("location:http://$domain/user/login");
			    exit;
			}
			
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
				return $row;
			}
			else {
				echo '预料之外的错误';
				exit;
			}
			
		}
		//登出按钮
		public function logout() {
			$this->load->helper('cookie');
			delete_cookie('mail');
			delete_cookie('ukey');
			$domain = $_SERVER['SERVER_NAME'];
            header("location:http://$domain/user/login");
		}
	}
?>