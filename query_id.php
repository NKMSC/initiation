<?php
	require("connect.php");
	//查询已知id的信息  以json返回
	function query_id($id){
		$con=ConnectMysql();
		$strSQL="select * from initiation where id=$id";
		$result=mysql_query($strSQL);;
		$row= mysql_fetch_array($result);
		if($row!=null){
			//该id存在  输出相关信息\
            $arr = Array('id'=>$row['id'], 'name'=>$row['name'], 'gender'=>$row['gender'],'college'=>$row['college'],'grade'=>$row['grade'],'phone'=>$row['phone'],'email'=>$row['email'],'dept1'=>$row['dept1'],'dept2'=>$row['dept2'],'info'=>$row['info']);
            echo json_encode((object)$arr);
            // $encode=json_encode((object)$arr);
			}
		else{
			//该id不存在 返回值为false；
			echo 0;
		}

	}
	//检验参数id
	function CheckId($id){
		if(ctype_digit($id)){
			return true;
		}else{
			return false;
		}
	}

	$id=$_GET[id];
	$ParamLegal=CheckId($id);
	if($ParamLegal==true){
		query_id($id);
	}
?>