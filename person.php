<?php
//定义一个常量，每页显示的条数
	define("PAGESIZE",10);
	define("PWD","nkumstc");//密码
if(isset($_POST["pwd"])){
		if($_POST["pwd"]==PWD)
		setcookie('pwd',PWD,time()+10000);	
}
?>
<html lang="zh-CN">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>报名情况查看</title>
	<style type="text/css">
	body{
		background-color:rgba(230,230,230,0.5); 
		margin-top: 20px;
	}
	table{
		text-align: left;
		background-color: rgba(230,230,230,0.9);
		width: 90%;
	}
	tr{
		line-height: 30px;
	}
	h2{
		text-align: center;
	}
	a{
		margin: 50px;
	}
    .CheckPwd{
		text-align: center;
		vertical-align: middle;
	}
	</style>
</head>
<body>
	<?php
	
	
	if((!isset($_COOKIE["pwd"])&&!isset($_POST["pwd"]))||(isset($_COOKIE["pwd"])&&$_COOKIE["pwd"]!=PWD)||(isset($_POST["pwd"])&&$_POST["pwd"]!=PWD)){
		echo "<form action=\"person.php\" method=\"post\"><label>请输入密码</label><input type=\"text\" name=\"pwd\"><input type=\"submit\" value=\"提交\">";
	}else if($_POST['pwd']==PWD||$_COOKIE["pwd"]==PWD){
		//输出整个table
		echo "<h2>已经报名的人</h2>
		<table id=\"table\" align=\"center\">
		<thead>
			<tr>
				<td>学号</td>
				<td>姓名</td>
				<td>性别</td>
				<td>学院</td>
				<td>年级</td>
				<td>手机</td>
				<td>邮箱</td>
				<td>意愿一</td>
				<td>意愿二</td>
				<td>备注</td>
			</tr>
		</thead>
		<tbody>";
		require("connect.php");
			$con=ConnectMysql();
			
			//查询所有
			function GetAll(){
				$strSQL="select * from initiation order by regtime esc";
				$result=mysql_query($strSQL);
				return $result;
			}
			function CountAll(){
				$strSQL="select count(*) from initiation";
				$result=mysql_query($strSQL);
				list($num)=mysql_fetch_row($result);
				return $num;
			}
			//从数据中取出特定数目的结果
			function SelectPagesize($offset){
				$strSQL="select * from initiation order by regtime desc limit $offset,".PAGESIZE;
				//echo "SelectPagesize->param:$strSQL<br>";
				$result=mysql_query($strSQL);
				return $result;
			}
			$sum=CountAll();
			//$result=GetAll();
			
			$AllPages=$sum%PAGESIZE==0?$sum/PAGESIZE:($sum/PAGESIZE+1);
        	$AllPages=(int)$AllPages;
			$PageString=null;//显示超链接
			if(isset($_GET['page'])&&$_GET['page']!=1){
				//当前页为 $_get[PAGE]
				$CurrentPage=$_GET['page'];
				$LastPage=$CurrentPage-1;
				if($CurrentPage==$AllPages){
					//当前是最后一页
					$PageString="<a href=\"person.php?page=$LastPage\">上一页</a><a class=\"Active\">第".$CurrentPage."页</a><a disabled=\"true\">下一页</a>";
				}else{
					//既不是第一页也不是最后一页
					$NextPage=$CurrentPage+1;
					$PageString="<a href=\"person.php?page=$LastPage\">上一页</a><a class=\"Active\">第".$CurrentPage."页</a><a href=\"person.php?page=$NextPage\">下一页</a>";
				}
				$result=SelectPagesize(($CurrentPage-1)*PAGESIZE);

			}else{
				//当前是第一页
				$PageString="<a>上一页</a><a class=\"Active\">第1页</a><a href=\"person.php?page=2\">下一页</a>";
				$result=SelectPagesize(0);
			}
			//echo "page->$AllPages<br>";
			while ($person=mysql_fetch_array($result)) {
				echo "<tr>";
				echo 	"<td>".$person['id']."</td>";
				echo	"<td>".$person['name']."</td>";
				echo	"<td>".$person['gender']."</td>";
				echo	"<td>".$person['college']."</td>";
				echo	"<td>".$person['grade']."</td>";
				echo	"<td>".$person['phone']."</td>";
				echo	"<td>".$person['email']."</td>";
				echo	"<td>".$person['dept1']."</td>";
				echo	"<td>".$person['dept2']."</td>";
				echo	"<td>".$person['info']."</td>";
				echo "</tr>";
			}
			echo "</tbody>
					<tfoot>
						<tr align=\"center\">
							<td colspan=\"10\">
								\"$PageString\";
							</td>
						</tr>
						<tr align=\"center\">
							<td colspan=\"10\">总计人数 :
								$sum&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;共".$AllPages."页
							</td>
						</tr>
					</tfoot>
					</table>";
	}
	?>
</body>
</html>