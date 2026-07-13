<?php

if($_SERVER["REQUEST_METHOD"] =="POST"){
 
  $root = $_SERVER["DOCUMENT_ROOT"];
 require $root.'/page_init.php';

 $data = json_decode(file_get_contents('php://input'), true);

 $btn = trim($data["submit_button_name"]);
 $email = trim(htmlspecialchars($data["user_email"],ENT_QUOTES,'UTF-8'));
 $psw = trim($data["user_psw"]);
 $rememberme = trim($data["rememberme"]);

 if($btn == "npa_staff_login"){
    
   if(empty($email)){
    
 $response = [
      "stat" => "failed",
      "err" => "em",
      "message" => "Please enter your email",
      ];
echo json_encode($response);
exit();    
       
   }
  elseif(empty($psw)){
    $response = [
      "stat" => "failed",
      "err" => "psw",
      "message" => "Please enter your your password",
      ];
echo json_encode($response);
exit();     
      
      
  }
  else{
  
  $row = collect_user_data($conn,'staffs','email',$email,'s');

    if(!$row){
   
       $response = [
      "stat" => "failed",
      "err" => "em",
      "message" => "Invalid User Email !",
      ];
echo json_encode($response);
exit(); 
        
    }
  
  elseif($row["status"] != "Active"){
      
        $response = [
      "stat" => "failed",
      "err" => "em",
      "message" => "Your account is not active !, please visit the school's ICT unit to tender this complain.",
      ];
echo json_encode($response);
exit();    
      
  } 
    
    else{
        
  $staff_id = $row["staff_id"];
  $staff_cat= $row["staff_cat"];
  $password = $row["login_psw"];
  $act = $row['status'];       
        
   $pswcheck = password_verify($psw, $password);    
          
    if(!$pswcheck){
    
       $response = [
      "stat" => "failed",
      "err" => "psw",
      "message" => "Incorrect password !",
      ];
echo json_encode($response);
exit();     
        
    }
    else{
 
  // you may now login      
    
 //set a cookie
 if($rememberme){
  
   $exp = time()+((60*60*24)*30);
   $token_key = $row['surname'].time();
   $token_value = "#001/SALts/".time()."/001#/".$row['surname'];
 
  $token_hash = password_hash($token_value,PASSWORD_DEFAULT);
   
  setcookie('staff_cookie',$token_key.':'.':'.$token_value,$exp,'/');  
 
  //save cookie to db
 
update_user_data($conn,'staffs','token_key','staff_id',$token_key,$staff_id,'si');

update_user_data($conn,'staffs','token_value','staff_id',$token_hash,$staff_id,'si');
 }
 
 
 date_default_timezone_set('Africa/Lagos');
 $day = date("d/m/Y h:i A");
 update_user_data($conn,'staffs','lastlogin','staff_id',$day,$staff_id,'si'); 
  
 
 $_SESSION['staff_id'] = $staff_id;           
 $_SESSION['staff_cat'] = $staff_cat;           
 
 $response = [
      "stat" => "success",
      "err" => "none",
      "message" => "Login Successful !",
      ];
echo json_encode($response);
exit();         
        
    }
     
    }
   
      
  }
     
 }
  else{
  
   $response = [
      "stat" => "failed",
      "err" => "button_name",
      "message" => "Unknown button name",
      ];
echo json_encode($response);
exit();
     
  }


}
else{
    
  $response = [
     "stat" => "failed",
     "err" => "REQUEST_METHOD",
     "message" => "Unknown Request method",
      ];
echo json_encode($response);
exit();   
    
    
}


