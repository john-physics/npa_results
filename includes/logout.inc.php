<?php
if($_SERVER['REQUEST_METHOD']=="POST"){
    
  require $_SERVER['DOCUMENT_ROOT'].'/start_session.php';
  
  $data = json_decode(file_get_contents('php://input'), true);

 $btn = $data["submit_button_name"];
 
 if($btn == "npa_staff_logout"){
     
  if(isset($_SESSION['staff_id'])){
      
  unset($_SESSION['staff_id']);
  session_destroy();
  
 if(isset($_COOKIE['staff_cookie'])){
     
  $exp = time() - 100;
  $val = "staff";
  setcookie('staff_cookie',$val,$exp,'/');   
     
 }
 
  $response = [
      "stat" => "success",
      "err" => "No error",
      "message" => "Logout successful !",
      ];
echo json_encode($response);
exit();   
     
  }
  else{
      
      $response = [
      "stat" => "failed",
      "err" => "btn_error",
      "message" => "Staff Not Logged in initially",
      ];
echo json_encode($response);
exit();   
      
      
  }
 }
 
  elseif($btn == "admin_logout"){
     
  if(isset($_SESSION['admin_id'])){
      
  unset($_SESSION['admin_id']);
  session_destroy();
  
 if(isset($_COOKIE['admin_cookie'])){
     
  $exp = time() - 100;
  $val = "adm";
  setcookie('admin_cookie',$val,$exp,'/');   
     
 }
 
  $response = [
      "stat" => "success",
      "err" => "No error",
      "message" => "Logout successful !",
      ];
echo json_encode($response);
exit();   
     
  }
  else{
      
      $response = [
      "stat" => "failed",
      "err" => "btn_error",
      "message" => "Admin Not Logged in initially",
      ];
echo json_encode($response);
exit();   
      
      
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