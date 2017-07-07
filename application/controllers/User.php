<?php
	class User extends CI_Controller {
		//用户注册
		public function reg() {
			error_reporting(0);

			$data['title'] = "用户注册";
			//获取用户IP
			if(getenv('HTTP_CLIENT_IP')) {
			  $onlineip = getenv('HTTP_CLIENT_IP');
			} elseif(getenv('HTTP_X_FORWARDED_FOR')) {
			  $onlineip = getenv('HTTP_X_FORWARDED_FOR');
			} elseif(getenv('REMOTE_ADDR')) {
			  $onlineip = getenv('REMOTE_ADDR');
			} else {
			  $onlineip = $HTTP_SERVER_VARS['REMOTE_ADDR'];
			}
			$data['ip'] = $onlineip;
			

			//加载视图
			$this->load->view('user/header',$data);
			$this->load->view('user/menu');
			$this->load->view('user/reg',$data);
			$this->load->view('user/footer');
		}
		//发送邮箱验证码
		public function sendcode() {
			//加载邮箱辅助函数
			$this->load->helper('email');
			$mail = $this->input->post("mail");
			//判断邮箱是否正确
			if (!valid_email($mail))
			{
			    echo "500";
			    exit;
			}
			//获取COOKIE
			$this->load->helper('cookie');
			if(get_cookie('codetime')) {
                echo "501";
                exit;
            }
            $this->load->database();
			$sql = "SELECT * FROM `md_user` WHERE `mail` = '$mail'";
			$query = $this->db->query($sql);
			$this->db->close();
			if($query->row()) {
				echo '502';
				exit;
			}

			//生成验证码
			$this->load->helper('string');
			$mailcode = random_string('numeric', 6);
			//对验证码加密
			$code = md5($mailcode."himd");
			//邮箱配置
			$config['protocol'] = 'smtp';
			$config['smtp_host'] = '';
			$config['smtp_user'] = '';
			$config['smtp_pass'] = '';
			$config['smtp_port'] = '465';
			$config['smtp_timeout'] = '60';
			$config['smtp_crypto'] = 'ssl';
			$config['charset'] = 'utf-8';
			$config['wordwrap'] = TRUE;
			$config['mailtype'] = 'html';
			$config['crlf']="\r\n";   
			$config['newline']="\r\n";
			//加载类
			$this->load->library('email');
			//加载Mail辅助函数
			//$this->load->helper('smtpmail');
			$this->email->initialize($config);
			//发件人
			$this->email->from('service@bk.tn', 'Himd');
			$this->email->to($mail);
			$this->email->subject('欢迎注册');
			//邮件内容
			$content = "欢迎注册Himd，您的验证码为：<b style = 'color:green;'>$mailcode</b>，15分钟内有效。";
			
			$this->email->message($content);

			$this->email->send(FALSE);
			//设置cookie时间
			set_cookie('codetime','180',180);
			//验证码加密
			set_cookie('code',$code,900);
			echo '200';
		}
		//用户注册
		public function userreg() {
			error_reporting(0);
			//获取注册信息
			$ip= $this->input->post('ip');
			$redate = date('Y-m-d H:i:s',time());
			$data['user'] = $this->input->post('user');
			$data['user'] = str_replace(' ','',$data['user']);
			//转换为小写
			$user = strtolower($data['user']);
			$data['passwd'] = $this->input->post('passwd');
			$passwd = str_replace(' ','',$data['passwd']);
			$passwd = md5($passwd.'himd');
			$mail = $this->input->post('mail');
			$code = $this->input->post('mailcode');
			//先判断验证码
			$code = md5($code."himd");
			$this->load->helper('cookie');
			if($code != get_cookie('code')) {
				echo '验证码已过期！';
				exit;
			}
			//判断用户名
			//获取用户名长度
			$ulength = strlen($user);
			$plength = strlen($passwd);
			$preg = '{^[a-z0-9]*$}';
			if (($ulength < 4) || ($ulength > 16)) {
				echo '用户名格式不对！';
				exit;
			}
			//正则验证
			if(!preg_match($preg,$user)) {
				echo '用户不合法！';
				exit;
			}
			//判断密码
			if (($plength < 6) || ($ulength > 32)) {
				echo '密码长度不对!';
				exit;
			}
			$preg = '{^[a-zA-Z0-9]*$}';
			if(!preg_match($preg,$passwd)) {
				echo '密码格式不对！';
				exit;
			}
			//判断邮箱
			$this->load->helper('email');
			if (!valid_email($mail))
			{
			    echo "邮箱格式不对！";
			    exit;
			}
			$this->load->database();
			$sql = "SELECT * FROM `md_user` WHERE `mail` = '$mail'";
			$query = $this->db->query($sql);
			if($query->row()) {
				echo '该邮箱已注册！';
				exit;
			}
			$sql = "SELECT * FROM `md_user` WHERE `user` = '$user'";
			$query = $this->db->query($sql);
			if($query->row()) {
				echo '用户名已被使用！';
				exit;
			}
			//如果上面验证都通过
			
			$sql = "INSERT INTO `md_user`(`user`,`ip`, `mail`, `passwd`, `regdate`, `num`) VALUES ('$user','$ip','$mail','$passwd','$redate',20)";
			$this->db->query($sql);
			if($this->db->affected_rows()) {
				$this->db->close();
				echo '200';
				//创建用户目录
				$udir = getcwd().'/docs/'.$user;
				mkdir ($udir,0777,true);
				
				$this->load->helper('cookie');
				//设置cookie,保存7天
				set_cookie('mail',$mail,604800);
				$ukey = md5($mail.$passwd);
				set_cookie('ukey',$ukey,604800);

				exit;
			}
			else {
				echo '发生了预料之外的错误';
			}
		}
		//用户登录
		public function login() {
			$data['title'] = "登 录";

			//加载视图
			$this->load->view('user/header',$data);
			$this->load->view('user/menu');
			$this->load->view('user/login');
			$this->load->view('user/footer');
		}
		//接收登录
		public function relogin() {
			$this->load->helper('cookie');
			$mail = $this->input->post('mail');
			$passwd = $this->input->post('passwd');
			//过滤
			$passwd = str_replace(' ','',$passwd);

			//获取用密码长度
			
			$plength = strlen($passwd);
			//判断邮箱
			$this->load->helper('email');
			if (!valid_email($mail))
			{
			    echo "邮箱格式不对！";
			    exit;
			}
			$sql = "SELECT * FROM `md_user` WHERE `mail` = '$mail'";
			$this->load->database();
			$query = $this->db->query($sql);
			$row = $query->row();
			if(!$row) {
				echo "用户名或密码不对！";
				$this->db->close();
			    exit;
			}
			//判断密码
			if (($plength < 6) || ($plength > 32)) {
				echo '密码长度不对!';
				exit;
			}
			$preg = '{^[a-zA-Z0-9]*$}';
			if(!preg_match($preg,$passwd)) {
				echo '密码格式不对！';
				exit;
			}
			//密码进行加密
			$passwd = md5($passwd.'himd');
			if($passwd != $row->passwd) {
				echo '用户名或密码不对！';
				$this->db->close();
			    exit;
			}
			if($passwd == $row->passwd) {
				$this->db->close();
				//设置cookie,保存7天
				set_cookie('mail',$mail,604800);
				$ukey = md5($mail.$passwd);
				set_cookie('ukey',$ukey,604800);
				
				//获取主机名
	            echo '200';
			    exit;
			}
			
		}
	}
?>