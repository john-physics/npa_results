<?php

require 'page_init.php';

if(!check_staff_login($conn)){
 header("Location:/home");
 die();
 
}

head('NPA Users',"$site | All Users","");

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

.search_class{
  display:none; 
    
}
.deletepopup h2{
    color:rgb(100,200,100);
}
.section h2{
  /*  color:rgb(50,200,100); */
    font-size:24px;
}

#spinner {
        display: none;
        border: 4px solid #f3f3f3;
        border-top: 4px solid #3498db;
        border-radius: 50%;
        width: 30px;
        height: 30px;
       animation: spin 0.5s linear infinite;
        margin: 20px auto;
    }
    
    #spinner2 {
        display: none;
        border: 4px solid #f3f3f3;
        border-top: 4px solid #3498db;
        border-radius: 50%;
        width: 30px;
        height: 30px;
       animation: spin 0.5s linear infinite;
        margin: 10px;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
 .acct-container {
     position:relative;
      max-width: 500px;
      margin: auto;
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

    .update-link:hover {
      background-color: #004a99;
    }
       .slideshow-container {
      width: 95%;
      height: 50px;
      position: relative;
      top: 20px;
      left: 0;
      background-color: #1a1a1a;
      display: flex;
      align-items: center;
      overflow: hidden;
      border-bottom: 2px solid #ff4500;
      border-radius:5px;
    }

    .slide-text {
      color: #ff4500; /* Orange-red for warning */
      font-size: 18px;
      font-weight: bold;
      white-space: nowrap;
      padding-left: 100%;
      animation: slide-left 60s linear infinite;
    }

    @keyframes slide-left {
      0% {
        transform: translateX(0%);
      }
      100% {
        transform: translateX(-100%);
      }
    }
    .info-item .value{
        
        overflow:auto;
    } 
    .tutor-profile{
     display:block;   
  overflow:hidden;
  position:absolute;
  left:10px;
    top:10px; 
    margin-right: 20px;
    }
  .tutor-profile img{
    display:block;   
  border: 2px solid rgba(200,100,100,0.5);
  width:95px;
  height:95px;
  border-radius:50%;
    }
    
 
 .section h2{
  
  color: rgb(50,200,150); 
  text-decoration:none;    
    
}
 hr{
       
    border: 1px solid hsl(60,50%,50%);   
       
   }
   
    .section #day{
    position:absolute:
    top:100px;
     display:block;
     text-align:center;
     font-size:12px;
     color: rgb(50,200,150); 
   margin-bottom:10px;
 }
  
   .section #warning{
 display:flex;
  justify-content:center;
 align-items:center;
     color:hsl(0,40%,60%);
     font-size:30px;
     margin-bottom:10px;
   
 } 
 .section #no-data{
 font-size:12px;   
   position:relative;
   top:-5px;
   color:rgb(150,200,250);
}
 .bounce {
  animation: bounce 2s infinite;
}

@keyframes bounce {
  0%, 100% { transform: translateY(0); }
  50% { transform: translateY(-20px); }
}

.contact-form label{
    position:relative;
    top:10px;
    font-weight:bold;
    font-style:italic;
    color:rgb(100,200,100);
}

table,th,td{
      
      border: none;
      border-collapse: collapse;
      font-size:12px;
  }
  
   table{
      margin:10px;
      border-top: 1px solid red; 
  /*   border-bottom: 1px solid red; */
     padding:0 5px 2px 2px;
       
   }
  th{
     text-align: center;
      padding: 5px;
     background:rgb(250,150,200);
     color:white;
     
  }
  td{
      padding:5px;
 
  }
  
  tr:nth-child(even){
      background-color: #fff;
  }
  tr:nth-child(odd){
      background-color: #ddd;
  }
  table tr td:nth-child(4){
    width: 100px;  
      
  }
  .courses-table{
      display:block;
      overflow:auto;
  }
  #prep1, #prep2,#prep3,#prep4{
     display:none;
     text-align:center;
     color:rgb(50,200,50);
     font-size:10px;
     position:relative;
     top:1px;
     font-weight:bold;
 }
