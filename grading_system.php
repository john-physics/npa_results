<?php
 require 'page_init.php';

if(!check_staff_login($conn)){

header("Location:/home");
exit();
}


head('Grading System',"$site | Grading System","Grading System"); //add header 
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

body {
    font-family: "Segoe UI", sans-serif;
    background: #eef2f7;
    margin: 0;
}

.class-container {
    width: 100%;
    margin: 40px auto;
    background: #fff;
    padding: 25px;
    border-radius: 10px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.08);
    overflow:auto;
}



.top-bar {
    text-align: right;
    margin: 20px 0;
}

.btn {
    background: #3498db;
    color: white;
    padding: 10px 18px;
    border-radius: 5px;
    text-decoration: none;
}

.btn:hover {
    background: #2980b9;
}

table {
    width: 100%;
    border-collapse: collapse;
}

th {
    background: #34495e;
    color: #fff;
    padding: 12px;
    text-align: center;
}

td {
    padding: 10px;
    border-bottom: 1px solid #ddd;
    text-align:center;
}

tr:hover {
    background: #f9f9f9;
}

  tr:nth-child(odd){
    background: rgba(0,0,0,0.04);
  }
  
.action-btns{
display:flex;
gap:20px;
align-items:center;
justify-content:center;

}
 .download-btn {
    background: #27ae60;
    color: #fff;
    padding: 5px 10px;
    border-radius: 4px;
    text-decoration: none;
    cursor:pointer;
} 
.preview-btn {
    background: rgb(230,50,50);
    color: #fff;
    padding: 5px 10px;
    border-radius: 4px;
    margin-right: 5px;
    text-decoration: none;
    cursor:pointer;
    
}

.download-btn:hover {
    background: #1e8449;
}

.preview-btn:hover {
    background: #d68910;
}


.pinpup-overlay {
  display: none;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0,0,0,0.6);
  justify-content: center;
  align-items: center;
  z-index:9990;
}

.popup-box {
  background: #fff;
  padding: 20px;
  border-radius: 10px;
  width: 300px;
  text-align: center;
}
.popup-box h3{
  font-size:20px; 
 color: #2196f3;   
    
}
.popup-box p{
  font-size:10px; 
 
    
}
.pinpup-actions {
  margin-top: 15px;
 
}

.pinpup-actions button {
  margin: 5px;
   width:45%;
   padding:10px;
   border-radius:10px;
   border:none;
   color:#fff;
}

.pinpup-actions #cancelpinBtn{
  background: #f44336;

}

.pinpup-actions #proceedBtn{
  background:  #4caf50;

}

.pinpup-actions #cancelpinBtn2{
  background: #f44336;

}

.pinpup-actions #proceedBtn2{
  background:  #4caf50;

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

 .acct-container {
     position:relative;
      max-width: 500px;
      margin: auto;
      background-color: #fff;
      border-radius: 12px;
      padding: 30px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
      display:flex;
      flex-direction:column;
      align-items: center;
      justify-content:center;
    }
  .acct-container h2{
      font-size:24px;
      position:relative;
      top:0;
  }
  
  .view-btn {
   display:block;
   width:100%;
    margin: 20px auto -10px auto;
    background: #27ae60;
    color: #fff;
    padding: 5px 10px;
    border-radius: 4px;
    text-decoration: none;
    cursor:pointer;
    text-align:center;
}

    .info-item {
      display: flex;
      align-items: center;
      margin-bottom: 20px;
      font-size: 16px;
    }
    
   .status-badge {
  color: white;
  font-weight: 600;
  padding: 3px 12px;
  border-radius: 20px;
  font-size: 14px;
  display: inline-block;
  transition: all 0.3s ease;
  animation: fadeIn 0.4s ease;
  
     -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    -webkit-touch-callout: none;
    -webkit-tap-highlight-color: transparent;
    cursor:pointer;
}

@keyframes fadeIn {
  from { opacity: 0; transform: scale(0.9); }
  to { opacity: 1; transform: scale(1); }
}

.status-badge:hover {
  box-shadow: 0 0 8px rgba(0,0,0,0.2);
  transform: scale(1.05);
}

.green_status {
  background-color: #4caf50;
}

.blue_status {
  background-color: #2196f3;
}

.grey_status {
  background-color: #ddd;
}  
 
</style>';


$staff_cat ="";
if(isset($_SESSION["staff_cat"])){
 $staff_cat = $_SESSION["staff_cat"];
}

