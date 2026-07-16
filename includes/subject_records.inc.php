<?php


if($_SERVER["REQUEST_METHOD"]== "POST"){
//  require '/show_errors'; 
   $root = $_SERVER["DOCUMENT_ROOT"];
 require $root.'/page_init.php';
  $string = $_SERVER["HTTP_REFERER"];
$location = extract_query_string($string);
 if(!$location){
     $location = "/home";
 }
 

 if(isset($_SESSION["staff_id"])){
 
 $staff_id = trim($_SESSION['staff_id']);
 }
 
if(!$staff_id){

  $_SESSION["error_msg"] ="please login to continue";
  header("Location:$location");
  die();
    
} 


if(isset($_POST['submit-new-rec-setting'])){
 
  
   $subject = trim($_POST["subject"]);
   $class = trim($_POST["class"]);
   $term =  trim($_POST["term"]);
   $session = trim($_POST["session"]);
   $std_num = trim($_POST["std_num"]);
   $processby = trim($_POST["processby"]);
   
   
   if(!$std_num){
       
   $_SESSION["error_msg"] ="Please enter the number of students offering the selected subject";
  header("Location: $location");
  die();     
       
   }
  
 $record_id = generate_id(6);
 $limit = 1000;
 while($limit && check_exist($conn,"subject_results","record_id",$record_id,"i")){
     
    $record_id = generate_id(6);     
   $limit--;
  
 }
 
 if(!$limit){
     
  $record_id = (int) substr((string) time(), -10);     
     
 }
 
 $serial = 0;
 for($sn = 1; $sn<=$std_num;$sn++){
     
 $data = [
     "conn"=> $conn,
   "table"=>  "subject_results",
     "cols"=> ['record_id','serial','staff_id','class','subject','term','session','date_created'],
     "vals"=> [$record_id,$sn,$staff_id,$class,$subject,$term,$session,$DayDateTime],
     "params"=> "iiisssss"
     ];
 
 $insert = "";
 $insert = insert_user_data($data);
 
  if($insert["status"] == "success"){
     $serial++;
  }  
     
 }
 
 if($serial == $std_num){
  
 $_SESSION["success_msg"] ="Enter students records, Please note that this module is working directly with student's serial number as it is on your score sheet, be careful to enter them accurately.";
  header("Location:/subject_records?enter_students_records&processby=".$processby."&record_id=".$record_id);
  die(); 
     
 }  
 else{

  $_SESSION["error_msg"] ="sorry something went wrong, Please try again";
  header("Location: $location");
  die(); 
     
  }
 
}

elseif(isset($_POST["submit-entered-records"])){
    
  // GENERAL INFORMATION
$staff_id   = trim($_SESSION['staff_id']);
$record_id   =   trim($_POST['record_id']);
$processby  =   trim($_POST['processby']);
$class   =   trim($_POST['class']);


  //  SUBJECT RESULTS 
if(isset($_POST['serial_no'])){
$serials = $_POST['serial_no'];

  $Inuse = collect_user_data($conn,"variables","type","grading_system_inuse","s");
 $gradeData = collect_table_data($conn,"grading_system","upper_limit DESC"); 
 $gradingSystem = [
     "grading_inuse" => $Inuse["value"],
     "grade_data" => $gradeData
     
     ];

if($processby == "totals"){
  $update = false;
  foreach ($serials as $index => $serial){
  
    $total = (int) trim($_POST['totals'][$index] ?? 0);    
  $gradeRemark ="";//clear previous grade  
  $grade = "";//clear previous grade 
  $remark = "";//clear previous remark 
  
   if($total > 0){
    $gradeRemark = result_grades($total,$gradingSystem);
    $grade = $gradeRemark["grade"];
    $remark = $gradeRemark["remark"];
  

  $updateData = [
      
      "total" => $total,
      "grade" => $grade,
      "remark"=>$remark,
      
      ];
  $conditions = [
      "record_id" => $record_id,
      "staff_id"=> $staff_id,
      "serial"=> $serial,

      ];
  
  $update = new_update_user_data(
    $conn,
    "subject_results",
     $updateData,
     $conditions,
    'issiii',
    true
    );
        
  }
  
 } 
  
  
if($update){

//determine position
$totalscores = $_POST["totals"];

foreach ($totalscores as $index => $totalscore){
  $serial = $serials[$index];
  $pos = posInSubject($conn,"subject_results",$record_id,$staff_id,$totalscore);
  
  if($pos){
 update_user_data3($conn,"subject_results","position","record_id","staff_id","serial",$pos,$record_id,$staff_id,$serial,"siii");    
    
  }
    
}



  $msg ="Records processed successfully";
 header("Location:/subject_records?processed_records&msg_report=".$msg."&report=success");
  die();    
    
}
else{
  
   $_SESSION["error_msg"] ="No changes made";
 header("Location:/subject_records?enter_students_records&processby=".$processby."&record_id=".$record_id);
  die();  
    
 }
} 
else{
//assessments    
  
 $classdet = collect_user_data2($conn,"variables","type","value","Class",$class,"ss");

$assPattern = convert_to_array($classdet["assessment_pattern"]);
$maxexam = 100 - array_sum($assPattern);
$totalscores = [];
 $update = false;
   foreach($serials as $index => $serial){

  $ca1 = (int) trim($_POST['ca1'][$index] ?? 0);
  $ca2 = (int) trim($_POST['ca2'][$index] ?? 0);
  $ca3 = (int) trim($_POST['ca3'][$index] ?? 0);
  $ca4 = (int) trim($_POST['ca4'][$index] ?? 0);
  $exam = (int) trim($_POST['exam'][$index] ?? 0);
 
 $cas = [$ca1,$ca2,$ca3,$ca4];
 $implodecas = implode(":",$cas);
 $totalcas = array_sum($cas);
 $total =  $totalcas + $exam;
 $totalscores[] = $total;
 
 $gradeRemark ="";//clear previous grade  
  $grade = "";//clear previous grade 
  $remark = "";//clear previous remark 
  
    if($total > 0){
    $gradeRemark = result_grades($total,$gradingSystem);
    $grade = $gradeRemark["grade"];
    $remark = $gradeRemark["remark"];
    
    }
  
  $updateData = [
      "cas"=> $implodecas,
      "exam" => $exam,
      "total" => $total,
      "grade" => $grade,
      "remark"=>$remark,
      
      ];
  $conditions = [
      "record_id" => $record_id,
      "staff_id"=> $staff_id,
      "serial"=> $serial,

      ];
  
  $update = new_update_user_data(
    $conn,
    "subject_results",
     $updateData,
     $conditions,
    'siissiii',
    true
    );
  
 }
  

if($update){ 
 foreach ($totalscores as $index => $totalscore){
  $serial = $serials[$index];
  $pos = posInSubject($conn,"subject_results",$record_id,$staff_id,$totalscore);
  
  if($pos){
 update_user_data3($conn,"subject_results","position","record_id","staff_id","serial",$pos,$record_id,$staff_id,$serial,"siii");    
    
  }
    
  }

  $msg ="Records processed successfully";
 header("Location:/subject_records?processed_records&msg_report=".$msg."&report=success");
  die();
}
else{
    
    
   $_SESSION["error_msg"] ="No changes made";
 header("Location:/subject_records?enter_students_records&processby=".$processby."&record_id=".$record_id);
  die(); 
    
     }

   } 
 }
 
 else{
     
   $_SESSION["error_msg"] ="Unknown request";
  header("Location: $location");
  die();     
     
 }
}
else{
    
  $_SESSION["error_msg"] ="Unregconized button";
  header("Location: $location");
  die();  
    
 }
}
 else{
    
  header("Location: $location");
  die();
    
} 