#spinner1,#spinner2, spinner3,#spinner4{
        display: none;
        border: 4px solid #f3f3f3;
        border-top: 4px solid #3498db;
        border-radius: 50%;
        width: 30px;
        height: 30px;
        animation: spin 0.4s linear infinite;
        margin: 5px auto;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
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

.pink_status {
  background-color: #f48fb1;
            
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

    .update-link:hover {
      background-color: #004a99;
    }

/* Overlay background */
    .notifyoverlay {
      display: none;
      position: fixed;
      top: 0; left: 0;
      width: 100%; height: 100%;
      background: rgba(0, 0, 0, 0.6);
      justify-content: center;
      align-items: center;
      z-index: 1000;
    }

    /* Popup box */
    .notifypopup {
      background: #fff;
      padding: 20px;
      border-radius: 12px;
      width: 320px;
      text-align: center;
      box-shadow: 0 5px 15px rgba(0,0,0,0.3);
      animation: fadeIn 0.3s ease;
    }

     @keyframes fadeIn {
      from {opacity: 0; transform: scale(0.9);}
      to {opacity: 1; transform: scale(1);}
    }
    
 /* Buttons inside popup */
    .notifypopup button {
      margin-top: 15px;
      padding: 10px 20px;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      font-size: 16px;
    }
    .submit-btn {
      background: #4CAF50;
      color: white;
      margin-right: 10px;
    }
    .close-btn {
      background: #f44336;
      color: white;
    }
    #delError,#resendError{
    display:block;
    position:relative;
    left:15px;
    text-align:left;
    font-size:10px;
    color:rgb(250,10,100);
    font-style:italic;
    }
   
     #man-error{
    display:block;
    position:relative;
    left:15px; top:10px;
    text-align:left;
    font-size:10px;
    color:rgb(250,10,100);
    font-style:italic;
    } 
  .notifyoverlay textarea {
  width: 100%;
  height: 120px;
  margin-top: 10px;
  padding: 10px;
  border: 1px solid #ddd;
  border-radius: 6px;
  font-size: 14px;
  box-sizing: border-box;
  transition: border-color 0.3s, box-shadow 0.3s; /* smooth effect */
  outline:none;
  
}
.notifyoverlay textarea:focus{
 
  border: 1px solid #4CAF50;
  
}
.elipses{
  display:block;
  position:absolute;
 top:20px; 
  right:5%;
  padding:5px;
   z-index:10;
   border:none;
   background:#fff;
   cursor:pointer;
   width:50px;
  height:40px;
  
}

/* Action dropdown */

.notify-actions {
  position: absolute;
  background: #f5f5f5;
  border-radius: 6px;
  box-shadow: 0px 2px 6px rgba(0,0,0,0.2);
  display: none;
  flex-direction: column;
  z-index: 1000;
  min-width: 90px;
 
}
.notify-actions button {
  padding: 8px 12px;
  border: none;
  background: none;
  text-align: left;
  width: 100%;
  cursor: pointer;
   font-size: 9px;
  font-weight:bold;
  color:rgb(50,100,150);
}
.notify-actions button:hover {
  background: #eee;
}

/* Delete confirmation popup */
.deletepopup {
  background: #fff;
  padding: 20px;
  border-radius: 12px;
  width: 300px;
  text-align: center;
  box-shadow: 0 5px 15px rgba(0,0,0,0.3);
  animation: fadeIn 0.3s ease;
}
  .deletepopup button {
      margin-top: 15px;
      padding: 10px 20px;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      font-size: 16px;
    }

#notify-a, #notify-b{
    text-decoration:none;
    
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
#spinner1,#spinner2,#spinner3 {
        display: none;
        border: 4px solid #f3f3f3;
        border-top: 4px solid #3498db;
        border-radius: 50%;
        width: 30px;
        height: 30px;
        animation: spin 0.4s linear infinite;
        margin: 5px auto;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }


