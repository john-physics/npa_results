<?php
 require 'page_init.php';
if(!check_staff_login($conn)){

header("Location:/home");
exit();
}


head('Manage Subject Records',"$site | Manage Subject Records","subject-Records"); //add header 
require 'menu.php';

// <!-- Message send report -->
 if(isset($_GET["msg_report"])){
 
   $msg = $_GET["msg_report"];
   $report = $_GET["report"];
   
   report_notice($report,$msg); 
   
  echo '<script src="scripts/report_notice.js"></script>';
     
 }
  
 require './error_suc_msg.php'; // detect and display error Messages if any
require './custom_alert.php'; 
require './script_errors.php'; 


echo '<style>

body{

    margin:0;

    background:#f4f6f9;

    font-family:
    Arial,
    Helvetica,
    sans-serif;

    color:#222;

}


.container{

    max-width:1100px;

    margin:auto;

    padding:30px 20px;

}

.header{

    background:#fff;

    padding:25px;

    border-radius:16px;

    margin-bottom:25px;

    box-shadow:
    0 10px 30px rgba(0,0,0,.08);

}

.header h1{

    margin:0 0 10px;

}



.subtitle{

    color:#666;

}

.grid{

    display:grid;

    grid-template-columns:
    repeat(
        auto-fit,
        minmax(280px,1fr)
    );

    gap:20px;

}

.card{

    background:#fff;

    padding:20px;

    border-radius:16px;

    box-shadow:
    0 8px 25px rgba(0,0,0,.08);

}



.folder-name{

    font-weight:bold;

    font-size:18px;

    margin-bottom:10px;

    word-break:break-all;

}



.meta{

    color:#666;

    font-size:14px;

    margin-bottom:8px;

}



.btn{

    display:inline-block;
    margin: 10px;
    padding:10px 18px;
    text-decoration:none;
    color:#fff;
    background:#5b1028;
    border-radius:10px;
    transition:.3s;
    font-size:10.5px;

}

.btn:hover{

    opacity:.85;

}


.empty{

    background:#fff;
    padding:30px;
    border-radius:16px;
    text-align:center;
    box-shadow:
    0 8px 25px rgba(0,0,0,.08);

}


#spinner, #spinner2 {
        display: none;
        border: 4px solid #f3f3f3;
        border-top: 4px solid #3498db;
        border-radius: 50%;
        width: 30px;
        height: 30px;
        animation: spin 0.5s linear infinite;
        margin: 10px auto;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
 
  #prep1, #prep2{
     display:none;
     text-align:center;
     color:rgb(50,200,50);
     font-size:10px;
     position:relative;
     top:1px;
     font-weight:bold;
 }

.form-container{
width:95%;
margin:20px auto;

}

.form-container select{
width:100%;

}
.form-container input{
width:100%;

}

