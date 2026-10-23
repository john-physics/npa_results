<?php
if($_SERVER['REQUEST_METHOD']=="POST"){
    
  require $_SERVER['DOCUMENT_ROOT'].'/start_session.php';
  
  $data = json_decode(file_get_contents('php://input'), true);

 $btn = $data["submit_button_name"];
 
 if($btn == "npa_staff_logout"){
     
  if(isset($_SESSION['staff_id']) && isset($_SESSION["staff_cat"])){
      
  unset($_SESSION['staff_id']);
  unset($_SESSION['staff_cat']);
 
  session_destroy();
  
 if(isset($_COOKIE['staff_cookie'])){
     
  $exp = time() - 1000;
  $val = "staff";
  setcookie('staff_cookie',$val,$exp,'/');   
 }
 
  $response = [
      "status" => "success",
      "err" => "No error",
      "message" => "Logout successful !",
      ];
echo json_encode($response);
exit();   
     
  }
  else{
      
      $response = [
      "status" => "failed",
      "err" => "btn_error",
      "message" => "Staff Not Logged in initially",
      ];
echo json_encode($response);
exit();   
      
      
  }
 }
 
 else{
     
   
   $response = [
      "status" => "failed",
      "err" => "button_name",
      "message" => "Unknown button name",
      ];
echo json_encode($response);
exit();   
     
     
 }
    
}
else{
    
  $response = [
     "status" => "failed",
     "err" => "REQUEST_METHOD",
     "message" => "Unknown Request method",
      ];
echo json_encode($response);
exit();   
      
    
}