#yes-no-btns{
position:relative;
top:10px;
    display:flex;
    flex-direction:space-between;
    gap:10px;
    justify-content:center;
    align-items:center;
    width:100%;
}
#yes_btn,#no_btn{
position:relative;
padding:5px;
color:#fff;
outline:none;
border:none;
border-radius:3px;
width:30%;
 display:inline-block; 
  
    
}
#yes_btn{
    background:rgb(100,200,100);
}
#no_btn{
    background:rgb(200,100,100);
}
#resend-h2,#manage-h2{
    font-size:20px;
}
 
 .search-container{
   display:block;
   width:100%;
   margin:auto;
     
 }
 .search-results {
display:block; 
     
     
 }
 .search-container h3{
   color:rgb(100,150,200);  
     
 }
 .search-results a{
     text-decoration:none;
     cursor:pointer;
     margin-bottom:10px;
     display:block;
     width:100%;
     background:#ddd;
    color:rgb(100,150,200);  
     border-radius:10px;
     padding:10px;
     font-weight:bold;
     
 }
 
 .search-results a:hover{
     transform: scale(1.05);
     transition: 0.3 ease;
 }
 .search-results small{
     color:rgb(250,100,150);
     font-size:9px;
     font-style:italic;
     position:relative;
     left:10px;
 }
 
 .search-results h4{
     color:rgb(100,200,150);
 }
 .search-container #no-results{
 font-style:italic;
 color:rgb(200,200,150);    
 }
 
 .showstars {
   position:relative;
   bottom:0;
  font-size: 25px;
  color: #ccc;
  display: flex;
  justify-content: center;
  margin: 5px 0;
  flex-direction: row; 
  
}

.star.filled {
  color: gold;
}

#dwn-link{
 text-decoration:none;
 cursor:pointer;
 position:absolute;
 right:10%;
 display:inline-block;

 text-align:right;
 font-size:12px;
  background:rgb(200,100,200);
  color:#fff;
  padding:5px;
  border-radius:5px;
}

@media screen and (min-width:800px){
    
   #dwn-link{
  
 position:absolute;
 right:22%;
 
}

 .search-container{
   display:block;
   width:60%;
   margin:auto;
     
 }
}
</style>';


 
  $staff_id = $_SESSION["staff_id"];
  $staff_cat = $_SESSION["staff_cat"];

$authorized[] = "Teacher";
/*this will allow Teacher Category to view classes and subject lists because this script was used to display them, dont remove unless you change display script for classes and Subjects */