.form-container textarea{
width:100%;

}
.form-container button{
width:100%;
cursor:pointer;
 background:linear-gradient(135deg,#134e5e,#71b280);
 
}


.subject-sheet-section,
.broadsheet-section{
    position: relative;
     top:20px;6h
    background:#fff;
    padding:20px;
    border-radius:20px;
    width: 95%;
    max-width: 800px;
    margin: auto;
    margin-bottom:20px;
    box-shadow:0 2px 10px rgba(0,0,0,0.08);
}

.sheet-topbar,
.broadsheet-header{
    display:block;
    align-items:center;
    justify-content:space-between;
    gap:10px;
    margin-bottom:10px;
    flex-wrap:wrap;
    font-size: 16px;
}

.sheet-details{
    flex:1;
    text-align:center;
}

.sheet-details h2{
    font-size:18px;
    margin-bottom:5px;
    text-decoration:none;
}


.broadsheet-footer{
 margin-top: 20px;   
  display: block;  
  width: 100%;
  overflow: auto;
  font-size: 9px;
}

.broadsheet-footer span{
 margin-left: 5px;
}
.download-btn{
    background:#28a745;
    color:#fff;
    padding: 3px 4px;
    border-radius:3px;
    font-size:8px;
}

.download-btn:hover{
    background:#218838;
}

.sheet-table-wrapper{
    overflow-x:auto;
}

.subject-sheet-table,
.broadsheet-table{
    width:100%;
    border-collapse:collapse;
    min-width:900px;
}

.broadsheet-table th,
 .broadsheet-table td {
    border:1px solid #ddd;
    padding:12px;
    text-align:center;
}

.subject-sheet-table th,
 .subject-sheet-table td{
 
     border:1px solid #ddd;
     padding:10px;
     text-align:center; 
   
 }

.subject-sheet-table th,
.broadsheet-table th{
    background:#2b78b7;
    color:#fff;
    position:sticky; 
    top:0;
}



  tr:nth-child(odd){
    background: rgba(0,0,0,0.04);
  }
 
 tr:nth-child(even){
    background:#f8f9fa;
}


.subject-sheet-table tbody tr:hover,
.broadsheet-table tbody tr:hover{
    background:#eef5fc;
}


.subject-sheet-table tbody td:nth-child(1),
.broadsheet-table tbody td:nth-child(1){

   width: 50px;
 
}

small{
    font-size:11px;
    display:block;
    margin-top:3px;
}

.broadsheet-footer{
    position:relative;
}
.broadsheet-footer .downloading{
 position: relative;
 margin: 10px 0;
 color:rgb(100,200,100);  
 font-weight: 500;
    
}

 .droping {
     
transition: transform 0.3s ease;
animation: droping 1.1s linear infinite;
       
    }
 
   @keyframes droping {
    0% { transform: translateY(-8px); }
    100% { transform: translateY(10px); }
    }

.summary{
display:block;
padding:10px;
border-radius:10px;
margin: 20px auto;
box-shadow:2px 2px 4px rgba(10,0,0,0.5);
width:80%;
max-width:600px;
    
    
}

.summary .summary-conts{
 display:flex;
 gap:20px;
    
}

.result-wrapper{
   padding:10px;
    width:95%;
    max-width:1000px;
    margin:auto;
    background:#fff;
    border-radius:12px;
    padding:20px;
    margin-top:20px;
    box-shadow:0 2px 10px rgba(0,0,0,0.08);
}

.student-header{
    font-size:22px;
    font-weight:bold;
    color:#0b6b65;
    text-align:center;
    margin-bottom:20px;
}

.student-profile{
    text-align:center;
    margin-bottom:20px;
}

.student-profile img{
    width:150px;
    height:150px;
    border-radius:50%;
    object-fit:cover;
    border:2px dashed rgb(250,100,150);
}

.general-inputs{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
    gap:15px;
    margin-bottom:25px;
}

.input-group{
    display:flex;
    flex-direction:column;
}

.input-group label{
    margin-bottom:5px;
    font-size:14px;
    color:#444;
}

.input-group input{
    height:45px;
    border:1px solid #ddd;
    border-radius:6px;
    padding:0 10px;
    background:#f9f9f9;
    outline:none;
}
.input-group input:focus{
 border:1px solid rgba(10,100,200,0.5);
}

.table-container{
    overflow-x:auto;
}

.table-container h3{
    text-align:center;
    padding:20px 0;
    color:#0f5c5c;
    font-size:24px;
    font-weight:700;
}

.result-table{
    width:100%;
    border-collapse:collapse;
}

.result-table th{
    background:#0b6b65;
    color:#fff;
    padding:12px;
    font-size:14px;
}

.result-table td{
    border:1px solid #eee;
    padding: 8px;
}

.result-table input{
    width:100%;
    height:38px;
    border-radius:5px;
    padding:0 5px;
    box-sizing:border-box;
    border:1px solid #e5e7eb; 
   outline:none;
   text-align:center;
}

.action-buttons{
    display:flex;
    justify-content:space-between;
    gap:10px;
    margin-top:25px;
    flex-wrap:wrap;
}

.action-buttons button{
    flex:1;
    min-width:120px;
    height:45px;
    border:none;
    border-radius:6px;
    color:#fff;
    font-weight:bold;
    cursor:pointer;
    font-size:14px;
}

.update-btn{
    background:#0b6b65;
}

.next-btn{
    background:#0f766e;
}

.view-btn{
    background:#2563eb;
}

.done-btn{
    background:#16a34a;
}

.rating-card{
    background:#fff;
    border-radius:14px;
    padding:0;
    margin-top:25px;
    overflow:hidden;
    border:1px solid #edf2f7;
    box-shadow:0 2px 8px rgba(0,0,0,0.03);
   overflow:auto;
    
}

.rating-card h3{
    text-align:center;
    padding:20px 0;
    color:#0f5c5c;
    font-size:24px;
    font-weight:700;
}

.rating-table{
    width:100%;
    border-collapse:collapse;
}

.rating-table th{
    background:#dce9e8;
    color:#0f5c5c;
    padding:16px;
    text-align:left;
    font-size:15px;
}

.rating-table td{
    padding:14px 16px;
    border-top:1px solid #edf2f7;
    color:#444;
    font-size:15px;
}

.rating-table input{
    width:60%;
    height:42px;
    border:1px solid #e5e7eb;
    border-radius:6px;
    padding:0 10px;
    outline:none;
    font-size:15px;
    background:#fff;
    box-sizing:border-box;
    text-align:center;
}

.rating-table input:focus{
    border-color:#0f766e;
    border-color: rgba(10,100,200,0.5);
}

.result-table input:focus{

   border-color:#0f766e; 
   border-color: rgba(10,100,200,0.5);
}

tr:nth-child(odd){
    background: rgba(0,0,0,0.03);
} 

.update-btn i{
   color:#d1fae5;
  
}

.next-btn i{
   color:#ecfeff;
  
}

.view-btn i{
   color:#dbeafe;
   
}

.done-btn i{
   color:#dcfce7;
   
}

.action-buttons i{
    
    margin-right:5px;
    font-size:18px;
}

#total-auto{
    
   font-size:12px;
   font-style:italic;
    
}
 .spin{
  font-size:20px;
 transition: transform 0.3s ease;
 animation: spin 0.6s linear infinite;
     
 }
 
 @keyframes spin{
     
   0%{ transform: rotate(0deg); }
   100%{ transform: rotate(360deg); }
     
 }
 
 .move{
     
  font-size:20px;
 transition: transform 0.3s ease; 
 animation: move 0.8s linear infinite;
   
 }

 @keyframes move{
     
   0%{ transform: translateX(20px); }
   100%{ transform: translateX(-20px); }
     
 }
 
 
  .blink{
     
  font-size:20px;
 transition: opacity 0.3s ease-in-out;
 animation: blink 0.8s linear infinite;
   
 }

