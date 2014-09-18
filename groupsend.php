<!DOCTYPE html>
<html lang="zh-cn">
<head>
	<meta content="text/html">
	<meta charset="utf-8">
	<style type="text/css">
	table{
		border: 1px solid #000;
	}
	</style>

	<?php
	//获得某个
	function getPerson(){
		require('connect.php');
		ConnectMysql();
		$strSQL="select * from initiation";
		$result=mysql_query($strSQL);
	}
	function DoSendEmail(){
		require('SendEmail.php');
		$persons=getPerson();
		while ($row=mysql_fetch_row($persons)) {
			echo $row['email']."<br>";
		}
	}
	?>
</head>
<body align="center">
	<h3>请选择收件人</h3>
	<table align="center">
		<button onclick="DoSendEmail()">点击发送</button>
	</table>
</body>
</html>