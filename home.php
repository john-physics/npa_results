<?php
 require 'page_init.php';

if(!check_staff_login($conn)){

header("Location:/");
exit();
}

 head('NPA Result Port',"$site | Result Portal","Dashboard");

require 'login_popup.php';
new_popup();
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

  body {
  
    /* Prevent Highlighting text on the Dashboard */
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;

    -webkit-touch-callout: none;
    -webkit-tap-highlight-color: transparent;
}


  #owner{
      font-size:8px;
      font-style:italic;
      font-weight:bold;
    /*  padding:10px; */
      position:relative;
      left:5%;
      color:rgb(200,50,200);
  }
  

 .dashb{
    display:grid;
    
    /* Automatically adjusts columns */
    grid-template-columns:repeat(auto-fit, minmax(80px, 1fr));
    
    gap:10px;
    width:100%;
    padding:10px;

    -webkit-user-select:none;
    -moz-user-select:none;
    -ms-user-select:none;
    user-select:none;

    -webkit-touch-callout:none;
   -webkit-tap-highlight-color:transparent;
}

.dashb .dashb-conts{
    min-height:100px;
    border-radius:5px;
    border:1px solid #ddd;
    font-size:10px;
    text-align:center;
    word-break:break-word;
    cursor:pointer;
    display:block;
    padding:5px;
    box-sizing:border-box;
      
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}
  
 .dashb-conts:hover{
    transform: translateY(-5px);
   box-shadow: 0 8px 20px rgba(0,0,0,0.15);
}
 
  .dashb-conts i{
        display:block;
        position:relative;
        top:10px;
        font-size:20px;
        font-weight:bold;
       
    }
    
 .icon-box{
   width:55px;
   height:55px;
   border-radius:50%;
   display:block;
   align-items:center;
   justify-content:center;
   background:#F3F4F6;
   margin:auto;
}   
    
   .fa-user-plus{
   color:#2563EB; /* Staff */
}

.fa-user-graduate{
   color:#16A34A; /* Students */
}

.fa-user{
   color:#16A34A; /* Students */
}

.fa-school{
   color:#F59E0B; /* Class */
}

.fa-book-open{
   color:#7C3AED; /* Subject */
}

.fa-calendar-check{
   color:#06B6D4; /* Appointment */
}

.fa-clock{
   color:#4F46E5; /* Current Session */
}

.fa-upload{
   color:#10B981; /* Upload Results */
}

.fa-chart-bar{
   color:#1D4ED8; /* View Results */
}
 
 .fa-chalkboard-teacher{
 color: #0d6efd;
   
 }
 
 .fa-images,.fa-chart-line{
     
  color: #0ea5e9;   /* Sky Blue */   
 }
 
 .fa-users{
     
 color: #0d6efd;   
     
 }
 
 .fa-signature{
     color:#1A237E;
      color: #3F51B5;
 }
 
 .fa-database{
    color: #198754;
}

.fa-file-lines{
   color: #0ea5e9;
}
.fa-wand-magic-sparkles{
    color: #0d6efd;
}

   .dashb-conts #badge{
   
   display:inline-block;
   position:relative;
   top:10px; 
   border-radius:50%;
   width:25px;
   height:25px;
   background:red;
   color:#fff;
   font-weight:bold;
   font-size:12px;
   }
      .dashb-conts #text{
      display:block;
      position:relative;
      top:20px;
      
      }
      

   @media screen and (min-width:800px){
       
    .dashb{
 
 grid-template-columns:repeat(auto-fit, minmax(150px, 1fr));
}

.dashb .dashb-conts{
    font-size:12px;
}    
       
   }


</style>';


 if(isset($_SESSION["staff_id"])){
    $userId = $_SESSION["staff_id"];
}

else{
    $userId = null;
}

$user = get_user_name($userId);
$fullname =  ucwords($user["fullname"]);

echo '<section id="dashb-section" class="section">
 
  <h2>Result Dashboard</h2>';
  
 //staff dashboard
 $name = $user["fullname_title"]??'Anonymous';
 $usercat= $user["user_cat"]??'Anonymous';
 $ImpAuthorized =implode(":",$authorized);

echo '<input type="hidden" id="authorized" value="'.$ImpAuthorized.'">
<input type="hidden" id="staff_cat" value="'.$usercat.'">';

  echo '<div class="dashb-wrapper"> 