@keyframes blink{
    
  0%{opacity: 1; }
  50%{opacity: 0;}
  100%{opacity: 1;}
    
}

.add-subj{
    position:relative;
    top: 10px;
}
 
 .add-subj button{
     
    width:50px;
    border:none;
    border-radius:3px;
    color:#fff;
    font-weight:bold;
    cursor:pointer;
    font-size:16px;
    padding:10px;
    background:#0b6b65;
 }
 
 
.result-wrapper button{
  transition: transform 0.3s ease;
}

.result-wrapper button:hover{
  transform: translateY(-5px) scale(1.03);
}

#subjectCounter{
    margin: 10px 0 0 20px;
    display:inline-block;
    background:#2b78b7;
    color:#fff;
    padding:10px 12px;
    border-radius:20px;
    font-size:12px;
}

.acct-container {
     position:relative;
     max-width: 500px;
      margin: 30px auto;
      background-color: #fff;
      border-radius: 12px;
      padding: 30px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }
  .acct-container a{
      text-decoration:none;
      color: rgb(0,100,150);
      font-weight:bold;
  }
    .acct-container a:hover{
      text-decoration:underline;
      color: rgb(150,100,10);
      font-weight:bold;
  }
   .acct-container h1 {
    display:block;
      text-align: center;
      color: #093d8f;
      margin-bottom: 30px;
      margin-left: 40px;
      position:relative;
      gap:20px;
      font-size:18px;
      overflow:auto;
    }

    .info-item {
      display: flex;
      align-items: center;
      margin-bottom: 20px;
      font-size: 16px;
    }

    .label {
      font-weight: 600;
      min-width: 140px;
      color: #5c5c5c;
    }

    .value {
      font-weight: 500;
      color: #1a1a1a;
    }

    .status {
      background-color: #4caf50;
      color: white;
      font-weight: 600;
      padding: 3px 12px;
      border-radius: 20px;
      font-size: 14px;
      display: inline-block;
    }
    
     .category-row {
      display: flex;
      align-items: center;
      gap: 10px;
    }
     .update-link {
      background-color: #0066cc;
      color: white;
      font-size: 12px;
      padding: 5px 10px;
      border-radius: 5px;
      text-decoration: none;
      transition: background-color 0.3s ease;
    }
  .status-badge {
  color: white;
  font-weight: 600;
  padding: 3px 12px;
  margin-left:5px;
  border-radius: 20px;
  font-size: 14px;
  display: inline-block;
  transition: all 0.3s ease;
  animation: fadeIn 0.4s ease;
}