if(in_array($staff_cat,$authorized)){
//$autofocus = "autofocus";

if(isset($_GET["user_found"])){
    
 $user_cat = $_GET["user_cat"];
 $user_id = $_GET["user_id"];

 $switch = switch_user($user_cat);
 $conn = $switch["conn"];
 $table = $switch["table"];
 $idcol = $switch["id_col"];
 $prf_dir = $switch["prf_dir"];
 $user_type = $switch["user_type"];
 
 $user = collect_user_data($conn,$table,$idcol,$user_id,"i");

  $user_id = $user[$idcol];  
  $user_email  = null_check($user["email"]??$user["parent_email"],"None");
  $user_num = null_check($user["number"]??$user["parent_number"],"None");
$cc_num = std_num($user_num,"cc");
  $sur = $user["surname"];
  $oth = $user["othernames"];
   $sur = ucwords(strtolower($sur));
  $oth = ucwords(strtolower($oth));
 $user_name = $sur." ".$oth;
 $title = $user["title"];
 $lastlogin = timeAgo($user["lastlogin"],'d/m/Y h:i A');
 
  $acct_status = $user["status"];
  $prf = $user["profile"]??'null.jpg';
   $prf_link = $prf_dir.'/'.$prf;

 if(!file_exists($_SERVER["DOCUMENT_ROOT"].$prf_link)){
 $prf_link = "/images/staff/default-prf.jpg";
 }
 

$text ="Please type your message";

 $whatsappText = rawurlencode($text);
 $emailText = htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
 
if($acct_status == "Active"){
    $status = "green_status";
}
elseif($status == "Pending"){
    
   $status = "yellow_status"; 
}
else{
    $status = "red_status";
}


if(!$lastlogin){
    
 $lastlogin = "Unknown";
    
}


echo '<section class="section" id="search_results">
 <input type="hidden" id="user_type" value="'.$user_type.'">
 <h2>Search Result</h2>  
  <div class="acct-container">
    <h1>'.$title." ".$sur.'<br>'.$oth.'</h1> 
<button type="button" class ="elipses" user-id="'.$user_id.'" user-cat="'.$user_cat.'" user-name="'.$user_name.'" acct-status="'.$acct_status.'"><i class="fas fa-ellipsis-v"></i></button>
<div class="tutor-profile"><a href="'.$prf_link.'"><img src="'.$prf_link.'" alt="user\'s profile"></a>
</div>

  <div class="info-item">
      <span class="label">'.$user_type.'\'s status:</span>
      <span class="status-badge '.$status.'">'.$acct_status.' </span>
    </div>';

if($user_type == "Staff"){
    
  $classHandling = null_check($user["class_handling"],'None');
 $subjectsHandling = null_check($user["subject_handling"],null);
$qualify = null_check($user["qualifications"],'Unknown');

  
   echo '<div class="info-item">
      <span class="label">Email Address:</span>
      <span class="value"><a href="mailto:'.$user_email.'?subject=Message%20from%20NewPhase%20Academy&body='.$emailText.'">'.$user_email.'</a></span>
    </div>
    
     <div class="info-item">
      <span class="label">Phone Numer:</span>
      <span class="value"> <a href="https://wa.me/'.$cc_num.'?text='.$whatsappText.'" target="_blank">'.$user_num.' </a></span>
    </div>
    
   
   <div class="info-item">
      <span class="label">'.$user_type.'\'s Category:</span>
     <span id="sp" class="status-badge blue_status">'.$user_cat.'</span>
    </div>';
  
  if(str_word_count($user_cat)>=2){
      
   echo '<style>
   
   #sp{
       font-size:13px;
   }
   </style>';  
      
  }
    echo '<div class="info-item">
    <span class="label">Class Handling:</span>
     <span class="value">'.$classHandling.' </span>
    </div>';
 
 if($subjectsHandling){
   
     echo '<div class="info-item">
    <span class="label">Subjects Handling:</span>
      <span class="value">'.$subjectsHandling.' </span>
    </div>';   
     
 }
     echo '<div class="info-item">
    <span class="label">Qualification(s):</span>
      <span class="value">'.$qualify.' </span>
    </div> 
    <div class="info-item">
    <span class="label">Last login:</span>
      <span class="value">'.$lastlogin.' </span>
    </div> '; 
    
}
 elseif($user_type == "Student"){
  
  $state = null_check($user["std_state"],'Unknown');
  $lga = null_check($user["std_lga"],'Unknown');
$resident = null_check($user["resident"],'Unknown');
$pin = null_check($user["std_pin"],'None');
$year = null_check($user["year_admitted"],'Unknown');
$class = null_check($user["current_class"],'Not yet set');
 
$dob = null_check($user["birth_date"],'Unknown');
 
 
    echo '
      <div class="info-item">
    <span class="label">Year Admitted:</span>
     <span class="value">'.$year.' </span>
    </div> 

      <div class="info-item">
    <span class="label">Current Class:</span>
      <span class="status-badge blue_status">'.$class.' </span>
    </div> 
    
    <div class="info-item">
      <span class="label">Parent\'s Email:</span>
      <span class="value"><a href="mailto:'.$user_email.'?subject=Message%20from%20NewPhase%20Academy&body='.$emailText.'">'.$user_email.'</a></span>
    </div>
    
     <div class="info-item">
      <span class="label">Parent\'s Numer:</span>
      <span class="value"> <a href="https://wa.me/'.$cc_num.'?text='.$whatsappText.'" target="_blank">'.$user_num.' </a></span>
    </div>
    
   
   <div class="info-item">
      <span class="label">State of Origin:</span>
     <span class="value">'.$state.'</span>
    </div>
  
     <div class="info-item">
     <span class="label">LGA:</span>
      <span class="value">'.$lga.' </span>
    </div> 
    
     <div class="info-item">
     <span class="label">D.O.B:</span>
      <span class="value">'.$dob.' </span>
    </div> 
    
      <div class="info-item">
     <span class="label">Resident:</span>
      <span class="value">'.$resident.' </span>
    </div>
    
     <div class="info-item">
    <span class="label">Result PIN:</span>
      <span class="status-badge pink_status" data-id="'.$user_id.'" data-name="'.$user_name.'">'.$pin.' </span>
    </div> '; 
   
  require 'regen_pin.php'; 
 }
 
   
  echo '</div></section>';   
 
 $autofocus = "";//reomove autofocus from search form
 


echo '<!-- Action Confirmation Overlay -->
<div class="notifyoverlay" id="actionOverlay">
  <div class="deletepopup">
    <h2 id="actionTitle"></h2>
    <p id="actionText"></p>
    <input type="text" id="actionReason" placeholder="Please enter a reason for this action" style="display:none">

    <button class="submit-btn" id="actionConfirm"></button>
    <button class="close-btn" id="actionCancel">Cancel</button>

    <div id="actionSpinner"></div>
    <small id="actionMsg"></small>
  </div>
</div>

<style>
#actionReason{
  width:95%;
  padding:8px;
  border-radius:3px;
  outline:none;
  border:1px solid #ddd;
}
#actionReason:focus{ border-color:skyblue; }
</style>';

 
 
}

