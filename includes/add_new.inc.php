<?php

$string = $_SERVER["HTTP_REFERER"];
$location = extract_query_string($string);

if(!$location){
    $location = "/home";
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
  $root = $_SERVER["DOCUMENT_ROOT"];
 require $root.'/page_init.php';
  
  $staff_id = $_SESSION["staff_id"];
  $staff_cat = $_SESSION["staff_cat"];

if(!$staff_id || !$staff_cat){
    
  $_SESSION["error_msg"] ="*Please login to continue !";  
    header("Location:$location");
    die();   
    
}
else{
  
  $authorized[] = $teacher;
 
if(in_array($staff_cat, $authorized)){
    
 if(isset($_POST["submit-upd-session"])){
   
  $session =  trim($_POST["session"]);
  $term = trim(htmlspecialchars($_POST["term"],ENT_QUOTES,'UTF-8'));
  $next_term_date = trim($_POST["next-term"]);
  $next_term = "";

if (!empty($next_term_date)) {
    $next_term= date("d/m/Y", strtotime($next_term_date));
    
$today = date("d-m-Y");
$todaystrtime = strtotime($today);
$next_termstrtime = strtotime($next_term_date);

if($next_termstrtime <= $todaystrtime){
    
   $_SESSION["error_msg"] = "Please choose a future date for when next term will begin";  
    header("Location:$location");
    die(); 
    
  }
}
 
  $curSession = "Current Session";
  $curTerm = "Current Term";
  $NextTerm = "Next Term Begins";

require 'create_tables.php';

$resultTable = create_result_table($conn, $resultTableDetails);

$subjectTable = create_result_table($conn, $subjectTableDetails);

$classSetTable = create_result_table($conn, $classSetTableDetails);


if($resultTable && $subjectTable && $classSetTable){

$tbmsg = "Database tables were also created successfully";
    
  if(check_exist($conn,"variables","type",$curSession,"s")){
     
  $upd1 = update_user_data($conn,"variables","value","type",$session,$curSession,"ss");  
     
 }
 else{
  
  $insertData1 = [
     "conn" => $conn,
     "table" => "variables",
     "cols" => ['type','value','classification'],
     "vals" => [$curSession,$session,"General"],
     "params" => "sss"
     
     ];
 
  $insert1 = insert_user_data($insertData1);

 if($insert1["status"] == "success"){
     
  $upd1 = true;    
  }
 }
 
 
 if(check_exist($conn,"variables","type",$curTerm,"s")){
     
  $upd2 = update_user_data($conn,"variables","value","type",$term,$curTerm,"ss");  
     
 }
 else{
  
  $insertData2 = [
     "conn" => $conn,
     "table" => "variables",
     "cols" => ['type','value','classification'],
     "vals" => [$curTerm,$term,"General"],
     "params" => "sss"
     
     ];
 
 $insert2 = insert_user_data($insertData2);

 if($insert2["status"] == "success"){
     
  $upd2 = true;    
  }
 }
 
 if(check_exist($conn,"variables","type",$NextTerm,"s")){
     
  $upd3 = update_user_data($conn,"variables","value","type",$next_term,$NextTerm,"ss");  
     
 }
 else{
  
  $insertData3 = [
     "conn" => $conn,
     "table" => "variables",
     "cols" => ['type','value','classification'],
     "vals" => [$NextTerm,$next_term,"General"],
     "params" => "sss"
     
     ];
 
$insert3 = insert_user_data($insertData3);

 if($insert3["status"] == "success"){
     
  $upd3 = true;    
  }
 }

 
 if($upd1 && $upd2 && $upd3){
     
  $msg = "Session updated successfully";
 // $msg.= " and ".$tbmsg;
    header("Location:/home?msg_report=".$msg."&report=suc");
    die();  
 }
 else{
     
  $_SESSION["error_msg"] = $insert1["message"].", ".$insert2["message"].", ".$insert3["message"];  
    header("Location:$location");
    die();    
     
   }

}
else{
//could not create result table
 
   $_SESSION["error_msg"] = "Session not updated.<br>Error: Database tables for $session results could not be created, please try again. <br>If this error persist, please consult the developer of this system.";  
    header("Location:$location");
    die();
 
    
   }
 }
  
elseif(isset($_POST["submit-add-class"])){
   
  $class =  normalizeClass(trim(htmlspecialchars($_POST["class"],ENT_QUOTES,'UTF-8')));
  $classCat = trim(htmlspecialchars($_POST["class-cat"],ENT_QUOTES,'UTF-8'));
  $pattern = trim(htmlspecialchars($_POST["pattern"],ENT_QUOTES,'UTF-8'));
 $ignoreValidation = trim($_POST["ignore-validation"]);
 
  $type = "Class";
  
if(!validateClass($class,$ignoreValidation)) {
    
   $_SESSION["error_msg"] ="* Please specify a valid class";  
    header("Location:$location");
    die();   
}
elseif(strlen($class) >= 20){

    $_SESSION["error_msg"] ="*Class name too long, You may consider using abbreviation";  
    header("Location:$location");
    die();  
    
}

else{
    
 if(check_exist2($conn,"variables","type","value",$type,$class,"ss")){
     
 if(update_user_data2($conn,"variables","classification","type","value",$classCat,$type,$class,"sss")){
  
  update_user_data2($conn,"variables","assessment_pattern","type","value",$pattern,$type,$class,"sss");  
   
   
   $msg = "Class updated successfully";
 $location.="&msg_report=$msg&report=suc";
    header("Location:$location");
    die();     
     
 } 
else{
  $_SESSION["error_msg"] ="*failed to update $class, Please try again";  
    header("Location:$location");
    die();   
    
  }     
 }     
else{
    
  $insertData = [
     "conn" => $conn,
     "table" => "variables",
     "cols" => ['type','value','classification','assessment_pattern'],
     "vals" => [$type,$class,$classCat,$pattern],
     "params" => "ssss"
     
     ];
 
 $insert = insert_user_data($insertData);

 if($insert["status"] == "success"){
     
     $msg = "$class added successfully";
   
    $location.="&msg_report=$msg&report=suc";
    header("Location:$location");
    die(); 
 
  }   
 else{
  
   $_SESSION["error_msg"] = "failed to add $class, ". $insert["message"];  
    header("Location:$location");
    die();   
      }  
    }
  }
} 
  
 elseif(isset($_POST["submit-add-subject"])){
   
$subject =  ucwords(strtolower(trim($_POST["subject"])));
$subjectCat = trim($_POST["subject-cat"]);
 $btnValue = trim($_POST["submit-add-subject"]);
  $type = "Subject";
 
if(strpos($subject,".") && strlen($subject) <= 7){
  $subject = strtoupper($subject);
}
  
  
if(preg_match('/\d/', $subject) || is_numeric($subject)) {
    
   $_SESSION["error_msg"] ="*Please enter a valid Subject";  
    header("Location:$location");
    die();   
}
elseif(strlen($subject) >= 100){

    $_SESSION["error_msg"] ="*Subject name too long, You may consider using abbreviation";  
    header("Location:$location");
    die();  
    
}

else{
    
 if($btnValue == "upd-subject-name"){
   $subjectId = $_POST["subj_id"];
    $updmsg = "No changes was made";
  if($subjectId){
   $subjdet = collect_user_data2($conn,"variables","id","type",$subjectId,$type,"is");
   $old_subject = $subjdet["value"];
   $old_cat = $subjdet["classification"];

 if($subject && $subject != $old_subject){
  
  update_user_data2($conn,"variables","value","id","type",$subject,$subjectId,$type,"sis");
  
 $updmsg = "Subject updated successfully";
   }
   
  if($subjectCat && $subjectCat != $old_cat){
  
 update_user_data2($conn,"variables","classification","id","type",$subjectCat,$subjectId,$type,"sis");
  
 $updmsg = "Subject updated successfully";
   } 
  }

$_SESSION["success_msg"] = $updmsg;
  
  header("Location:$location");
    die(); 

 }
 else{
     
  if(check_exist2($conn,"variables","type","value",$type,$subject,"ss")){
     
 $_SESSION["error_msg"] = "$subject already exist";

   header("Location:$location");
    die();
 }    
else{
    
  $insertData = [
     "conn" => $conn,
     "table" => "variables",
     "cols" => ['type','value','classification'],
     "vals" => [$type,$subject,$subjectCat],
     "params" => "sss"
     
     ];
 
 $insert = insert_user_data($insertData);

 if($insert["status"] == "success"){
     
     $msg = "$subject added successfully";
   
$msg_report = [
    "msg_report" => $msg,
    "report" => "success",
    "add_new_subject" => "true"
];

header('Location: /add_new?'.http_build_query($msg_report)); 
 die();
 
  }   
 else{
  
   $_SESSION["error_msg"] = "failed to add $subject, ". $insert["message"];  
    header("Location:$location");
    die();   
      }  
    }
    
    }
  }
} 
   
 elseif(isset($_POST["submit-appoint-role"])){
  if(in_array($staff_cat,$appointers)){
      
 $staff =  ucwords(trim(htmlspecialchars($_POST["staff"],ENT_QUOTES,'UTF-8')));
  $role= trim(htmlspecialchars($_POST["role"],ENT_QUOTES,'UTF-8'));
  $duplicableRoles = [
      "ICT Director",
      "Asst. ICT Director",
      "Teacher",
      "Asst. Teacher",
      "Exam Officer",
      "Asst. Exam Officer",
      
      ];
 
  if(!$staff || !$role){
       
   $_SESSION["error_msg"] ="Empty data input";  
    header("Location:$location");
    die();    
      
  }
  
elseif(!check_exist($conn,"staffs","staff_id",$staff,"i")){
 
  $_SESSION["error_msg"] ="Invalid Staff";  
    header("Location:$location");
    die();    
    
}
 elseif($role === $dirgen){
 
   $_SESSION["error_msg"] ="Cannot assign the selected role to a staff";  
    header("Location:$location");
    die();    
    
} 

 elseif(check_exist2($conn,"staffs","staff_id","staff_cat",$staff,$dirgen,"is")){
 
   $_SESSION["error_msg"] ="Cannot assign role to the selected staff";  
    header("Location:$location");
    die();    
    
}

 elseif(check_exist($conn,"staffs","staff_cat",$role,"s") && !in_array($role,$duplicableRoles)){

 $staff_det = collect_user_data($conn,"staffs","staff_cat",$role,"s");

$staffName = $staff_det["title"]." ".$staff_det["surname"]." ".$staff_det["othernames"];
$Id = $staff_det["staff_id"];

 if($Id == $staff){
    
   $_SESSION["error_msg"] ="The role of $role had already been assigned to $staffName, make another appointment instead !";  
    header("Location:$location");
    die(); 
     
 } 
 
 $_SESSION["re-assign"] =true;
 $_SESSION["staff"] = $staff;
 $_SESSION["role"] = $role;
 $_SESSION["prev_holder"] = $Id;
 
   $_SESSION["success_msg"] ='The role of '.$role.' had already been assigned to '.$staffName.', do you want to re-assign it? <br>
   <a href="/add_new?re-assign-role" id="re-assign-role">Yes, Re-assign '.$role.'</a>';  
    header("Location:$location");
    die();    
    
}

 else{
      
 //all conditions satisfied 
 
 if(update_user_data($conn,"staffs","staff_cat","staff_id",$role,$staff,"si")){
     
//notify staff  
$appt_det = collect_user_data($conn,"staffs","staff_id",$staff_id,"i");
$apptName = $appt_det["title"]." ".$appt_det["surname"]." ".$appt_det["othernames"];


$staff_det = collect_user_data($conn,"staffs","staff_id",$staff,"i");
$staffName = $staff_det["title"]." ".$staff_det["surname"]." ".$staff_det["othernames"];
 $email = $staff_det["email"];
  $site = ucwords(strtolower($site));
 $subject = "New Role Appointment";
$body = "

We’re pleased to inform you that you have been assigned to a new role on <strong>$site</strong> Result Platform.<br><br>

<strong>Role Assigned:</strong> $role<br>
<strong>Assigned By:</strong> $apptName<br><br>

This role gives you access to features and responsibilities associated with your position. Please log in to your dashboard to explore your new permissions.<br><br>

If you believe this role was assigned in error or you need clarification, kindly contact the administrator.<br><br>

Congratulations, and thank you for being part of our school! <br><br>

<i>Best regards,<br>
$staff_cat,<br>
$site</i>
";
 
 
  $msg =[
      "name" => $staffName,
      "email" => $email,
      "subject" => $subject,
      "body" => $body,
      "attach" => null,
      ];
  
 $insert = inser_into_queue($msg);
  
   $_SESSION["success_msg"] ="Appointment successful ✓";  
  
    header("Location:$location");
    die();  
     
 }
 
 else{
     
   $_SESSION["error_msg"] ="Unable to appoint staff due to sql errors, Please try again.";  
    header("Location:$location");
    die();     
     
     }     
      
   }
  } 
  else{
      
   $_SESSION["error_msg"] ="Sorry you are not authorized to perform this request";  
    header("Location:$location");
    die();   
      
  }
 }
 
 elseif(isset($_POST["submit-add-staff"])){
 
 $surname =  ucwords(strtolower(trim(htmlspecialchars($_POST["surname"],ENT_QUOTES,'UTF-8'))));
 $othernames =  ucwords(strtolower(trim(htmlspecialchars($_POST["othernames"],ENT_QUOTES,'UTF-8'))));
$email =  strtolower(trim(htmlspecialchars($_POST["email"],ENT_QUOTES,'UTF-8')));
$num = trim(htmlspecialchars($_POST["num"],ENT_QUOTES,'UTF-8'));
$gender = trim(htmlspecialchars($_POST["gender"],ENT_QUOTES,'UTF-8'));
$title = trim(htmlspecialchars($_POST["title"],ENT_QUOTES,'UTF-8'));
$profile = $_FILES["profile"];
$signature = $_FILES["signature"];
$btnValue =  $_POST["submit-add-staff"];

 
  $_SESSION["sumbit-attempt"] = true;
  $_SESSION["surname"]  = $surname;
  $_SESSION["othernames"] = $othernames;
  $_SESSION["email"] = $email;
  $_SESSION["number"] = $num;
  $_SESSION["parent_name"] = "";
  $_SESSION["parent_email"] = "";
  $_SESSION["parent_number"] ="";
  $_SESSION["resident"] = "";
  $_SESSION["state_origin"] = "";
  $_SESSION["lga_origin"] = "";
  $_SESSION["current_class"] = "";
  

if(!$surname){
  
  $_SESSION["autofocus"] = "surname";
  $_SESSION["error_msg"] = "*Surname is required";
 header("Location:$location");
   die();   
     
 }
 elseif(!$othernames){
  
  $_SESSION["autofocus"] = "othernames";   
 $_SESSION["error_msg"] = "*Othername(s) is required";
 header("Location: $location");
   die();   
     
 }
 
 elseif(!$email){
  $_SESSION["autofocus"] = "email";  
  $_SESSION["error_msg"]  = "*Staff's Email is required (preferably Gmail)";
 header("Location: $location");
   die();    
    
 }
 
 elseif(!validate_user_email($email)){
     
   $_SESSION["autofocus"] = "email";  
  $_SESSION["error_msg"]  = "*Please enter a valid email address (preferably Gmail)";
  $_SESSION["email"] = "";
 header("Location: $location");
   die();    
     
 }
 
 elseif(!$num){
  $_SESSION["autofocus"] = "email";  
  $_SESSION["error_msg"]  = "*Staff's phone number is required (preferably WhatsApp number)";
 header("Location: $location");
   die();    
    
 }
 
 elseif(!validate_phone_number($num)){
     
   $_SESSION["autofocus"] = "number";  
  $_SESSION["error_msg"]  = "*Please enter a valid phone number";
  $_SESSION["number"] = "";
 header("Location: $location");
   die();    
     
 }
 else{
 
 if($btnValue == "submit-staff-det"){
  
   if(check_exist($conn,"staffs","email",$email,"s")){
 //prevent duplicate entry for emails   

   $_SESSION["autofocus"] = "email";  
  $_SESSION["error_msg"]  = "*Email already in use";
  $_SESSION["email"] = "";
 header("Location: $location");
   die();

}

elseif(check_exist($conn,"staffs","number",$num,"s")){
 //prevent duplicate entry for number   

   $_SESSION["autofocus"] = "number";  
  $_SESSION["error_msg"]  = "*Phone number already in use";
  $_SESSION["number"] = "";
 header("Location: $location");
   die();

}   
     
 else{
   
 $Id = generate_id(8);
 $limit = 1000;
 while($limit && check_exist_id($Id)){
  //ensures a uniq staff id    
  $Id = generate_id(8);
  $limit--;
     
 }

if(!$limit){
 //Unable to generate uniq staff Id    
 $Id = substr(time(),2,8);  
    
}


 $cat = "Teacher";//default staff_cat
 // $login_psw = generate_psw();

 $conv = convert_to_array($othernames);
 $psw_str = strtolower($conv[0]);
 $special = ['@','#','@','$','&'];
 $char = $special[rand(0,4)];
$login_psw = $psw_str.$char.generate_id(4);
 $psw_hash = password_hash($login_psw,PASSWORD_DEFAULT);
 $status = "Active";//
 $status_reason = "Auto Verification";
 
 $insertData = [
     "conn" =>$conn,
     "table" => "staffs",
     "cols" => ['staff_id','staff_cat','title','surname','othernames','email','number','gender','status','status_reason','login_psw','timestamp'],
     "vals" => [$Id,$cat,$title,$surname,$othernames,$email,$num,$gender,$status,$status_reason,$psw_hash,$DayDateTime],
     "params" => "isssssssssss"
     
     ];
 
 $insert = insert_user_data($insertData);
  
  if($insert["status"] == "success"){
      
//upload staff profile & signature
if($profile["name"]){
 $targetFolder ="/images/staff/";
 $filename = upload_image_as_webp($profile, $targetFolder, "profile_", $Id);

if($filename && $filename !== "extension_error"){
   //file was uploaded
   update_user_data($conn,"staffs","profile","staff_id",$filename,$Id,"si");
   
 }
 else{

 $_SESSION["error_msg"] = "profile not uploaded: file as type not allowed"; 
     
 }
}

//upload staff signature
if($signature["name"]){
 
 $signatureRename = "";
if (!empty($_POST['cleaned_signature'])) {
    $data = $_POST['cleaned_signature'];
    $data = str_replace('data:image/png;base64,', '', $data);
    $data = base64_decode($data);
    
    $prefix = $Id.rand(10,99);
    $signatureRename = 'signature_'.$prefix.'.png';
 file_put_contents($_SERVER["DOCUMENT_ROOT"].'/images/staff/'.$signatureRename, $data);
    
 update_user_data($conn,"staffs","signature","staff_id",$signatureRename,$Id,"si");   
    
} 
else{

 $signatureName = $signature["name"];
 $tempDir = $signature["tmp_name"];
 $signatureExt = strtolower(pathinfo($signatureName,PATHINFO_EXTENSION));
   
$allowedExt = ['png','jpg','jpeg','webp'];
 
 if(in_array($signatureExt,$allowedExt)){
 
  $rename = $Id.substr(time(),6,4);    
  $signatureRename = 'signature_'.$rename.'.'.$signatureExt;
  $signaturePath = $_SERVER["DOCUMENT_ROOT"].'/images/staff/'.$signatureRename;
     
  if(move_uploaded_file($tempDir,$signaturePath)){
   //signature uploaded to server successfully, update database   
  
 update_user_data($conn,"staffs","signature","staff_id",$signatureRename,$Id,"si");
  }
  
  else{
   
  if(isset($_SESSION["error_msg"])){
      
    $_SESSION["error_msg"].= "<br><br> signature not uploaded: Internal server error.";     
    
  } 
  else{
  
   $_SESSION["error_msg"] = "signature not uploaded: Internal server error.";       
  }    
     
  }
 }
 else{
 
   if(isset($_SESSION["error_msg"])){
      
  $_SESSION["error_msg"].= "<br><br> signature not uploaded: upload of $signatureExt file as signature is not allowed";       
    
  } 
  else{
  
  $_SESSION["error_msg"] = "signature not uploaded: upload of $signatureExt file as signature is not allowed";         
  }
 
 }  
 }  

}


 $subject = "Staff Portal Access Information";
$staff_name = $title." ".$surname." ".$othernames;

$body = "Dear $staff_name,<br><br>
You have been successfully added as a staff member on the school result portal by the administrator.<br><br>
Your login details are as follows:<br>
Email: $email<br>
Password: $login_psw<br><br>
Please log in using the link below:<br>
$rurl<br>
For security reasons, we strongly recommend that you change your password immediately after your first login.
<br><br>
If you experience any issues accessing your account, kindly contact the ICT-Director for assistance.<br><br>
We are glad to have you on board and wish you a productive experience using the platform.<br><br>
<i>Best regards,<br>
$staff_cat,<br>
$site</i>";
  
 
   $msg =[
      "name" => $staff_name,
      "email" => $email,
      "subject" => $subject,
      "body" => $body,
      "attach" => null,
      ];
  
 $insert = inser_into_queue($msg);
  
 $HisHer = switch_gender($gender,"possessive_adj"); 
  $_SESSION["success_msg"] ="$staff_name was added successfully ✓<br><br>
  $HisHer login details are as follows:<br>
    Email: $email<br>
    Password: $login_psw<br><br>";  
  
   unset($_SESSION["sumbit-attempt"]);
   
    header("Location:$location");
    die();
 
  }
  else{
      
     $_SESSION["autofocus"] = "";  
  $_SESSION["error_msg"]  = "*failed to add staff's details, please try again";
 header("Location: $location");
   die();     
      
   }
  }
 } 
 elseif($btnValue == "edit-staff-det"){

 $Id =  trim(htmlspecialchars($_POST["hidden_id"],ENT_QUOTES,'UTF-8'));
 
if($Id){
    
 $staff_det = collect_user_data($conn,"staffs","staff_id",$Id,"i");

 $old_title = $staff_det["title"];
 $old_surname = $staff_det["surname"];
 $old_othernames =$staff_det["othernames"];
 $old_email =$staff_det["email"];
 $old_num = $staff_det["number"];
 $old_gender = $staff_det["gender"];
 $old_profile = $staff_det["profile"];
 $old_signature = $staff_det["signature"];
 
 
  $_SESSION["success_msg"] ="";
  $_SESSION["success_error"] ="";
  $upd = 0; $err =0;
  if($title && $title != $old_title){
  if(update_user_data($conn,"staffs","title","staff_id",$title,$Id,"si")){
  $_SESSION["success_msg"].="<br>• Staff's title updated successfully ✓";
      
   $upd++;   
  }
  else{
      
 $_SESSION["error_msg"].="<br>• Failed to update staff's title: Database error"; 
    $err++;  
   }
  }
    
 if($surname && $surname != $old_surname){
  if(update_user_data($conn,"staffs","surname","staff_id",$surname,$Id,"si")){
  $_SESSION["success_msg"].="<br>• Staff's surname updated successfully ✓";
      
   $upd++;   
  }
  else{
      
 $_SESSION["error_msg"].="<br>• Failed to update staff's surname: Database error"; 
    $err++;  
   }
  }
 
 
 if($othernames && $othernames != $old_othernames){
  if(update_user_data($conn,"staffs","othernames","staff_id",$othernames,$Id,"si")){
  $_SESSION["success_msg"].="<br>• Staff's othername(s) updated successfully ✓";
      
   $upd++;   
  }
  else{
      
 $_SESSION["error_msg"].="<br>• Failed to update staff's othername(s): Database error"; 
    $err++;  
   }
  }
 
 
if($email && $email != $old_email){
  if(update_user_data($conn,"staffs","email","staff_id",$email,$Id,"si")){
  $_SESSION["success_msg"].="<br>• Staff's email updated successfully ✓";
      
   $upd++;   
  }
  else{
      
 $_SESSION["error_msg"].="<br>• Failed to update staff's email: Database error"; 
    $err++;  
   }
  }
  
 if($num && $num != $old_num){
  if(update_user_data($conn,"staffs","number","staff_id",$num,$Id,"si")){
  $_SESSION["success_msg"].="<br>• Staff's phone number updated successfully ✓";
      
   $upd++;   
  }
  else{
      
 $_SESSION["error_msg"].="<br>• Failed to update staff's number: Database error"; 
    $err++;  
   }
  } 
    
 
if($gender && $gender != $old_gender){
  if(update_user_data($conn,"staffs","gender","staff_id",$gender,$Id,"si")){
  $_SESSION["success_msg"].="<br>• Staff's gender updated successfully ✓";
      
   $upd++;   
  }
  else{
      
 $_SESSION["error_msg"].="<br>• Failed to update staff's gender: Database error"; 
    $err++;  
   }
  }
 
 
//upload staff profile 
if($profile["name"]){
 $targetFolder ="/images/staff/";
 $filename = upload_image_as_webp($profile, $targetFolder, "profile_", $Id);

if($filename && $filename !== "extension_error"){
   //file was uploaded
   update_user_data($conn,"staffs","profile","staff_id",$filename,$Id,"si");
 
   // remove old prf from server 
if (!empty($old_profile)) {
    $old_profile = basename($old_profile);
    $oldprfDir = $_SERVER["DOCUMENT_ROOT"] . '/images/staff/' . $old_profile;

    if (is_file($oldprfDir)) {
        unlink($oldprfDir);
    }
}
   
      $upd++;
$_SESSION["success_msg"] .="<br>• Profile updated successfully ✓";

 }
 else{

 $_SESSION["error_msg"] = "profile not uploaded: file as type not allowed"; 
     
 }
}

//upload staff signature
if($signature["name"]){
 
 $signatureRename = "";
if (!empty($_POST['cleaned_signature'])) {
    $data = $_POST['cleaned_signature'];
    $data = str_replace('data:image/png;base64,', '', $data);
    $data = base64_decode($data);
    
    $prefix = $Id.rand(10,99);
    $signatureRename = 'signature_'.$prefix.'.png';
 file_put_contents($_SERVER["DOCUMENT_ROOT"].'/images/staff/'.$signatureRename, $data);
    
 update_user_data($conn,"staffs","signature","staff_id",$signatureRename,$Id,"si");   
   $upd++; 
   
   $_SESSION["success_msg"] .="<br>• signature updated successfully ✓";


} 
else{

 $signatureName = $signature["name"];
 $tempDir = $signature["tmp_name"];
 $signatureExt = strtolower(pathinfo($signatureName,PATHINFO_EXTENSION));
   
$allowedExt = ['png','jpg','jpeg','webp'];
 
 if(in_array($signatureExt,$allowedExt)){
 
  $rename = $Id.substr(time(),6,4);    
  $signatureRename = 'signature_'.$rename.'.'.$signatureExt;
  $signaturePath = $_SERVER["DOCUMENT_ROOT"].'/images/staff/'.$signatureRename;
     
  if(move_uploaded_file($tempDir,$signaturePath)){
   //signature uploaded to server successfully, update database   
  
 update_user_data($conn,"staffs","signature","staff_id",$signatureRename,$Id,"si");
 $upd++;
  $_SESSION["success_msg"] .="<br>• signature updated successfully ✓";

  }
  
  else{
   
  if(isset($_SESSION["error_msg"])){
      
    $_SESSION["error_msg"].= "<br><br> signature not uploaded: Internal server error.";     
    
  } 
  else{
  
   $_SESSION["error_msg"] = "signature not uploaded: Internal server error.";       
  }    
     
  }
 }
 else{
 
   if(isset($_SESSION["error_msg"])){
      
  $_SESSION["error_msg"].= "<br><br> signature not uploaded: upload of $signatureExt file as signature is not allowed";       
    
  } 
  else{
  
  $_SESSION["error_msg"] = "signature not uploaded: upload of $signatureExt file as signature is not allowed";         
  }
 
 }  
 }  

}


 if(!$upd){
 
 unset($_SESSION["success_msg"]);
 
if(!$err){

 $_SESSION["error_msg"] ="You have not made any changes";
 $err++;    
    
   }
 }

 if(!$err){
     
 unset($_SESSION["error_msg"]);
    
 }
 
 //end of execution 
  $_SESSION["autofocus"] = ""; 
$string.="&msg_report=update completed&report=suc";

  unset($_SESSION["sumbit-attempt"]);
 header("Location:$string");
 die();
 
    
}
else{
  // if staff_if is not set at background (hidden_id)  
   
   $_SESSION["autofocus"] = "";  
  $_SESSION["error_msg"]  = "*Sorry, something went wrong, please logout, then login and try again.";
 header("Location: $location");
   die();     
    
}
     
 }
  else{
      
  $_SESSION["autofocus"] = "";  
  $_SESSION["error_msg"]  = "*unknown request";
 header("Location: $location");
   die();     
      
    }   
   }
 }
  
 elseif(isset($_POST["submit-add-students"])){
 
 $surname =  ucwords(strtolower(trim(htmlspecialchars($_POST["surname"],ENT_QUOTES,'UTF-8'))));
 $othernames =  ucwords(strtolower(trim(htmlspecialchars($_POST["othernames"],ENT_QUOTES,'UTF-8'))));

$pname =  ucwords(strtolower(trim(htmlspecialchars($_POST["pname"],ENT_QUOTES,'UTF-8'))));
$pemail =  strtolower(trim(htmlspecialchars($_POST["pemail"],ENT_QUOTES,'UTF-8')));
$pnum = trim(htmlspecialchars($_POST["pnum"],ENT_QUOTES,'UTF-8'));
$gender = trim(htmlspecialchars($_POST["gender"],ENT_QUOTES,'UTF-8'));
$currentClass = trim(htmlspecialchars($_POST["current_class"],ENT_QUOTES,'UTF-8'));

$date  = trim(htmlspecialchars($_POST["year"],ENT_QUOTES,'UTF-8'));
$lga = trim(htmlspecialchars($_POST["lga"],ENT_QUOTES,'UTF-8'));
$state = trim(htmlspecialchars($_POST["state"],ENT_QUOTES,'UTF-8'));
$resident = trim(htmlspecialchars($_POST["resident"],ENT_QUOTES,'UTF-8'));
$dob = $_POST["dob"];
$allowDuplicate = trim($_POST["allow-duplicate"]);


$profile = $_FILES["stdprofile"];
$btnValue = $_POST["submit-add-students"];

$year = null;
$formattedDOB = null;
if($date){
$timestamp = strtotime($date . "-01"); // add day to make it valid
$year = date("M, Y", $timestamp);
    
}

if($dob){

 // Create a DateTime object from the input string
$dateformat = DateTime::createFromFormat('Y-m-d', $dob);
// Format it to the desired output
$formattedDOB = $dateformat->format('d-m-Y');   
}


  $_SESSION["sumbit-attempt"] = true;
  $_SESSION["surname"]  = $surname;
  $_SESSION["othernames"] = $othernames;
  $_SESSION["email"] = "";
  $_SESSION["number"] = "";
  $_SESSION["parent_name"] = $pname;
  $_SESSION["parent_email"] = $pemail;
  $_SESSION["parent_number"] =$pnum;
  $_SESSION["resident"] =  $resident;
  $_SESSION["std_state"] = $state;
  $_SESSION["std_lga"] = $lga;
  $_SESSION["current_class"] = $currentClass;
   $_SESSION["dob"] = $dob;
$_SESSION["year_admitted"] = $date;


if(!$surname){
  
  $_SESSION["autofocus"] = "surname";
  $_SESSION["error_msg"] = "*Surname is required";
 header("Location:$location");
   die();   
     
 }
 elseif(!$othernames){
  
  $_SESSION["autofocus"] = "othernames";   
 $_SESSION["error_msg"] = "*Othername(s) is required";
 header("Location: $location");
   die();   
     
 }
 
 elseif($pemail && !validate_user_email($pemail)){
     
   $_SESSION["autofocus"] = "email";  
  $_SESSION["error_msg"]  = "*Please enter a valid email address (preferably Gmail)";
  $_SESSION["email"] = "";
 header("Location: $location");
   die();    
     
 }
 
 elseif($pnum && !validate_phone_number($pnum)){
     
   $_SESSION["autofocus"] = "number";  
  $_SESSION["error_msg"]  = "*Please enter a valid phone number";
  $_SESSION["number"] = "";
 header("Location: $location");
   die();    
     
 }
 else{
 
 if($btnValue == "submit-student-det"){
  
 //check duplicates
 
 if(check_exist3($conn,"students","surname","othernames","current_class",$surname,$othernames,$currentClass,"sss") && !$allowDuplicate){

$heShe = switch_gender($gender,"pronoun"); 
 $_SESSION["error_msg"] = "$surname $othernames already exist in $currentClass. If $heShe is another student in the same class, Please mark the checkbox 'Allow Duplicate Names' before proceeding";
   
    $_SESSION["autofocus"] = "surname";  
 
    header("Location: $location");
   die();    
     
 }
  
 
 $Id = generate_id(8);
 $limit = 1000;
 while($limit && check_exist_id($Id)){
  //ensures a uniq student id    
  $Id = generate_id(8);
  $limit--;
 }

if(!$limit){
 //Unable to generate uniq student Id    
 $Id = substr(time(),2,8);
}


 $pin =  generatePin(8);
 $limit = 1000;
 while($limit && check_exist($conn,"students","std_pin",$pin,"s")){
  //ensures a uniq student pin   
 $pin =  generatePin(8); //8 chars
 $limit--;
     
 }

if(!$limit){
 //Unable to generate uniq student pin    
$pin=strtoupper(bin2hex(random_bytes(5))); // 10 chars
    
}
 
 
 $status = "Active";//
 $status_reason = "Auto Verification";
 
 $insertData = [
     "conn" =>$conn,
     "table" => "students",
     "cols" => ['std_id','surname','othernames','current_class','year_admitted','std_state','std_lga','birth_date','resident','parent_name','parent_email','parent_number','gender','status','status_reason','std_pin','timestamp'],
     "vals" => [$Id,$surname,$othernames,$currentClass,$year,$state,$lga,$formattedDOB,$resident,$pname,$pemail,$pnum,$gender,$status,$status_reason,$pin,$DayDateTime],
     "params" => "issssssssssssssss"
     
     ];
 
 $insert = insert_user_data($insertData);
  
  if($insert["status"] == "success"){
      
//upload student profile 
if($profile["name"]){
 $targetFolder ="/images/students/";
 $filename = upload_image_as_webp($profile, $targetFolder, "profile_", $Id);

if($filename && $filename !== "extension_error"){
   //file was uploaded
   update_user_data($conn,"students","profile","std_id",$filename,$Id,"si");
   
 }
 else{

 $_SESSION["error_msg"] = "profile not uploaded: file as type not allowed"; 
     
 }
}


$subject = "Access Details for Your Ward’s Result Portal";
$std_name = $surname . " " . $othernames;

$body = "Dear $pname,<br><br>
We are pleased to inform you that your ward, <strong>$std_name</strong>, has been successfully registered on the school's result portal.<br><br>
You can now access your ward’s academic results using the details below:<br><br>
<strong>Result Checking PIN:</strong> $pin<br>
<strong>Portal Link:</strong> <a href='$rurl'>$rurl</a><br><br>

Please keep this information secure and do not share it with unauthorized persons.<br><br>
If you experience any difficulty accessing your ward’s result, kindly contact the ICT Director of the school for assistance.<br><br>
We appreciate your continued support and wish <strong>$std_name</strong> excellent academic success.<br><br>
<i>Best regards,<br>
$site</i>";
 
   $msg =[
      "name" => $pname,
      "email" => $pemail,
      "subject" => $subject,
      "body" => $body,
      "attach" => null,
      ];
  
 $insert = inser_into_queue($msg);
  
 $_SESSION["success_msg"] ="$std_name was added successfully ✓";  
  
   unset($_SESSION["sumbit-attempt"]);
   
    header("Location:$location");
    die();
 
  }
  else{
      
     $_SESSION["autofocus"] = "";  
  $_SESSION["error_msg"]  = "*failed to add student's details, please try again";
 header("Location: $location");
   die();     
      
   }
  
 } 
 elseif($btnValue == "edit-student-det"){

 $Id =  trim(htmlspecialchars($_POST["hidden_id"],ENT_QUOTES,'UTF-8'));
 
if($Id){
    
 $student_det = collect_user_data($conn,"students","std_id",$Id,"i");

 
 $old_surname = $student_det["surname"];
 $old_othernames =$student_det["othernames"];
 $old_pname =$student_det["parent_name"];
 $old_pemail =$student_det["parent_email"];
 $old_pnum = $student_det["parent_number"];
 $old_gender = $student_det["gender"];
 $old_profile = $student_det["profile"];
 $old_state = $student_det["std_state"];
 $old_lga = $student_det["std_lga"];
 $old_dob = $student_det["birth_date"];
 $old_resident = $student_det["resident"];
 $old_year =$student_det["year_admitted"];
 $old_class=$student_det["current_class"];
 
 
  $_SESSION["success_msg"] ="";
  $_SESSION["success_error"] ="";
  $upd = 0; $err =0;
  if($year && $year != $old_year){
  if(update_user_data($conn,"students","year_admitted","std_id",$year,$Id,"si")){
  $_SESSION["success_msg"].="<br>• Student's year of admission updated successfully ✓";
      
   $upd++;   
  }
  else{
      
 $_SESSION["error_msg"].="<br>• Failed to update student's year of admission: Database error"; 
    $err++;  
   }
  }
  
   if($currentClass && $currentClass != $old_class){
  if(update_user_data($conn,"students","current_class","std_id",$currentClass,$Id,"si")){
  $_SESSION["success_msg"].="<br>• Student's current class updated successfully ✓";
      
   $upd++;   
  }
  else{
      
 $_SESSION["error_msg"].="<br>• Failed to update student's current class: Database error"; 
    $err++;  
   }
  } 
    
 if($surname && $surname != $old_surname){
  if(update_user_data($conn,"students","surname","std_id",$surname,$Id,"si")){
  $_SESSION["success_msg"].="<br>• Student's surname updated successfully ✓";
      
   $upd++;   
  }
  else{
      
 $_SESSION["error_msg"].="<br>• Failed to update student's surname: Database error"; 
    $err++;  
   }
  }
 
 
 if($othernames && $othernames != $old_othernames){
  if(update_user_data($conn,"students","othernames","std_id",$othernames,$Id,"si")){
  $_SESSION["success_msg"].="<br>• Student's othername(s) updated successfully ✓";
      
   $upd++;   
  }
  else{
      
 $_SESSION["error_msg"].="<br>• Failed to update student's othername(s): Database error"; 
    $err++;  
   }
  }
 
 
if($pemail && $pemail != $old_pemail){
  if(update_user_data($conn,"students","parent_email","std_id",$pemail,$Id,"si")){
  $_SESSION["success_msg"].="<br>• Parent's email updated successfully ✓";
      
   $upd++;   
  }
  else{
      
 $_SESSION["error_msg"].="<br>• Failed to update parent's email: Database error"; 
    $err++;  
   }
  }
  
  if($pname && $pname != $old_pname){
  if(update_user_data($conn,"students","parent_name","std_id",$pname,$Id,"si")){
  $_SESSION["success_msg"].="<br>• Parent's name updated successfully ✓";
      
   $upd++;   
  }
  else{
      
 $_SESSION["error_msg"].="<br>• Failed to update parent's name: Database error"; 
    $err++;  
   }
  }
  

 if($pnum && $pnum != $old_pnum){
  if(update_user_data($conn,"students","parent_number","std_id",$pnum,$Id,"si")){
  $_SESSION["success_msg"].="<br>• Parent's phone number updated successfully ✓";
      
   $upd++;   
  }
  else{
      
 $_SESSION["error_msg"].="<br>• Failed to update parent's number: Database error"; 
    $err++;  
   }
  } 
    
 
if($gender && $gender != $old_gender){
  if(update_user_data($conn,"students","gender","std_id",$gender,$Id,"si")){
  $_SESSION["success_msg"].="<br>• Student's gender updated successfully ✓";
      
   $upd++;   
  }
  else{
      
 $_SESSION["error_msg"].="<br>• Failed to update student's gender: Database error"; 
    $err++;  
   }
  }
 
 if($state && $state != $old_state){
  if(update_user_data($conn,"students","std_state","std_id",$state,$Id,"si")){
  $_SESSION["success_msg"].="<br>• Student's State of origin updated successfully ✓";
      
   $upd++;   
  }
  else{
      
 $_SESSION["error_msg"].="<br>• Failed to update student's state of origin: Database error"; 
    $err++;  
   }
  }
 
 if($lga && $lga != $old_lga){
  if(update_user_data($conn,"students","std_lga","std_id",$lga,$Id,"si")){
  $_SESSION["success_msg"].="<br>• Student's LGA updated successfully ✓";
      
   $upd++;   
  }
  else{
      
 $_SESSION["error_msg"].="<br>• Failed to update student's LGA: Database error"; 
    $err++;  
   }
  }

 if($formattedDOB && $formattedDOB != $old_dob){
  if(update_user_data($conn,"students","birth_date","std_id",$formattedDOB,$Id,"si")){
  $_SESSION["success_msg"].="<br>• Student's Date of birth updated successfully ✓";
      
   $upd++;   
  }
  else{
      
 $_SESSION["error_msg"].="<br>• Failed to update student's LGA: Database error"; 
    $err++;  
   }
  }

 
  if($resident && $resident != $old_resident){
  if(update_user_data($conn,"students","resident","std_id",$resident,$Id,"si")){
  $_SESSION["success_msg"].="<br>• Student's residential address updated successfully ✓";
      
   $upd++;   
  }
  else{
      
 $_SESSION["error_msg"].="<br>• Failed to update student's residential address: Database error"; 
    $err++;  
   }
  }
 
 
 
//upload students profile 
if($profile["name"]){
 $targetFolder ="/images/students/";
 $filename = upload_image_as_webp($profile, $targetFolder, "profile_", $Id);

if($filename && $filename !== "extension_error"){
   //file was uploaded
   update_user_data($conn,"students","profile","std_id",$filename,$Id,"si");
 
   // remove old prf from server 
if (!empty($old_profile)) {
    $old_profile = basename($old_profile);
    $oldprfDir = $_SERVER["DOCUMENT_ROOT"] . '/images/students/' . $old_profile;

    if (is_file($oldprfDir)) {
        unlink($oldprfDir);
    }
}
   
      $upd++;
$_SESSION["success_msg"] .="<br>• Profile updated successfully ✓";

 }
 else{

 $_SESSION["error_msg"] = "profile not updated: file as type not allowed"; 
     
 }
}


 if(!$upd){
 
 unset($_SESSION["success_msg"]);
 
if(!$err){

 $_SESSION["error_msg"] ="You have not made any changes";
 $err++;    
    
   }
 }

 if(!$err){
     
 unset($_SESSION["error_msg"]);
    
 }
 
 //end of execution 
  $_SESSION["autofocus"] = ""; 
$string.="&msg_report=update completed&report=suc";

  unset($_SESSION["sumbit-attempt"]);
 header("Location:$string");
 die();
    
}
else{
  // if std_id is not set at background (hidden_id)  
   
   $_SESSION["autofocus"] = "";  
  $_SESSION["error_msg"]  = "*Sorry, something went wrong, please logout, then login and try again.";
 header("Location: $location");
   die();     
    
}
     
 }
  else{
      
  $_SESSION["autofocus"] = "";  
  $_SESSION["error_msg"]  = "*unknown request";
 header("Location: $location");
   die();     
      
    }   
   }
 }
  
 elseif(isset($_POST["submit-assign-cteach"])){
  
  if(in_array($staff_cat,$appointers)){
  
   $staff =  trim(htmlspecialchars($_POST["staff"],ENT_QUOTES,'UTF-8'));  
   $class =  trim(htmlspecialchars($_POST["class"],ENT_QUOTES,'UTF-8'));   

  if(!$staff || !$class){
       
   $_SESSION["error_msg"] ="Empty data input";  
    header("Location:$location");
    die();    
      
  }
  
elseif(!check_exist($conn,"staffs","staff_id",$staff,"i")){
 
   $_SESSION["error_msg"] ="Invalid Staff";  
    header("Location:$location");
    die();    
    
}

 elseif(check_exist2($conn,"staffs","staff_id","staff_cat",$staff,$dirgen,"is")){
 
   $_SESSION["error_msg"] ="Cannot assign class to the selected staff";  
    header("Location:$location");
    die();    
    
}

 elseif(check_exist($conn,"staffs","class_handling",$class,"s")){

 $staff_det = collect_user_data($conn,"staffs","class_handling",$class,"s");

$staffName = $staff_det["title"]." ".$staff_det["surname"]." ".$staff_det["othernames"];
$Id = $staff_det["staff_id"];

 if($Id == $staff){
    
   $_SESSION["error_msg"] ="$class had already been assigned to $staffName.";  
    header("Location:$location");
    die(); 
     
 } 
 
 $_SESSION["re-assign"] =true;
 $_SESSION["staff"] = $staff;
 $_SESSION["class"] = $class;
 $_SESSION["prev_handler"] = $Id;

   $_SESSION["success_msg"] =''.$class.' had already been assigned to '.$staffName.', do you want to re-assign it? <br>
   <a href="/add_new?re-assign-class" id="re-assign-role">Yes, Re-assign '.$class.'</a>';  
    header("Location:$location");
    die();    
    
}

 else{
      
 //all conditions satisfied 
 
 if(update_user_data($conn,"staffs","class_handling","staff_id",$class,$staff,"si")){
     
//notify staff  
$appt_det = collect_user_data($conn,"staffs","staff_id",$staff_id,"i");
$apptName = $appt_det["title"]." ".$appt_det["surname"]." ".$appt_det["othernames"];


$staff_det = collect_user_data($conn,"staffs","staff_id",$staff,"i");
$staffName = $staff_det["title"]." ".$staff_det["surname"]." ".$staff_det["othernames"];
 $email = $staff_det["email"];
 $site = ucwords(strtolower($site));
 $subject = "New Class Assignment";
$body = "

We’re pleased to inform you that you have been assigned to a new class on <strong>$site</strong> Result Platform.<br><br>

 <strong>Class Assigned:</strong> $class<br>
<strong>Assigned By:</strong> $apptName<br><br>

This class assignment gives you access to features and responsibilities associated with result uploads and compilations for the assigned class. Please log in to your dashboard to explore your new permissions.<br><br>

If you believe this class was assigned in error or you need clarification, kindly contact the administrator.<br><br>

Congratulations, and thank you for being part of our school! <br><br>

<i>Best regards,<br>
$staff_cat,<br>
$site</i>
";
 
 
  $msg =[
      "name" => $staffName,
      "email" => $email,
      "subject" => $subject,
      "body" => $body,
      "attach" => null,
      ];
  
 $insert = inser_into_queue($msg);
  
   $_SESSION["success_msg"] ="Class assigned successfully ✓";  
  
    header("Location:$location");
    die();  
     
 }
 
 else{
     
   $_SESSION["error_msg"] ="Unable to assign class due to sql errors, Please try again.";  
    header("Location:$location");
    die();     
     
     }     
      
   }
  } 
  else{
      
   $_SESSION["error_msg"] ="Sorry you are not authorized to perform this request";  
    header("Location:$location");
    die();   
      
  }
 }

elseif(isset($_POST["submit_add_stds_photo"])){


$std_class = $_POST["std_class"];
$Id = trim($_POST["stds"]);
$profile = $_FILES["stdprofile"];
  
$_SESSION["std_class"] = $std_class;
  
if(!$Id){
      
  $_SESSION["error_msg"] ="Sorry something went wrong, Please refresh the page and try again.";  
    header("Location:$location");
    die();    
    
} 
  
//upload student profile 
if($profile["name"]){
 $targetFolder ="/images/students/";
 $filename = upload_image_as_webp($profile, $targetFolder, "profile_", $Id);

if($filename && $filename !== "extension_error"){
   //file was uploaded
   update_user_data($conn,"students","profile","std_id",$filename,$Id,"si");
  
   $std = get_user_name($Id);
 $std_name = $std["fullname"];
$_SESSION["success_msg"] ="$std_name's photo uploaded successfully ✓";
  
 }
 else{

 $_SESSION["error_msg"] = "profile not uploaded: file as type not allowed"; 
     
 }
}  
else{

 $_SESSION["error_msg"] = "Please select a photo to upload";      
    
} 


  header("Location:$location");
    die();
    
}
 
elseif(isset($_POST["submit-staff-signature"])){
  $signature = trim($_POST["signature"]); 
  $folderName = trim($_POST["folder"]); 
  $staff = trim($_POST["staff"]);  
 
  $folderPath = $_SERVER["DOCUMENT_ROOT"]."/background-remover/uploads/".$folderName;
 $targetSignature = $folderPath."/".$signature;
 $targetSignaturePath = $_SERVER["DOCUMENT_ROOT"]."/images/staff";
 
 //copy signature to $targetSignaturePath
 
 $copySignature = copy_processed_signature($targetSignature, $targetSignaturePath);


 if($copySignature){

  $staffdet = collect_user_data($conn,"staffs","staff_id",$staff,"i");
  $staffname = $staffdet["title"]." ".$staffdet["othernames"];
  $oldSignature = $staffdet["signature"];
  
   //update db    
  update_user_data($conn, "staffs","signature", "staff_id",$signature,$staff,"si");
 
 if($oldSignature !== $signature){
  $oldSignaturePath = $_SERVER["DOCUMENT_ROOT"].'/images/staff/'.$oldSignature;
   if(is_file($oldSignaturePath)){
      unlink($oldSignaturePath);
   } 
 }
 
  $msg = "$staffname's signature was set successfully";
 header("Location:/background-remover/view?folder=".$folderName."&msg_report=".urlencode($msg)."&report=success");
 die();
     
 }
 else{
    
  $msg = "Unable to set signature, please try again.";
 header("Location:/background-remover/view?folder=".$folderName."&msg_report=".urlencode($msg)."&report=failed");
 die();   
 }
}

  //you can add more btns here.
else{
     $_SESSION["error_msg"] ="unknown button name";  
    header("Location:$location");
    die();    
        
    }   
    
    
}  
 else{
 
   $_SESSION["error_msg"] ="*Unauthorized request !";  
    header("Location:$location");
    die();    
     
     
  }   
    
 }
}
else{
    $_SESSION["error_msg"] ="unknown request method";  
    header("Location:$location");
    die();
}