.status-badge:hover {
  box-shadow: 0 0 8px rgba(0,0,0,0.2);
  transform: scale(1.05);
}

.green_status {
  background-color: #4caf50;
}


.red_status {
  background-color: #f44336;
}


.yellow_status {
  background-color: #ff9800;
}


.gold_status {
  background-color: #c6a700; /* rich gold tone */
  color: #fff8e1;
}


.blue_status {
  background-color: #2196f3;
}


.gray_status {
  background-color: #607d8b;
}


</style>';

if(isset($_GET["new_subject_records"])){
  
  $h2 = "New Records";
 echo '<section id="about" class="section">
  <h2>'.$h2.'</h2>
  <div class="form-container">
  
  <form action="/includes/subject_records.inc" method="post"  enctype="multipart/form-data" class="reg-form" id="reg-form">

<label for="subject">Select your subject</label>
 <select id="subject" name="subject">';

$subjects = collect_table_data1($conn,"variables","type","Subject","s","value ASC","id");

 foreach($subjects as $subject_id){
   $subjectname = get_subject_name($subject_id);
   echo'<option value="'.$subject_id.'">'.$subjectname.'</option>';
 }
  
  echo '</select>
 
 
 <label for="class">Select Class</label>
 <select id="class" name="class">';

 $classes = sortClasses(collect_table_data1($conn,"variables","type","Class","s","","value"));

 foreach ($classes as $class){
  echo '<option>'.$class.'</option>'; 
     
 }
 
 echo '</select>
    <label for="term">Select Exam</label>
<select name="term" id="term">';
  
   $terms = generate_terms();
foreach($terms as $term){

echo '<option value="'.$term.'">'.$term.' Examination</option>';
} 
 echo '</select>

 <label for="session">Select Exam Year</label>
    <select id="session" name="session">';
  
   $sessions = generate_sessions();
  
foreach($sessions as $session){

echo '<option>'.$session.'</option>';

}
 
 echo '</select>
  
  <label for="std_num">Number of Students</label>
  <input type="number" id="std_num" name="std_num" placeholder="How many students offers the selected subject?" min="1" required>
  
 <label for="processby">Select Processing Method</label>
<select name="processby" id="processby">
<option value="assessments">Assessments</option>
<option value="totals">Total Scores</option>
</select>
 
  <button type="submit" id="submit" name="submit-new-rec-setting">Next</button>
 
  <div id="spinner"></div>
 <small id="prep1">Processing your request, please wait...</small>

  </form>
     
 </div></section>'; 

 
    
}


