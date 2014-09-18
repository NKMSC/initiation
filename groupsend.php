	<?php
	require('connect.php');
	require('SendEmail.php');
	if(!isset($_POST['content'])||!isset($_POST['title'])||!isset($_POST['purpose'])||!isset($_POST['depart'])){
		echo "<script type='text/javascript'>window.location='GroupSendHtml.php';</script>";
	}
	$content=$_POST['content'];
	$title=$_POST['title'];
	$purpose=$_POST['purpose'];
	$depart=$_POST['depart'];
		ConnectMysql();
		$msg="";
		$addr="";
		$countSucc=0;
		$countFail=0;
		$strSQL="select email,name from initiation";
		switch ($depart) {
			case 'all':
				break;
			case 'tech'://技术部
				switch ($purpose) {
					case 'dept1':
						# code...
					$strSQL=$strSQL." where dept1='技术部'";
						break;
					case 'dept2':
						# code...
					$strSQL=$strSQL." where dept2='技术部'";
						break;
				}
				break;
			case 'business'://运营部
				switch ($purpose) {
					case 'dept1':
						# code...
					$strSQL=$strSQL." where dept1='运营部'";
						break;
					case 'dept2':
						# code...
					$strSQL=$strSQL." where dept2='运营部'";
						break;
				}
				break;
			case 'plan'://策宣部
				switch ($purpose) {
					case 'dept1':
						# code...
					$strSQL=$strSQL." where dept1='策宣部'";
						break;
					case 'dept2':
						# code...
					$strSQL=$strSQL." where dept2='策宣部'";
						break;
				}
				break;
		}
			$result=mysql_query($strSQL);
			if($result==false){
				echo mysql_error();
			}
			while ($row=mysql_fetch_array($result)) {
				# code...
				$msg="亲爱的".$row['name']." ".$content;
				$addr=$row['email'];
				$flag=GroupSendEmail($addr,$title,$msg);
				if($flag==true){
					$countSucc++;
					$msg="";
				}else {
					$countFail++;
					die($flag);
				}
			}
	?>
	<html lang="zh-CN">
	<head>
		<meta charset="utf-8">
	</head>
	<h1>
	<a href="control.html">返回后台首页</a>
		<?php
		echo "成功发送邮件:".$countSucc."失败:".$countFail;
		?>
	</h1>
	</html>