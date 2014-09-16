<?php
/*信息录入*/
require_once("connect.php");
require_once("SendEmail.php");

$gender_list = array('F','M','男','女');
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
	$dept2=null;
}
if($info){
	$info=htmlspecialchars($info);
}
//发送邮件的msg
if($gender=="M"){
	$gender="男";
}else if($gender=="F"){
	$gender="女";
}
$con=ConnectMysql();
//检查是否有该学号是否已经注册过
$CheckSql="select * from initiation where id=$id";
$check_result=mysql_query($CheckSql);
if($check_result&&mysql_fetch_array($check_result))
{			//已经注册过
	$altertime=date('Y-m-d H:i:s');
	$strSQL="update initiation set name='$name',gender='$gender',college='$college',grade='$grade', phone='$phone',email='$email',dept1='$dept1',dept2='$dept2',altertime='$altertime',info='$info' where id=$id";
	$result=mysql_query($strSQL);//成功返回true 失败返回false
	if($result)
	{
        //发送邮件
		$table="<table id=\"table\"><thead><tr><td>学号</td><td>姓名</td><td>性别</td><td>学院</td><td>年级</td><td>手机</td><td>邮箱</td><td>意愿一</td><td>意愿二</td></tr></thead><tbody><tr><td>$id</td><td>$name</td><td>$gender</td><td>$college</td><td>$grade</td><td>$phone</td><td>$email</td><td>$dept1</td><td>$dept2</td></tr><tr><td>备注</td><td colspan=\"8\">$info</td></tr></tbody></table>";
		Success('你已经成功修改信息',$table);

	}else{
		//更新失败
		Error("更新数据失败:".mysql_error());
	}
}else{			//没有注册过
	$regtime=date('Y-m-d H:i:s');
	$altertime=date('Y-m-d H:i:s');
	$strSQL="insert into initiation values('$id','$name','$gender','$college','$grade','$phone','$email','$dept1','$dept2','$regtime','$altertime','$info')";
	$result=mysql_query($strSQL);//成功返回资源标识符，失败返回false
	if($result)
	{
		$table="<table id=\"table\"><thead><tr><td>学号</td><td>姓名</td><td>性别</td><td>学院</td><td>年级</td><td>手机</td><td>邮箱</td><td>意愿一</td><td>意愿二</td></tr></thead><tbody><tr><td>$id</td><td>$name</td><td>$gender</td><td>$college</td><td>$grade</td><td>$phone</td><td>$email</td><td>$dept1</td><td>$dept2</td></tr><tr><td>备注</td><td colspan=\"8\">$info</td></tr></tbody></table>";
		Success('你的报名信息提交成功',$table);		
	}else{
		Error("插入数据失败:".mysql_error());
	}
}

//获取POST参数 空则返回null
function GetPost($name)
{
	if (empty($_POST[$name]))
	{
		return false;
	}else{
		return trim($_POST[$name]);
	}
}

//错误 跳转到错误页面
function Error($error_info)
{
	header("Content-type: text/html; charset=utf-8"); 
	Header("Location: http://q.nkumstc.cn/error.html?$error_info");
	die($error_info);
}

// 跳转到成功页面 并发送邮件
function Success($suc_info,$table)
{
	global $email;global $name;
	header("Content-type: text/html; charset=utf-8"); 
	Header("Location: http://q.nkumstc.cn/success.html?$name 童鞋,$suc_info,请留意邮箱$email"); 
	$head='<head><style type="text/css">table{border-collapse:collapse;}table,td, th{border:1px solid black;padding:5px;}</style></head>';
	$body='<h2>亲爱的'.$name.'童鞋,'.$suc_info.'</h2>'.$table.'<h3><strong>如果信息有误请于报名入口<a href="http://q.nkumstc.cn">http://q.kumstc.cn</a>再次录入信息！</strong></h3><p>需要更多信息可访问<a href="http://nkumstc.cn">南微软主页(NKUSMCT.CN)</a>,或者在下面的媒体渠道关注联系我们</p><br/>人人：个人主页<a href="http://www.renren.com/318793631/profile">南微软</a><br>人人：公共主页<a href="http://page.renren.com/601898669">南微软</a><br>微博：<a href="http://weibo.com/nkumstc">南开大学微软技术俱乐部</a><br>提示：<small>为了确保您能及时收到邮件，<strong>请将此邮箱添加入通讯录或者白名单</strong>，避免邮件进入垃圾箱！</small><br/><small>如果以上不是你的个人信息请忽略此邮件！</small><p align="right">南开大学微软技术俱乐部</p></body>';
	$msg='<html>'.$head.$body.'</html>';
	
	$send_result=SendEmail($email,$msg);
	if($send_result===true){
		echo "信息确认邮件已发送至 $email";
	}else{
		echo "确认邮件发送失败：$send_result";
	}
}

?>
<h1>信息处理中...</h1>
<p>如果超过一分钟未跳转请联系我们</p>
