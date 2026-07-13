<?php

// require './show_errors.php';
$location = $_SERVER["HTTP_REFERER"];
if(!$location){
$location = "/home";
}

if($_SERVER["REQUEST_METHOD"] == "POST"){

require $_SERVER["DOCUMENT_ROOT"]."/page_init.php";

if(isset($_POST["submit-ass-records"])){
   
  // GENERAL INFORMATION
$std_id   =   trim($_POST['std_id']);
$class      = trim($_POST['std_class']);
$session    = trim($_POST['session']);
$term       = trim($_POST['term']);
$staff_id   = trim($_POST['staff_id']);
$uploader  = trim($_POST['uploader']);
$ct_cmt = trim($_POST["ct_cmt"]);
$pp_cmt = trim($_POST["pp_cmt"]);


$staff_cat = $_SESSION["staff_cat"];
$cteach = collect_user_data($conn,"staffs","class_handling",$class,"s");
$cteacher = $cteach["staff_id"];

$ass = collect_user_data2($conn,"variables","type","value","Class",$class,"ss");
 $classCat = $ass["classification"];
 $pattern = $ass["assessment_pattern"];
 
 $sucmsg =""; $errmsg="";
 $_SESSION["std_identity"] = $std_id;
 $_SESSION["std_class"] = $class;
 $_SESSION["session"] = $session;
 $_SESSION["term"] = $term;
 $_SESSION["updated_result"] = true;


if(!$staff_cat){
 
 header("Location: /home?msg_report=Please login to continue&report=failed");
   die();
    
}

if(!in_array($staff_cat, $authorized) && $staff_id != $cteacher && $staff_id != $uploader){
   $msg = "You can only upload results against your class";
  header("Location: /upload_results?msg_report=".$msg."&report=failed");
   die();  

}

//check result luck
if(result_lock($term,$session)){
    
 $_SESSION["error_msg"]="Result luck activated and hence cannot modify results of previous terms or sessions, if it is absolutely necessary to do this, please inform the Director or the Principal to deactivate Result Luck.";
   
   header("Location: $location");
   die();
    
}


  //  SUBJECT RESULTS 
if(isset($_POST['subject_id'])){

 $ca_list = explode(':', $pattern);
 $maxca = array_sum($ca_list);
 $maxexam = 100 - $maxca;
 
 $subjects = $_POST['subject_id'];
  
   foreach($subjects as $index => $subject_id){

  $ca1 = (int) trim($_POST['ca1'][$index] ?? 0);
  $ca2 = (int) trim($_POST['ca2'][$index] ?? 0);
  $ca3 = (int) trim($_POST['ca3'][$index] ?? 0);
  $ca4 = (int) trim($_POST['ca4'][$index] ?? 0);
  $exam = (int) trim($_POST['exam'][$index] ?? 0);

  //validate ca  
  $cas = [$ca1,$ca2,$ca3,$ca4];
  if(!validate_cas($cas,$ca_list,$exam)){
  //some values in this row failed validation, skip uploading for the subject: error_msg already from inside validate_cas function.  
    continue;  
    
  }
  
 $total = array_sum($cas) + $exam;
 $minscore = minimum_total_score();
$subject_name = get_subject_name($subject_id);

if($exam > 0 && $total < $minscore){
    $message = "Scores for <b>$subject_name</b> were not updated; "
             . "total score must not be less than <b>$minscore</b>. "
             . "Please adjust the scores and click Update again.";

    if(isset($_SESSION["error_msg"])){
        $_SESSION["error_msg"] .= "<br>$message";
    } else {
        $_SESSION["error_msg"] = $message;
    }

    continue;
} 


if($total > 100){
 $message = "Scores for <b>$subject_name</b> were not updated; "
             . "total score must not be more than <b>100</b>. "
             . "Please adjust the scores and click Update again.";

    if(isset($_SESSION["error_msg"])){
        $_SESSION["error_msg"] .= "<br>$message";
    } else {
        $_SESSION["error_msg"] = $message;
    }

    continue;
} 

  
  $gradeRemark ="";//clear previous grade  
  $grade = "";//clear previous grade 
  $remark ="";
    if($total > 0){
    $gradeRemark = result_grades($total);
    $grade = $gradeRemark["grade"];
    $remark = $gradeRemark["remark"];
    
    } 
    
  $subjectTableName = form_table_name("subject_records_",$session);
   
  if(check_exist4($conn,$subjectTableName,"std_id","term","class","subject",$std_id,$term,$class,$subject_id,"isss")){
  
  //update ca
 foreach ($cas as $index => $ca){
  $updcol = "ca".$index+1;
  
  if($ca){
  update_user_data4($conn,$subjectTableName,$updcol,"std_id","term","class","subject",$ca,$std_id,$term,$class,$subject_id,"iisss"); 
    
  }
 }
 
 //update exam
 if($exam){
     
  update_user_data4($conn,$subjectTableName,"exam","std_id","term","class","subject",$exam,$std_id,$term,$class,$subject_id,"iisss");    
  }
  
 //update total and grade 
  if($total){
  update_user_data4($conn,$subjectTableName,"total","std_id","term","class","subject",$total,$std_id,$term,$class,$subject_id,"iisss");    
  }
 
   if($grade){
  update_user_data4($conn,$subjectTableName,"grade","std_id","term","class","subject",$grade,$std_id,$term,$class,$subject_id,"sisss");    
  }
  
    if($remark){
  update_user_data4($conn,$subjectTableName,"remark","std_id","term","class","subject",$remark,$std_id,$term,$class,$subject_id,"sisss");    
  }
  
  $sucmsg = "Results updated successfully";
  
 }
  
  else{
  //new records 
  $pos = null; //will be determined when done with all uploads
 $status = "Unpublished";
 
  $data = [
    "conn" => $conn,
    "table" => $subjectTableName,
    "cols" => ["staff_id","std_id","term", "class","class_cat","subject","ca1","ca2", "ca3","ca4","exam","total","position","grade","result_status","date_created"],
     "vals" => [$uploader,$std_id,$term,$class,$classCat,$subject_id,$ca1,$ca2,$ca3,$ca4,$exam,$total,$pos,$grade,$status,$DayDateTime],
     "params" =>"iissssiiiiiissss"
     ]; 
   
  $insert = insert_user_data($data);
  
  if($insert["status"] == "success"){
      
  $sucmsg = "Results saved successfully";   
  }
  else{
      
  $errmsg .= "Error saving Results, please try again";   
    
     }
      
   }
 }
}

  
  //Results table
  $resultTableName = form_table_name("results_",$session);
 if(!check_exist3($conn,$resultTableName,"std_id","term","class",$std_id,$term,$class,"iss")){
  
  //new records      
  $status = "Unpublished";
    $std_cat = $classCat;
     $data = [
    "conn" => $conn,
    "table" => $resultTableName,
    "cols" => ["staff_id","std_id","std_cat","term","class","result_status","date_created"],
     "vals" => [$uploader,$std_id,$std_cat,$term,$class,$status,$DayDateTime],
     "params" =>"iisssss"
     ]; 
   
  $insert = insert_user_data($data);
  if($insert["status"] != "success"){
  $errmsg = "failed to save result identities";
  }
     
 }
  
 if($pp_cmt){
  update_user_data3($conn,$resultTableName,"principal_comment","std_id","term","class",$pp_cmt,$std_id,$term,$class,"siss");
 }
  
  if($ct_cmt){
  update_user_data3($conn,$resultTableName,"teacher_comment","std_id","term","class",$ct_cmt,$std_id,$term,$class,"siss");
 }

  // DEVELOPMENT RATINGS  
if(isset($_POST['development'])){
$minrating = 5; $maxrating = 10;

 foreach($_POST['development'] as $development => $rating){
      
if($rating){
 if(is_numeric($rating)){
 if($rating >= $minrating && $rating <= $maxrating){

 $development = strtolower($development);
 update_user_data3($conn,$resultTableName,$development,"std_id","term","class",$rating,$std_id,$term,$class,"iiss");
 
 if(!$sucmsg){
  $sucmsg = "Ratings updated successfully";  
    }
   }
  else{
   $errmsg .= "<br>$development rating must be between $minrating and $maxrating";    
    }   
  }
  else{
  $errmsg .= "<br>$development rating must be a number";   
      
    }  
   }
  }
 }
 
 
//SKILLS RATINGS 
 if(isset($_POST['skills'])){

foreach($_POST['skills'] as $skill => $rating){
if($rating){
    
  if(is_numeric($rating)){
 if($rating >= $minrating && $rating <= $maxrating){
 
 $skill = strtolower($skill);
 update_user_data3($conn,$resultTableName,$skill,"std_id","term","class",$rating,$std_id,$term,$class,"iiss");
  
  if(!$sucmsg){
  $sucmsg = "Ratings updated successfully"; 
  }
  
   }
  else{
   $errmsg .= "<br>$skill rating must be between $minrating and $maxrating";    
    }   
  }
  else{
  $errmsg .= "<br>$skill rating must be a number";   
      
   }
   
    }
  
   }
  }
 

  if(strpos($location,"?")){

  if($errmsg){
  
  if(!isset($_SESSION["error_msg"])){
      $_SESSION["error_msg"] ="Error:";
   }  
      
  $_SESSION["error_msg"] .= $errmsg;
  $location .="&msg_report=Error uploading result, please try again&report=failed";     
  }
  else{
  //suc     
   $location .="&msg_report=$sucmsg&report=success";        
  }
 }
 else{
   
  if($errmsg){
      
  if(!isset($_SESSION["error_msg"])){
   $_SESSION["error_msg"] ="Error:";
   } 
  $_SESSION["error_msg"]  .= $errmsg;
  $location .="?msg_report=Error uploading result, please try again&report=failed";     
  }
  else{
  //suc     
   $location .="?msg_report=$sucmsg&report=success";        
  }  
 }
 
 header("Location: $location");  
 die();
}
else{

if(!isset($_SESSION["error_msg"])){
       $_SESSION["error_msg"] ="Error:";
   } 
   

 $_SESSION["error_msg"] .="<br>Unrecognized button name";
 
 header("Location: $location");

 die();
    
 }
}
else{
    
 header("Location: $location");
 die();
    
}