if(isset($_GET["manage_class"])){
    
  echo '<section class="section" id="about">
 
 <h2>Manage Classes</h2>';
 
 require 'manage_class.php';


 echo '</section>';
  
    
}

elseif(isset($_GET["manage_subjects"])){
  
  $h2 = "Manage Subjects";
 if($staff_cat == "Teacher"){
     $h2 = "Subject List";
 }
  
    
  echo '<section class="section" id="about">
 
 <h2>'.$h2.'</h2>';
 
 require 'manage_subjects.php';

 echo '</section>';
  
}
else{
    
  echo '<section class="section" id="about">
 <h2>Search Users On this Site</h2>
<form id="search-users" class="contact-form">
<label for="search-by">Search By:</label>
 <select id="search-by" onchange="showClass()">
<option>Name</option>
<option>Class</option>
<option>PIN</option>
<option>Email</option>
<option>Id</option>

</select>

<label id="sval-label" for="search-value">Email/Name/Id</label>
<input type="text" id="search-value" placeholder="Type to search" oninput="debounceSearch()" '.$autofocus.' required>

<div class="search_class">
 <select id="search-class" onchange="debounceSearch()">';
 $classes = sortClasses(collect_table_data1($conn,"variables","type","Class","s","","value"));
 foreach ($classes as $class){
     
  echo '<option>'.$class.'</option>'; 
     
 }

echo '</select>

</div>
<button type="submit"><i class="fa-solid fa-search"></i></button>
</form>

<div class="search-container">
<h3>Search Results</h3>
<p id="no-results">All search results will appear here !</p>

<div class="search-results" id="search-results"></div>
</div>
 </section>';
   
    
    
    }
  } 

else{
    
  echo '<script>
  
  window.location.href="/home?msg_report=Access denied !&report=failed";
  
 </script>';
 exit();
}
 
  Addfooter($site);

?>