elseif(isset($_GET["enter_students_records"])){
    
 $processby = $_GET["processby"];
 $record_id = $_GET["record_id"];
 $staff_id = $_SESSION["staff_id"];  
 
 $records = collect_table_data2($conn,"subject_results","staff_id","record_id",$staff_id,$record_id,"ii","serial ASC");
 
 $class = $records[0]["class"];
 $subject_id = $records[0]["subject"];
 $subject_name = get_subject_name($subject_id);
 
 
 if($processby == "totals"){
  $processbydisplay = "Total Scores";
  echo '<style>
  
  .result-table input{
     width:40%; 
  
  }
  
  .result-table td{
      text-align:center;
     
     
  }
 
  </style>';
echo '<div class="result-wrapper">
  <div class="student-header">
    PROCESS SUBJECT RECORDS
    </div>
    
        <div class="general-inputs">
        <div class="input-group">
            <label>Subject Name</label>
           <input type="text" value="'.$subject_name.'" readonly>
        </div>

      <div class="input-group">
            <label>Class</label>
            <input type="text" value="'.$class.'" readonly>
        </div>
        
          <div class="input-group">
            <label>Processing Method</label>
            <input type="text" value="'.$processbydisplay.'" readonly>
        </div>
       </div>
    
    
  <form action="/includes/subject_records.inc" method="post" id="resultForm" class="resultForm">
  
   <input type="hidden" name="record_id"
       value="'.$record_id.'">
  <input type="hidden" name="processby"
       value="'.$processby.'">
 <input type="hidden" name="class"
       value="'.$class.'">

      <div class="table-container">
    <h3>Input for Total Scores</h3>  
       
  <table class="result-table">
  <tr>
    <th>S/N</th>
    <th>Total 
    <small>(100)</small></th>
    </tr>';
   
  foreach($records as $record){

  $serial = $record["serial"];
  $total = null_check($record["total"],"");
  
 echo '<tr>
   <td>'.$serial.'.</td>
    <input
       type="hidden"
        name="serial_no[]"
       value="'.$serial.'">
      <td>
          <input
                type="number"
                name="totals[]"
                value="'.$total.'"
                max="100"
                min="10"
            >
        </td> 
        </tr>';
 

}
  
     echo '</table>
     </div>
     
     <div class="action-buttons">
     <button type="submit" name="submit-entered-records" id="update-btn" class="update-btn"  title="Click here to save/update the entered records">
       <i id="upd-btn" class="fa-solid fa-rotate"></i>
       Process Records
</button>
</div>
</form>

 <div><center>
  <a class ="btn" href="?new_subject_records">Change Processing Method</a></center>
 </div>
  </div>';
     
 } 
 else{
 //processby assessments 
 
  $processbydisplay = "Assessments";
$classdet = collect_user_data2($conn,"variables","type","value","Class",$class,"ss");

$assPattern = convert_to_array($classdet["assessment_pattern"]);
$maxexam = 100 - array_sum($assPattern);

echo '<div class="result-wrapper">
  <div class="student-header">
    PROCESS SUBJECT RECORDS
    </div>
    
        <div class="general-inputs">
        <div class="input-group">
            <label>Subject Name</label>
           <input type="text" value="'.$subject_name.'" readonly>
        </div>

      <div class="input-group">
            <label>Class</label>
            <input type="text" value="'.$class.'" readonly>
        </div>
        
          <div class="input-group">
            <label>Processing Method</label>
            <input type="text" value="'.$processbydisplay.'" readonly>
        </div>
       </div>
    
    
  <form action="/includes/subject_records.inc" method="post" id="resultForm" class="resultForm">
  
<input type="hidden" name="record_id"
       value="'.$record_id.'">
  <input type="hidden" name="processby"
       value="'.$processby.'">
 <input type="hidden" name="class"
       value="'.$class.'">

      <div class="table-container">
    <h3>Input for Assessment Scores</h3>  
       
  <table class="result-table">
  <tr>
    <th>S/N</th>';
   
   foreach ($assPattern as $index => $maxca){
       
   echo '<th>CA'.($index+1).' 
    <small>('.$maxca.')</small></th>';    
       
   }
   
   echo '<th>Exam 
    <small>('.$maxexam.')</small></th></tr>';
   
  foreach($records as $record){

  $serial = $record["serial"];
 $cas = convert_to_array($record["cas"]);
  $exam = null_check($record["exam"],"");
  
 echo '<tr>
   <td>'.$serial.'.</td>
    <input
       type="hidden"
        name="serial_no[]"
       value="'.$serial.'">';
      
     foreach ($assPattern as $index =>$ass){
     $field = 'ca'.($index + 1);
     $ca = $cas[$index];
     
          echo '
            <td>
                <input
                    type="number"
                    name="'.$field.'[]"
                    value="'.$ca.'"
                    max="'.$ass.'"
                    min="1"
                >
            </td>';   
         
     }
       
     echo '<td>
          <input
                type="number"
                name="exam[]"
                value="'.$exam.'"
                max="'.$maxexam.'"
                min="10"
            >
        </td> 
        </tr>';
 

}
  
     echo '</table>
     </div>
     
     <div class="action-buttons">
     <button type="submit" name="submit-entered-records" id="update-btn" class="update-btn"  title="Click here to save/update the entered records">
       <i id="upd-btn" class="fa-solid fa-rotate"></i>
       Process Records
</button>
</div>
</form>

 <div><center>
  <a class ="btn" href="?new_subject_records">Change Processing Method</a></center>
 </div>
  </div>';
  
 }
}