<span id="owner"> '.$name.' • '.$usercat.' • | Manage Result Dashboard</span>
 <div class="dashb" id="dashb">';

 if(in_array($usercat, $authorized)){
  
 echo '<div class="dashb-conts" data-page="add_new?add_new_staff">
 <span><i class="fa-solid fa-user-plus"></i></span>
<span id="text">Add Staff</span>
 </div>
 
 <div class="dashb-conts" data-page="view_staff">
 <span><i class="fa-solid fa-users"></i></span>
<span id="text">View Staff</span>
 </div>
 
  <div class="dashb-conts" data-page="add_new?add_new_class">
  <span><i class="fa-solid fa-school text-warning"></i></span>
  <span id="text">Add Class</span>
 </div>

 <div class="dashb-conts" data-page="add_new?add_new_subject">
  <span><i class="fa-solid fa-book-open text-purple"></i></span>
  <span id="text">Add Subject</span>
 </div>
 
 <div class="dashb-conts" data-page="add_new?upd_current_session">
 <span><i class="fa-solid fa-clock"></i></span>
  <span id="text">Update Current Session</span>
 </div>

 <div class="dashb-conts" data-page="upload_results?show_all_results">
  <span><i class="fa-solid fa-certificate"></i></span>
  <span id="text">View All Results</span>
 </div>

 <div class="dashb-conts" data-page="add_new?new_appoint_ment">
 <span><i class="fa-solid fa-calendar-check "></i></span>
  <span id="text">Appointment</span>
 </div>
 
 <div class="dashb-conts" data-page="add_new?assign_class_teachers">
 <span><i class="fa-solid fa-chalkboard-teacher"></i></span>
  <span id="text">Assign Class Teachers</span>
 </div>

  <div class="dashb-conts" data-page="settings">
  <span><i class="fa-solid fa-gear"></i></span>
  <span id="text">General Settings</span>
 </div>
 
  <div class="dashb-conts" data-page="backup?backup_access">
    <span><i class="fa-solid fa-database"></i></span>
    <span id="text">Database Backup</span>
</div>

 <div class="dashb-conts" data-page="optimize_images">
  <span><i class="fa-solid fa-wand-magic-sparkles"></i></span>
 <span id="text">Optimize Images</span>
 </div>
    
  <div class="dashb-conts" data-page="background-remover">
  <span><i class="fa-solid fa-signature "></i></span>
 <span id="text">Signature Cleaner</span>
 </div>';
       
 }
 

// All staff can access this      
   
 echo '<div class="dashb-conts" data-page="add_new?add_new_stds">
  <span><i class="fa-solid fa-user-graduate "></i></span>
  <span id="text">Add Students</span>
 </div>
 
<div class="dashb-conts" data-page="add_new?add_stds_photo">
    <span><i class="fa-solid fa-images "></i></span>
    <span id="text">Add Students Photo</span>
</div>
 
  <div class="dashb-conts" data-page="view_students?view_class">
  <span><i class="fa-solid fa-user "></i></span>
 <span id="text">View Students Details</span>
 </div>
 
   <div class="dashb-conts" data-page="users?manage_subjects">
  <span><i class="fa-solid fa-book-open "></i></span>
 <span id="text">View Subjects</span>
 </div>
 

 <div class="dashb-conts" data-page="upload_results">
  <span><i class="fa-solid fa-upload "></i></span>
  <span id="text">Upload Results</span>
 </div>
 
  <div class="dashb-conts" data-page="results?view_results">
   <span><i class="fa-solid fa-chart-bar "></i></span>
   <span id="text">Check Results</span>
  </div>
 
 <div class="dashb-conts" data-page="subject_records">
  <span><i class="fa-solid fa-file-lines "></i></span>
  <span id="text">Subject Records</span>
 </div>
 
  <div class="dashb-conts" data-page="profile">
   <span><i class="fa-solid fa-user-shield "></i></span>
   <span id="text">Staff Profile</span>
  </div>

   </div> 
 </div>';   
     
 
   $current = get_current_session();
   $termSession = trim($current['term']." ".$current['session']);
   if(!$termSession){
    $termSession = "Unknown";
   }

  echo '<br><hr><span id="day"><strong>Current Session: '.$termSession.'</strong></span>
</section>';





Addfooter($site); 


?>
<script>
    
   
 const button = document.querySelectorAll(".dashb-conts");
 
 button.forEach(btn =>{
     
  btn.addEventListener("click",(e)=>{
   const page = btn.dataset.page;   
      
 window.location = page;   
    
  });   
     
 });
 

</script>


<script>
  // logout Btn
   
 const logoutBtn = document.getElementById("logout-link");
     
logoutBtn.addEventListener("click", (e) => {
 
  document.getElementById("logout-popup").classList.add("active");
 
  document.getElementById("nav-section").style.display="none"; 
  document.getElementById("dashb-section").style.display="none";
  document.getElementById("footer").style.display="none";


});

</script>

