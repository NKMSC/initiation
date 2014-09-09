<?php
/*信息录入*/
require_once("connect.php");
require_once("SendEmail.php");
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
//发送邮件的msg
if($gender=="M"){
	$RealGender="男";
}else if($gender=="F"){
	$RealGender="女";
}
$msg="<html><head><style type=\"text/css\">table{border-collapse:collapse;}table, td, th{border:1px solid black;padding:5px;}</style></head><body><h3>这是来自南开大学微软俱乐部的信息确认邮件!</h3><table id=\"table\"><thead><tr><td>学号</td><td>姓名</td><td>性别</td><td>学院</td><td>年级</td><td>手机</td><td>邮箱</td><td>意愿一</td><td>意愿二</td></tr></thead><tbody><tr><td>$id</td><td>$name</td><td>$RealGender</td><td>$college</td><td>$grade</td><td>$phone</td><td>$email</td><td>$dept1</td><td>$dept2</td></tr><tr><td>备注</td><td colspan=\"8\">$info</td></tr></tbody></table><h5>如果信息有误请前于报名入口<a href='http://q.nkumstc.cn'>q.kumstc.cn</a>再次录入信息！</h5><b>需要更多信息你可以访问<a href='http://nkumstc.cn'>南微软官方主页</a>,或者在下面的媒体渠道关注联系我们</b>人人：个人主页<a href=\"http://www.renren.com/318793631/profile\">南微软</a><br>人人：公共主页<a href=\"http://page.renren.com/601898669\">南微软</a><br>微博：<a href=\"http://weibo.com/nkumstc\">南开大学微软技术俱乐部</a><br><small>为了确保您能及时收到邮件，请将我们添加为好友，否则邮件有可能会进入垃圾箱！</small><small>如果以上不是你的个人信息请忽略此邮件！</small></body></html>";
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
       
            $SendEmailoResult=SendEmail($email,$msg);
            if($SendEmailoResult==true){
                Success('报名信息修改成功');
            }else{
                Error("发送邮件失败"+$SendEmailoResult);
            }
        
        
	}else{
		//更新失败
		Error("更新数据失败:".mysql_error());
	}
}else{			//没有注册过
	$strSQL="insert into initiation values('$id','$name','$gender','$college','$grade','$phone','$email','$dept1','$dept2','$info')";
	$result=mysql_query($strSQL);//成功返回资源标识符，失败返回false
	if($result)
	{
    
            $SendEmailoResult=SendEmail($email,$msg);
            if($SendEmailoResult==true){
                Success('报名信息提交成功');
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
