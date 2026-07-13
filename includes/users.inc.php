<?php

if($_SERVER["REQUEST_METHOD"] =="POST"){
 
 require  $_SERVER["DOCUMENT_ROOT"].'/page_init.php';

 $data = json_decode(file_get_contents('php://input'), true);

  $btn = trim($data["submit_button_name"]);

if(isset($_SESSION["staff_id"])){
    
 $userId= $_SESSION["staff_id"];
 $userCat = $_SESSION["staff_cat"];

$staff_det = get_user_name($userId); 
$staff_name = $staff_det["fullname_title"];
 
}
else{
    
     $response = [
     "status" => "failed",
     "error" => "user_login",
     "message" => "Please login to continue !",
      ];
echo json_encode($response);
exit();      
     
 }
 

 if(in_array($userCat,$authorized)){
 
 if($btn == "search_users"){
 
 $searchBy= trim($data["search_by"]);
$searchValue = trim($data["search_value"]);
 
 $results = [];
  if($searchBy && $searchValue){
  
  if($searchBy == "Email"){
 $searchs = search_users($conn, "staffs", ["email"], $searchValue);   
 
   if($searchs){
   foreach ($searchs as $search){
       
    $fullname = $search["title"]." ".$search["surname"]." ".$search["othernames"];
    $email = $search["email"];
    $Id = $search["staff_id"];
    $cat = $search["staff_cat"];
  $lastlogin= null_check(timeAgo($search["lastlogin"],'d/m/Y h:i A'),"Lastlogin: Unknown");
    
   $result = [
       "fullname" => $fullname,
       "user_cat" =>$cat,
       "user_id" => $Id,
       "email" =>$email,
       "lastlogin" =>$lastlogin,
        "pin" => $Id
       
       ];
   
   $results[] = $result; 
       
   }

  }  
 
  $response = [
     "status" => "success",
     "error" => "none",
     "message" => "Search completed",
     "results" => $results,
     
      ];
echo json_encode($response);
exit();    
      
  }
  
 elseif($searchBy == "Class"){
   
  $searchs = search_users($conn, "students", ["current_class"], $searchValue);   
   if($searchs){
   foreach ($searchs as $search){
       
    $fullname = $search["surname"]." ".$search["othernames"];
    $email = null_check($search["parent_number"],'No Contact');
    $Id = $search["std_id"];
    $cat = "Student";
   $lastlogin = "Class: ".null_check($search["current_class"],'Unknown');
    $pin = $search["std_pin"];
  
   $result = [
       "fullname" => $fullname,
       "user_cat" =>$cat,
       "user_id" => $Id,
       "email" =>$email,
       "lastlogin" =>$lastlogin,
        "pin" => $pin
       
       ];
   
   $results[] = $result; 
       
   }

  }  
 

  $response = [
     "status" => "success",
     "error" => "none",
     "message" => "Search completed",
     "results" => $results,
     
      ];
echo json_encode($response);
exit();    
      
  }
  
 elseif($searchBy == "Name"){
     
  $searchs = search_users($conn, "staffs", ["surname","othernames"], $searchValue);   
 
   if($searchs){
   foreach ($searchs as $search){
       
    $fullname = $search["title"]." ".$search["surname"]." ".$search["othernames"];
    $email = $search["email"];
    $Id = $search["staff_id"];
    $cat = $search["staff_cat"];
  $lastlogin= null_check(timeAgo($search["lastlogin"],'d/m/Y h:i A'),"Lastlogin: Unknown");
    
   $result = [
       "fullname" => $fullname,
       "user_cat" =>$cat,
       "user_id" => $Id,
       "email" =>$email,
       "lastlogin" =>$lastlogin,
         "pin" => $Id
       
       ];
   
   $results[] = $result; 
       
   }

  }  
 
  $searchs2 = search_users($conn, "students", ["surname","othernames"], $searchValue);   
   if($searchs2){
   foreach ($searchs2 as $search){
       
    $fullname = $search["surname"]." ".$search["othernames"];
    $email = null_check($search["parent_number"],'No Contact');
    $Id = $search["std_id"];
    $cat = "Student";
   $lastlogin = "Class: ".null_check($search["current_class"],'Unknown');
    $pin = $search["std_pin"];
  
   $result = [
       "fullname" => $fullname,
       "user_cat" =>$cat,
       "user_id" => $Id,
       "email" =>$email,
       "lastlogin" =>$lastlogin,
        "pin" => $pin
       
       ];
   
   $results[] = $result; 
       
   }

  }    
    
  $response = [
     "status" => "success",
     "error" => "none",
     "message" => "Search completed",
     "results" => $results,
     
      ];
echo json_encode($response);
exit();    
   
     
 }
 
 elseif($searchBy == "Id"){
 
   $searchs = search_users($conn, "staffs", ["staff_id"], $searchValue);   
 
   if($searchs){
   foreach ($searchs as $search){
       
    $fullname = $search["title"]." ".$search["surname"]." ".$search["othernames"];
    $email = $search["email"];
    $Id = $search["staff_id"];
    $cat = $search["staff_cat"];
  $lastlogin= null_check(timeAgo($search["lastlogin"],'d/m/Y h:i A'),"Lastlogin: Unknown");
    
   $result = [
       "fullname" => $fullname,
       "user_cat" =>$cat,
       "user_id" => $Id,
       "email" =>$email,
       "lastlogin" =>$lastlogin,
         "pin" => $Id
       
       ];
   
   $results[] = $result; 
       
   }

  }  
 
  
 $searchs2 = search_users($conn, "students", ["std_id"], $searchValue);   
   if($searchs2){
   foreach ($searchs2 as $search){
       
    $fullname = $search["surname"]." ".$search["othernames"];
    $email = null_check($search["parent_number"],'No Contact');
    $Id = $search["std_id"];
    $cat = "Student";
   $lastlogin = "Class: ".null_check($search["current_class"],'Unknown');
    $pin = $search["std_pin"];
  
   $result = [
       "fullname" => $fullname,
       "user_cat" =>$cat,
       "user_id" => $Id,
       "email" =>$email,
       "lastlogin" =>$lastlogin,
        "pin" => $pin
       
       ];
   
   $results[] = $result; 
       
   }

  }      
  
    
  $response = [
     "status" => "success",
     "error" => "none",
     "message" => "Search completed",
     "results" => $results,
     
      ];
echo json_encode($response);
exit();    
   
     
 }
 
  elseif($searchBy == "PIN"){
      
   $searchs = search_users($conn, "students", ["std_pin"], $searchValue);   
   if($searchs){
   foreach ($searchs as $search){
       
    $fullname = $search["surname"]." ".$search["othernames"];
    $email = null_check($search["parent_number"],'No Contact');
    $Id = $search["std_id"];
    $cat = "Student";
   $lastlogin = "Class: ".null_check($search["current_class"],'Unknown');
    $pin = $search["std_pin"];
  
   $result = [
       "fullname" => $fullname,
       "user_cat" =>$cat,
       "user_id" => $Id,
       "email" =>$email,
       "lastlogin" =>$lastlogin,
        "pin" => $pin
       
       ];
   
   $results[] = $result; 
       
   }

  } 
    
  $response = [
     "status" => "success",
     "error" => "none",
     "message" => "Search completed",
     "results" => $results,
     
      ];
echo json_encode($response);
exit();    
   
 }
else{
    
 $response = [
     "status" => "failed",
     "error" => "Search By",
     "message" => "Unrecognized search key !",
      ];
echo json_encode($response);
exit();    
         
    
   }  
  }   
  else{
   
   $response = [
     "status" => "failed",
     "error" => "Empty request",
     "message" => "No Input data to search !",
      ];
echo json_encode($response);
exit();    
      
  }       

 }

elseif($btn == "del-this-user"){
   
$user = convert_to_array($data["user_id"]);
$user_id = $user[0];
$user_cat = $user[1];
$user_type = trim($data["user_type"]);
 
 if(!$user_id || !$user_cat || !$user_type){
     
  $response = [
     "status" => "failed",
     "error" => "Empty Input",
     "message" => "user details not complete !",
      ];
echo json_encode($response);
exit();   
       
 }

elseif(!$authorized){
 
  $response = [
     "status" => "failed",
     "error" => "Missing files",
     "message" => "Sorry some important constant files are missing and hence your request cannot be executed !",
      ];
echo json_encode($response);
exit();    
    
}
 
 elseif(in_array($user_cat,$authorized)){
     
   $response = [
     "status" => "failed",
     "error" => "Permission Denied",
     "message" => "The selected $user_type cannot be removed from this site !",
      ];
echo json_encode($response);
exit();    
     
 }
 elseif(in_array($userCat,$authorized)){
  
 $switch = switch_user($user_cat);
 $conn = $switch["conn"];
 $table = $switch["table"];
 $idcol = $switch["id_col"];
 $userdet = collect_user_data($conn,$table,$idcol,$user_id,"i");

if($table == "students" && student_have_results($conn,$user_id)){
  // no deleting of stds that has results
    $response = [
     "status" => "failed",
     "error" => "Permission Denied",
     "message" => "The selected student already have results and hence cannot be removed. Unless the rules are changed",
      ];
echo json_encode($response);
exit();      
    
}

if($table == "staffs"){  
// no deleting of staffs with Class 
 $classhandling = null_check($userdet["class_handling"],""); 
  $heshe = strtolower(null_check(switch_gender($userdet["gender"],"pronoun"),"he/she"));
  
  if($classhandling){
  
    $response = [
     "status" => "failed",
     "error" => "Permission Denied",
     "message" => "The selected staff is currently handling $classhandling  and hence cannot be removed unless $heshe is replaced.",
      ];
echo json_encode($response);
exit();       
      
  }
}


if(delete_user_data($conn,$table,$idcol,$user_id,"i")){
 $action ="Removed $user_cat";
 $action_reason ="Not specified";
 $records = 1;
 $current = get_current_session();
  $session = trim($current['session']);
  $term = trim($current['term']);
  $backup = $user_id;
  
 $logAction = log_admin_action($conn,$userId,$staff_name,$action,$action_reason, $records,$session,$term,$backup);
  
if(in_array($user_cat,$staffCats)){
   
 $profile = $userdet["profile"]; 
 $signature = $userdet["signature"]; 
 
 $prf_dir = $_SERVER["DOCUMENT_ROOT"]."/images/staff/$profile";
 $sign_dir = $_SERVER["DOCUMENT_ROOT"]."/images/staff/$signature";

}
else{
 
$profile = $userdet["profile"]; 
$prf_dir = $_SERVER["DOCUMENT_ROOT"]."/images/students/$profile";
    
}



if(is_file($prf_dir)){
    
 unlink($prf_dir);  
    
}

if(is_file($sign_dir)){
    
 unlink($sign_dir);  
    
}



  $response = [
     "status" => "success",
     "error" => "none",
     "message" => "$user_type removed successfully ✓",
      ];
echo json_encode($response);
exit();     
      
  }   
   else{
      
   $response = [
     "status" => "failed",
     "error" => "SQL Errors",
     "message" => "Unable to remove user due to sql errors !",
      ];
echo json_encode($response);
exit();     
       
       
   }  
     
 }
 else{
     
   $response = [
     "status" => "failed",
     "error" => "Permission Denied",
     "message" => "Unauthorized user attempts !",
      ];
echo json_encode($response);
exit();     
     
     
 }
}

elseif($btn == "suspend-user"){
   
$user = convert_to_array($data["user_id"]);
$user_id = $user[0];
$user_cat = $user[1];
 $user_type = trim($data["user_type"]);
 $reason =  trim($data["suspend_reason"]);


 if(!$user_id || !$user_cat || !$user_type){
     
  $response = [
     "status" => "failed",
     "error" => "Empty Input",
     "message" => "user details not complete !",
      ];
echo json_encode($response);
exit();   
       
 }
 
  elseif(!$reason){
     
  $response = [
     "status" => "failed",
     "error" => "Empty Input",
     "message" => "Suspension reason is required !",
      ];
echo json_encode($response);
exit();   
       
 }

elseif(!$authorized){
 
  $response = [
     "status" => "failed",
     "error" => "Missing files",
     "message" => "Sorry some important constant files are missing and hence your request cannot be executed !",
      ];
echo json_encode($response);
exit();    
    
}
 
 elseif(in_array($user_cat,$authorized)){
     
   $response = [
     "status" => "failed",
     "error" => "Permission Denied",
     "message" => "The selected $user_type cannot be suspended from this site !",
      ];
echo json_encode($response);
exit();    
     
 }
 elseif(in_array($userCat,$authorized)){
  
  $switch = switch_user($user_cat);
 $conn = $switch["conn"];
 $table = $switch["table"];
 $idcol = $switch["id_col"];
 $userdet = collect_user_data($conn,$table,$idcol,$user_id,"i");
$iniStatus = $userdet["status"];
 
 if($table == "staffs"){  
// no deleting of staffs with Class 
 $classhandling = null_check($userdet["class_handling"],""); 
  $heshe = strtolower(null_check(switch_gender($userdet["gender"],"pronoun"),"he/she"));
  
  if($classhandling){
  
    $response = [
     "status" => "failed",
     "error" => "Permission Denied",
     "message" => "The selected staff is currently handling $classhandling  and hence cannot be suspended unless $heshe is replaced.",
      ];
echo json_encode($response);
exit();       
      
  }
}
 
 
 if($iniStatus !== "Suspended"){
     
   if(update_user_data($conn,$table,"status",$idcol,"Suspended",$user_id,"si")){
  
   update_user_data($conn,$table,"status_reason",$idcol,$reason,$user_id,"si");

$action ="Suspended $user_cat";
 $action_reason = $reason;
 $records = 1;
 $current = get_current_session();
  $session = trim($current['session']);
  $term = trim($current['term']);
  $backup = $user_id;
  
 $logAction = log_admin_action($conn,$userId,$staff_name,$action,$action_reason, $records,$session,$term,$backup);
  

   $response = [
     "status" => "success",
     "error" => "none",
     "message" => "$user_type Suspended successfully ✓",
      ];
echo json_encode($response);
exit();     
      
  }   

  else{
      
   $response = [
     "status" => "failed",
     "error" => "SQL Errors",
     "message" => "Unable to suspend $user_type due to sql errors !",
      ];
echo json_encode($response);
exit();     
       
       
   }
   
 }
 else{
     
  $response = [
     "status" => "failed",
     "error" => "Mis-conception",
     "message" => "The selected $user_type was already Suspended !",
      ];
echo json_encode($response);
exit();     
     
 }
     
 }
 else{
     
   $response = [
     "status" => "failed",
     "error" => "Permission Denied",
     "message" => "Unauthorized user attempts !",
      ];
echo json_encode($response);
exit();     
     
     
 }
}

elseif($btn == "un-suspend-user"){
   
$user = convert_to_array($data["user_id"]);
$user_id = $user[0];
$user_cat = $user[1];
 $user_type = trim($data["user_type"]);
 $reason = trim($data["unsuspend_reason"]);

 if(!$user_id || !$user_cat || !$user_type){
     
  $response = [
     "status" => "failed",
     "error" => "Empty Input",
     "message" => "user details not complete !",
      ];
echo json_encode($response);
exit();   
       
 }
 
 elseif(in_array($userCat,$authorized)){
  
  $switch = switch_user($user_cat);
 $conn = $switch["conn"];
 $table = $switch["table"];
 $idcol = $switch["id_col"];
 $userdet = collect_user_data($conn,$table,$idcol,$user_id,"i");
$iniStatus = $userdet["status"];
 
 if($iniStatus == "Suspended"){
  
   if(update_user_data($conn,$table,"status",$idcol,"Active",$user_id,"si")){
 
  update_user_data($conn,$table,"status_reason",$idcol,$reason,$user_id,"si");
 
 $action ="Unsuspended $user_cat";
 $action_reason = $reason;
 $records = 1;
 $current = get_current_session();
  $session = trim($current['session']);
  $term = trim($current['term']);
  $backup = $user_id;
  
 $logAction = log_admin_action($conn,$userId,$staff_name,$action,$action_reason, $records,$session,$term,$backup);
  
   $response = [
     "status" => "success",
     "error" => "none",
     "message" => "Suspension removed successfully ✓",
      ];
echo json_encode($response);
exit();     
      
  }   
   else{
      
   $response = [
     "status" => "failed",
     "error" => "SQL Errors",
     "message" => "Unable to unsuspend the selected $user_type due to sql errors !",
      ];
echo json_encode($response);
exit();     
       
      
   }     
    
 }

else{
    
  $response = [
     "status" => "failed",
     "error" => "Mis-conception",
     "message" => "The selected $user_type was not under Suspension !",
      ];
echo json_encode($response);
exit();     
       
    
  }
 }
 else{
     
   $response = [
     "status" => "failed",
     "error" => "Permission Denied",
     "message" => "Unauthorized user attempts !",
      ];
echo json_encode($response);
exit();     
     
     
 }
}

elseif($btn == "regenerate-result-pin"){
    
 $std_Id = trim($data["std_id"]);

 if(check_exist($conn,"students","std_id",$std_Id,"i")){
     
  $pin =  generatePin(8);
 $limit = 1000;
 while($limit && check_exist($conn,"students","std_pin",$pin,"s")){
  //ensures a uniq student pin   
 $pin =  generatePin(8); 
 $limit--;
     
 }

if(!$limit){
 //Unable to generate uniq student pin    
 $pin=strtoupper(bin2hex(random_bytes(5))); // 10 chars 
}
     
 
 if(update_user_data($conn,"students","std_pin","std_id",$pin,$std_Id,"si")){
  
  $action ="Regenerated result pin";
 $action_reason ="Not specified";
 $records = 1;
 $current = get_current_session();
  $session = trim($current['session']);
  $term = trim($current['term']);
  $backup = $std_Id.':'.$pin;
  
 $logAction = log_admin_action($conn,$userId,$staff_name,$action,$action_reason, $records,$session,$term,$backup);
  
  $response = [
     "status" => "success",
     "error" => "None",
     "message" => "PIN updated successfully",
     "new_pin" => $pin,
      ];
echo json_encode($response);
exit();      
     
 }
 else{
   
   $response = [
     "status" => "failed",
     "error" => "SQL Error",
     "message" => "Unable to update pin, please try again.",
      ];
echo json_encode($response);
exit();     
     
  } 
 }
else{
    
      $response = [
     "status" => "failed",
     "error" => "Invalid Entry",
     "message" => "Invalid student Id",
      ];
echo json_encode($response);
exit();    
    
 }
}

elseif($btn =="remove-class"){
  
  $class = trim($data["class_name"]);
  $type = "Class";
  if(check_exist2($conn,"variables","type","value",$type,$class,"ss")){
      
  if(variable_contain_results($conn,$class,$type)){
   
    $response = [
    "status"  => "failed",
    "error"   => "Removal blocked",
    "message" => "The class '{$class}' cannot be removed because results have already been uploaded for it."
];

echo json_encode($response);
exit();
      
  }
  
  if(delete_user_data2($conn,"variables","type","value",$type,$class,"ss")){
       
$action ="Removed a class";
 $action_reason ="Not specified";
 $records = 1;
 $current = get_current_session();
  $session = trim($current['session']);
  $term = trim($current['term']);
  $backup = $class;
  
 $logAction = log_admin_action($conn,$userId,$staff_name,$action,$action_reason, $records,$session,$term,$backup);
  
   $response = [
     "status" => "success",
     "error" => "None",
     "message" => "$class removed successfully",
      ];
echo json_encode($response);
exit();   
   
   }   
   else{
       
   $response = [
     "status" => "failed",
     "error" => "SQL Error",
     "message" => "Unable to remove class due to sql errors",
      ];
echo json_encode($response);
exit();       
       
   }   
  }
  else{
      $response = [
     "status" => "failed",
     "error" => "Invalid Data",
     "message" => "Invalid class name",
      ];
echo json_encode($response);
exit();       
     
  }
}

elseif($btn =="remove-subj"){
  
  $subj = trim($data["subj_name"]);
  $type = "Subject";
  
  if(check_exist2($conn,"variables","type","value",$type,$subj,"ss")){
   
 $det = collect_user_data2($conn,"variables","type","variables",$type,$subj,"ss");
 $subjId = $det["id"];
  
 if(variable_contain_results($conn,$subj,$type)){
    $response = [
    "status"  => "failed",
    "error"   => "Removal blocked",
    "message" => "The subject '{$subj}' cannot be removed because results have already been uploaded for it."
];

echo json_encode($response);
exit();
      
  }
      
 if(delete_user_data2($conn,"variables","type","value",$type,$subj,"ss")){
   
  $action ="Removed a subject";
 $action_reason ="Not specified";
 $records = 1;
 $current = get_current_session();
  $session = trim($current['session']);
  $term = trim($current['term']);
  $backup = $subjId.':'.$subj;
  
 $logAction = log_admin_action($conn,$userId,$staff_name,$action,$action_reason, $records,$session,$term,$backup);
      
   
   $response = [
     "status" => "success",
     "error" => "None",
     "message" => "$subj removed successfully",
      ];
echo json_encode($response);
exit();   
   
   }   
   else{
       
   $response = [
     "status" => "failed",
     "error" => "SQL Error",
     "message" => "Unable to remove subject due to sql errors",
      ];
echo json_encode($response);
exit();       
       
   }   
  }
  else{
      $response = [
     "status" => "failed",
     "error" => "Invalid Data",
     "message" => "Invalid subject name",
      ];
echo json_encode($response);
exit();       
     
  }
}


//more btns can goes here
 
else{
 
    $response = [
     "status" => "failed",
     "error" => "Button Error",
     "message" => "Unrecognized button name!",
      ];
echo json_encode($response);
exit();   
    
  } 
 }
 
 else{
     
  $response = [
     "status" => "failed",
     "error" => "Authorization",
     "message" => "Unauthorized user attempts !",
      ];
echo json_encode($response);
exit();     
     
 }
}
else{
    
  $response = [
     "status" => "failed",
     "error" => "REQUEST_METHOD",
     "message" => "Unauthorized request method !",
      ];
echo json_encode($response);
exit();      
     
 
    
}