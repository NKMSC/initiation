<?php
	if(!isset($_COOKIE["pwd"])){
		header("location:login.php");
	}
	?>
	<!DOCTYPE html>
	<html lang="zh-cn">
	<head>
		<meta charset="utf-8">
		<title>群发邮件</title>
		<style type="text/css">
		body{
			padding-top: 40px;
		}
		label{
			display: inline;
		}
		textarea,input{
			margin: 20px auto;
			vertical-align: middle;
			display: block;
		}
		</style>

		<!-- /*<script type="text/javascript">
		function CheckParam(){
			if((document.getElementById('title').value=="null")||(document.getElementById('content').value=='null')){
				alert("您填写的参数不完整！请核对后再发送");
			}else{
				alert("参数正确放行");
			}
		}
		</script>*/ -->
	</head>
	<body align="center">
		<form action="groupsend.php" method="post">
			<label for="purpose">请选择志愿顺序</label>
			<select name="purpose">
				<option value="all" selected="true">全部</option>
				<option value="dept1">第一志愿</option>
				<option value="dept2">第二志愿</option>
			</select>
			<label for="depart">请选择部门</label>
			<select name="depart">
				<option value="all" selected="true">全部</option>
				<option value="tech">技术部</option>
				<option value="business">运营部</option>
				<option value="plan">策宣部</option>
			<input type="text" name="title" placeholder="邮件标题">
			<textarea cols="40" rows="5" name="content" placeholder="邮件内容"></textarea>
			<input type="submit" onclick="CheckParam();" value="发送">
		</form>
	</body>
	</html>