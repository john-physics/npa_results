<?php

if($_SERVER["REQUEST_METHOD"] =="POST"){
 
  $root = $_SERVER["DOCUMENT_ROOT"];
 require $root.'/page_init.php';

 $data = json_decode(file_get_contents('php://input'), true);

 $btn = trim($data["submit_button_name"]);
 
 if($btn == "npa_staff_login"){
    
  $email = trim($data["user_email"]);
 $psw = trim($data["user_psw"]);
 $rememberme = trim($data["rememberme"]);

  
   if(empty($email)){
    
 $response = [
      "status" => "failed",
      "error" => "em",
      "message" => "Please enter your email",
      ];
echo json_encode($response);
exit();    
       
   }
  elseif(empty($psw)){
    $response = [
      "status" => "failed",
      "error" => "psw",
      "message" => "Please enter your your password",
      ];
echo json_encode($response);
exit();     
      
      
  }
  else{
  
  $row = collect_user_data($conn,'staffs','email',$email,'s');

    if(!$row){
   
       $response = [
      "status" => "failed",
      "error" => "em",
      "message" => "Invalid User Email !",
      ];
echo json_encode($response);
exit(); 
        
    }
  
  elseif($row["status"] != "Active"){
      
        $response = [
      "status" => "failed",
      "error" => "em",
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
      "status" => "failed",
      "error" => "psw",
      "message" => "Incorrect password !",
      ];
echo json_encode($response);
exit();     
        
    }
    else{
 
  // you may now login      
    
 //set cookie
 if($rememberme){
  $exp = time()+((60*60*24)*60); //2 months
   $token_key = strtolower($row['surname']).'-'.bin2hex(random_bytes(16));
   $token_value = "#001/NPA-SALts/".bin2hex(random_bytes(16))."/001#/".ucwords($row['surname']);
 
  $token_hash = password_hash($token_value,PASSWORD_DEFAULT);
   
  setcookie('staff_cookie',$token_key.'::'.$token_value,$exp,'/');  
 
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
      "status" => "success",
      "error" => "none",
      "message" => "Login Successful !",
      ];
echo json_encode($response);
exit();         
        
    }
     
    }
   
      
  }
     
 }
  elseif($btn === "check_staff_login"){
      
if(check_staff_login($conn)){

   $response = [
      "status" => "logged-in",
      "error" => "none",
      "message" => "Staff is logged in",
      "login" => true
      ];
echo json_encode($response);
exit();


} 
else{
   
  
     $response = [
      "status" => "logged-out",
      "error" => "none",
      "message" => "Staff is logged out",
      "login" => false
      ];
echo json_encode($response);
exit();  
    
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


