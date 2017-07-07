		<!--内容部分-->
		<div class="col-lg-9">
			<div class="col-lg-12">
				<p style = "line-height:2em;">
					<a href="?status=all">全 部</a> || 
					<a href="?status=public">公 开</a> || 
					<a href="?status=private">私 有</a> || 
				</p>
				<hr>
			</div>
			<div class="col-lg-12">
				<table width = "100%;" class = "table table-striped">
				<tbody>
				<?php foreach($result as $itrm): ?>
                    <tr>
                            <td width = "80%;"><a href="../docs/index/<?php echo $itrm['fileid']; ?>" target = "_blank"><?php echo $itrm['title'] ?></a></td>
                            <td width = "20%;">
	                            <a href="./edit?fid=<?php echo $itrm['fileid']; ?>">编辑</a> | 
	                            <a href="javascript:;" onclick = "return del('<?php echo $itrm['fileid']; ?>');">删除</a>
	                        </td>
                    </tr>
                <?php endforeach;?>
                </tbody>
                </table>
			</div>
			
		</div>
		<!--内容部分end-->
	</div>
</div>
<script>
	function del(id) {
		var id = id;
		if (confirm('确认删除？')==true){ 
		  	window.location.href = "./delete/" + id;
		 }else{ 
		  return false; 
		 } 
	}
</script>