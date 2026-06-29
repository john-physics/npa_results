<?php

set_time_limit(300);
ignore_user_abort(true);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP; 
use PHPMailer\PHPMailer\POP3; 
// Include library PHPMailer 
require __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/functions/functions.php';

$dirname = "/home/newphase/domains";
//$dirname = "/storage/emulated/0";
$configfile = $dirname . '/config/npa.config.ini';


if(file_exists($configfile)){
    
$config = parse_ini_file($configfile,true);

$host = $config["data"]["hostname"];
$user = $config["data"]["username"];
$dbpsw = $config["data"]["dbpsw"];
$dbname = $config["data"]["dbname"];
$email_host= $config["data"]["email_host"];
$email_user= $config["data"]["email_user"];
$email_psw  = $config["data"]["email_psw"];
$email_sender = $config["data"]["email_sender"];
$rurl = $config["data"]["rurl"];
$site = $config["data"]["site"];
$logourl = $rurl."/images/npa-logo.jpg";
 

   if($dbname){
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // Enable error exceptions 
try{
  
 $conn = mysqli_connect($host,$user,$dbpsw,$dbname);
 
}
catch(mysqli_sql_exception $error){
    
   $error -> getMessage();
   
 file_put_contents(
    __DIR__ . "/cron_debug.log",
    date("Y-m-d H:i:s") . " $error\n",
    FILE_APPEND
);
 
 exit();
 
    }   
}

else{
  $error = "Database name not specified"; 
   
 file_put_contents(
    __DIR__ . "/cron_debug.log",
    date("Y-m-d H:i:s") . " $error\n",
    FILE_APPEND
);

exit();
  
 }
}
else{
 
  $error = "Configuration file not found"; 
 
 file_put_contents(
    __DIR__ . "/cron_debug.log",
    date("Y-m-d H:i:s") . " $error\n",
    FILE_APPEND
);
 

 exit();
  
  
}

 $status = "pending";
 $limit = 3; //18 emails per hour with cron of 10 mins interval
 $mailque = get_pending_mails($conn, $status, $limit);
 
 $sent = 0;
 $er = 0;
 $errors = "";

if($mailque){

$mail = new PHPMailer(true);

$mail->SMTPDebug = 0;
$mail->isSMTP();
$mail->Host       = $email_host;
$mail->SMTPAuth   = true;
$mail->Username   = $email_user;
$mail->Password   = $email_psw;
$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
$mail->Port       = 465;
$mail->Timeout = 60;
$mail->SMTPKeepAlive = true; 

$mail->setFrom($email_user, $email_sender);
$mail->addReplyTo($email_user, $email_sender);
$mail->isHTML(true);

foreach ($mailque as $queue) {

    $email = strtolower($queue["recipient_email"]);
    $name  = $queue["recipient_name"]??$email;
    $msg_subj = $queue["subject"];
    $msg  = $queue["message"];
    $attach = $queue["attachment"];
    $msgId = $queue["id"];
    $date = date("Y"); 
   
    if ($email && filter_var($email, FILTER_VALIDATE_EMAIL)) {

        try {

       $mail->addAddress($email, $name);

     if ($attach) {
 $path = __DIR__.'/vendor/attachment/';
     $file = $path . $attach;
      
  if(is_file($file)){
       
    $mail->addAttachment($file);   
       
   }
  }

   $mail->Subject = $msg_subj;
   $mail->Body  = '<div style="text-align:justify;padding:10px">
   '.$msg.'<br>
  </div>
  <center>
 <img src="'.$logourl.'" width="120" alt="School Logo">
 <h3 style="color:green"><i>'.$site.' <br> &copy; '.$date.'</i>
       </h3><br><br>
  <a href="'.$rurl.'/unsubscribe?user_email='.$email.'">Unsubscribe</a>     
   </center>';
   
     $mail->send();

     $sent++;
 date_default_timezone_set("Africa/Lagos");
 $dateTime = date("d/m/Y h:i A");
   update_user_data($conn,"mail_queue","status","id","sent",$msgId,"si");
   update_user_data($conn,"mail_queue","sent_at","id",$dateTime,$msgId,"si");


     if ($attach) {
 $path = __DIR__.'/vendor/attachment/';
     $file = $path . $attach;
      
  if(is_file($file)){
       
    unlink($file);   
       
   }
  }

 } catch (Exception $e) {

            $er++;
            update_user_data($conn,"mail_queue","status","id","failed",$msgId,"si");
            $errors .= $mail->ErrorInfo;
        $errors .= $e->getMessage() . "; ";
        
 }

        
        $mail->clearAddresses();
        $mail->clearAttachments();
    }
 }
     
}


 //end of loop 
 
 if($er || $errors ){
 
  file_put_contents(
    __DIR__ . "/cron_debug.log",
    date("Y-m-d H:i:s") . "Error sending mails. Error_num: $er, Errors: $errors\n",
    FILE_APPEND);
}


exit(); 
