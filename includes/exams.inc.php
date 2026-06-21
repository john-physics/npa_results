<?php

$location = $_SERVER["HTTP_REFERER"];
if(!$location){
    $location = "/exams";
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
  $root = $_SERVER["DOCUMENT_ROOT"];
 require $root.'/page_init.php';
  

 if(isset($_POST["submit_new_exam_schd"])){
   
  $user_id =  trim(htmlspecialchars($_POST["user_id"],ENT_QUOTES,'UTF-8'));
  $user_cat = trim(htmlspecialchars($_POST["user_cat"],ENT_QUOTES,'UTF-8'));
  $course = trim(htmlspecialchars($_POST["course"],ENT_QUOTES,'UTF-8'));
  $examDate = trim(htmlspecialchars($_POST["exam_date"],ENT_QUOTES,'UTF-8'));
  $examTime = trim(htmlspecialchars($_POST["exam_time"],ENT_QUOTES,"UTF-8"));
  $reminder = trim(htmlspecialchars($_POST["reminder"],ENT_QUOTES,'UTF-8'));
  
   $Extime = date("h:i A",strtotime($examTime));
   $DateObj = new DateTime($examDate);
   $Exdate = $DateObj->format('D d/m/Y');
   
   $examSchedule = $Exdate." ".$Extime;
  
 $schdstrtoTime = strtotime(str_replace('/','-',$examSchedule));
 $todaystrtoTime = strtotime(str_replace('/','-',$DayDateTime));
 
if($schdstrtoTime <= $todaystrtoTime){
    
 $_SESSION["error_msg"] = "Please select a future date and time !";
   
  header("Location:$location");
  die();   
    
}


  if($user_cat == "Student"){
  
  $assPoints = get_Work_Points($era_db,$user_id,$course);
  
  $stdDet = collect_user_data2($era_db,"Fees","Std_ID","Course",$user_id,$course,"is");
  
  $stdTutor = $stdDet["Tutor_ID"];
  $applyStatus = $stdDet["Apply_Fee_Status"];
  $tutFee = $stdDet["Tuition_Fee_Payable"];
  $tutFeeStatus = $stdDet["Tuition_Fee_Status"];
   
  if($applyStatus == "Paid"){
  
  if($tutFeeStatus == "Paid"){
    
  if(!done_with_courses($era_db,$user_id,$course)){
  
    $_SESSION["error_msg"] = "You need to finish learning all the available course contents of $course before you can schedule its exam.";
   
  header("Location:$location");
  die();      
    
   }
  } 
  else{
   
$_SESSION["error_msg"] = 'You have an unpaid tuition fee of '.$naira. number_format($tutFee,2).' for '.$course.'. You need to pay this fees before you can schedule its exam.';
   
  header("Location:$location");
  die();      
      
   }
  } 
  else{
      
     $_SESSION["error_msg"] = "You must apply for a Course and finish its lessons before you can schedule its exam.";
   
  header("Location:$location");
  die();   
      
  }
 }
 elseif($user_cat == "DE-Student"){
  
  $stdTutor = get_random_tutor($home_db,$course);
  $assPoints = "Pending"; 
 
     
 }
 else{
 // default category, for now keep it like the DE-Student category, there may be changes later.    
     
  
   $stdTutor = get_random_tutor($home_db,$course);
   $assPoints = "Pending"; 
  
  }   

  
  //No errors any more, save schedule
  $schdDet = collect_user_data2($era_db,"Exams","Std_ID","Course",$user_id,$course,"is");
 
  $status = $schdDet["Exam_Status"];
  $savedExamdate = $schdDet["Exam_Schedule"];
 $NewExamStatus = "Pending";
 $examPoints = "Pending";

 $courseDet = collect_user_data($era_db,"Fees_Settings","Course",$course,"s");
  $examFee = $courseDet["Exam_Fee"];
  $examFeeStatus = "Pending";
  


 if($status && $savedExamdate){
     
if($status == "Cancelled"){
// schedule was set initially but Cancelled
//update its records
 
$upd1 = update_user_data2($era_db,"Exams","Exam_Schedule","Std_ID","Course",$examSchedule,$user_id,$course,"sis");

$upd2 = update_user_data2($era_db,"Exams","Reminder","Std_ID","Course",$reminder,$user_id,$course,"sis");

$upd3 = update_user_data2($era_db,"Exams","Exam_Status","Std_ID","Course",$NewExamStatus,$user_id,$course,"sis");

 if($upd1 && $upd3){
     
  $_SESSION["success_msg"] = "Your exam schedule for $course was updated successfully ✓<br>
  Initial Schedule: $savedExamdate<br>
  Current Schedule: $examSchedule";
   
header("Location:/exams?schd_status=".$NewExamStatus);
  die();    
        
 }
 else{
     
  $_SESSION["error_msg"] = "Unable to update your exam schedule for $course, please try again.";
   
  header("Location:$location");
  die();     
     
  }
}
 else{
  // schedule already set or exam has been taken    
     
  $_SESSION["success_msg"] = "You have already scheduled an exam for $course, the scheduled date and time is $savedExamdate. You can Cancel this schedule if you are no longer satisfied with it and make another schedule. <br><b>Note:</b>You cannot Cancel the schedule for an exam that's already taken.";
   
  header("Location:$location");
  die();   
     
   }
 }
 else{
 // insert a New record
 
 $data = [
     "conn" => $era_db,
     "table" => "Exams",
     "cols" => ['Std_ID','Std_Cat','Course','Exam_Schedule','Assignment_Points','Exam_Points','Exam_Fee','Exam_Fee_Status','Exam_Status','Std_Tutor','Reminder'],
     "vals" => [$user_id,$user_cat,$course,$examSchedule,$assPoints,$examPoints,$examFee,$examFeeStatus,$NewExamStatus,$stdTutor,$reminder],
     "params" => "issssssssis"
     ];
 
  
  $insert = insert_user_data($data);
 if($insert["status"] == "success"){
     
  $_SESSION["success_msg"] = "Your exam schedule for $course has been saved successfully ✓";
   
  header("Location:/exams?schd_status=".$NewExamStatus);
  die();      
     
 }
 
 else{
    $reasons = $insert["error"]; 
     $_SESSION["error_msg"] ="unable to saved schedule. <br>
     Re: $reasons";  
    header("Location:$location");
    die(); 
     
    }
  
 
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
    $_SESSION["error_msg"] ="unknown request method";  
    header("Location:$location");
    die();
}

