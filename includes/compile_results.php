<?php

$location = $_SERVER["HTTP_REFERER"];
if(!$location){
$location = "/home";
}

require $_SERVER["DOCUMENT_ROOT"]."/page_init.php";

if(isset($_GET["next_std_result"])){
    
   $class = trim($_GET["std_class"]);
   $term = trim($_GET["term"]);
   $session = trim($_GET["session"]);
   
   $resultTable = form_table_name("results_",$session);
   $subjectTable = form_table_name("subject_records_",$session);

   $doneResults = collect_table_data2($conn,$resultTable,"term","class",$term,$class,"ss","ASC","std_id");
   
   $class_set = collect_user_data3($conn,"class_set","session","term","class",$session,$term,$class,"sss"); 
   $students = convert_to_array($class_set["students"]);
   
   foreach ($students as $std_id){
   
   if(!in_array($std_id,$doneResults)){
       
 $_SESSION["std_identity"] = $std_id;
 $_SESSION["std_class"] = $class;
 $_SESSION["session"] = $session;
 $_SESSION["term"] = $term;
 $_SESSION["updated_result"] = true;
 
 $std = collect_user_data($conn,"students","std_id",$std_id,"i");
 $stdname = $std["surname"]." ".$std["othernames"];
 $msg = "Add results for $stdname";
  header("Location: /edit_results?msg_report=".$msg."&report=success");
  die();
       
    }    
   }
   
 //check which std has incomplete resultts

foreach ($students as $std_id){
    
   //all stds results were uploaded  
   //gather subjects offered by this std
  $std_dets = collect_user_data($conn,"students","std_id",$std_id,"i");
 $subjects = convert_to_array($class_set["subjects"]);
 $added = convert_to_array($std_dets["added_subjects"]);
 $removed = convert_to_array($std_dets["removed_subjects"]);
 
if($removed){
 $subjects = remove_from_array($removed,$subjects);
}
 
 if($added){
     
 $subjects = merge_into_array($added,$subjects,"end",false);     
     
 }

 $totalscores =  [];
 foreach ($subjects as $subject){
 $subjectname = get_subject_name($subject);
 
 if(!check_exist4($conn,$subjectTable,"std_id","term","class","subject",$std_id,$term,$class,$subject,"isss")){
     
  $_SESSION["std_identity"] = $std_id;
 $_SESSION["std_class"] = $class;
 $_SESSION["session"] = $session;
 $_SESSION["term"] = $term;
 $_SESSION["updated_result"] = true;


 $stdname = $std_dets["surname"]." ".$std_dets["othernames"];
 $msg = "Add $subjectname records for $stdname";
 header("Location: /edit_results?msg_report=".$msg."&report=success");
  die();
          
  }

//records found, proceed

$Asspattern = collect_user_data2($conn,"variables","type","value","Class",$class,"ss");
$pattern = convert_to_array($Asspattern["assessment_pattern"]);
 $totalca = array_sum($pattern);
 $maxexam = 100 - $totalca;
 
  $records = collect_user_data4($conn,$subjectTable,"std_id","term","class","subject",$std_id,$term,$class,$subject,"isss");

  $exam = null_check($records["exam"],0);
  $totalscore = null_check($records["total"],0);
 
 foreach ($pattern as $index => $maxca){
 $cakey = "ca".$index+1; 
 
 if(!$records[$cakey]){
  //checking if some ca have not been uploaded
  
 $_SESSION["std_identity"] = $std_id;
 $_SESSION["std_class"] = $class;
 $_SESSION["session"] = $session;
 $_SESSION["term"] = $term;
 $_SESSION["updated_result"] = true;


 $stdname = $std_dets["surname"]." ".$std_dets["othernames"];
 $msg = "Add ".strtoupper($cakey)." $subjectname records for $stdname";

 header("Location: /edit_results?msg_report=".$msg."&report=success");
  die();   
     
   }
  }

//check if exam for this subject is already uploaded 
  if(!$exam){
      
 $_SESSION["std_identity"] = $std_id;
 $_SESSION["std_class"] = $class;
 $_SESSION["session"] = $session;
 $_SESSION["term"] = $term;
 $_SESSION["updated_result"] = true;

$stdname = $std_dets["surname"]." ".$std_dets["othernames"];
$msg = "Add $stdname's exam record for $subjectname.";

header("Location: /edit_results?msg_report=".$msg."&report=success");
die(); 
   
  }

   } 
  }




//check comments
foreach($students as $std_id){

$result = collect_user_data3($conn,$resultTable,"term","class","std_id",$term,$class,$std_id,"ssi");
$ppComm = $result["principal_comment"];
$cteachComm = $result["teacher_comment"];

 $std_dets = collect_user_data($conn,"students","std_id",$std_id,"i");

if(!$ppComm || !$cteachComm){
 
 $_SESSION["std_identity"] = $std_id;
 $_SESSION["std_class"] = $class;
 $_SESSION["session"] = $session;
 $_SESSION["term"] = $term;
 $_SESSION["updated_result"] = true;
      
 $stdname = $std_dets["surname"]." ".$std_dets["othernames"];
 $msg = "Add comments for $stdname";
  
 $_SESSION["success_msg"] = "Add comments for $stdname. You may view the result first by clicking on the view button below the subjects input then return here to add your comments<br><br>
 <b>NB:</b> You must click on 'Done' button before overall average and positions can be calculated, it will also check if you have uploaded all your students results.";
 
header("Location: /edit_results?msg_report=".$msg."&report=success");
die();

 }
    
}


 //all resultts done, redirect to done-with-results. 
 $_SESSION["std_identity"] = $students[0];
 $_SESSION["std_class"] = $class;
 $_SESSION["session"] = $session;
 $_SESSION["term"] = $term;
 $_SESSION["updated_result"] = true;


 $_SESSION["success_msg"] = "Congratulations! <br> Your students' results have all been uploaded successfully. Please scroll down and click on 'Done' to calculate overall average and students' positions";
 
 $msg = "Upload completed";
header("Location: /edit_results?msg_report=".$msg."&report=success");
die();

}
elseif(isset($_GET["done_with_uploads"])){
    
   $class = trim($_GET["std_class"]);
   $term = trim($_GET["term"]);
   $session = trim($_GET["session"]);
   
   $resultTable = form_table_name("results_",$session);
   $subjectTable = form_table_name("subject_records_",$session);
    
  $doneResults = collect_table_data2($conn,$resultTable,"term","class",$term,$class,"ss","ASC","std_id");
   
   $class_set = collect_user_data3($conn,"class_set","session","term","class",$session,$term,$class,"sss");
   $students = convert_to_array($class_set["students"]);
   
   foreach ($students as $std_id){
  
 $std_dets = collect_user_data($conn,"students","std_id",$std_id,"i");
 $stdname = $std_dets["surname"]." ".$std_dets["othernames"];
 $gender = $std_dets["gender"];
 
 $hisher = strtolower(switch_gender($gender,"possessive_adj"));
 $himher = strtolower(switch_gender($gender,"object"));
   
   if(!in_array($std_id,$doneResults)){
       
 $_SESSION["std_identity"] = $std_id;
 $_SESSION["std_class"] = $class;
 $_SESSION["session"] = $session;
 $_SESSION["term"] = $term;
 $_SESSION["updated_result"] = true;

 
 $_SESSION["error_msg"] ="You must upload results for all the students in your class. $stdname's records were not found, please upload $hisher records or remove $himher from the class.";
 $msg = "Please add results for $stdname";
  header("Location: /edit_results?msg_report=".$msg."&report=failed");
  die();
       
    }
    
  //all stds results were uploaded  
 //gather subjects offered by this std
 $subjects = convert_to_array($class_set["subjects"]);
 $added = convert_to_array($std_dets["added_subjects"]);
 $removed = convert_to_array($std_dets["removed_subjects"]);
 
if($removed){
 $subjects = remove_from_array($removed,$subjects);
}
 
 if($added){
     
 $subjects = merge_into_array($added,$subjects,"end",false);     
     
 }

 $totalscores =  [];
 foreach ($subjects as $subject){
 $subjectname = get_subject_name($subject);
 
 if(!check_exist4($conn,$subjectTable,"std_id","term","class","subject",$std_id,$term,$class,$subject,"isss")){
     
  $_SESSION["std_identity"] = $std_id;
 $_SESSION["std_class"] = $class;
 $_SESSION["session"] = $session;
 $_SESSION["term"] = $term;
 $_SESSION["updated_result"] = true;

 $_SESSION["error_msg"] ="You must upload results for all students in your class in all the subjects in their subject list. <br>$stdname's records for $subjectname was not found, please upload $hisher records or remove the subject from $hisher subject list.";
 $msg = "Please add $subjectname records for $stdname";
  header("Location: /edit_results?msg_report=".$msg."&report=failed");
  die();
          
  }

//records found, proceed

$Asspattern = collect_user_data2($conn,"variables","type","value","Class",$class,"ss");
$pattern = convert_to_array($Asspattern["assessment_pattern"]);
 $totalca = array_sum($pattern);
 $maxexam = 100 - $totalca;
 
  $records = collect_user_data4($conn,$subjectTable,"std_id","term","class","subject",$std_id,$term,$class,$subject,"isss");

  $exam = null_check($records["exam"],0);
  $totalscore = null_check($records["total"],0);
  $mintotal = minimum_total_score();
   
  
 foreach ($pattern as $index => $maxca){
 $cakey = "ca".$index+1; 
 
 if(!$records[$cakey]){
  //checking if some ca have not been uploaded
  
 $_SESSION["std_identity"] = $std_id;
 $_SESSION["std_class"] = $class;
 $_SESSION["session"] = $session;
 $_SESSION["term"] = $term;
 $_SESSION["updated_result"] = true;

 $_SESSION["error_msg"] ="You must upload results for all the students in your class in all the subjects in their subject list. <br>$stdname's records for ".strtoupper($cakey)." $subjectname was not uploaded, please upload $hisher full records.";
 $msg = "Please add ".strtoupper($cakey)." $subjectname records for $stdname";
  header("Location: /edit_results?msg_report=".$msg."&report=failed");
  die();
     
   }
  }

//check if exam for this subject is already uploaded 
  if(!$exam){
      
 $_SESSION["std_identity"] = $std_id;
 $_SESSION["std_class"] = $class;
 $_SESSION["session"] = $session;
 $_SESSION["term"] = $term;
 $_SESSION["updated_result"] = true;

$_SESSION["error_msg"] = "You must upload results for all students in the class and for all subjects in their subject lists. <br>$stdname's exam record for $subjectname has not been uploaded. Please upload $hisher complete result records.";

$msg = "Please upload $stdname's exam record for $subjectname.";

header("Location: /edit_results?msg_report=".$msg."&report=failed");
die(); 
   
 }
  
 //check minimum_total_score
 
if($totalscore < $mintotal){
 // Teacher must correct the entries
    $_SESSION["std_identity"] = $std_id;
    $_SESSION["std_class"] = $class;
    $_SESSION["session"] = $session;
    $_SESSION["term"] = $term;
    $_SESSION["updated_result"] = true;

    $_SESSION["error_msg"] = "The total score entered for $stdname in $subjectname is below the minimum allowed score of $mintotal. Please review and correct $hisher result entries.";

    $msg = "$stdname's total score for $subjectname is below the minimum allowed score.";

    header("Location: /edit_results?msg_report=".$msg."&report=failed");
    die();
 }
  
  //std position in this subject
 $posInsubject = pos_in_subject($conn,$subjectTable,$term,$class,$subject,$totalscore);


if($posInsubject){
update_user_data4($conn,$subjectTable,"position","std_id","term","class","subject",$posInsubject,$std_id,$term,$class,$subject,"sisss");
}

if($DayDateTime){
    
update_user_data4($conn,$subjectTable,"date_created","std_id","term","class","subject",$DayDateTime,$std_id,$term,$class,$subject,"sisss"); 
    
}

if(result_signataries($conn,$resultTable,$term,$class,$std_id,true)){
  $result_status = "Published";
 update_user_data4($conn,$subjectTable,"result_status","std_id","term","class","subject",$result_status,$std_id,$term,$class,$subject,"sisss");
}


  $totalscores[] = $totalscore; 
  
 } 
 
 //done with subject loop, calculate overall_average
  
 $subjectNum = count($totalscores);
 $overallscore = array_sum($totalscores);
 $overallaverage = round($overallscore/$subjectNum,2);
 $totalscoreable = $subjectNum*100;
if($overallaverage){
 $gradeRemark = result_grades($overallaverage,'None');
 $overallgrade = $gradeRemark["grade"];
 $remark = $gradeRemark["remark"];
}


if($subjectNum){
update_user_data3($conn,$resultTable,"subject_num","std_id","term","class",$subjectNum,$std_id,$term,$class,"siss");
}

if($overallscore){
update_user_data3($conn,$resultTable,"total_score","std_id","term","class",$overallscore,$std_id,$term,$class,"siss");
} 
 
 if($totalscoreable){
update_user_data3($conn,$resultTable,"total_scorable","std_id","term","class",$totalscoreable,$std_id,$term,$class,"siss");
}
 
 if($overallaverage){
update_user_data3($conn,$resultTable,"overall_average","std_id","term","class",$overallaverage,$std_id,$term,$class,"siss");
}

  if($overallgrade){
update_user_data3($conn,$resultTable,"overall_grade","std_id","term","class",$overallgrade,$std_id,$term,$class,"siss");
 }
 
  if($remark){
update_user_data3($conn,$resultTable,"general_remark","std_id","term","class",$remark,$std_id,$term,$class,"siss");
 }
 
 if($DayDateTime){
     
 update_user_data3($conn,$resultTable,"date_created","std_id","term","class",$DayDateTime,$std_id,$term,$class,"siss");   
     
 }
 
  if(result_signataries($conn,$resultTable,$term,$class,$std_id,true)){
  $result_status = "Published"; 
 update_user_data3($conn,$resultTable,"result_status","std_id","term","class",$result_status,$std_id,$term,$class,"siss");    
     
  }
  
}
 
  
 //end of student loop, find position_inclass 
 $posInclass = pos_in_class($conn,$term,$class,$resultTable);
 
  //finish... 
  $msg = "$class results compilation has been completed successfully";
 header("Location: /upload_results?msg_report=".$msg."&report=success");
  die();
    
}

else{
    
 header("Location: $location");
 die();
    
}
