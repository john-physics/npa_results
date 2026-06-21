<?php

if($_SERVER["REQUEST_METHOD"] =="POST"){
 
 require  $_SERVER["DOCUMENT_ROOT"].'/page_init.php';

 $data = json_decode(file_get_contents('php://input'), true);

  $btn = trim($data["submit_button_name"]);

if(isset($_SESSION["staff_id"])){
    
 $userId= $_SESSION["staff_id"];
 $userCat = $_SESSION["staff_cat"];
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
   
 if(check_exist($conn,"staffs","email",$searchValue,"s")){
     
 $dets = collect_table_data1($conn,"staffs","email",$searchValue,"s","ASC","staff_id");
  
  foreach ($dets as $det){
  
$results[] = get_user_name($det);
    
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
   
 if(check_exist($conn,"students","current_class",$searchValue,"s")){
     
 $dets = collect_table_data1($conn,"students","current_class",$searchValue,"s","ASC","std_id");
  
  foreach ($dets as $det){
  
$results[] = get_user_name($det);
    
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
  
 elseif($searchBy == "Surname"){
     
   if(check_exist($conn,"students","surname",$searchValue,"s")){
     
 $dets = collect_table_data1($conn,"students","surname",$searchValue,"s","ASC","std_id");
  
  foreach ($dets as $det){
  
$results[] = get_user_name($det);
    
    }
  }   
    
  if(check_exist($conn,"staffs","surname",$searchValue,"s")){
     
 $dets = collect_table_data1($conn,"staffs","surname",$searchValue,"s","ASC","staff_id");
 
 foreach ($dets as $det){
  
$results[] = get_user_name($det);
    
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
      
 if(check_exist($conn,"students","std_id",$searchValue,"i")){
     
 $dets = collect_table_data1($conn,"students","std_id",$searchValue,"i","ASC","std_id");
  
  foreach ($dets as $det){
  
 $results[] = get_user_name($det);
    
    }
  } 
   
    
  if(check_exist($conn,"staffs","staff_id",$searchValue,"i")){
     
 $dets = collect_table_data1($conn,"staffs","staff_id",$searchValue,"i","ASC","staff_id");
 
 foreach ($dets as $det){
  
 $results[] = get_user_name($det);
    
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
      
 if(check_exist($conn,"students","std_pin",$searchValue,"s")){
     
 $dets = collect_table_data1($conn,"students","std_pin",$searchValue,"s","ASC","std_id");
  
  foreach ($dets as $det){
  
 $results[] = get_user_name($det);
    
    }
  } 
   
    
  if(check_exist($conn,"staffs","staff_id",$searchValue,"i")){
     
 $dets = collect_table_data1($conn,"staffs","staff_id",$searchValue,"i","ASC","staff_id");
 
 foreach ($dets as $det){
  
 $results[] = get_user_name($det);
    
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
 elseif($_SESSION["staff_cat"] == $dirgen || $_SESSION["staff_cat"] == $principal){
  
 $switch = switch_user($user_cat);
 $conn = $switch["conn"];
 $table = $switch["table"];
 $idcol = $switch["id_col"];
 $userdet = collect_user_data($conn,$table,$idcol,$user_id,"i");

  if(delete_user_data($conn,$table,$idcol,$user_id,"i")){
  
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



if(file_exists($prf_dir)){
    
 unlink($prf_dir);  
    
}

if(file_exists($sign_dir)){
    
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
     "message" => "The selected $user_type cannot be suspended from this site !",
      ];
echo json_encode($response);
exit();    
     
 }
 elseif($_SESSION["staff_cat"] == $dirgen || $_SESSION["staff_cat"] == $principal){
  
  $switch = switch_user($user_cat);
 $conn = $switch["conn"];
 $table = $switch["table"];
 $idcol = $switch["id_col"];
 $userdet = collect_user_data($conn,$table,$idcol,$user_id,"i");
$iniStatus = $userdet["status"];
 
 if($iniStatus !== "Suspended"){
     
   if(update_user_data($conn,$table,"status",$idcol,"Suspended",$user_id,"si")){
  
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

 if(!$user_id || !$user_cat || !$user_type){
     
  $response = [
     "status" => "failed",
     "error" => "Empty Input",
     "message" => "user details not complete !",
      ];
echo json_encode($response);
exit();   
       
 }
 
 elseif($_SESSION["staff_cat"] == $dirgen || $_SESSION["staff_cat"] == $principal){
  
  $switch = switch_user($user_cat);
 $conn = $switch["conn"];
 $table = $switch["table"];
 $idcol = $switch["id_col"];
 $userdet = collect_user_data($conn,$table,$idcol,$user_id,"i");
$iniStatus = $userdet["status"];
 
 if($iniStatus == "Suspended"){
  
   if(update_user_data($conn,$table,"status",$idcol,"Active",$user_id,"si")){
  
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