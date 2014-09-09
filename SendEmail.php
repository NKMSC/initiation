<?php
header("Content-type: text/html; charset=utf-8"); 
require 'class.phpmailer.php';
//该函数用来发邮件
function SendEmail($address){
    $mail = new PHPMailer;
	$mail->CharSet = "utf-8";
	$mail->IsSMTP();                                      // Set mailer to use SMTP
	$mail->SMTPAuth = true; // authentication enabled
    $mail->SMTPSecure = 'tls'; // secure transfer enabled REQUIRED for GMail
    $mail->Host = "smtp.qq.com";
    $mail->Port = 25; 
    $mail->IsHTML(true);
    $mail->Username = "997833949@qq.com";
    $mail->Password = "renyujie910";
    $mail->SetFrom("new@nkumstc.cn","南微软纳新管理");
    $mail->Subject = "Test";
	$mail->Body = "这是来自南微软俱乐部的<a href=\"http://nkumstc.cn/\">验证邮件</a>";
    $mail->AddAddress($address);
     if(!$mail->Send())
        {
         //echo "Mailer Error: " . $mail->ErrorInfo;
         return false;
        }
        else
        {
         // echo "Message has been sent";
            return true;
        }
}
?>