<script>
 
 let searchTimer;
 
 const Search = document.getElementById("search-users");
 Search.addEventListener("click",(e)=>{
   e.preventDefault();
   
   searchUsers();
     
 });
 
 function debounceSearch() {

    clearTimeout(searchTimer);

    searchTimer = setTimeout(() => {
        searchUsers();
    }, 300);

}
   
 function searchUsers(){
  
 const noResults = document.getElementById("no-results");  
 const searchBy = document.getElementById("search-by").value;    
     
const searchValue1 = document.getElementById("search-value").value.trim();
const searchValue2 = document.getElementById("search-class").value.trim();
let searchValue ="";

if(searchValue1){
   searchValue = searchValue1; 
}
else if(searchValue2){
  searchValue = searchValue2;  
}

const searchResults = document.getElementById("search-results");

noResults.innerHTML =  "Searching started...";
  if(!searchValue){
  searchResults.innerHTML = "";
  noResults.innerHTML = "All search results will appear here !";
return;
  }
 
  fetch("/includes/users.inc", {
  method: "POST",
  headers: { "Content-Type": "application/json" },
  body: JSON.stringify({
    submit_button_name: "search_users",
    search_by: searchBy,
    search_value: searchValue,
  })
})
.then(response => response.json())
    .then(data => {
       // Output the response to the user
   
   if(data.status == "success"){
  
    const Results = data.results;     
    
   if(Results.length > 0){
       //clear previous Results
  searchResults.innerHTML = "";
noResults.innerHTML = data.message;
 Results.forEach(Result =>{

 const url = document.createElement("a");  
 const Name = document.createElement("h4");
const Cat =document.createElement("small");
const Email = document.createElement("h5");
const Lastlogin = document.createElement("h6");
 
 url.href = `/users?user_found&user_cat=${Result.user_cat}&user_id=${Result.user_id}`;
  Name.innerHTML= Result.fullname;   
 Cat.innerHTML = Result.user_cat;
   Email.innerHTML = `${Result.email} • ${Result.pin}`;
 Lastlogin.innerHTML = Result.lastlogin;
     
     Name.appendChild(Cat);
     url.appendChild(Name);
     url.appendChild(Email);
     url.appendChild(Lastlogin);
     searchResults.appendChild(url);
 });
       
   }
   else{
       
   searchResults.innerHTML = "";
  noResults.innerHTML = "No results found for your entry !";
return;
    
       
   }
  }
   
  else{
  showError(data.message,data.error);    
      
  } 
    })
    .catch((error) => {
    
  showError(error,'Ajax Error');  
        
        
    });
  
 }   
    
</script>

