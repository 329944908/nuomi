<?php
/**
 * This example shows making an SMTP connection with authentication.
 */

//SMTP needs accurate times, and the PHP time zone MUST be set
//This should be done in your php.ini, but this is how to do it if you don't have access to that
header("content-type:text/html;charset=utf-8");
require 'class.phpmailer.php';
require 'class.smtp.php';
date_default_timezone_set('PRC');//set time

//Create a new PHPMailer instance
$mail = new \PHPMailer;
//Tell PHPMailer to use SMTP
$mail->isSMTP();
//Enable SMTP debugging
// 0 = off (for production use)
// 1 = client messages
// 2 = client and server messages
$mail->SMTPDebug = 2;   //用的时候这个应该注释  不然会输出代码
//Ask for HTML-friendly debug output
$mail->Debugoutput = 'html';
//Set the hostname of the mail server
$mail->Host = "smtp.qq.com";                   //发送者使用的邮件服务器
//Set the SMTP port number - likely to be 25, 465 or 587
$mail->Port = 25;
//Whether to use SMTP authentication
$mail->SMTPAuth = true;
//Username to use for SMTP authentication
$mail->Username = "329944908";           //发送者邮箱
//Password to use for SMTP authentication
$mail->Password = "rcpdqdblrswybgfh";             //客户端授权密码
//Set who the message is to be sent from
$mail->setFrom('329944908@qq.com', '');  //发送者邮箱
//Set an alternative reply-to address
//$mail->addReplyTo('replyto@example.com', 'First Last');
//Set who the message is to be sent to
$mail->addAddress('13244237632@qq.com', '发给谁的备注');   //邮件接收者邮箱
//Set the subject line
$mail->Subject = '邮件标题';                            //发送邮件标题
//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
$mail->msgHTML('邮件正文');                             //发送邮件正文
//Replace the plain text body with one created manually
//$mail->AltBody = 'This is a plain-text message body';
//Attach an image file
//$mail->addAttachment('images/phpmailer_mini.png');

//send the message, check for errors
if (!$mail->send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;
} else {
    echo "Message sent success!";
}
