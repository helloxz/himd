<?php
    class Home extends CI_Controller {
        public function index() {
            error_reporting(0);
            //获取项目路径
            $apppath = $_SERVER['DOCUMENT_ROOT'];
            $current = date('YmdHi',time()).rand(1000,9999);
            //MD5加密
            $current = substr(md5($current),8,16);
            
            $this->load->helper('cookie');

            if(!(get_cookie('user'))) {
                set_cookie('user',$current,3600);
            }
            //set_cookie('user',$current,3600);
            

            $data['user'] = get_cookie('user');
            $mdpath = $apppath."/tmp/".$data['user'].".md";
            
            $data['mdcontent'] = file_get_contents($mdpath);

            if($data['mdcontent'] == '') {
                $data['mdcontent'] = file_get_contents($apppath."/tmp/welcom.md");
            }
            
            
            
            //$data['user'] = $_COOKIE['check'];
            $this->load->view('home',$data);
        }
        // 保存文件
        public function save() {
            //加载cookie辅助函数
            $this->load->helper('cookie');
            $mdname = get_cookie('user');
            //获取项目路径
            $apppath = $_SERVER['DOCUMENT_ROOT'];
            
            $content = $this->input->post('content');
            //防止XSS
            //$content = $this->security->xss_clean($content);
            $mdfile = fopen($apppath."/tmp/".$mdname.".md","w") or die ("权限不足！");
            fwrite($mdfile,$content);
            fclose($mdfile);

            echo '200';
        }
        //重写
        function rewrite() {
            error_reporting(0);
            $this->load->helper('cookie');
            $current = date('YmdHi',time()).rand(1000,9999);
            //MD5加密
            $current = substr(md5($current),8,16);
            //重新设置cookie
            set_cookie('user',$current,3600);
            //获取主机名
            $domain = $_SERVER['SERVER_NAME'];
            header("location:http://$domain");
            exit;
        }
    }
?>