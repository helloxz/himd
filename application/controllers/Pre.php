<?php
    class Pre extends CI_Controller {
        public function index() {
            error_reporting(0);
            $this->load->helper('cookie');
            $uid = get_cookie('user');
            //没有获取到uid
            
            //获取项目路径
            $apppath = $_SERVER['DOCUMENT_ROOT'];
            
            //$this->load->helper('parsedown');
            //为避免XSS，改用HyperDown解析
            $this->load->helper('parser');
            //$Parsedown = new Parsedown();
            $mdname = $uid;

            

            //文件路径
            $mdpath = $apppath."/tmp/".$mdname.".md";
            //获取文件大小
	        $mdsize = filesize($mdpath);

            //打开一个markdown文档
            $fpmd = fopen($mdpath,"r");
            //读取整个文档并赋值
            $content = fread($fpmd,$mdsize);
            //文件不存在
            if(!$fpmd) {
                //返回404状态
                header('HTTP/1.1 404 Not Found'); 
                header("status: 404 Not Found"); 
                //读取404页面
                show_404();
                echo $error404;
                exit;
            }
            //文件为空
            if($content == "") {
                $content = "<h3>空空如也</h3>";
            }
            //关闭fclose
            fclose($fpmd);

            
            //$data['content'] = $Parsedown->text($content);
            $parser = new HyperDown\Parser;
			$data['content'] = $parser->makeHtml($content);
			$data['content'] = str_replace("<em>_</em>","<hr>",$data['content']);
            
            

            $this->load->view('preview',$data);
        }
    }
?>