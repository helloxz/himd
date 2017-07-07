		<!--内容部分-->
		<div class="col-lg-9" style = "border-left:1px solid #ccc;">
			<div class="col-lg-12">
				<p><input type="text" id = "title" class="form-control" placeholder = "请填写标题" value = "<?php echo $dtitle; ?>" /></p>
				<textarea name="mdeditor" id = "mdeditor" rows="40"><?php echo $content; ?></textarea>
				<button class = "btn btn-success" id = "save"> 保 存</button>
				<a href="./tpre/<?php echo "$fid" ?>" class = "btn btn-info" style = "margin-left:12px;" target = "_blank">预 览</a> 
				<b style = "margin-left:50px;">是否公开：</b>
				<label class="checkbox-inline">
				    <input type="radio" name="optionsRadiosinline" id="optionsRadios3" value="1">是
				  </label>
				  <label class="checkbox-inline">
				    <input type="radio" name="optionsRadiosinline" id="optionsRadios4" value="0" checked>否
				</label>
			</div>
		</div>
		<!--内容部分end-->
	</div>
</div>
<script>
	var simplemde = new SimpleMDE({ 
	element: $("#mdeditor")[0] 
	});
	$(document).ready(function(){
		$("#save").click(function(){
			var content = simplemde.value();
			var title = $("#title").val();
			//获取radio的值
			var choose  = $('input[name="optionsRadiosinline"]:checked').val();
			$.post("./updoc?fid=<?php echo $fid; ?>",{title:title,content:content,choose:choose},function(data,status){
				if(data == '200') {
					$("#msg").show();
					$("#msg").text('保存成功！');
					$("#msg").fadeOut(2000);
				}
				if(data == '201') {
					$("#msg").show();
					$("#msg").text('更新成功！');
					$("#msg").fadeOut(2000);
				}
				else {
					$("#msg").show();
					$("#msg").css(color,red);
					$("#msg").text(data);
					$("#msg").fadeOut(2000);
				}
			});
		});
	});
</script>