<script>
document.addEventListener("DOMContentLoaded", () => {
  const $ = id => document.getElementById(id);

  const overlay    = $("actionOverlay");
  const titleEl    = $("actionTitle");
  const textEl     = $("actionText");
  const reasonEl   = $("actionReason");
  const confirmBtn = $("actionConfirm");
  const cancelBtn  = $("actionCancel");
  const spinner    = $("actionSpinner");
  const msgEl      = $("actionMsg");

  const getUserType = () => $("user_type").value;

  // One entry per action
  const ACTIONS = {
    remove: {
      label: "Remove User",
      title: t => `Remove ${t}`,
      text: t => `Are you sure you want to remove the selected ${t} from this site?`,
      confirm: "Yes, Remove",
      busy: t => `Removing ${t}, Please wait ...`,
      submit: "del-this-user",
    },
    left: {
      label: "Mark as Left",
      title: t => `Mark ${t} as Left`,
     text: t => `Are you sure you want to mark the selected ${t} as Left?`,
      confirm: "Yes",
      busy: t => `Changing ${t} status to Left, Please wait ...`,
      submit: "mark-user-left",
    },
    suspend: {
      label: "Suspend User",
      title: t => `Suspend ${t}`,
      text: t => `Are you sure you want to suspend this ${t}?`,
      confirm: "Yes, Suspend",
      busy: t => `Suspending ${t}, Please wait ...`,
      submit: "suspend-user",
      reasonKey: "suspend_reason",
    },
    unsuspend: {
      label: "Unsuspend User",
      title: () => "Remove Suspension",
      text: t => `Are you sure you want to unsuspend this ${t}?`,
      confirm: "Yes, Unsuspend",
      busy: () => "Removing Suspension, Please wait ...",
      submit: "un-suspend-user",
      reasonKey: "unsuspend_reason",
    },
  };

  let current = null; // { action, userId }

  function showMsg(text, color) {
    msgEl.innerText = text;
    msgEl.style.color = color || "";
    msgEl.style.display = text ? "block" : "none";
  }

  function setBusy(busy) {
    spinner.style.display = busy ? "flex" : "none";
    confirmBtn.disabled = busy;
  }

  function openOverlay(actionName, userId) {
    const cfg = ACTIONS[actionName];
    const type = getUserType();

    current = { action: actionName, userId };
    titleEl.innerText = cfg.title(type);
    textEl.innerText = cfg.text(type);
    confirmBtn.innerText = cfg.confirm;
    reasonEl.value = "";
    reasonEl.style.display = cfg.reasonKey ? "block" : "none";
    showMsg("");
    setBusy(false);
    overlay.style.display = "flex";
  }

  function closeOverlay() {
    overlay.style.display = "none";
    current = null;
    reasonEl.value = "";
    showMsg("");
    setBusy(false);
  }

  // ---------- Row menu ----------
  document.addEventListener("click", e => {
    document.querySelectorAll(".notify-actions").forEach(m => m.remove());

    const btn = e.target.closest(".elipses");
    if (!btn) return;
    e.preventDefault();

    const id     = btn.getAttribute("user-id") || "";
    const cat    = btn.getAttribute("user-cat") || "";
    const status = btn.getAttribute("acct-status") || "";
    const userId = `${id}:${cat}`;

    const menu = document.createElement("div");
    menu.classList.add("notify-actions");

    const add = (label, handler) => {
      const b = document.createElement("button");
      b.innerText = label;
      b.addEventListener("click", () => { menu.remove(); handler(); });
      menu.appendChild(b);
    };

    add(ACTIONS.remove.label, () => openOverlay("remove", userId));

    if (status === "Active") {
      add(ACTIONS.suspend.label, () => openOverlay("suspend", userId));
    } else if (status === "Suspended") {
      add(ACTIONS.unsuspend.label, () => openOverlay("unsuspend", userId));
    }

    if (status !== "Left") {
      add(ACTIONS.left.label, () => openOverlay("left", userId));
    }

    add("Edit Details", () => {
      const type = getUserType();
      const param = type === "Staff" ? "add_new_staff&action=edit-record&staff" : "add_new_stds&action=edit-record&std";
      window.location.href = `/add_new?${param}=${id}&user_type=${type}`;
    });

    document.body.appendChild(menu);
    const rect = btn.getBoundingClientRect();
    menu.style.display = "flex";
    menu.style.top  = rect.bottom + window.scrollY - 10 + "px";
    menu.style.left = rect.left + window.scrollX - 25 + "px";
  });

  // ---------- Overlay buttons ----------
  cancelBtn.addEventListener("click", e => {
    e.preventDefault();
    closeOverlay();
  });

  confirmBtn.addEventListener("click", e => {
    e.preventDefault();
    if (!current) return;

    const cfg  = ACTIONS[current.action];
    const type = getUserType();
    const payload = {
      submit_button_name: cfg.submit,
      user_id: current.userId,
      user_type: type,
    };

    if (cfg.reasonKey) {
      const reason = reasonEl.value.trim();
      if (!reason) {
        showMsg("Please enter a reason for this action", "red");
        return;
      }
      payload[cfg.reasonKey] = reason;
    }

   showMsg(cfg.busy(type), "rgb(50,200,50)");
    setBusy(true);

    fetch("/includes/users.inc", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify(payload),
    })
      .then(res => res.json())
      .then(data => {
        if (data.status === "success") {
          showToast(data.message);
          showMsg("Refreshing the page...", "rgb(50,200,50)");
          setTimeout(() => (window.location.href = "?new"), 2000);
        } 
        
else if (data.status === "blocked" && current.action === "remove") {
  
  setBusy(false);
  titleEl.innerText = `Cannot remove ${type}`;
  textEl.innerText = data.message;
  showMsg("");
  confirmBtn.innerText = "Mark as Left instead";
  current.action = "left";   // next click submits "mark-user-left"
   } 
     else {
          closeOverlay();
          showError(data.message, data.error);
        }
      })
      .catch(err => {
        closeOverlay();
        showError(err, "Ajax Error");
      });
  });
});
</script>
<script>
 
 function showClass(){
     
   const selClass = document.querySelector(".search_class");
   const sby = document.getElementById("search-by").value;
   const sval = document.getElementById("search-value");
   const svalLabel = document.getElementById("sval-label");  
 
 if(sby === "Class"){
 
  selClass.style.display="block";
 sval.style.display="none";   
  svalLabel.innerHTML = "Select Class";  
 }
 else{
     
  selClass.style.display="none";
 sval.style.display="block";  
svalLabel.innerHTML = "Email/Name/Id";
  }
 }   

</script>