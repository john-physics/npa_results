<?php

 require 'page_init.php';

head('NPA Result Port',"$site | Result Portal","Dashboard");




 
 $mails = collect_table_data1($conn,"mail_queue","status","pending","s");
 
 $delLocal = 0;
 $delEmpty = 0;
 foreach ($mails as $mail){
     
 $message = $mail["message"];
 $mail_Id = $mail["id"];
 $email = $mail["recipient_email"];
 
 
if (strpos($message,"localhost") !== false) {
   
  delete_user_data($conn,"mail_queue","id",$mail_Id,"i");
    $delLocal++;
}
   
 elseif(!$email){
     
   delete_user_data($conn,"mail_queue","id",$mail_Id,"i");
    $delEmpty++;  
     
     
  }
 }
 
 
 echo "<br><br>";
  echo "Total mails: ". count($mails);
  echo "<br>Local deleted mails: ".$delLocal;
     
   echo "<br>Empty deleted mails: ".$delEmpty;   
 
