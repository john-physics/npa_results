<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP; 
use PHPMailer\PHPMailer\POP3; 
// Include library PHPMailer 
 require 'vendor/autoload.php';


function sendPswToken($config,$email,$name,$token,$valid,$site,$rurl){

if($email){
  
 mailing_list($email,'Subscribe','User Consent'); //Subscribe user to mailing
 
$email_host= $config["data"]["email_host"];
$email_user= $config["data"]["email_user"];
$email_psw  = $config["data"]["email_psw"];
$email_sender = $config["data"]["email_sender"];
$date = date("Y");
$logourl = $rurl."/images/npa-logo.jpg";
 

 $mail = new PHPMailer(true);

try {
    $mail->SMTPDebug = 0;
    $mail->isSMTP();                       
  
  $mail->Host  = $email_host;                    
    $mail->SMTPAuth  = true;
    $mail->Username = $email_user; 
   $mail->Password  = $email_psw;         // SMTP Password
   
   $mail->SMTPOptions = array(
    'ssl' => [
        'verify_peer' => true,
        'verify_depth' => 3,
        'allow_self_signed' => false,
        'peer_name' =>$email_host, ],
 );
   
   $mail-> SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
  
    $mail->Port  = 465;
    $mail->setFrom($email_user, $email_sender);  // Mail sender

  $mail->addAddress($email, $name); 
  $mail-> addReplyTo($email_user,$email_sender);
  
   // Mail content
  
   $mail->isHTML(true);
   $mail->Subject = "Password Reset Token";
 $mail->Body  = '<div style="text-align:justify;padding:10px">Dear '.$name.',<br><br>
   There is a pending request to reset your login Password on '.$site.' result portal, use the token below to authorize the request and complete the action
   <br><br>
 <center>'.$token.'</center><br>
 This token is valid for only '.$valid.' minutes
</div>
 <center>
 <img src="'.$logourl.'" width="120" alt="School Logo">
 <h3 style="color:green"><i>'.$site.' <br> &copy; '.$date.'</i>
       </h3><br><br>
  <a href="'.$rurl.'/unsubscribe?user_email='.$email.'">Unsubscribe</a>     
   </center>';
       
    $mail->send();
       
$feedback = [
      "status" => "success",
      "message" => "Token sent successfully"
      
      ];
      
} catch (Exception $e) {
 
 $feedback = [
      "status" => "failed",
      "message" => "Request Email not sent: {$mail->ErrorInfo}"
      ];
      
   }     
    
}
else{
  
  $feedback = [
      
      "status" => "failed",
      "error" => "empty_email",
      "message" => "Empty user Email"
      
      ]; 
    
  }
  
  return $feedback; 
}