elseif(isset($_GET["view_subject_results"])){

$staff_id = $_SESSION["staff_id"];
$subject_id = $_GET["subject_id"];
$record_id = $_GET["record_id"];
$class = $_GET["class"];
$term = str_replace("_"," ",$_GET["term"]);
$session = str_replace("_","/",$_GET["session"]);

$subjectname=get_subject_name($subject_id);
$results = get_processed_results($conn,$staff_id,$record_id);
 $username = get_user_name($staff_id); 
  $staff_name = $username["fullname_title"]??'Anonymous';
 
if(empty($results)){
    
 echo '<div class="empty">
No records found for '.$subjectname.'
</div>';
    
}
else{
  
 $classdet = collect_user_data2($conn,"variables","type","value","Class",$class,"ss");
$assPattern = convert_to_array($classdet["assessment_pattern"]);

echo '<section class="subject-sheet-section">

    <div class="sheet-topbar">

        <div class="sheet-details">

            <h2 id="subjectTitle">
                '.$class.' '.$subjectname.' Score Sheet<br>'.$term.' '.$session.'
            </h2>
         </div>
        </div>


  <div class="sheet-table-wrapper">
   <table class="subject-sheet-table">

    <thead id="subjectTableHead">
    <tr>
    <th>S/N</th>';
  
  if($results[0]["cas"]){
      
  foreach ($assPattern as $index => $maxca){
   echo '<th>CA'.($index+1).'</th>';   
       
   }
   
  echo '<th>Exam</th>';
  
  }
  
  echo '<th>Total</th> 
        <th>Position</th> 
       <th>Grade</th> 
        <th>Remark</th> 
   </thead>
    <tbody id="subjectTableBody">';
  
  $classScores =[]; 
  foreach ($results as $result){
      
   $serial = $result["serial"]; 
   $date = $result["date_created"];
  $cas = convert_to_array($result["cas"]);
  $exam = null_check($result["exam"],"-");
 $total = null_check($result["total"],"-");
 $grade= null_check($result["grade"],"-");
$remark =null_check($result["remark"],"-");
$pos = null_check($result["position"],"-");
  
  echo '<tr>
  <td>'.$serial.'.</td>';
 if($results[0]["cas"]){
  
  foreach($assPattern as $assIndex =>$ass){
  $ca = null_check($cas[$assIndex],"-");   
   echo '<td>'.$ca.'</td>';  
  }
 echo '<td>'.$exam.'</td>';
 }
    echo '<td>'.$total.'</td>
     <td>'.$pos.'</td>
     <td>'.$grade.'</td>
     <td>'.$remark.'</td> 
  
  </tr>';
 
 if(is_numeric($total)){
  $classScores[] =$total;
   }
      
 }

    echo '</tbody>
    </table>

    </div>
   
 <div class="acct-container">
 <h2>Result Summary</h2>'; 
  if($classScores){

  $classAverage = round(array_sum($classScores)/count($classScores) ,2);
  
  $highest = max($classScores);
 $lowest = min($classScores);
$gradeRemark=result_grades($classAverage);
$classGrade = $gradeRemark["grade"];
$classRemark = $gradeRemark["remark"];
$badge = determine_badge($classGrade);
 }

 $processby = "totals";
if($cas){
 $processby = "assessments"; 
}  
   
   
   echo '<div class="info-item">
     <span class="label"> Highest Score:</span>
     <span class="value">'.$highest.' </span>
    </div> 
    
      <div class="info-item">
     <span class="label">Lowest Score:</span>
      <span class="value">'.$lowest.' </span>
    </div>
    
     <div class="info-item">
     <span class="label">Sum Total:</span>
      <span class="value">'.array_sum($classScores).' </span>
    </div>
    
     <div class="info-item">
     <span class="label">Class Average:</span>
      <span class="value">'.$classAverage.' </span>
    </div>  
    
    
    <div class="info-item">
     <span class="label">Class Performance:</span>
     <span class="status-badge '.$badge.'">'.$classRemark.' </span>
    </div>

</div> 
   
  <div class="broadsheet-footer">
<center>
  <a class ="btn" href="?enter_students_records&processby='.$processby.'&record_id='.$record_id.'">Edit this Record</a>
   <a class ="btn" href="?processed_records">View Other Records</a></center>
  <br>
 <span id="subjectcompby">Compiled By: '.$staff_name.' • '.$date.'</span><br> 
</div>

</section>';


 }
}
else{

echo '<div class="container">
<div class="header">
<h1>
Processed Subject Records
</h1>
<div class="subtitle">
Browse your previously processed records.
</div>
<a class ="btn" href="?new_subject_records">Enter New Records</a>
</div>';

$staff_id = $_SESSION["staff_id"];
$results = get_processed_results($conn,$staff_id);

if(empty($results)){
    
 echo '<div class="empty">
No processed records found.
</div>';
    
}
else{
 
 
echo '<div class="grid">';
 foreach ($results as $result){
     
   $term = $result["term"];
   $session = $result["session"];
   $class = $result["class"];
   $date = $result["date_created"];
   $subject_id = $result["subject"];
   $record_id = $result["record_id"];
   $subjectname = get_subject_name($subject_id);
$get_term = str_replace(" ","_",$term);
$get_session=str_replace("/","_",$session);
    
 echo '<div class="card">
<div class="folder-name">
'.$subjectname.' for '.$session.'</div>

<div class="meta">
Class: '.$class.'
</div>

<div class="meta">
Date Created: '.$date.'
</div>

<a href="?view_subject_results&subject_id='.$subject_id.'&record_id='.$record_id.'&term='.$get_term.'&session='.$get_session.'&class='.$class.'" target="_blank" title="click here to view this subject" class="btn">
View Result Sheet
</a>


</div>';
 
 }
 echo '</div>';
} 
//close container    
echo '</div>';

}



Addfooter($site); 
?>

<script>

const RegForm = document.getElementById("reg-form");
const spinner = document.getElementById("spinner");
const prep1 = document.getElementById("prep1");

RegForm.addEventListener("submit",(e)=>{
  
  spinner.style.display= "flex";  
   prep1.style.display = "block";
   
 // e.preventDefault();
    setTimeout(()=>{
      
    spinner.style.display= "none";  
   prep1.style.display = "none";
 
  },10000); 
   
   
});

 </script>
 
 <script>
 
 const updBtn = document.getElementById("upd-btn");
const Resultform = document.getElementById("resultForm");
resultForm.addEventListener("submit",(e)=>{
    
  updBtn.classList.add("spin"); 
   
  setTimeout(()=>{
      
    spinner.style.display= "none";  
   prep1.style.display = "none";
 
  },10000); 
   
});    
     
 </script>