if(isset($_GET["add_new_grades"])){
 
$h2 = "Add New Grades";
$btnValue = "submit-grade-details";
$btnName = "Add Grade";
$grade_id = "";
$plswait = "Adding new grade, Please wait ...";

$score_range  = "";
$grade_suffix = "";
$grade_nonsuffix ="";
 $remark ="";  
   
if(isset($_GET["edit_grades"]) && $_GET["edit_grades"] == 1){
 $action = $_GET["edit_grades"];  
 $grade_id = $_GET["grade_id"]; //staff Id
 $h2 = "Edit Grade's Details";
 $btnValue = "edit-grade-details";
 $btnName = "Update Details";
 $plswait = "Updating grade's details, Please wait ...";

 $grade_det = collect_user_data($conn,"grading_system","id",$grade_id,"i");

$score_range  = $grade_det["score_range"];
$grade_suffix = $grade_det["grade_suffix"];
$grade_nonsuffix = $grade_det["grade_nonsuffix"];
$remark = $grade_det["remark"];


}


 if(isset($_SESSION["submit-attempt"])){

$score_range  = $_SESSION["score_range"];
$grade_suffix =  $_SESSION["grade_suffix"];
$grade_nonsuffix =  $_SESSION["grade_nonsuffix"];
$remark = $_SESSION["remark"];
 
  }


echo '<section id="about" class="section">
  <h2>'.$h2.'</h2>
  <div class="form-container">
  
  <form action="/includes/add_new.inc" method="post"  enctype="multipart/form-data" class="reg-form" id="reg-form">

 <input type="hidden" name="grade_id" value="'.$grade_id.'">   
  <label for="score_range">Score Range</label>
 <input type="tel" id="score_range" name="score_range" placeholder="Enter score range (i.e 0 - 39)" value="'.$score_range.'" required>
  
  <label for="grade_suffix">Grade with suffix</label>
  <input type="text" id="grade_suffix" name="grade_suffix" placeholder="Enter Grade with suffix (i.e F9)" value="'.$grade_suffix.'" required>
      
  <label for="grade_nonsuffix">Grade without suffix</label>
  <input type="text" id="grade_nonsuffix" name="grade_nonsuffix" placeholder="Grade without suffix (i.e F)" value="'.$grade_nonsuffix.'" required>
      
 <label for="remark">Grade\'s Remark</label>
  <input type="text" id="remark" name="remark" placeholder="Enter Remark (i.e Fail)" value="'.$remark.'" required>
      
  
   <button type="submit" id="submit" name="submit-add-grades" value="'.$btnValue.'">'.$btnName.'</button>

 <div id="spinner"></div>
    <small id="prep1">'.$plswait.'</small>

  </form>
     
 </div></section>'; 
   
}
else{
    
 echo '<section class="section">
<h2>Our Grading System</h2>';

$gradeData = collect_table_data($conn,"grading_system","upper_limit DESC");


echo '<div class="class-container">
<table>
    <thead>
        <tr>
       <th>S/N</th>
       <th>Score Range</th>
        <th>Grades with suffix </th>
      <th>Gades without suffix</th>
       <th>Remark</th>';
       $colspan  = 5;
       if(in_array($staff_cat,$authorized)){
      echo '<th>Actions</th>';  
      $colspan = 6;
       }
           
         echo '</tr>
        </thead>
        <tbody>';
        
    if(!$gradeData){
        
   echo ' <tr>
     <td colspan="'.$colspan.'" style="text-align:center;">No data found.</td>
     </tr>';    
        
    }
   
   else{
    
    $sn =0;  
   foreach ($gradeData as $grades) {

  $grade_id =$grades["id"];
  $score_range  = null_check($grades["score_range"],"Unknown");
 $grade_suffix = null_check($grades["grade_suffix"],"None");
 $grade_nonsuffix = null_check($grades["grade_nonsuffix"],"None");
 $remark = null_check($grades["remark"],"None");

    $sn++;
      
     echo '<tr>
      <td>'.$sn.'.</td>
      <td>'.$score_range.'</td>
      <td>'.$grade_suffix.'</td>
      <td>'.$grade_nonsuffix.'</td>
      <td>'.$remark.'</td>';
     
  if(in_array($staff_cat,$authorized)){
     
     echo '<td>
 <div class="action-btns">  
 <a href="?add_new_grades&edit_grades=1&grade_id='.$grade_id.'" class="download-btn"><i class="fa-solid fa-pen-to-square"></i></a>
   
     <a href="#" class="preview-btn" data-grade-id="'.$grade_id.'"><i class="fa-solid fa-trash"></i></a>
   </div> 
    </td>';
         
      }
       
   echo '</tr>';   
        
   }
  }  
echo '</tbody>
    </table>
</div>';



echo '<!-- Popup Overlay -->
<div id="pinPopup" class="pinpup-overlay">
  <div class="popup-box" id="popup-box">
    <h3>Remove Score Range</h3>
    <p id="popupText"></p>

    <div class="pinpup-actions">
     <button type="button" id="cancelpinBtn">Cancel</button>
      <button type="button" onclick="proceedBtn()" id="proceedBtn">Proceed</button>
    </div>
   
    <div id="spinner"></div>
     <small id="prep1">Removing Score range, please wait...</small>

  </div>
</div>';

echo '<!-- Popup Overlay -->
<div id="pinPopup2" class="pinpup-overlay">
  <div class="popup-box" id="popup-box2">
    <h3>Warning !</h3>
    <p id="popupText2"></p>

    <div class="pinpup-actions">
     <button type="button" id="cancelpinBtn2">Cancel</button>
      <button type="button" id="proceedBtn2">Proceed</button>
    </div>
   
    <div id="spinner2"></div>
     <small id="prep2">Processing your request, please wait...</small>

  </div>
</div>';



$switchInuse="";
if(in_array($staff_cat, $authorized)){
 $switchInuse = "switchgradeinuse";
}

$Inuse = collect_user_data($conn,"variables","type","grading_system_inuse","s");
$InuseValue = $Inuse["value"];

if($InuseValue == "grade_suffix"){
   $Inuse1 = "blue_status";
   $Inuse2 = "grey_status";
}
elseif($InuseValue == "grade_nonsuffix"){
  $Inuse1 = "grey_status";
   $Inuse2 = "blue_status";   
    
}
else{
    $Inuse1 = "grey_status";
   $Inuse2 = "grey_status";
}

echo '<div class="acct-container">
     <h2>Grading System In-use</h2>
     <div class="info-item">
   <span id="grade_suffix" class="status-badge '.$Inuse1.' '.$switchInuse.'" data-value="grade_suffix">Grades with suffix</span>
    </div> 
    
  <div class="info-item">
   <span id="grade_nonsuffix" class="status-badge '.$Inuse2.' '.$switchInuse.'" data-value="grade_nonsuffix">Grades without suffix</span>
    </div>';

if(in_array($staff_cat, $authorized)){
    
  echo '<a href="?add_new_grades&edit_grades=0" class="view-btn">Add New Grades</a>'; 
    
}

echo '</div>
</section>';
   
    
}



