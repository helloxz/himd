<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta charset="utf-8" />
	<title>Himd - Markdown在线编辑器</title>
	<meta name="generator" content="EverEdit" />
	<meta name="author" content="" />
	<meta name="keywords" content="" />
	<meta name="description" content="" />
	<link href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
	<link href="https://libs.xiaoz.top/simplemde/simplemde.min.css" rel="stylesheet">
	<link href="../static/style.css" rel="stylesheet">
	<script src="https://libs.xiaoz.top/simplemde/simplemde.min.js"></script>
	<script src = "https://libs.xiaoz.top/jquery/2.0.3/jquery-2.0.3.min.js"></script>
</head>
<body>
	<div id="msg"></div>
	<!--导航菜单-->
	<div id="menu">
		<div class="container">
			<div class="row">
				<div class="col-lg-8">
					<h1><a href="">Himd</a><small> - Markdown在线编辑器</small></h1>
				</div>
				<div class="col-lg-4 menu-right">
					<div style = "margin-top:28px;">
						<a href="./user/login">登 录</a> | 
						<a href="./user/reg">注 册</a>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!--导航菜单END-->
	<div class="container">
		<div class="row" style = "margin-top:30px;">
			<div class="col-lg-8 col-md-offset-2">
				<textarea name="mdeditor" id = "mdeditor" rows="40"><?php echo $mdcontent; ?></textarea>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-8 col-md-offset-2">
				<button type="button" class="btn btn-primary btn-sm" id = "btn"><span class="glyphicon glyphicon-floppy-disk"></span> 保 存</button>
				<!--<button class = "btn" id= "btn">保 存</button>-->
				<span class = "interval"></span>
				<a href="../pre/index/<?php echo $user; ?>" target = "_blank" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-zoom-in"></span> 预 览</a>
				<span class = "interval"></span>
				<a href="./home/rewrite" id = "rewrite" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-pencil"></span> 再写一篇</a>
				<div class="reg" >
					<a href="./user/login">登 录</a> | 
					<a href="./user/reg">注 册</a>
				</div>
			</div>
		</div>
	</div>
	<!--页脚-->
	<div id="footer">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">Copyright © 2016 - 2017 | Powered by <a href="https://github.com/helloxz/himd" target = "_blank" rel = "nofollow">Himd</a>
				<div class="col-lg-12" style = "margin-bottom:16px;"><a href="https://www.xiaoz.me/" target = "_blank" title = "小z博客"><img width = "120px" height = "43px" src="https://cdn.xiaoz.me/wp-content/uploads/2017/06/xiao_zlogo185.png" alt="小z博客"></a></div>
			</div>
		</div>
	</div>
	<!--页脚END-->
	<script>
		var simplemde = new SimpleMDE({ 
			element: $("#mdeditor")[0] 
			});
		//保存
		function save() {
			var content = simplemde.value();
			if(content.length < 60) {
					$("#msg").show();
					$("#msg").css("color","red");
					$("#msg").text("内容太少了！");
					$("#msg").fadeOut(3000);
					return false;
				}
			else {
				$.post("./home/save",{content:content},function(data,status) {
				if((status == 'success') && (data == '200')) {
					$("#msg").show();
					$("#msg").css("color","#46B782");
					$("#msg").text("保存成功！");
					$("#msg").fadeOut(3000);
				}
			});
			}
		}
		//单击保存按钮
		$(document).ready(function(){
			$("#btn").click(function(){
				save();
			});
		});
		// ctrl + s监听事件
		$(document).keydown(function(e){
			// ctrl + s
			if( e.ctrlKey  == true && e.keyCode == 83 ){
				save();
				return false; // 截取返回false就不会保存网页了
			}
		});
	</script>
	
</body>
</html>