<!--注册表单-->
<div class="container" style = "margin-top:80px;">
	<div class="row">
		<div class="col-lg-6 col-md-offset-3">
			<form class="form-horizontal" role="form" method = "post">
				<div class="form-group">
					<label class="col-sm-2 control-label">账 号</label>
					<div class="col-sm-10">
						<input type="email" class="form-control" placeholder="请填写注册邮箱" id = "mail">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">密 码</label>
					<div class="col-sm-10">
						<input type="password" class="form-control" id="passwd" placeholder = "字母数字或特殊字符组成">
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						<button type="button" class="btn btn-primary" id = "login">登 录</button>  <span style = "margin-left:20px;"><a href="">忘记密码？</a></span>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		$("#login").click(function(){
			var mail = $("#mail").val();
			var passwd = $("#passwd").val();

			if(mail == '') {
				$("#msg").show();
				$("#msg").css("color","red");
				$("#msg").text("用户名不能为空！");
				$("#msg").fadeOut(3000);
				return false;
			}
			if(passwd == '') {
				$("#msg").show();
				$("#msg").css("color","red");
				$("#msg").text("密码不能为空！");
				$("#msg").fadeOut(3000);
				return false;
			}
			else {
				$.post("./relogin",{mail:mail,passwd:passwd},function(data,status) {
					if(data == '200') {
						window.location.href = "../../uadmin/index";
						return false;
					}
					else {
						$("#msg").show();
						$("#msg").css("color","red");
						$("#msg").text(data);
						$("#msg").fadeOut(3000);
						return false;
					}
				});
			}
		});
	});
</script>