<?php

ini_set('memory_limit', '-1');
set_time_limit(0);

require 'page_init.php';

$start = microtime(true);

  $current = get_current_session();
  $session = trim($current['session']);

$resultTable = form_table_name("results_",$session);


$generalResults = select_table_data($conn, $resultTable, ['id','overall_average']);
 
 $genUpd=0;
 foreach ($generalResults as $result){
     
  $Id = $result["id"];
  $average = $result["overall_average"];
  $gradeRemark = result_grades($average);
    $grade = $gradeRemark["grade"];
   $remark = $gradeRemark["remark"];
  
 update_user_data($conn,$resultTable,"overall_grade","id",$grade,$Id,"si");
  update_user_data($conn,$resultTable,"general_remark","id",$remark,$Id,"si"); 
   $genUpd++;  
 }
 
 
 unset($generalResults); //free up memory
 
 
 $subjectTable = form_table_name("subject_records_",$session);

$subjectRecords = select_table_data($conn, $subjectTable, ['id','total']);

 $recordUpd=0;
 foreach ($subjectRecords as $records){
     
  $Id = $records["id"];
  $total = $records["total"];
  $gradeRemark = result_grades($total);
    $grade = $gradeRemark["grade"];
   $remark = $gradeRemark["remark"];
  
 update_user_data($conn,$subjectTable,"grade","id",$grade,$Id,"si");
  update_user_data($conn,$subjectTable,"remark","id",$remark,$Id,"si"); 
   $recordUpd++;  
 }
 
 
  unset($subjectRecords); //free up memory
 
 
 if($genUpd || $recordUpd){
     
 echo "General Results: $genUpd results were updated";
 echo "<br><br>";
     
  echo "Subject Records: $recordUpd records were updated"; 
  
 $time = round(microtime(true) - $start, 2);
 echo "<br><br>Completed in {$time} seconds.";
 }
 else{
  
  echo "No update made";
 $time = round(microtime(true) - $start, 2);
 echo "<br><br>Completed in {$time} seconds.";
     
 }