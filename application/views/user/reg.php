<div id = "ip" style = "display:none;"><?php echo $ip; ?></div>
<!--注册表单-->
<div class="container" style = "margin-top:80px;">
	<div class="row">
		<div class="col-lg-6 col-md-offset-3">
			<form class="form-horizontal" role="form" method = "post">
				<div class="form-group">
					<label class="col-sm-2 control-label">用户名</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" placeholder="字母或数字组成" id = "user">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">密 码</label>
					<div class="col-sm-10">
						<input type="password" class="form-control" id="passwd" placeholder = "字母数字或特殊字符组成">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">邮 箱</label>
					<div class="col-sm-10">
						<input type="email" class="form-control" placeholder="service@hixz.org" id = "mail">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">验证码</label>
					<div class="col-sm-10">
						<input type="texe" class="form-control" style = "width:50%;" placeholder="请查收邮箱" id = "mailcode">
							<span class = "sendcode col-sm-4"><a href="javascript:;" id = "send">发 送</a></span>
					</div>
				</div>
				<!--<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						<div class="checkbox">
							<label>
								<input type="checkbox"> 注册协议（必读）
							</label>
						</div>
					</div>
				</div>-->
				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						<button type="button" class="btn btn-default" id = "reg">注 册</button> <label for="" id = "loading" style = "color:#3E9827;display:none;">注册中...</label>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		$("#send").click(function(){
			var mail = $("#mail").val();
			if(mail == '') {
				$("#msg").show();
				$("#msg").css("color","red");
				$("#msg").text("请先填写邮箱！");
				$("#msg").fadeOut(3000);
				return false;
			}
			else {
				$("#msg").show();
				$("#msg").css("color","green");
				$("#msg").text("发送中，请稍后...");
				$.post("./sendcode",{mail:mail},function(data,status){
					if(data == '200') {
						$("#msg").show();
						$("#msg").css("color","green");
						$("#msg").text("发送成功，请查收邮件。");
						$("#msg").fadeOut(8000);
						return false;
					}
					if(data == '500') {
						$("#msg").show();
						$("#msg").css("color","red");
						$("#msg").text("邮箱格式不对！");
						$("#msg").fadeOut(3000);
						return false;
					}
					if(data == '501') {
						$("#msg").show();
						$("#msg").css("color","red");
						$("#msg").text("3分钟后可再次发送！");
						$("#msg").fadeOut(3000);
						return false;
					}
					if(data == '502') {
						$("#msg").show();
						$("#msg").css("color","red");
						$("#msg").text("该邮箱已注册！");
						$("#msg").fadeOut(3000);
						return false;
					}
				});
			}
		});
		//提交注册按钮
		$("#reg").click(function(){
			var ip = $("#ip").text();
			var user = $("#user").val();
			var passwd = $("#passwd").val();
			var mail = $("#mail").val();
			var mailcode = $("#mailcode").val();
			if(user == '') {
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
			if(mailcode == '') {
				$("#msg").show();
				$("#msg").css("color","red");
				$("#msg").text("请先获取验证码！");
				$("#msg").fadeOut(3000);
				return false;
			}
			
			$.post("./userreg",{ip:ip,user:user,passwd:passwd,mail:mail,mailcode:mailcode},function(data,status){
				$("#msg").show();
				$("#msg").text(data);
				$("#msg").fadeOut(3000);
				if(data == '200') {
					$("#msg").show();
					$("#msg").css("color","green");
					$("#msg").text("注册成功！");
					$("#msg").fadeOut(3000);
					window.location.href = "../../uadmin/index";
					return false;
				}
			});
		});
		//提交注册END	
	});
</script>