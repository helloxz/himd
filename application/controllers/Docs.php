<?php
	class Docs extends CI_Controller{
		public function index($fid) {
			error_reporting(0);
			$fileid = $fid;
			if((!isset($fid)) || (strlen($fid) != 16)) {
				show_404();
				exit;
			}

			//初始化数据库
			$this->load->database();
			$sql = "SELECT * FROM `md_docs` WHERE `fileid` = '$fileid' AND `status` = 1";

			$query = $this->db->query($sql);
			$row = $query->row();
			$this->db->close();

			if($row != 1) {
				echo '没有阅读权限!';
				//$data['content'] = '没有阅读权限!';
			}
			
			$data['dtitle'] = $row->title;
			$data['utime'] = $row->utime;
			$data['user'] = $row->user;
			$user = $row->user;

			$myfile = getcwd().'/docs/'.$user.'/'.$fileid.'.md';
			$content = file_get_contents($myfile);

			$this->load->helper('parser');
			$parser = new HyperDown\Parser;
			$data['content'] = $parser->makeHtml($content);

			$this->load->view('docs',$data);
		}
	}
?>