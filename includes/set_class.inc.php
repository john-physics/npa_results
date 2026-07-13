<?php

if($_SERVER["REQUEST_METHOD"] =="POST"){
 
 require $_SERVER["DOCUMENT_ROOT"].'/page_init.php';

  $data = json_decode(file_get_contents('php://input'), true);
  $btn = trim($data["button_name"]); 


if(isset($_SESSION["staff_id"])){
    
 $userId= $_SESSION["staff_id"];
 $userCat = $_SESSION["staff_cat"];
 $current = get_current_session();
$CurrentSession = $current['session'];
$currentTerm = $current["term"];

$staff_det = get_user_name($userId); 
$staff_name= $staff_det["fullname_title"];
 
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
 
 
 if($btn == "load_students"){ 
   
 $class = trim($data["class_name"]);
  $term_session   =   trim($data["term_session"]);
  $explode = explode(" ",$term_session);
  $term = $explode[0]." ".$explode[1];
  $session = $explode[2];
  
$students = fetch_students($conn,$class);

 /* the function above first load students in the passed class and related atms
  then load Students in nearby classes (1 class behind and after)
  */ 
  $loadedstutdents = $students; //initially $loadedstutdents

  $class_set = collect_user_data4($conn,"class_set","staff_id","session","term","class",$userId,$session,$term,$class,"isss");
  
  if($class_set){
  $class_students = convert_to_array($class_set["students"]);
  if($class_students && is_array($class_students)){
      
   $loadedstutdents = []; //reset $loadedstutdents to remove those in class already
   
   foreach ($students as $stutdent){
   
   $std_id = $stutdent["id"];
   $std_name = $stutdent["name"];
   if(!in_array($std_id,$class_students)){
    
     $loadedstutdents[] = $stutdent;
      
     }
       
   }
  } 
 
 }

  
 if($loadedstutdents){ 
     
        $response = [
     "status" => "success",
     "error" => "none",
     "message" => "Students loaded successfully ✓",
     "students" => $loadedstutdents,
      ];
      
echo json_encode($response);
exit();   
     
 }
 else{
     
        $response = [
     "status" => "success",
     "error" => "No students",
    "message" => "No new students to add",
     "students" => [],
      ];
      
echo json_encode($response);
exit();   
     
   }
     
 }
 
 
 elseif($btn == "save_students"){
 
  $class = trim($data["class_name"]);
  $term_session = trim($data["term_session"]);
  $students = $data["students"]??[];
  $staff_id = trim($data["staff_id"]);
  
   if(!$staff_id){
       
       $response = [
     "status" => "failed",
     "error" => "user_login",
     "message" => "Please login to continue !",
      ];
echo json_encode($response);
exit();     
       
   }
   
   elseif(!$students){
       
       $response = [
     "status" => "failed",
     "error" => "select_error",
     "message" => "Please select atleast 1 student!",
      ];
echo json_encode($response);
exit();    
       
   }
   else{
     
  $explode = explode(" ",$term_session);
  $term = $explode[0]." ".$explode[1];
  $session = $explode[2];
 
  $students = sort_stds($conn,"students", $students,"sortbynames");
  $ImpStds = implode(":",$students);
    
   if(check_exist4($conn,"class_set","staff_id","session","term","class",$staff_id,$session,$term,$class,"isss")){
  //update records
  
 if(update_user_data4($conn,"class_set","students","staff_id","session","term","class",$ImpStds,$staff_id,$session,$term,$class,"sisss")){
     
  update_user_data4($conn,"class_set","date_created","staff_id","session","term","class",$DayDateTime,$staff_id,$session,$term,$class,"sisss");
  
update_stds_class($conn,$students,$class);
  
      $response = [
     "status" => "success",
     "error" => "None",
     "message" => "$class students updated successfully",
      ];
echo json_encode($response);
exit(); 
  
     
 }
 else{
     
     $response = [
     "status" => "failed",
     "error" => "sql_error",
     "message" => "Unable to update $class students, Please try again.",
      ];
echo json_encode($response);
exit();   
     
     }
   }
   else{
  //new records     
       
  $insertData =[
     "conn" => $conn,
     "table" => "class_set",
     "cols" => ['staff_id','session','term','class','students','date_created'],
     
     "vals"=> [$staff_id,$session,$term,$class,$ImpStds,$DayDateTime],
     "params" => "isssss"
      
      ];
  
 $insert = insert_user_data($insertData);
 
 if($insert["status"] =="success"){
  
update_stds_class($conn,$students,$class);
 
      $response = [
     "status" => "success",
     "error" => "None",
     "message" => "$class students added successfully",
      ];
echo json_encode($response);
exit();    
    
     
 }
 else{
     
    
     $response = [
     "status" => "failed",
     "error" => "sql_error",
     "message" => "Unable to add students to $class, Please try again.",
      ];
echo json_encode($response);
exit();    
     
     
     }
    }
   }
 }
 
  elseif($btn == "save_subjects"){
 
  $class = trim($data["class_name"]);
  $term_session = trim($data["term_session"]);
  $subjects = $data["subjects"]??[];
  $staff_id = trim($data["staff_id"]);
  
   if(!$staff_id){
       
       $response = [
     "status" => "failed",
     "error" => "user_login",
     "message" => "Please login to continue !",
      ];
echo json_encode($response);
exit();     
       
   }
   
   elseif(!$subjects){
       
       $response = [
     "status" => "failed",
     "error" => "select_error",
     "message" => "Please select atleast 1 subject!",
      ];
echo json_encode($response);
exit();    
       
   }
   else{
     
  $explode = explode(" ",$term_session);
  $term = $explode[0]." ".$explode[1];
  $session = $explode[2];
  
 $subjects = sort_stds($conn, "variables", $subjects, "sortsubjects");
  
  $ImpSubjects = implode(":",$subjects);
    
   if(check_exist4($conn,"class_set","staff_id","session","term","class",$staff_id,$session,$term,$class,"isss")){
  //update records
  
 if(update_user_data4($conn,"class_set","subjects","staff_id","session","term","class",$ImpSubjects,$staff_id,$session,$term,$class,"sisss")){
     
  update_user_data4($conn,"class_set","date_created","staff_id","session","term","class",$DayDateTime,$staff_id,$session,$term,$class,"sisss");
  
      $response = [
     "status" => "success",
     "error" => "None",
     "message" => "$class subjects updated successfully",
      ];
echo json_encode($response);
exit(); 
  
     
 }
 else{
     
     $response = [
     "status" => "failed",
     "error" => "sql_error",
     "message" => "Unable to update $class subjects, Please try again.",
      ];
echo json_encode($response);
exit();   
     
     }
   }
   else{
  //new records     
       
  $insertData =[
     "conn" => $conn,
     "table" => "class_set",
     "cols" => ['staff_id','session','term','class','subjects','date_created'],
     
    "vals"=> [$staff_id,$session,$term,$class,$ImpSubjects,$DayDateTime],
     "params" => "isssss"
      
      ];
  
 $insert = insert_user_data($insertData);
 
 if($insert["status"] =="success"){
  
      $response = [
     "status" => "success",
     "error" => "None",
     "message" => "$class subjects added successfully",
      ];
echo json_encode($response);
exit();    
    
     
 }
 else{
     
    
     $response = [
     "status" => "failed",
     "error" => "sql_error",
     "message" => "Unable to add $class subjects, Please try again.",
      ];
echo json_encode($response);
exit();    
     
     
     }
    }
   }
 }
 
 elseif($btn == "load_subjects"){
  
  $std_class = trim($data["class_name"]);
  $term_session   =   trim($data["term_session"]);
  $explode = explode(" ",$term_session);
  $term = $explode[0]." ".$explode[1];
  $session = $explode[2];
  
 $class_set = collect_user_data4($conn,"class_set","staff_id","session","term","class",$userId,$session,$term,$std_class,"isss");
  $class_subjects = convert_to_array($class_set["subjects"]);
  
  $subjects = collect_table_data1($conn,"variables","type","Subject","s","value ASC","id");
  
$loadedsubjects =[];  

foreach ($subjects as $subject_id){
    
  if(!in_array($subject_id,$class_subjects)){
      
   $subject_name = get_subject_name($subject_id);  
     
   $subject = [
       "id" => $subject_id,
       "name" => $subject_name,
       
       ]; 
    
  $loadedsubjects[] = $subject;    
  } 
      
}

  if($loadedsubjects){
     
    $response = [
     "status" => "success",
     "error" => "none",
     "message" => "Subjects loaded successfully ✓",
     "subjects" => $loadedsubjects,
      ];
      
echo json_encode($response);
exit();   
      
  }
   
else{
    
    $response = [
     "status" => "failed",
     "error" => "No Subjects",
     "message" => "No new subject to add",
     "subjects" => [],
      ];
      
echo json_encode($response);
exit();

  }

 }
 elseif($btn == "load_remove_students"){
  
  $class = trim($data["class_name"]);
  $students = [];
   $classDet = collect_user_data4($conn,"class_set","staff_id","session","term","class",$userId,$CurrentSession,$currentTerm,$class,"isss");
  
  if($classDet){
      
  $stds = convert_to_array($classDet["students"]);     
  
  foreach ($stds as $std_id){
      
  $det = collect_user_data($conn,"students","std_id",$std_id,"i");
  $name = $det["surname"]." ".$det["othernames"];
      
  $std_det = [
      "id" => $std_id,
      "name" => $name,
      
      ];
      
  $students[] = $std_det;    
    
   }
   
  
     $response = [
     "status" => "success",
     "error" => "none",
     "message" => "students loaded successfully",
     "students" => $students,
      ];
echo json_encode($response);
exit();  
   
  }
  else{
      
   $response = [
     "status" => "failed",
     "error" => "empty class",
     "message" => "No students found!",
     "students" => [],
      ];
echo json_encode($response);
exit();   
        
      
  }
 }
 
  elseif($btn == "load_remove_subjects"){
  
  $class = trim($data["class_name"]);

  $subjects = [];
  $classDet = collect_user_data4($conn,"class_set","staff_id","session","term","class",$userId,$CurrentSession,$currentTerm,$class,"isss");
  
  if($classDet){
      
  $subjs = convert_to_array($classDet["subjects"]);     
  
  foreach ($subjs as $sub){
      
  $det = collect_user_data2($conn,"variables","id","type",$sub,"Subject","is");
  $sub_name = $det["value"];
      
  $subj_det = [
      "id" => $sub,
      "name" => $sub_name,
      
      ];
      
  $subjects[] = $subj_det;    
    
   } 
   
  
     $response = [
     "status" => "success",
     "error" => "none",
     "message" => "subjects loaded successfully",
     "subjects" => $subjects,
      ];
echo json_encode($response);
exit();  
   
  }
  else{
      
   $response = [
     "status" => "failed",
     "error" => "empty class",
     "message" => "No subject found!",
     "subjects" => [],
      ];
echo json_encode($response);
exit();   
        
      
  }
 }
 
 elseif($btn == "remove_students"){

    $selected = $data["selected"] ?? [];
   $class = trim($data["class_name"]);
   
   $classDet = collect_user_data4($conn,"class_set","staff_id","session","term","class",$userId,$CurrentSession,$currentTerm,$class,"isss");
     
   $stds = convert_to_array($classDet["students"]);     
  $newstds = remove_from_array($selected,$stds);
 
  if($newstds){
  $newstds = sort_stds($conn,"students", $newstds,"sortbynames");
    $newStudents = implode(":",$newstds);
      
  }
  else{
      
     $newStudents =  null;
  }
     
 if(update_user_data4($conn,"class_set","students","staff_id","session","term","class",$newStudents,$userId,$CurrentSession,$currentTerm,$class,"sisss")){
     
      
    echo json_encode([
        "status" => "success",
        "message" => count($selected)." students removed successfully"
    ]);

    exit();  
     
      
 }
  else{
     
    echo json_encode([
        "status" => "failed",
        "message" => "Unable to remove students, Please try again.",
    ]);

    exit();
  }
 
}

elseif($btn == "remove_subjects"){

 $selected = $data["selected"] ?? [];
 $class = trim($data["class_name"]);
 
$sessionTerm = get_current_session();
$CurrentSession = $sessionTerm["session"];
$currentTerm = $sessionTerm["term"];

  foreach ($selected as $select){
      
    if(variable_contain_results($conn,$select,"Subject",$CurrentSession,$class)){
        
        echo json_encode([
        "status" => "failed",
        "message" => "Some selected items already contain results and hence cannot be removed",
    ]);

    exit();   
        
    }
  }

 $classDet = collect_user_data4($conn,"class_set","staff_id","session","term","class",$userId,$CurrentSession,$currentTerm,$class,"isss");
  
  $subjs = convert_to_array($classDet["subjects"]);     
  $newsubjs = remove_from_array($selected,$subjs,"end",false);
  
  if($newsubjs){
      
  $newsubjs = sort_stds($conn, "variables", $newsubjs, "sortsubjects");
   $newSubjects = implode(":",$newsubjs);
      
  }
  else{
    $newSubjects = null;  
      
  }
     
 if(update_user_data4($conn,"class_set","subjects","staff_id","session","term","class",$newSubjects,$userId,$CurrentSession,$currentTerm,$class,"sisss")){
      
    echo json_encode([
        "status" => "success",
        "message" => count($selected)." subjects removed successfully"
    ]);

    exit();  
     
 }
  else{
     
    echo json_encode([
        "status" => "success",
        "message" => "Unable to remove subjects, Please try again.",
    ]);

    exit();
  }
 
}

 elseif($btn == "save_add_students"){

    $selected = $data["selected"] ?? [];
   $class = trim($data["class_name"]);
   
   $classDet = collect_user_data4($conn,"class_set","staff_id","session","term","class",$userId,$CurrentSession,$currentTerm,$class,"isss");
     
   $stds = convert_to_array($classDet["students"]);     
  $newstds = merge_into_array($selected,$stds,"end",false);
   $newstds = sort_stds($conn, "students", $newstds, "sortbynames");
  $newStudents = implode(":",$newstds);
    
 if(update_user_data4($conn,"class_set","students","staff_id","session","term","class",$newStudents,$userId,$CurrentSession,$currentTerm,$class,"sisss")){
     
 update_stds_class($conn,$newstds,$class);
     
    echo json_encode([
        "status" => "success",
        "message" => count($selected)." students added successfully"
    ]);

    exit();  
     
     
 }
  else{
     
    echo json_encode([
        "status" => "success",
        "message" => "Unable to remove students, Please try again.",
    ]);

    exit();
  }
 
}

elseif($btn == "save_add_subjects"){

 $selected = $data["selected"] ?? [];
   $class = trim($data["class_name"]);
   
   $classDet = collect_user_data4($conn,"class_set","staff_id","session","term","class",$userId,$CurrentSession,$currentTerm,$class,"isss");
     
   $subjs = convert_to_array($classDet["subjects"]);     
  $newsubjs = merge_into_array($selected,$subjs,"end",false);
 
  $newsubjs = sort_stds($conn, "variables", $newsubjs, "sortsubjects");
  $newSubjects = implode(":",$newsubjs);
    
 if(update_user_data4($conn,"class_set","subjects","staff_id","session","term","class",$newSubjects,$userId,$CurrentSession,$currentTerm,$class,"sisss")){
     
      
    echo json_encode([
        "status" => "success",
        "message" => count($selected)." subjects added  successfully"
    ]);

    exit();  
     
 }
  else{
     
    echo json_encode([
        "status" => "success",
        "message" => "Unable to remove subjects, Please try again",
    ]);

    exit();
  }
 
}

elseif($btn == "delete_all_results"){
 
  $term_session = trim($data["term_session"]);
  $delete_reason = trim($data["delete_reason"]);   
  $staff_psw = trim($data["staff_psw"]);  
 
$wordCount=str_word_count($delete_reason);

if ($wordCount < 3) {
   $response = [
     "status" => "failed",
     "error" => "Reason",
     "message" => "Reason is too short. Please provide at least 3 words",
      ];
echo json_encode($response);
exit();
}
 
if($authorized && is_array($authorized)){
    
  if(in_array($userCat,$authorized)){
  
 
  if(!allow_result_deletion()){
     
   $response = [
     "status" => "failed",
     "error" => "Authorization",
     "message" => "Deletion of results is not allowed at the moment.",
      ];
echo json_encode($response);
exit();    
     
 }
 
  $explode = explode(" ",$term_session);
  $term = $explode[0]." ".$explode[1];
  $session = $explode[2]; 
  $table = form_table_name("results_",$session);  
  
  $staff = collect_user_data2($conn,"staffs","staff_id","staff_cat",$userId,$userCat,"is");
 if($staff){
 $loginPsw = $staff["login_psw"];
 $staff_name = $staff["title"]." ".$staff["surname"]." ".$staff["othernames"];
 
 
 if($loginPsw){
  
 if(password_verify($staff_psw,$loginPsw)){
  
  if(check_exist_table($conn,$table)){
      
  if(table_contains_data($conn,$table)){
 
 $backup = backup_results($conn,$session,$term,$table);

if($backup){

$records = count_table_data($conn,$table);
 
  if(delete_user_data($conn,$table,"term",$term,"s")){

//clean up subject_records
$subjectTableName = form_table_name("subject_records_",$session);
delete_user_data($conn,$subjectTableName,"term",$term,"s");
  
  //log action 
  $action = "Deleted All Results";
$log = log_admin_action($conn,$userId,$staff_name,$action,$delete_reason, $records,$session,$term,$backup);
 
   $response = [
     "status" => "success",
     "error" => "none",
     "message" => "All results for $term_session were deleted successfully",
      ];
echo json_encode($response);
exit();      
    
   }
   else{
       
   $response = [
     "status" => "failed",
     "error" => "invalid database table",
     "message" => "Unable to perform your request. <br>Error desc: Error executing database query",
      ];
echo json_encode($response);
exit();      
           
    }

}
else{

  $response = [
     "status" => "failed",
     "error" => "back error",
     "message" => "Unable to perform your request, Please try again",
      ];
echo json_encode($response);
exit(); 
  }
 
 }
  else{
  
  $response = [
     "status" => "failed",
     "error" => "invalid database table",
     "message" => "Unable to perform your request.  Error desc: No results found for $term_session",
      ];
echo json_encode($response);
exit();      
      
   }  
  }  
  
  else{
 
   $response = [
     "status" => "failed",
     "error" => "invalid database table",
     "message" => "Unable to perform your request.   <br>Error desc: $term_session results does not exist at the moment",
      ];
echo json_encode($response);
exit();      
      
  }
 }
  
 else{
  $response = [
     "status" => "failed",
     "error" => "invalid psw",
     "message" => "Unable to perform your request.  <br>Error desc: Invalid login password",
      ];
echo json_encode($response);
exit();           
       
   }  
 }
 else{
$response = [
     "status" => "failed",
     "error" => "invalid identity",
     "message" => "Unable to perform your request.  <br>Error desc: Invalid login identity!, Please logout, and login then try again.",
      ];
echo json_encode($response);
exit();         
      
    }
 }
  else{
 
   $response = [
     "status" => "failed",
     "error" => "invalid identity",
     "message" => "Unable to perform your request.   <br>Error desc: Invalid login identity!, Please logout, and login then try again.",
      ];
echo json_encode($response);
exit();         
      
  }
 }
 else{
     
   $response = [
     "status" => "failed",
     "error" => "Unauthorized",
     "message" => "Unable to perform your request.   <br>Error desc: Permission denied!",
      ];
echo json_encode($response);
exit();     
       
 }
}
else{
    
 $response = [
     "status" => "failed",
     "error" => "Missing constants",
     "message" => "Unable to perform your request, Please try again.   <br>awError desc: Some important constants are missing, if this error persist consult the developer of this system to fix the missing files.",
      ];
echo json_encode($response);
exit();     
    
 }
}

elseif($btn == "delete_single_result"){
    
  $std_id = trim($data["std_id"]);
  $class = trim($data["std_class"]);
  $term = trim($data["term"]);
  $session = trim($data["session"]);
  
 if(!$std_id || !$class || !$term || !$session || !$authorized){
     
   $response = [
     "status" => "failed",
     "error" => "Empty Data Input",
     "message" => "Something went wrong, Please try again",
      ];
echo json_encode($response);
exit();   
     
 }
 elseif(!in_array($userCat,$authorized)){
     
   $response = [
     "status" => "failed",
     "error" => "Authorization",
     "message" => "Sorry, you are not authorized to perform this action",
      ];
echo json_encode($response);
exit();      
     
 }
 elseif(!allow_result_deletion()){
     
   $response = [
     "status" => "failed",
     "error" => "Authorization",
     "message" => "Deletion of results is not allowed at the moment.",
      ];
echo json_encode($response);
exit();    
     
 }
  else{
 //you may now delete 
    //Results table
  $resultTableName = form_table_name("results_",$session);
  $subjectTableName = form_table_name("subject_records_",$session);
   
  $student = collect_user_data($conn,"students","std_id",$std_id,"i");
  $studentname = $student["surname"]." ".$student["othernames"];
  if(delete_user_data3($conn,$resultTableName,"std_id","term","class",$std_id,$term,$class,"iss")){
 //clean up subject_records 
 delete_user_data3($conn,$subjectTableName,"std_id","term","class",$std_id,$term,$class,"iss");     
     
    //log action 
  $action = "Deleted one result";
  $delete_reason = "Not specified";
  $backup = "Not available";
  $records = 1;
 $log = log_admin_action($conn,$userId,$staff_name,$action,$delete_reason, $records,$session,$term,$backup);
    
      $response = [
     "status" => "success",
     "error" => "none",
     "message" => "One result deleted successfully",
      ];
echo json_encode($response);
exit();   
      
  }
  else{
  
    $response = [
     "status" => "failed",
     "error" => "SQL Error",
     "message" => "Unable to delete result due to sql errors.",
      ];
echo json_encode($response);
exit();     
      
      
   }   
  }
}

elseif($btn == "min_result_score"){
    
  $score = trim($data["minimum_score"]); 
   
    if(!$score){
     
   $response = [
     "status" => "failed",
     "error" => "Empty Data Input",
     "message" => "Please enter minimum score for total score per subject",
      ];
echo json_encode($response);
exit();   
     
 }
 elseif(!in_array($userCat,$appointers)){
     
   $response = [
     "status" => "failed",
     "error" => "Authorization",
     "message" => "Sorry, you are not authorized to perform this action",
      ];
echo json_encode($response);
exit();      
     
 }
 
  elseif(!is_numeric($score)){
     
   $response = [
     "status" => "failed",
     "error" => "data type",
     "message" => "Score must be a number",
      ];
echo json_encode($response);
exit();      
     
 }
 else{
  
  $type = "minimum_score";   
  if(check_exist($conn,"variables","type",$type,"s")) {
      
  update_user_data($conn,"variables","value","type",$score,$type,"ss");
  
  
      $response = [
     "status" => "success",
     "error" => "none",
     "message" => "Minimum score updated successfully",
      ];
echo json_encode($response);
exit(); 
      
  }
  else{
 $newRecords = [
     "conn" => $conn,
     "table" => "variables",
     "cols" => ['type','value','classification'],
     "vals" =>[$type,$score,"General"],
     "params" => "sss",
     ];    
      
  $insert = insert_user_data($newRecords);
  
  if($insert["status"] == "success"){
      
     $response = [
     "status" => "success",
     "error" => "none",
     "message" => "Minimum score saved successfully",
      ];
echo json_encode($response);
exit();   
      
  }
 else{
     
     $response = [
     "status" => "failed",
     "error" => "SQL Error",
     "message" => "Unable to save $type, Please try again",
      ];
echo json_encode($response);
exit();   
     
    }  
      
  }
 }   
}
elseif($btn =="general_settings"){

 $setting = trim($data["setting"]);
 $value = trim($data["value"]);
  
 if(!in_array($userCat,$appointers)){
     
   $response = [
     "status" => "failed",
     "error" => "Authorization",
     "message" => "Sorry, you are not authorized to perform this action",
      ];
echo json_encode($response);
exit();      
     
 }
 else{
 //site_lock 
 //result_lock 
 //result_deletion 
 //red_ink 
 //show_position_inclass
 
 if($value == 1){
  $value = "On";   
 }
 else{
     $value = "Off";
 }
 
 if($setting == "delete_result"){
 $setting = "result_deletion";
 }
 
 
 if(check_exist($conn,"variables","type",$setting,"s")){
     
  update_user_data($conn,"variables","value","type",$value,$setting,"ss");
  
  
    //log action 
  $action = "Updated $setting to $value";
  $delete_reason = "Not specified";
  $backup = "Not available";
  $records = 1;
 $log = log_admin_action($conn,$userId,$staff_name,$action,$delete_reason, $records,$CurrentSession,$currentTerm,$backup);
   
      $response = [
     "status" => "success",
     "error" => "none",
     "message" => "settings updated successfully",
      ];
echo json_encode($response);
exit();    
     
 }

 else{

  $newRecords = [
     "conn" => $conn,
     "table" => "variables",
     "cols" =>['type','value','classification'],
     "vals" =>[$setting,$value,"General"],
     "params" => "sss",
     ];    
      
  $insert = insert_user_data($newRecords);
  
  if($insert["status"] == "success"){
      
     $response = [
     "status" => "success",
     "error" => "none",
     "message" => "$setting saved successfully",
      ];
echo json_encode($response);
exit();    
      
  }
 else{
     
     $response = [
     "status" => "failed",
     "error" => "SQL Error",
     "message" => "Unable to save $setting, Please try again",
      ];
echo json_encode($response);
exit();   
     
    }      
   }
 }
}

elseif($btn =="load_subjects_action"){

  $action = trim($data["action_type"]);
  $std_id  =  trim($data["std_id"]);
  $std_class = trim($data["std_class"]);
  $term   =   trim($data["term"]);
  $session  = trim($data["session"]);
  
  $class_set = collect_user_data3($conn,"class_set","session","term","class",$session,$term,$std_class,"sss");
  $class_subjects = convert_to_array($class_set["subjects"]);
  
  $std_det = collect_user_data($conn,"students","std_id",$std_id,"i");
 $previousadded = convert_to_array($std_det["added_subjects"]);
 $previousremoved = convert_to_array($std_det["removed_subjects"]);

 $Allsubjects = collect_table_data1($conn,"variables","type","Subject","s","","id");
  
  if($action == "add_subjects"){
  
  $class_subjects = merge_into_array($previousadded,$class_subjects,"end",false);
      
  $addableSubjects = [];
  foreach ($Allsubjects as $subject_id){
       
 if(!in_array($subject_id,$class_subjects)){
     
   $subject_name =  get_subject_name($subject_id);      
   
   $subject = [
       "id" =>$subject_id,
       "name" => $subject_name
       ];
       
      $addableSubjects[] = $subject;
         
     }  
   }
   
   /* select subj that were initially dropped */
   foreach($previousremoved as $removed){
   $subject_name =  get_subject_name($removed);      
   $subject = [
       "id" =>$removed,
       "name" => $subject_name
       ];
     
     if(!in_array($subject,$addableSubjects)){
   
    $addableSubjects[] = $subject;    
         
     }
     
   }
  
  
   if($addableSubjects){
       
     $response = [
     "status" => "success",
     "error" => "none",
     "message" => "subjects loaded successfully",
     "subjects" => $addableSubjects,
      ];
echo json_encode($response);
exit(); 
  
   }
   else{
  
   $response = [
     "status" => "failed",
     "error" => "No Subjects",
     "message" => "No new subject to add!",
     "subjects" => [],
      ];
echo json_encode($response);
exit(); 
     
   }
  }
  
  elseif($action == "remove_subjects"){
   
  $subjects = remove_from_array($previousremoved,$class_subjects);
  /* drop subjects that were initially removed to avoid removing already removed subjects */
     
   $removeableSubjects = [];
   
   foreach ($subjects as $subject_id){
       
   $subject_name =  get_subject_name($subject_id);      
   
   $subject = [
       "id" =>$subject_id,
       "name" => $subject_name
       ];
       
      $removeableSubjects[] = $subject;
             
   }
   

  /* select subj that were initially added for dropping */
   foreach($previousadded as $added){
   
   $subject_name =  get_subject_name($added);      
   $subject = [
       "id" =>$added,
       "name" => $subject_name
       ];
      
     if(!in_array($subject,$removeableSubjects)){
   
    $removeableSubjects[] = $subject;     
         
     } 
   }
  
  
   if($removeableSubjects){
       
       $response = [
     "status" => "success",
     "error" => "none",
     "message" => "subjects loaded successfully",
     "subjects" => $removeableSubjects,
      ];
echo json_encode($response);
exit();     
       
   }
  else{
 
   $response = [
     "status" => "failed",
     "error" => "No Subjects",
     "message" => "No subjects to be removed",
     "subjects" => [],
      ];
echo json_encode($response);
exit();        
      
   } 
  }
  
  else{
      
    $response = [
     "status" => "failed",
     "error" => "Action type",
     "message" => "Unrecognized action type !",
      ];
echo json_encode($response);
exit();   
  }
}

elseif($btn =="save_action_type"){
    
  $action = trim($data["action_type"]);
  $std_id  =  trim($data["std_id"]);
  $std_class = trim($data["std_class"]);
  $term   =   trim($data["term"]);
  $session  = trim($data["session"]);
  $selected = $data["selected"] ?? [];
  
   $class_set = collect_user_data3($conn,"class_set","session","term","class",$session,$term,$std_class,"sss");
  $class_subjects = convert_to_array($class_set["subjects"]);
 
  $std_det = collect_user_data($conn,"students","std_id",$std_id,"i");
 $previousadded = convert_to_array($std_det["added_subjects"]);
 $previousremoved = convert_to_array($std_det["removed_subjects"]);

  $reqiredValues = [$action,$std_id,$term,$session,$std_class];
  
  if(empty($selected)){
   
       $response = [
     "status" => "failed",
     "error" => "Empty form submission",
     "message" => "Please select atleast 1 item",
      ];
echo json_encode($response);
exit();     
      
  }
  
  foreach ($reqiredValues as $reqired){
     if(empty($reqired)){
   
       $response = [
     "status" => "failed",
     "error" => "Empty required input",
     "message" => "Sorry something went wrong, Please refresh the page and try again.",
      ];
echo json_encode($response);
exit();     
      
    }   
  }
  
    
 if($action == "add_subjects"){
   $addedsubjects =[];
   foreach ($selected as $select){
   if(in_array($select, $previousremoved) || !in_array($select,$class_subjects)){
       
     $addedsubjects[] = $select;  
       
     }    
   }
  
  $mergedSubjects = merge_into_array($addedsubjects,$previousadded,"end",false);
  $implodedSubjects = implode(":",$mergedSubjects);
 $count = count($addedsubjects);
 $pluralize = pluralize("subject",$count);
  $countSubjects = $count." ".$pluralize;

 if(update_user_data($conn,"students","added_subjects","std_id",$implodedSubjects,$std_id,"si")){
  /* remove newly added from $previousremoved if exist */
 $newremoved = remove_from_array($mergedSubjects,$previousremoved); 
  $newremoved = implode(":",$newremoved);
   
  update_user_data($conn,"students","removed_subjects","std_id",$newremoved,$std_id,"si");
   
    $response = [
     "status" => "success",
     "error" => "none",
     "message" => "$countSubjects added successfully",
      ];
echo json_encode($response);
exit();     
     
 }
 else{
     
       $response = [
     "status" => "failed",
     "error" => "SQL Error",
     "message" => "Unable to add subjects, Please refresh the page and try again.",
      ];
echo json_encode($response);
exit();
     
   }
 }
 elseif($action == "remove_subjects"){
   $removedsubjects =[];
   foreach ($selected as $select){
   if(in_array($select,$class_subjects) ||  in_array($select,$previousadded)){
       
     $removedsubjects[] = $select;  
       
     }    
   }
  
 
  
  $mergedSubjects = merge_into_array($removedsubjects,$previousremoved,"end",false);
  $implodedSubjects = implode(":",$mergedSubjects);
 $count = count($removedsubjects);
 $pluralize = pluralize("subject",$count);
  $countSubjects = $count." ".$pluralize;


 if(update_user_data($conn,"students","removed_subjects","std_id",$implodedSubjects,$std_id,"si")){
  
   /* remove newly removed from $previousadded if exist */
 $newadded = remove_from_array($mergedSubjects,$previousadded); 
  $newadded = implode(":",$newadded);
   
  update_user_data($conn,"students","added_subjects","std_id",$newadded,$std_id,"si");
  
  //remove the subjects from subj db if exist.
  $subjTable = form_table_name("subject_records_",$session);
 $del =0;
  foreach($mergedSubjects as $remove){
  
  if(check_exist4($conn,$subjTable,"std_id","term","class","subject",$std_id,$term,$std_class,$remove,"isss")){
  
  $delDet =  collect_user_data4($conn,$subjTable,"std_id","term","class","subject",$std_id,$term,$std_class,$remove,"isss");
  
   $delId = $delDet["id"];
   
 delete_user_data($conn,$subjTable,"id",$delId,"i");
 $del++;
      
    }
  
  } 
  
    $response = [
     "status" => "success",
     "error" => "none",
     "message" => "$countSubjects removed successfully, $del results were also removed for the student.",
      ];
echo json_encode($response);
exit();     
     
 }
 else{
     
       $response = [
     "status" => "failed",
     "error" => "SQL Error",
     "message" => "Unable to remove subjects, Please refresh the page and try again.",
      ];
echo json_encode($response);
exit();
     
   }
 }
 else{
  
      $response = [
     "status" => "failed",
     "error" => "Action type",
     "message" => "Unrecognized action type",
      ];
echo json_encode($response);
exit();   
     
 }
}

 elseif ($btn == "fetch_stds_class") {
    $class = trim($data["class_name"]);

    if (empty($class)) {
        $response = [
            "status" => "failed",
            "error" => "Empty Ajax Input",
            "message" => "No class received from Input",
        ];
        echo json_encode($response);
        exit();
    }

    $students = collect_table_data1($conn, "students", "current_class", $class, "s","surname ASC");

    // Check if it is an array and has elements
    if (is_array($students) && count($students) > 0) {
        $studentsArray = [];
        foreach ($students as $std) {
           $studentsArray[] = [
               "id"   => $std["std_id"],
               "name" => $std["surname"]." ".$std["othernames"],
            ];
        }

        $response = [
            "status" => "success",
            "error" => "none",
            "message" => "Students fetched successfully!",
            "students" => $studentsArray,
        ];
    } else {
        // Handle case where query returned nothing
        $response = [
            "status" => "success", //avoid displaying error message
            "error" => "No data found",
            "message" => "No students found for this class.",
            "students" => [],
        ];
    }
    
    echo json_encode($response);
    exit();
}

elseif($btn == "del_subject_records"){
  
  $staff_id = trim($data["staff_id"]);
  $record_id = trim($data["record_id"]);
  
  if(!$record_id || !$staff_id){
      
       $response = [
     "status" => "failed",
     "error" => "Empty Input",
     "message" => "Sorry something went wrong, Please reload the page and try again.",
      ];
echo json_encode($response);
exit();    
    
  }
  
 elseif(!check_exist2($conn,"subject_results","record_id","staff_id",$record_id,$staff_id,"ii")){
   
       $response = [
     "status" => "failed",
     "error" => "Invalid Input",
     "message" => "Sorry something went wrong, Please reload the page and try again.",
      ];
echo json_encode($response);
exit();    

 }
 
 else{
 //delete records 
 
 if(delete_user_data2($conn,"subject_results","record_id","staff_id",$record_id,$staff_id,"ii")){
  
  $response = [
     "status" => "success",
     "error" => "None",
     "message" => "Records deleted successfully",
      ];
echo json_encode($response);
exit();   
     
 }
 else{
 
 $response = [
     "status" => "failed",
     "error" => "SQL Error",
     "message" => "Failed to delete records, Please reload the page and try again.",
      ];
echo json_encode($response);
exit();    
     
 }
 }
}


elseif($btn == "del_score_range"){
    
 $grade_id = trim($data["grade_id"]);  
 $staff_cat = $_SESSION["staff_cat"];
 
 if(!in_array($staff_cat,$authorized)){
     
  $response = [
     "status" => "failed",
     "error" => "Authorization",
     "message" => "Unauthorized user attempt .",
      ];
echo json_encode($response);
exit();    
     
 }
 else{
     
  if(check_exist($conn,"grading_system","id",$grade_id,"i")){
 
$rangeDet = collect_user_data($conn,"grading_system","id",$grade_id,"i");
$score_range = $rangeDet["score_range"];
 
 if(delete_user_data($conn,"grading_system","id",$grade_id,"i")){
  
     //log action 
  $action = "Deleted score range for grading system";
  $delete_reason = "Not specified";
  $backup = $score_range;
  $records = 1;
 $log = log_admin_action($conn,$userId,$staff_name,$action,$delete_reason, $records,$CurrentSession,$currentTerm,$backup); 
  
  
  $response = [
     "status" => "success",
     "error" => "None",
     "message" => "Score range deleted successfully",
      ];
echo json_encode($response);
exit();   
     
 }
 else{
 
 $response = [
     "status" => "failed",
     "error" => "SQL Error",
     "message" => "Failed to delete Score range, Please reload the page and try again.",
      ];
echo json_encode($response);
exit();    
     
   }
  }
  else{
      
     
       $response = [
     "status" => "failed",
     "error" => "Invalid Input",
     "message" => "Sorry something went wrong, Please reload the page and try again.",
      ];
echo json_encode($response);
exit();      
      
  }
 }
}
 
elseif($btn =="switchgradeinuse"){
  
  $staff_cat = $_SESSION["staff_cat"];
  $Inuse  = trim($data["in_use"]);
  $vartype = "grading_system_inuse";
  $varcat = "General";
 
 
 if(!$Inuse){
   
  $response = [
     "status" => "failed",
     "error" => "Empty Input",
     "message" => "Sorry something went wrong, Please reload the page and try again.",
      ];
echo json_encode($response);
exit();  
  
 }
 
 elseif(!in_array($staff_cat,$authorized)){
   
 $response = [
     "status" => "failed",
     "error" => "Authorization",
     "message" => "Unauthorized user attempt .",
      ];
echo json_encode($response);
exit();  
  
 }
 else{
 
      //log action 
   if($Inuse =="grade_suffix"){
     $InuseText = "grade with suffix";
    }
   else{
     $InuseText = "grade without suffix";
     
   } 
    
  $action = "Updated grading system to $InuseText";
  $delete_reason = "Not specified";
  $backup = "Not available";
  $records = 1;
 $log = log_admin_action($conn,$userId,$staff_name,$action,$delete_reason, $records,$CurrentSession,$currentTerm,$backup); 
 
 if(check_exist($conn,"variables","type",$vartype,"s")){
 //update $vartype    
  
 if(update_user_data($conn,"variables","value","type",$Inuse,$vartype,"ss")){
    
   $response = [
     "status" => "success",
     "error" => "None",
     "message" => "Choice saved",
      ];
echo json_encode($response);
exit();    
     
 }
  else{
  
 $response = [
     "status" => "failed",
     "error" => "SQL Error",
     "message" => "Failed to update grade in use, Please reload the page and try again.",
      ];
echo json_encode($response);
exit();     
      
  }  
 }
 else{
//insert $vartype

 $insertData = [
     "conn"=>$conn,
     "table"=>"variables",
     "cols"=> ['type','value','classification'],
     "vals"=> [$vartype,$Inuse,$varcat],
     "params"=> "sss"

     ];
     
 $insert = insert_user_data($insertData);
 
 if($insert["status"]=="success"){
     
   $response = [
     "status" => "success",
     "error" => "None",
     "message" => "Choice saved",
      ];
echo json_encode($response);
exit();    
     
 }
  else{
 
 $response = [
     "status" => "failed",
     "error" => "SQL Error",
     "message" => "Failed to update grade in use, Please reload the page and try again.",
      ];
echo json_encode($response);
exit();     
      
    }   

   }
 }
 
}
 
 //more btns here.
 else{
     
    $response = [
     "status" => "failed",
     "error" => "Button Name",
     "message" => "Unrecognized button name !",
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



