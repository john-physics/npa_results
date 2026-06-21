<?php

  require 'page_init.php';
  require 'AssessmentInput.php';
  
if(!check_staff_login($conn)){

header("Location:/home");
exit();
}


head('Edit Results',"$site | Edit Results",""); //add header 
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


echo '<style>

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
</style>';


if($_SERVER["REQUEST_METHOD"] == "POST" || isset($_SESSION["updated_result"])){
  
 $staff_id = $_SESSION["staff_id"];
 $staff_cat = $_SESSION["staff_cat"];
 
 
  $std_id  = null_check(trim($_POST["std_id"]),$_SESSION["std_identity"]);

 $std_class = null_check(trim($_POST["std_class"]),$_SESSION["std_class"]);
 $term = null_check(trim($_POST["term"]),$_SESSION["term"]);
 $session = null_check(trim($_POST["session"]),$_SESSION["session"]);
  
 $class_set = collect_user_data4($conn,"class_set","staff_id","session","term","class",$staff_id,$session,$term,$std_class,"isss"); 
  
 $students = convert_to_array($class_set["students"]);
 
if(!in_array($std_id, $students) && !in_array($staff_cat, $authorized)){
//suspicious moves  
 // $_SESSION["error_msg"] ="Unable to initiate results upload process. Please follow due proceedures and try again";  
 echo '<script>
 
 window.location.href = "/upload_results";
 </script>';  
  
  exit();   
    
}
 
 //gather relevant constants.
 
 $std_det = collect_user_data($conn,"students","std_id",$std_id,"i");
 $std_name = normalize_user_name($std_det["surname"]." ".$std_det["othernames"],"ucwords");
 $profile = null_check($std_det["profile"],'null.jpg');
 $std_pin = $std_det["std_pin"]; 
 $profilePath = $root."/images/students/".$profile;
 
 if(!file_exists($profilePath)){
     
   $profile = "npa-logo.jpg"; 
     
 }
 
 
 $pp_det = collect_user_data($conn,"staffs","staff_cat","Principal","s");
 $pp_name = normalize_user_name($pp_det["title"]." ".$pp_det["surname"]." ".$pp_det["othernames"],'ucwords');
 
  $nextTerm  = collect_user_data($conn,"variables","type","Next Term Begins","s");
 $nextTermBegins = $nextTerm["value"];


$resultTable = form_table_name("results_",$session);
$std_results = collect_user_data3($conn,$resultTable,"std_id","term","class",$std_id,$term,$std_class,"iss");
 
 $pp_cmt = null_check($std_results["principal_comment"],"Satisfactory");
 $ct_cmt = $std_results["teacher_comment"];
 //$std_cat = $std_results["std_cat"];
 $activeness = $std_results["activeness"];
$attendance = $std_results["attendance"];
$punctuality = $std_results["punctuality"];
$self_control=$std_results["self_control"];
$honesty = $std_results["honesty"];
$humility = $std_results["humility"];
$leadership = $std_results["leadership"];
$hand_writing=$std_results["hand_writing"];
$fluency = $std_results["fluency"];
$musical_skills = $std_results["musical_skills"];
$sports = $std_results["sports"];
 $std_cat = $std_results["std_cat"]??$std_det["std_cat"];

 $cteach = collect_user_data($conn,"staffs","class_handling",$std_class,"s");

 $uploader = null_check($std_results["staff_id"],$cteach["staff_id"]); 
    
 $staff_det = collect_user_data($conn,"staffs","staff_id",$uploader,"i");
 $cteach_name = normalize_user_name($staff_det["title"]." ".$staff_det["surname"]." ".$staff_det["othernames"],'ucwords');
 
 echo '<div class="result-wrapper">

    <div class="student-header">
        STUDENT INFORMATION
    </div>

    <div class="student-profile">
     <a href="/images/students/'.$profile.'" title="student profile Image">
      <img src="images/students/'.$profile.'"></a>
    </div>

  <form action="/includes/upload_results.inc" method="post" id="resultForm" class="resultForm">

    <div class="general-inputs">

        <div class="input-group">
            <label>Student Name</label>
            <input type="text" value="'.$std_name.'" readonly>
        </div>

      <div class="input-group">
            <label>Class</label>
            <input type="text" value="'.$std_class.'" readonly>
        </div>
        
        <div class="input-group">
            <label>PIN</label>
            <input type="text" value="'.$std_pin.'" readonly>
        </div>

       <div class="input-group">
            <label>Category</label>
            <input type="text" value="'.$std_cat.'" readonly>
        </div>

        <div class="input-group">
            <label>Principal\'s Name</label>
            <input type="text" value="'.$pp_name.'" readonly>
         </div>
         
         <div class="input-group"> 
       <label>Principal\'s Comment</label>
       <input type="text" id="pp_cmt" name="pp_cmt" value="'.$pp_cmt.'" placeholder="Enter Principal\'s Comment here">
        </div>
        
        
       <div class="input-group">
            <label>Class Teacher\'s Name</label>
            <input type="text" value="'.$cteach_name.'" readonly>
         </div>
          <div class="input-group">
       <label>Class Teacher\'s Comment</label>
       <input type="text" id="ct_cmt" name="ct_cmt" value="'.$ct_cmt.'" placeholder="Enter Your Comment here">
        </div>     

 <div class="input-group">
       <label>Next Term Begins:</label>
       <input type="text" id="next-term" name="next-term" value="'.$nextTermBegins.'" readonly>
        </div>   


    </div>
    
    <!-- DEVELOPMENT CARD -->
<div class="rating-card">

    <h3>Ratings</h3>

    <table class="rating-table">

        <tr>
            <th>No.</th>
            <th>Development</th>
            <th>Ratings</th>
        </tr>

        <tr>
            <td>1</td>
            <td>Activeness</td>
            <td>
          <input type="number" min="1" max="10"
             name="development[activeness]"
             value="'.$activeness.'">
                
            </td>
        </tr>

        <tr>
            <td>2</td>
            <td>Attendance</td>
            <td>
        <input type="number" min="1" max="10"
          name="development[attendance]"
             value="'.$attendance.'">
             
            </td>
        </tr>

        <tr>
            <td>3</td>
            <td>Punctuality</td>
           <td>
        <input type="number" min="1" max="10"
         name="development[punctuality]"
         value="'.$punctuality.'">
                
            </td>
        </tr>

        <tr>
            <td>4</td>
            <td>Self Control</td>
            <td>
                <input type="number" min="1" max="10"
          name="development[self_control]"
         value="'.$self_control.'">
            </td>
        </tr>

        <tr>
            <td>5</td>
            <td>Honesty</td>
            <td>
               <input type="number" min="1" max="10"
          name="development[honesty]"
         value="'.$honesty.'">
            </td>
        </tr>

        <tr>
            <td>6</td>
            <td>Humility</td>
            <td>
                <input type="number" min="1" max="10"
       name="development[humility]"
         value="'.$humility.'">
            </td>
        </tr>

        <tr>
            <td>7</td>
            <td>Leadership</td>
            <td>
                <input type="number" min="1" max="10"
       name="development[leadership]"
         value="'.$leadership.'">
            </td>
        </tr>

    </table>

</div>

<!-- SKILLS CARD -->

<div class="rating-card">

    <table class="rating-table">

        <tr>
            <th>No.</th>
            <th>Skills</th>
            <th>Ratings</th>
        </tr>

        <tr>
            <td>1</td>
            <td>Handwriting</td>
            <td>
                <input type="number" min="1" max="10"
         name="skills[hand_writing]"
         value="'.$hand_writing.'">
            </td>
        </tr>

        <tr>
            <td>2</td>
            <td>Fluency</td>
            <td>
                <input type="number" min="1" max="10"
         name="skills[fluency]"
         value="'.$fluency.'">
            
            </td>
        </tr>

        <tr>
            <td>3</td>
            <td>Musical Skills</td>
            <td>
                <input type="number" min="1" max="10"
         name="skills[musical_skills]"
         value="'.$musical_skills.'">
            </td>
        </tr>

        <tr>
            <td>4</td>
            <td>Sports</td>
            <td>
                <input type="number" min="1" max="10"
         name="skills[sports]"
         value="'.$sports.'">
            </td>
        </tr>

    </table>

</div>
    
    <div class="table-container">
    <h3>Subject List</h3>';  
  // <!-- Dynamic Result Table Here -->
  
  $constructor =  [
      "conn" =>$conn,
      "std_class" => $std_class,
      "session" => $session,
      "term" => $term,
      "std_id"=>$std_id,
      "staff_id" => $staff_id,
      "uploader" => $uploader
      
      ];
 
$Input = new AssessmentInput($constructor); 
 $Input -> renderInputs(); 
    
    echo '</div>
   <!-- hidden details -->
   <input type="hidden" id="std_id" name="std_id" value="'.$std_id.'">
    <input type="hidden" id="std_class" name="std_class" value="'.$std_class.'">
    <input type="hidden" id="session" name="session" value="'.$session.'">
    <input type="hidden" id="term" name="term" value="'.$term.'">
    <input type="hidden" id="staff_id" name="staff_id" value="'.$staff_id.'">
    <input type="hidden" id="uploader" name="uploader" value="'.$uploader.'">
   <input type="hidden" id="std_name" name="std_name" value="'.$std_name.'">

 
  <div class="add-subj">
    <button type="button" id="add-subj"  onclick="addRemoveSubjects()" title="Click here to add or remove subjects for '.$std_name.'">
   <i id="add-btn" class="fa-solid fa-plus-minus"></i>
</button>';

  
  $result_status = check_result_status($conn,$term,$session,$std_class);
  
$uploads = $result_status["total_uploads"];
$class_size = $result_status["class_size"];


 echo '<span id="subjectCounter">
        Total uploads: '.$uploads.' out of '.$class_size.'
            </span>
  </div>
    
    <div class="action-buttons">
     <button type="submit" name="submit-ass-records" id="update-btn" class="update-btn"  title="Click here to save/update the entered records">
       <i id="upd-btn" class="fa-solid fa-rotate"></i>
       Update
</button>

    </form>
    
  
   <button type="button" class="next-btn" onclick="nextResult()" title="Click here to upload results for another student in '.$std_class.'">
    <i id="next-btn" class="fa-solid fa-arrow-right"></i>
         Next
    </button>

<form action="/results" method="post">
  
   <input type="hidden" name="viewer" value="staff">
  <input type="hidden" name="std_pin" value="'.$std_pin.'">
  <input type="hidden" name="std_class" value="'.$std_class.'">
  <input type="hidden" name="term" value="'.$term.'">
<input type="hidden" name="session" value="'.$session.'">
    
   <button type="submit" class="view-btn" onclick="ViewResults()" title="Click here to preview uploaded results for '.$std_name.'">
   <i id="view-btn" class="fa-solid fa-eye"></i>
       View
     </button>
    </form>

    <button type="button" class="done-btn" onclick="doneWithUploads()" title="Click here when you are done uploading results for all students in your class">
   <i id="done-btn" class="fa-solid fa-circle-check"></i>
      Done
   </button>  
   
       </div> 

</div>';
  
  require 'add_subjects.php'; 
}
else{

 echo '<script>
 window.location.href = "/upload_results";
 </script>';  
  
  exit();  
}

Addfooter($site); 

?>

<script>

const updBtn = document.getElementById("upd-btn");
const Resultform = document.getElementById("resultForm");
resultForm.addEventListener("submit",(e)=>{
    
  updBtn.classList.add("spin"); 
    
});


function nextResult(){
   
const Term = document.getElementById("term").value;
const Session = document.getElementById("session").value;
const stdClass = document.getElementById("std_class").value;

 const nextBtn = document.getElementById("next-btn");
 nextBtn.classList.add("move");
  
 window.location.href = `/includes/compile_results?next_std_result&std_class=${stdClass}&term=${Term}&session=${Session}`;

}

function doneWithUploads(){
   
const Term = document.getElementById("term").value;
const Session = document.getElementById("session").value;
const stdClass = document.getElementById("std_class").value;

 const doneBtn = document.getElementById("done-btn");
 
 doneBtn.classList.add("blink");
   
 window.location.href = `/includes/compile_results?done_with_uploads&std_class=${stdClass}&term=${Term}&session=${Session}`;

}


</script>