Addfooter($site); 

echo '<script>

let gradeId = "";
document.addEventListener("click", function(e) {
// e.preventDefault();
  const btn = e.target.closest(".preview-btn");

  if (btn) {
 
 gradeId = btn.dataset.gradeId;
 
  document.getElementById("popupText").innerHTML =
    `By clicking Proceed, the selected score range will be removed from the granding system.<br><br>Do you want to proceed?`;

  document.getElementById("pinPopup").style.display = "flex";
 
  }

});


/* CANCEL BUTTON */

 document.getElementById("cancelpinBtn").addEventListener("click",(e)=>{

 document.getElementById("pinPopup").style.display = "none";   

}); 


const popup = document.getElementById("pinPopup");
const popupBox = document.getElementById("popup-box");

/* Close when clicking outside the popup box */
popup.addEventListener("click", function(e) {
  if (!popupBox.contains(e.target)) {
    popup.style.display = "none";

  }
});


/* PROCEED BUTTON */
function proceedBtn(){

 const spinner = document.getElementById("spinner");
const prep1 = document.getElementById("prep1");
spinner.style.display= "flex";  
  prep1.style.display = "block";
 
 fetch("/includes/set_class.inc", {
  method: "POST",
  headers: { "Content-Type": "application/json" },
  body: JSON.stringify({
    button_name: "del_score_range",
    grade_id: gradeId,
    
  })
})
  .then(res => res.json())
  .then(data => {

    if (data.status === "success") {
      
  showToast(data.message);
  prep1.innerHTML = data.message+". Refeshing the page...";

setTimeout(() =>{
      
      // reload page
  window.location.reload();
 spinner.style.display= "none";  
  prep1.style.display ="none";
 document.getElementById("pinPopup").style.display = "none";
 
  },1000);

     } else {
   
   spinner.style.display= "none";  
  prep1.style.display = "none";
   
 showError(data.message,data.error);  
  document.getElementById("pinPopup").style.display = "none";
    
    }

  })
  .catch(error => {
    spinner.style.display= "none";  
  prep1.style.display = "none";
    showError(error,"Ajax Error");  
  document.getElementById("pinPopup").style.display = "none";

  });  
    
    
}


