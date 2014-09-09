<?php
/*信息录入*/
require("connect.php");
require("SendEmail.php");
header("Content-type: text/html; charset=utf-8"); 
//获取POST参数 空则返回null
function GetPost($name)
{
	if (empty($_POST[$name]))
	{
		return null;
	}else{
		return trim($_POST[$name]);
	}
}

//错误 跳转到错误页面
function Error($error_info)
{
    //die($error_info);
    Header("Location: http://q.nkumstc.cn/error.html?$error_info");
}

//跳转到成功页面
function Success($suc_info)
{
    
    //echo $suc_info;
    Header("Location: http://q.nkumstc.cn/success.html?$suc_info"); 
}

$gender_list = array('F','M');
$college_list=array("计控","软件","电光","数学","物理","商学","经济","化学","生科","环科","文学","法学","历史","哲学","医学","周政","马克思","旅游","外语","汉语","泰达","其它");
$grade_list = array("大一","大二","大三","大四","研一","研二","研三","博士","其他");
$dept_lsit=array("技术部","运营部","策宣部");

$id=GetPost('id');
$name=GetPost('name');
$gender=GetPost('gender');
$college=GetPost('college');
$grade=GetPost('grade');
$phone=GetPost('phone');
$email=GetPost('email');
$dept1=GetPost('dept1');

$dept2=GetPost('dept2');//允许为空
$info=GetPost('info');//允许为空


//验证id
if(!preg_match("/^\d+[x|X]?$/", $id)){
	Error('学号不是数字');
}
//验证 姓名
if(!$name){
	Error('姓名不可为空');
}
//验证性别
if(!in_array($gender,$gender_list)){
	Error('性别不在范围内');
}
//验证学院
if(!in_array($college,$college_list)){
	Error('学院不在范围内');
}
//年级
if(!in_array($grade, $grade_list)){
	Error('年级不在范围内');
}
//phone
if(!preg_match("/1[3458]{1}\d{9}$/",$phone))
{
	Error('输入不是国内合法手机号');
}
//email
if(!preg_match("/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/",$email))
{
	Error('邮箱格式不正确');
}
//部门
if(!in_array($dept1, $dept_lsit))
{
	Error('第一部门不在范围内');
}
if($dept2&&!in_array($dept2, $dept_lsit))
{
	Error('备选部门不在范围内');
}

$con=ConnectMysql();
//检查是否有该学号是否已经注册过
$CheckSql="select * from initiation where id=$id";
$check_result=mysql_query($CheckSql);
if($check_result&&mysql_fetch_array($check_result))
{			//已经注册过
	$strSQL="update initiation set name='$name',gender='$gender',college='$college',grade='$grade', phone='$phone',email='$email',dept1='$dept1',dept2='$dept2',info='$info' where id=$id";
	$result=mysql_query($strSQL);//成功返回true 失败返回false
	if($result)
	{
        //发送邮件
        SendEmail($email);
		Success('信息修改成功');
	}else{
		//更新失败
		Error("更新数据失败:".mysql_error());
	}
}else{			//没有注册过
	$strSQL="insert into initiation values('$id','$name','$gender','$college','$grade','$phone','$email','$dept1','$dept2','$info')";
	$result=mysql_query($strSQL);//成功返回资源标识符，失败返回false
	if($result)
	{
        //发送邮件
        $SendEmailoResult=SendEmail($email);
        if($SendEmailoResult==true){
            Success('提交成功');
        }else{
            Error("发送邮件失败"+$SendEmailoResult);
        }
		
	}else{
        Error("插入数据失败:".mysql_error());
	}
}
?>
<h1>信息处理中...</h1>
如果超过一分钟未跳转请联系我们
