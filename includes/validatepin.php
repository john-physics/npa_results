<?php
if($_SERVER["REQUEST_METHOD"] =="POST"){
 
  $root = $_SERVER["DOCUMENT_ROOT"];
 require $root.'/page_init.php';

 $btn = trim($_POST["submit_button_name"]);
 $pin = trim($_POST["std_pin"]);
 $view_class = trim($_POST["view_class"]);
 $session = trim($_POST["session"]);

if($btn == "check_pin"){
 
 if(!$pin){
  
    $response = [
      
     "status" => "failed",
     "error" => "Empty Input",
     "message" =>"Please enter your PIN",
     "pin" => "unverified"
      ]; 
    
  echo json_encode($response);
exit();      
     
 }
 
  elseif(!$view_class){
  
    $response = [
      
     "status" => "failed",
     "error" => "Empty Input",
     "message" =>"Please select student's class",
     "pin" => "unverified"
      ]; 
    
  echo json_encode($response);
exit();      
     
 }
  elseif(!$session){
  
    $response = [
      
     "status" => "failed",
     "error" => "Empty Input",
     "message" =>"Please select exam year",
     "pin" => "unverified"
      ]; 
    
  echo json_encode($response);
exit();      
     
 }
 elseif(!preg_match('/^[A-Za-z0-9]{8}$|^[A-Za-z0-9]{10}$/', $pin)) {
   
    $response = [
      
     "status" => "failed",
     "error" => "Pin format",
     "message" =>"Invalid PIN format",
     "pin" => "unverified"
      ]; 
    
  echo json_encode($response);
exit();          
     
 }
 elseif(check_exist($conn,"students","std_pin",$pin,"s")){
    
  //coherency check   
 $std_details = collect_user_data($conn,"students","std_pin",$pin,"s");
 $std_id = $std_details["std_id"];
 $current_class = null_check($std_details["current_class"],"Unknown");    
  
 if($view_class == $current_class){
     
    $response = [
     "status" => "success",
     "error" => "None",
     "message" =>"PIN verified",
     "pin" => "valid"
      ]; 
    
  echo json_encode($response);
  exit();     
     
 }
  else{
 //match std previous classes using result db
 $resultTable = form_table_name("results_",$session);
 if(check_exist2($conn,$resultTable,"std_id","class",$std_id,$view_class,"is")){
     
       $response = [
     "status" => "success",
     "error" => "None",
     "message" =>"PIN verified",
     "pin" => "valid"
      ]; 
    
  echo json_encode($response);
  exit();    
     
 }
 
 else{
  
       $response = [
     "status" => "failed",
     "error" => "coherency",
     "message" =>"Incoherent student's details",
     "pin" => "invalid"
      ]; 
    
  echo json_encode($response);
exit();     
     
   } 
  }
 }
  else{
    
     $response = [
     "status" => "failed",
     "error" => "Validility",
     "message" =>"Invalid PIN",
     "pin" => "invalid"
      ]; 
    
  echo json_encode($response);
exit();      
      
  }  
}
else{
    
  $response = [
      
     "status" => "failed",
     "error" => "Button Name",
     "message" =>"Unrecognized button name",
     "pin" => "unverified"
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