</script>
<script>

const RegForm = document.getElementById("reg-form");
const spinner = document.getElementById("spinner");
const prep1 = document.getElementById("prep1");

RegForm.addEventListener("submit",(e)=>{
  
  spinner.style.display= "flex";  
   prep1.style.display = "block";
   
  
    setTimeout(()=>{
      
    spinner.style.display= "none";  
   prep1.style.display = "none";
 
  },5000); 
   
   
});

 </script>
 
 <script>
 let dataValue ="";
 const gradeSuffix = document.getElementById("grade_suffix");
 const gradeNonSuffix = document.getElementById("grade_nonsuffix");
 
 document.addEventListener("click",(e)=>{
  const clickedBadge = e.target.closest(".status-badge");   
 if(clickedBadge){
 
  dataValue = clickedBadge.dataset.value;
 
 if(clickedBadge.classList.contains("switchgradeinuse")){
   
 if(dataValue == "grade_suffix"){
  //add blue_status to suffix
 if(!gradeSuffix.classList.contains("blue_status")){
  gradeSuffix.classList.add("blue_status");
   
 }
 
  if(gradeSuffix.classList.contains("grey_status")){
  gradeSuffix.classList.remove("grey_status");
   
  }
 
 
 //add grey_status to nonsuffix 
 if(!gradeNonSuffix.classList.contains("grey_status")){
  gradeNonSuffix.classList.add("grey_status");
   
 }
 
  if(gradeNonSuffix.classList.contains("blue_status")){
  gradeNonSuffix.classList.remove("blue_status");
  }
  
 }

 else if(dataValue == "grade_nonsuffix"){
  //add blue_status to nonsuffix
 if(!gradeNonSuffix.classList.contains("blue_status")){
  gradeNonSuffix.classList.add("blue_status");
   
 }
 
  if(gradeNonSuffix.classList.contains("grey_status")){
  gradeNonSuffix.classList.remove("grey_status");
  } 

 //add grey_status to suffix 
 if(!gradeSuffix.classList.contains("grey_status")){
  gradeSuffix.classList.add("grey_status");
   
 }
 
  if(gradeSuffix.classList.contains("blue_status")){
  gradeSuffix.classList.remove("blue_status");
  }  
  
 }

  //save switchgradeinuse to db 
 const gradeStyle = clickedBadge.innerHTML;
   document.getElementById("popupText2").innerHTML =
    `By clicking Proceed, You will change the granding system to use <b>${gradeStyle}</b>.<br><br>Do you want to proceed?`;

  document.getElementById("pinPopup2").style.display = "flex";
 
 /* CANCEL BUTTON */

 document.getElementById("cancelpinBtn2").addEventListener("click",(e)=>{

 document.getElementById("pinPopup2").style.display = "none";   

}); 


const popup2 = document.getElementById("pinPopup2");
const popupBox2 = document.getElementById("popup-box2");

/* Close when clicking outside the popup box */
popup2.addEventListener("click", function(e) {
  if (!popupBox2.contains(e.target)) {
    popup2.style.display = "none";

  }
});
 
 
 /* PROCEED BUTTON */

document.getElementById("proceedBtn2").addEventListener("click",(e)=>{

 const spinner2 = document.getElementById("spinner2");
const prep2 = document.getElementById("prep2");
spinner2.style.display= "flex";  
  prep2.style.display = "block";
 
 fetch("/includes/set_class.inc", {
  method: "POST",
  headers: { "Content-Type": "application/json" },
  body: JSON.stringify({
    button_name: "switchgradeinuse",
    in_use: dataValue,
    
  })
})
  .then(res => res.json())
  .then(data => {

    if (data.status === "success") {
      
  showToast(data.message);
  prep2.innerHTML = data.message+". Refeshing the page...";

setTimeout(() =>{
      
      // reload page
  window.location.reload();
 spinner2.style.display= "none";  
  prep2.style.display ="none";
 document.getElementById("pinPopup2").style.display = "none";
 
  },1000);

     } else {
   
   spinner2.style.display= "none";  
  prep2.style.display = "none";
   
 showError(data.message,data.error);  
  document.getElementById("pinPopup2").style.display = "none";
    
    }

  })
  .catch(error => {
    spinner2.style.display= "none";  
  prep2.style.display = "none";
    showError(error,"Ajax Error");  
  document.getElementById("pinPopup2").style.display = "none";

  });  
      
 
});


    }
   }
 });
 
 </script>';

