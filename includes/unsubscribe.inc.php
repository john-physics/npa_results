<?php
if($_SERVER['REQUEST_METHOD'] =="POST"){
  
  $root = $_SERVER["DOCUMENT_ROOT"];
 require $root.'/page_init.php';
  
 
  if(isset($_POST['submit_un_sub_email'])) {
      
   $user_email =  trim(htmlspecialchars($_POST['user_email'],ENT_QUOTES,'UTF-8'));
   $reasons =  trim(htmlspecialchars($_POST['reasons'],ENT_QUOTES,'UTF-8'));
   
   $mailing = "Unsubscribe";

 $report = mailing_list($user_email,$mailing,$reasons);
 
 header("location:/unsubscribe?unsubscribe_email_report&email=".$user_email."&report=".$report);
die();
      
  }
  else{
 header("location:/home");
die();     
      
  }

}
else{
    
header("location:/unsubscribe");
die();
}


