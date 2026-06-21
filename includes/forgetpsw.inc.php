<?php

if($_SERVER["REQUEST_METHOD"]=="POST"){
 
  $root = $_SERVER["DOCUMENT_ROOT"];
 require $root.'/page_init.php';
require $root.'/send_email.php';
 
 $data = json_decode(file_get_contents('php://input'), true);

 $btn = trim(htmlspecialchars($data["submit_button_name"],ENT_QUOTES,'UTF-8'));
 $email = trim(htmlspecialchars($data["user_email"],ENT_QUOTES,'UTF-8'));
 $user = trim(htmlspecialchars($data["user_cat"],ENT_QUOTES,'UTF-8'));



  if($user == "staff"){
     
  $table = "staffs"; 
  $id_col = "staff_id";
  $cat_col ="staff_cat";
  $col1 = "email";
  $col2 = "status";
 
 } 
 else{
 //for now there is only 1 user cat 

  $table = "students"; 
  $id_col = "std_id";
  $cat_col ="std_cat";
  $col1 = "email";
  $col2 = "status";
     
  }
 
 if($btn == "forgot_psw_submitEmail"){
  
  if(empty($email)){
    
 $response = [
      "status" => "failed",
      "error" => "em",
      "message" => "Please enter your Email Address",
      ];
echo json_encode($response);
exit();    
       
   }
  else{
  
  $row = collect_user_data($conn,$table,$col1,$email,'s');
  
  $user_id = $row[$id_col];
  $act = $row[$col2];
  $userCat = $row[$cat_col];
  $name = $row["surname"]."\n".$row["othernames"];
   
   if(empty($user_id)){
   
       $response = [
      "status" => "failed",
      "error" => "em",
      "message" => "Invalid ".ucwords($user)." Email !",
      ];
echo json_encode($response);
exit(); 
        
    }
    
  elseif($act != "Active"){
      
        $response = [
      "status" => "failed",
      "error" => "inactive",
      "message" => "Your account is not Active !, please check your email for a confirmation message from us and confirm your email to activate your account or send us a feed back using this email $email"
      ];
echo json_encode($response);
exit();    
      
  } 
    else{
    
// generate a token and send by email
$token = generate_id(7);
 date_default_timezone_set("Africa/Lagos");
$todayDate = date("d/m/Y h:i A");
$valid = 10;
$exp = time()+(30*$valid);//10 mins

if($token){
    
 $token_hash = password_hash($token, PASSWORD_DEFAULT);
 
 if($token_hash){
  //delete all previous data for this user from forget psw db if any
  
 delete_user_data3($conn,"password_reset","user_id","user_email","user_cat",$user_id,$email,$userCat,"iss");   
   $ins = [
     "conn" => $conn,
    "table" => "password_reset",
     "cols" => ['user_id','user_email','user_cat','token_hash','expiration','timestamp'],
     "vals" => [$user_id,$email,$userCat,$token_hash,$exp,$todayDate],
     "params" => "isssss"
     
     ]; 
  
  $insert = insert_user_data($ins);
  
  $status = $insert["status"];
  $error = $insert["error"];
  $msg = $insert["message"];
  
 if($status == "success"){
 
 $send = sendPswToken($config,$email,$name,$token,$valid,$site,$rurl);  
 
 if($send["status"] =="success"){
  
  $_SESSION["token_report"] = "sent";
  $_SESSION["token_valid"] = $valid;
  $_SESSION["user_email"] = $email;
  $_SESSION["user_cat"] = $userCat;
  $_SESSION["reset_id"] = $user_id;
   
 //  $_SESSION["token"] = $token;
     
    $response = [
     "status" => "success",
     "error" => "none",
     "message" => $send["message"],
      ];
echo json_encode($response);
exit(); 
  
  
  } 
   else{
       
   $response = [
     "status" => "failed",
     "error" => "smtp_error",
     "message" => $send["message"],
      ];
echo json_encode($response);
exit();      
       
   }  
 }
 else{
  
   $response = [
     "status" => "failed",
     "error" => "sql_error",
     "message" => "Unable to save password reset token in the database, if this error persist please consult the help center",
      ];
echo json_encode($response);
exit();         
     
 }
     
 }
 else{
     
    $response = [
     "status" => "failed",
     "error" => "token_hash",
     "message" => "Unable to hash password reset token, if this error persist please consult the ICT unit for help",
      ];
echo json_encode($response);
exit();       
     
 }
    
}
else{
    
   $response = [
     "status" => "failed",
     "error" => "token_generation",
     "message" => "Unable to generate password reset token, if this error persist please consult the ICT unit for help",
      ];
echo json_encode($response);
exit();     
    
  }

     
 }
   
  }
 }
 elseif($btn == "forgot_psw_submitToken"){
   
  $token = $email;
  $user_email = $_SESSION["user_email"];
  $userCat = $_SESSION["user_cat"];
  $reset_id = $_SESSION["reset_id"];
 
  if(!$token){
      
     $response = [
     "status" => "failed",
     "error" => "empty_token",
     "message" => "Please enter the password reset token that was sent to your email",
      ];
echo json_encode($response);
exit();    
      
  }
  
  elseif(!is_numeric($token)){
    
        $response = [
     "status" => "failed",
     "error" => "Invalid_token",
     "message" => "Invalid token",
      ];
echo json_encode($response);
exit();  
      
  }
  
 elseif(!$user_email || !$reset_id){
     
     $response = [
     "status" => "failed",
     "error" => "SESSION_ERROR",
     "message" => "Something went wrong, please click the cancel button (x) above and start afresh",
      ];
echo json_encode($response);
exit();     
     
 }
 else{
     
//limit token submit attempts
 if(isset($_SESSION["t-s-a"])){
     
  $_SESSION["t-s-a"]++;
  $currentAttempt = $_SESSION["t-s-a"];
 
 }
 else{
  $currentAttempt = 1;
  $_SESSION["t-s-a"] = $currentAttempt;
  
 }
 
 $maxAttempts = 4; //maximum attempts
 
 if($currentAttempt >= $maxAttempts || isset($_COOKIE["t-s-a"])){
  
  if(!isset($_COOKIE["t-s-a"])){
      
 $cookieExp = time()+(60*60*24*7); //1 week

  setcookie("t-s-a",$currentAttempt,$cookieExp,"/");  
 
  }
     
    $response = [
     "status" => "failed",
     "error" => "max_attempt",
     "message" => "Sorry you have exceeded your maximum token submit attempts and hence your password cannot be resetted at this time, please try again later.",
      ];
echo json_encode($response);
exit();  
     
 }
 
     
 //get details of the token from database
  $token_det =  collect_user_data3($conn,'password_reset','user_id','user_email','user_cat',$reset_id,$user_email,$userCat,'iss');  
   
  $token_hash = $token_det["token_hash"];
  $valid = $token_det["expiration"];
  $time = time();
  
 
  if(!password_verify($token,$token_hash)){
      
     $response = [
     "status" => "failed",
     "error" => "invalid_token",
     "message" => "Invalid token",
      ];
echo json_encode($response);
exit();     
      
  }
 elseif($time >= $valid){
     
      $response = [
     "status" => "failed",
     "error" => "expired_token",
     "message" => "Token already expired, click on the cancel button (x) above to start afresh",
      ];
echo json_encode($response);
exit();   
     
 }
 else{
//token is valid and not expired 
$_SESSION["token_report"] = "verified";

      $response = [
     "status" => "success",
     "error" => "valid_token",
     "message" => "Token verified successfully",
      ];
echo json_encode($response);
exit();   
     
     
   } 
      
 }  
     
}

elseif($btn == "forgotpswSubmitNewpsw"){
    
 $new_psw = trim($data["new_psw"]);
 $con_new_psw = trim($data["con_new_psw"]);
 $user_email = $_SESSION["user_email"];
 $userCat = $_SESSION["user_cat"];
 $reset_id = $_SESSION["reset_id"];
 
 $passwordRegex = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&_#])[A-Za-z\d@$!%*?&_#]{8,}$/';
    
  if(!$new_psw) {
      
      $response = [
     "status" => "failed",
     "error" => "empty_new_psw",
     "message" => "New password must not be empty",
      ];
echo json_encode($response);
exit();   
      
  }
 elseif(!$con_new_psw){
     
      $response = [
     "status" => "failed",
     "error" => "empty_con_new_psw",
     "message" => "Confirm password must not be empty",
      ];
echo json_encode($response);
exit();   
     
 }
  elseif($new_psw != $con_new_psw){
     
      $response = [
     "status" => "failed",
     "error" => "psw_mis_match",
     "message" => "Your Passwords do not match !",
      ];
echo json_encode($response);
exit();   
     
 }
  elseif(!preg_match($passwordRegex, $new_psw)){
      
      $response = [
      "status" => "failed",
      "error" => "new_psw",
      "message" => "Weak Password ! (Password must be upto 8 characters and must contain atleast one special character, one upper and one lower case character)"
     
      ];
      
     echo json_encode($response);
    exit();      
 
  }
  elseif(!$user_email || !$reset_id){
     
     $response = [
     "status" => "failed",
     "error" => "SESSION_ERROR",
     "message" => "Something went wrong, please click the cancel button below and start afresh",
      ];
echo json_encode($response);
exit(); 
 
}
else{
 
 $psw_hash = password_hash($new_psw, PASSWORD_DEFAULT);
  
  if($psw_hash){
      
 if(update_user_data2($conn,$table,"login_psw",$id_col,$col1,$psw_hash,$reset_id,$user_email,"sis")){
  
 $_SESSION["token_report"] = "psw_changed";
       
   $response = [
      "status" => "success",
      "error" => "none",
      "message" => "password changed successfully", 
      ];
echo json_encode($response);
exit();          
      
  }
 
 else{
    
$_SESSION["token_report"] = "psw_not_changed";
  
    $response = [
      "status" => "failed",
      "error" => "query",
      "message" => "Error exercuting database query, please try again !",
      ];
echo json_encode($response);
exit();    
      
   }      
      
 }
 else{
 
     $response = [
      "status" => "failed",
      "error" => "psw_hash",
      "message" => "Unable to hash password, if this error persist please consult the ICT unit for help",
      ];
echo json_encode($response);
exit();     
     
  }
  
 }
}
 else{
     
   $response = [
     "status" => "failed",
     "error" => "button_name",
     "message" => "Unknown button name",
      ];
echo json_encode($response);
exit();   
     
 }
}
else{
    
  $response = [
     "status" => "failed",
     "error" => "REQUEST_METHOD",
     "message" => "Unknown Request method",
      ];
echo json_encode($response);
exit();   
    
    
}


