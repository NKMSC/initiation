<?
define("pwd", 'nkumstc');
$password=$_POST["password"];
if($password==pwd){
	setcookie('pwd',PWD,time()+3600);
	header("location:control.html");
}else{
	header("location:login.php");
}
?>