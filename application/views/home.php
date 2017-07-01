<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta charset="utf-8" />
	<title>Himd - 在线Markdown编辑器</title>
	<meta name="generator" content="EverEdit" />
	<meta name="author" content="" />
	<meta name="keywords" content="" />
	<meta name="description" content="" />
	<link rel="stylesheet" href="https://libs.xiaoz.top/bootstrap/3.3.0/css/bootstrap.min.css">
	<link href="https://libs.xiaoz.top/simplemde/simplemde.min.css" rel="stylesheet">
	<script src="https://libs.xiaoz.top/simplemde/simplemde.min.js"></script>
	<script src = "https://libs.xiaoz.top/jquery/2.0.3/jquery-2.0.3.min.js"></script>
	<style type = "text/css">
		.CodeMirror {
		    height: 380px;
		}
		#msg{
			border:1px solid #DBDBDB;
			background-color:#F9F9F9;
			width:10%;
			position:fixed;
			left:45%;
			margin-top:20px;
			border-radius:3px;
			line-height:2em;
			text-align:center;
			display:none;
		}
		.interval {
			margin-left:10px;
		}
	</style>
</head>
<body>
	<div id="msg"></div>
	<div class="container">
		<div class="row" style = "margin-top:80px;">
			<div class="col-lg-8 col-md-offset-2">
				<textarea name="mdeditor" id = "mdeditor" rows="40"><?php echo $mdcontent; ?></textarea>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-8 col-md-offset-2">
				<button type="button" class="btn btn-primary btn-sm" id = "btn">保 存</button>
				<!--<button class = "btn" id= "btn">保 存</button>-->
				<span class = "interval"></span>
				<a href="../pre/index/<?php echo $user; ?>" target = "_blank" class="btn btn-primary btn-sm">预 览</a>
				<span class = "interval"></span>
				<a href="./home/rewrite" id = "rewrite" class="btn btn-primary btn-sm">再写一篇</a>
			</div>
		</div>
	</div>
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
			//再写一篇
			//$("#rewrite").click(function(data,status){
			//	$.get("./index.php/home/rewrite");
			//	if((status == 'success') && (data == '200')) {
					
			//		$("#msg").show();
			//		$("#msg").css("color","#46B782");
			//		$("#msg").text("已重写！");
			//		$("#msg").fadeOut(3000);
			//	}
			//});
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