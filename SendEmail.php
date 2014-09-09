<?php
header("Content-type: text/html; charset=utf-8"); 
require_once 'class.phpmailer.php';
require_once 'query_id.php';

//加密函数
function encodingVerification($address){
    //$base64_encode($str)
//  var_dump($arr);
    $content = "http://nkumstcnew.sinaapp.com/getVerification?v=".urlencode(base64_encode($address));
    //var_dump($content);
    return $content;
}


//解密验证
function getVerification(){
//  echo $_GET['v'];
//  echo "\n".urldecode($_GET['v']);
    //$v = decodingVerification(base64_decode(urldecode($_GET['v'])));
    echo "\n".$v;
}
//getVerification();
//该函数用来发邮件
function SendEmail($address,$msg){
    $mail = new PHPMailer;
    $content=encodingVerification($address);
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
    $mail->Subject = "南微软纳新";
    $mail->Body=$msg; 
    $mail->AddAddress($address);
     if(!$mail->Send())
        {
         //echo "Mailer Error: " . $mail->ErrorInfo;
         //var_dump("失败".$mail->ErrorInfo);
         echo $mail->ErrorInfo;
         return false;
        }
        else
        {
         // echo "Message has been sent";
           // var_dump("成功");
            return true;
        }
}
?>