<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta charset="utf-8" />
	<title><?php echo $dtitle; ?> - 在线Markdown编辑器</title>
	<meta name="generator" content="EverEdit" />
	<meta name="author" content="" />
	<meta name="keywords" content="" />
	<meta name="description" content="" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://libs.xiaoz.top/highlight.js/9.8.0/styles/github.css">
	<link href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
	<script src = "https://libs.xiaoz.top/highlight.js/9.8.0/highlight.pack.js"></script>
	<script src = "https://libs.xiaoz.top/jquery/2.0.3/jquery-2.0.3.min.js"></script>
	<style type = "text/css">
		body {
			font-family:"Microsoft YaHei";
		}
				/*导航菜单*/
		#menu {
			width:100%;
			background-color: #DDD;
			border-bottom:1px solid #C7C7C7;
		}

		#menu h1{
			font-size:28px;
		}
		#menu a{
			text-decoration:none;
		}
		.menu-right {
			text-align:right;
		}
		/*h1, .h1, h2, .h2, h3, .h3 {
		    margin-bottom: 22px;
		    margin-top: 22px;
		}*/
		img {display:block;}
		/*li {
			padding-bottom:5px;
		}*/
		blockquote p {
			font-size:16px;
		}
		
		/*页脚*/
		#footer {
			width:100%;
			background-color: #E7E7E7;
			border-top:1px solid #C7C7C7;
			font-size:13px;
			margin-top:60px;
			line-height:3em;
			text-align:center;
			border-bottom:1px solid #C7C7C7;
		}
		li pre {
		    margin-top: 8px;
		}  
		ul pre {
		    margin-left: -40px;
		}
		.htmlcontent p{
			line-height:1.6em;
		}
		.h1, h1 {
		    font-size: 26px;
		}
	</style>
	<script>hljs.initHighlightingOnLoad();</script>
</head>
<body>
	<!--导航菜单-->
	<div id="menu">
		<div class="container">
			<div class="row">
				<div class="col-lg-8">
					<h1><a href="../../">Himd</a><small> - Markdown在线编辑器</small></h1>
				</div>
				<!--<div class="col-lg-4 menu-right">
					<div style = "margin-top:28px;">
						<a href="">登 录</a> | 
						<a href="">注 册</a>
					</div>
				</div>-->
			</div>
		</div>
	</div>
	<!--导航菜单END-->
	<div class="container">
		<div class="row">
			<div class="col-lg-8 col-md-offset-2">
				<div><h1><?php echo $dtitle; ?></h1></div>
				<p>
				<span class = "glyphicon glyphicon-user"></span> By <?php echo $user; ?> &nbsp;&nbsp;&nbsp;&nbsp; <span class = "glyphicon glyphicon-time"></span> 最后更新：
				<?php
					$utime = explode(' ',$utime);
					echo $utime[0];
				?>
				</p><hr>
				<div class = "htmlcontent"><?php echo $content; ?></div>
			</div>
		</div>
	</div>
	<!--页脚-->
	<div id="footer">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">Copyright © 2016 - 2017 | Powered by <a href="https://github.com/helloxz/himd" target = "_blank" rel = "nofollow">Himd</a>
				<div class="col-lg-12" style = "margin-bottom:16px;"><center><a href="https://www.xiaoz.me/" target = "_blank" title = "小z博客"><img width = "120px" height = "43px" src="https://cdn.xiaoz.me/wp-content/uploads/2017/06/xiao_zlogo185.png" alt="小z博客"></a></center></div>
			</div>
		</div>
	</div>
	<!--页脚END-->
	<!--图片自适应-->
	<script>
		$(document).ready(function(){
			$(".container img").addClass("img-responsive");
		});
	</script>
</body>
</html>