<?php

if($_SERVER["REQUEST_METHOD"]== "POST"){
//  require '/show_errors'; 
   $root = $_SERVER["DOCUMENT_ROOT"];
 require $root.'/page_init.php';
  
  
 if(isset($_SESSION["staff_id"])){
 
 $staff_id = trim(htmlspecialchars($_SESSION['staff_id'],ENT_QUOTES,'UTF-8'));
 }
  
if(isset($_SESSION["std_id"])){
 
 $std_id = trim(htmlspecialchars($_SESSION['std_id'],ENT_QUOTES,'UTF-8'));
 } 


if(!$staff_id && !$std_id){
    
  $string = $_SERVER["HTTP_REFERER"];
$location = extract_query_string($string);
 
  $_SESSION["error_msg"] ="please login to continue";
  header("Location:/$location");
  die();
    
}



 $reservedPrf = [
     'default-prf.jpg','default-prf.png',
     'logo.jpg','logo.png',
     'npa.jpg','npa.png',
     'webdev1.jpg','webdev1.png',
     'webdev2.jpg','webdev2.png',
     'webdevhub.jpg','webdevhub.png',
     'webdevhub1.jpg','webdevhub1.png',
    'webdevhub2.jpg','webdevhub2.png',
    'webdevhub-logo1.jpg','webdevhub-logo1.png',
   'webdevhub-logo2.jpg','webdevhub-logo2.png',
            
     ];
 
 if(isset($_POST['save_profile_changes'])){
 
  $prf = $_FILES['prf'];
  $new_email = trim(htmlspecialchars($_POST["new_email"],ENT_QUOTES,'UTF-8'));
  $new_num = trim(htmlspecialchars($_POST["new_num"],ENT_QUOTES,'UTF-8'));
  $new_sur = trim(htmlspecialchars($_POST["new_sur"],ENT_QUOTES,'UTF-8'));
  $new_oth = trim(htmlspecialchars($_POST["new_oth"],ENT_QUOTES,'UTF-8'));
  $new_title = trim(htmlspecialchars($_POST["new_title"],ENT_QUOTES,'UTF-8'));
  $new_gender = trim(htmlspecialchars($_POST["new_gender"],ENT_QUOTES,'UTF-8'));


 $user_det = collect_user_data($conn,'staffs','staff_id',$staff_id,'i');

 $old_email = $user_det["email"];
 $old_num = $user_det["number"];
 $old_sur = $user_det["surname"];
 $old_oth = $user_det["othernames"];
 $old_title = $user_det["title"];
 $old_gender = $user_det["gender"];
 $old_prf = $user_det["profile"];
 
  $errors = [];
  $changes = [];
 
  if($new_email && $new_email != $old_email){
   if(check_exist($conn,'staffs','email',$new_email,'s')){
       
   $errors[] = "email already in use";
   
   }
   elseif(!validate_user_email($new_email)){
    
     $errors[] = "Email not valid, please enter a valid email address";  
   }
   else{
       
   update_user_data($conn,'staffs','email','staff_id',$new_email,$staff_id,'si');   
   $changes[] = "Your email was changed to $new_email";     
   }

  }
   
   if($new_num && $new_num != $old_num){
  
  if(!validate_phone_number($new_num)){
      
    $errors[] = "Phone Number not valid, please enter a standard Phone Number";
      
  }
  
  elseif(check_exist($conn,'staffs','number',$new_num,'s')){
       
   $errors[] = "Phone number already in use";
   
   }
   
   else{
       
   update_user_data($conn,'staffs','number','staff_id',$new_num,$staff_id,'si');   
   $changes[] = "Your Phone number was changed to $new_num";     
   }

  } 
   
  if($new_sur && $new_sur != $old_sur){
      
 update_user_data($conn,'staffs','surname','staff_id',$new_sur,$staff_id,'si');   
   $changes[] = "Your Surname was changed to $new_sur";       
      
  }
  
  if($new_oth && $new_oth != $old_oth){
      
 update_user_data($conn,'staffs','othernames','staff_id',$new_oth,$staff_id,'si');   
   $changes[] = "Your Other Name(s) was changed to $new_oth";       
      
  }
 
  if($new_gender && $new_gender != $old_gender){
      
  update_user_data($conn,'staffs','gender','staff_id',$new_gender,$staff_id,'si');   
   $changes[] = "Your gender was updated to $new_gender";       
      
  }
  
  
   if($new_title && $new_title != $old_title){
  
 update_user_data($conn,'staffs','title','staff_id',$new_title,$staff_id,'si');   
   $changes[] = "Your title was changed to $new_title";       
      
  }
 
 if($prf["name"]){
     
   $prfName = $prf["name"];   
   $tmp = $prf["tmp_name"];
   $type = $prf["type"];
   
// Get extension using pathinfo
$ext = strtolower(pathinfo($prfName, PATHINFO_EXTENSION));

  $exts = ['jpg','png','jpeg','webp'];

  if(!in_array($ext,$exts)){
      
 $errors[] = "Upload of $type for profile picture is not allowed";
      
  }
  else{
  
 $prfPath = $_SERVER["DOCUMENT_ROOT"]."/images/staff";
 if(!is_dir($prfPath)){
     
 mkdir($prfPath,0755,true);   
     
  } 
  
 $targetFolder ="/images/staff/";
 $filename = upload_image_as_webp($prf, $targetFolder, "profile_", $staff_id);

 if($filename && $filename !== "extension_error"){
     
update_user_data($conn,"staffs","Profile","staff_id",$filename,$staff_id,"si");
// remove old prf from server 

$oldprfDir = "$prfPath/$old_prf";
if(is_file($oldprfDir)){
 unlink($oldprfDir); 
   }
  
 
  $changes[]  = "Your profile picture was changed successfully";    
   }
   else{
       
  $errors[] = "Could not Upload new profile picture";     
       
   }
  
  }
     
 }
 
 if($errors){
 
  $_SESSION["changes_errors"] = $errors;
  
  $msg = "Error making changes to your profile";
     
  header("Location:/profile?msg_report=".$msg."&report=failed");
  die();  
     
 }
 elseif($changes){
     
 $_SESSION["changes_made"] = $changes;
    
  $msg = "Profile changes made successfully";
     
  header("Location:/profile?msg_report=".$msg."&report=suc");
  die();     
     
 }
 else{
   
  $msg = "You have not made any changes to your profile";
     
   header("Location:/profile?msg_report=".$msg."&report=fail");
  die();  
     
  }
 
 } 
 
 else{
 // check for ajax request for change psw    
 $data = json_decode(file_get_contents('php://input'), true);

if($data){
    
 $btn = $data["submit_button_name"];
 $old_psw = $data["old_psw"];
 $new_psw = $data["new_psw"];
 $con_psw = $data["con_psw"];
 $user_id = $_SESSION["std_id"];   
 $staff_id = $_SESSION["staff_id"];
 
 $passwordRegex = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&_#])[A-Za-z\d@$!%*?&_#]{8,}$/';
  
 if(!$user_id && !$staff_id){
     
 $response = [
      "status" => "failed",
      "err" => "user",
      "message" => "User not logged in",
      ];
echo json_encode($response);
exit();      
     
 } 
 
 elseif(!$old_psw){
     
    $response = [
      "status" => "failed",
      "err" => "old_psw",
      "message" => "Old password must not be empty",
      ];
echo json_encode($response);
exit();  
     
 }
 elseif(!$new_psw){
     
    $response = [
      "status" => "failed",
      "err" => "new_psw",
      "message" => "New password must not be empty",
      ];
echo json_encode($response);
exit();   
     
 }
 elseif(!$con_psw){
     
    $response = [
      "status" => "failed",
      "err" => "new_psw",
      "message" => "Confirm new password must not be empty",
      ];
echo json_encode($response);
exit();   
     
 }
  elseif($new_psw != $con_psw){
     
    $response = [
      "status" => "failed",
      "err" => "new_psw",
      "message" => "Your Passwords do not match !",
      ];
echo json_encode($response);
exit();   
     
 }
  elseif(!preg_match($passwordRegex, $new_psw)){
      
      $response = [
      "status" => "failed",
      "err" => "new_psw",
      "message" => "Password must be upto 8 characters and must contain atleast one special character, one upper and one lower case character"
     
      ];
      
     echo json_encode($response);
    exit();      
         
  }
 else{
 
 if($btn == "staff_profile_chpsw"){
  $conn = $conn;
  $table = "staffs";
  $id_col = "staff_id";
  $col1 = "email";
  $Id = $staff_id;  
 }
 elseif($btn == "stds_profile_chpsw"){
     
  $conn = $conn;
  $table = "students";
  $id_col = "std_id";
  $col1 = "std_pin";
  $Id = $user_id;
 }
 else{
     
   $response = [
      "status" => "failed",
      "err" => "button_error",
      "message" => "Unknown button name !",
      ];
echo json_encode($response);
exit();    
       
 }
 
 $row = collect_user_data($conn,$table,$id_col,$Id,'i');
  $ini_psw = $row["login_psw"];    
  
if(!password_verify($old_psw,$ini_psw)){
    
    $response = [
      "status" => "failed",
      "err" => "old_psw",
      "message" => "Wrong password !",
      ];
echo json_encode($response);
exit();    
    
} 
else{
    
  $psw_hash = password_hash($new_psw, PASSWORD_DEFAULT);
  
  update_user_data($conn,$table,"login_psw",$id_col,$psw_hash,$Id,"si");
 
 
 $changes[] = "Your login password was changed successfully, Use your new password when next you wants to login";
     
 $_SESSION["changes_made"] = $changes;
       
   $response = [
      "status" => "success",
      "err" => "none",
      "message" => "password changed successfully", 
      ];
echo json_encode($response);
exit();      
 
    
  }
     
 }
}
else{
  
    $response = [
      "status" => "failed",
      "err" => "Empty data",
      "message" => "Empty form data",
      ];
echo json_encode($response);
exit(); 
    
   }
  }  

}
else{
    
  header("Location:/profile");
  die();
    
}