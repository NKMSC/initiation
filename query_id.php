<?php //查询已知id的信息  以json返回
require_once("connect.php");
$id=$_GET['id'];
if(!preg_match("/^\d+[x|X]?$/", $id))//验证id
{
    echo  0;
}else{
    $con=ConnectMysql();
    $strSQL="select * from initiation where id=$id";
    $result=mysql_query($strSQL);
    $row= mysql_fetch_array($result);
    if($row!=null)
    { //该id存在  输出相关信息
        $arr = Array('id'=>$row['id'], 'name'=>$row['name'], 'gender'=>$row['gender'],'college'=>$row['college'],'grade'=>$row['grade'],'phone'=>$row['phone'],'email'=>$row['email'],'dept1'=>$row['dept1'],'dept2'=>$row['dept2'],'info'=>$row['info']);
        echo json_encode($arr);
    }else{
        echo 0;
    }
}
?>