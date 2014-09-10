<?php
require_once 'class.phpmailer.php';
//该函数用来发邮件
function SendEmail($address,$msg)
{
    $mail = new PHPMailer;
    $mail->CharSet = "utf-8";
    $mail->IsSMTP();                               // Set mailer to use SMTP
    $mail->SMTPAuth = true; // authentication enabled
    $mail->SMTPSecure = 'tls'; // secure transfer enabled REQUIRED for GMail
    $mail->Host = "smtp.qq.com";
    $mail->Port = 25; 
    $mail->IsHTML(true);
    $mail->Username = "997833949@qq.com";
    $mail->Password = "renyujie910";
    $mail->SetFrom("new@nkumstc.cn","南微软纳新管理");
    $mail->Subject = "南微软纳新信息核对邮件";
    $mail->Body=$msg; 
    $mail->AddAddress($address);
    if(!$mail->Send())
    {
       return $mail->ErrorInfo;
   } else {
    return true;
}
}
?>