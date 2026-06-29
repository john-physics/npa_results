 <?php
ini_set('display_errors', 0);
  require 'page_init.php';
if(!check_staff_login($conn)){

header("Location:/home");
exit();
}


head('Manage Result Portal',"$site | Manage Result Portal","add-staff"); //add header 
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

 .ignore {
 display:block;
 position:relative;
 top:10px;
 margin-bottom:20px;
 }

.ignore input{
  position:absolute;
  right:45%;
    
}

.ignore input:focus{
    
  border:none;
  box-shadow:none;
}

.ignore label{
  position:relative;
  left:10%;
  bottom:6px;  
}
  .ass_pattern{
    display:block;
    position:relative;
    top:20px;
    background:#ddd;
    border-radius:10px;
    padding:5px;
    max-width:750px;
    margin:auto;
    margin-bottom:15px;
   }
   .ass_pattern h3{
    font-size:18px;   
     text-align:center;
     margin:10px auto;
     color: rgb(100,100,200);
     font-style:italic;
   }
   .ass_pattern p{
     font-size:12px;  
       
       
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

.preview{
position:relative;
top:0;
    display:flex;
    justify-content:center;
    align-items:center;
    width:100%;
    padding:10px;
    gap:5px;
    border-radius:20px;
    margin-bottom:10px;
    box-shadow: 1px 1px 2px rgba(10,0,0,0.2);
    overflow-x:auto;
}

.preview img{  
 width:75%;
 height:200px;
 border-radius:10px;
 margin = "auto";
}

 canvas {
    border: 1px solid #ccc;
    background-color: #f9f9f9; /* Helps you see the transparency */
}

.fileInput h4{
position:relative;
top:5px;
 font-size:14px;
 font-style:italic;
 font-weight:bold;
 color:rgb(100,200,50);
 text-decoration:underline;
 text-align:center;
}

#profile,#signature{
    display:none;
}

#profilePreview,#signaturePreview{
    display:none;
}
.fileInputLabels{
  display:flex;
  flex-direction:row;
  align-items:center;
  justify-content:center;
  width:100%;  
  gap:20px;
}
.fileInputLabels label{
  background:rgb(200,150,150);
  display:inline-block;
  width:150px;
  padding:10px;
  font-size:12px;
  color:#fff;
  border-radius:5px;
  cursor:pointer;
  text-align:center;
}

.filesClass{
position:relative;
top:30px;
margin-bottom:40px; 
 display: block; 

}

#stdprofile{
display:none;
}

#re-assign-role{
    
 display:block;
 background:rgba(100,200,100,0.6);
 color:#fff;
 text-align:center;
 padding:5px;
 border-radius:5px;
 text-decoration:none;
 width:80%;
 margin: 10px auto 0 auto;
}

@media screen and (min-width:800px){
.preview img{  
 width:60%;
 height:400px;
 
}
.form-container{
width:80%;

}

.ignore input{
  position:absolute;
  right:49%;
    
}

.ignore label{
  position:relative;
  left:5%;
  bottom:6px;  
}

}


.staff-sign{

    background:white;
    border-radius:16px;
    padding:20px;
    box-shadow:
    0 8px 25px rgba(0,0,0,.08);

}



.staff-sign img{

    width:100%;
    height:220px;
    object-fit:contain;
    background:
    repeating-conic-gradient(
        #eee 0% 25%,
        #fff 0% 50%
    )
    50% /
    20px 20px;
    border-radius:10px;

}

 #staff-select{
     font-size:11px;
 }


</style>';

$surname = "";$othernames = "";
 $email = ""; $currentClass ="";
 $num ="";$pname = "";$pemail ="";
 $pnum ="";$autofocus = "";$lga = "";
 $state = "";$address="";
 $sel1 =""; $sel2 =""; $year=""; 
 $qualify="";

 if(isset($_SESSION["sumbit-attempt"])){
   
  $surname = $_SESSION["surname"];  
  $othernames = $_SESSION["othernames"];  
  $email = $_SESSION["email"];  
  $num = $_SESSION["number"];  
  $autofocus = $_SESSION["autofocus"];
  $pname = $_SESSION["parent_name"];
  $pemail = $_SESSION["parent_email"];
  $pnum = $_SESSION["parent_number"];
  $address = $_SESSION["resident"];
  $state =$_SESSION["std_state"];
  $lga = $_SESSION["std_lga"];
  $currentClass = $_SESSION["current_class"];
  
  $dobValue = $_SESSION["dob"];
 $monthValue = $_SESSION["year_admitted"];
  $qualify = $_SESSION["qualify"];
  
 }
 

if($autofocus == "surname"){
    
  $atf1 = "autofocus";
  $atf2 = ""; $atf3 = "";$atf4 = ""; 
  $atf5 = ""; $atf6 = "";$atf7 = "";
   
}
elseif($autofocus == "othernames"){
  $atf1 = "";
  $atf2 = "autofocus";$atf3 = "";  
  $atf4 = "";  $atf5 = "";$atf6 = "";
   $atf7 = "";
    
}


 elseif($autofocus == "email"){
  $atf1 = "";$atf2 = "";
  $atf3 = "autofocus"; $atf4 = "";
  $atf5 = ""; $atf6 = ""; $atf7 = "";
    
} 
 elseif($autofocus == "number"){
  $atf1 = ""; $atf2 = "";
  $atf3 = ""; $atf4 = "autofocus";
  $atf5 = ""; $atf6 = "";$atf7 = "";
   
} 
elseif($autofocus == "pname"){
  $atf1 = ""; $atf2 = ""; $atf3 = "";  
  $atf4 = ""; $atf5 = "autofocus";
   $atf6 = ""; $atf7 = "";
    
} 

elseif($autofocus == "pemail"){
  $atf1 = ""; $atf2 = ""; $atf3 = "";  
  $atf4 = ""; $atf5 = "";
  $atf6 = "autofocus"; $atf7 = "";
    
} 

elseif($autofocus == "pnum"){
  $atf1 = ""; $atf2 = ""; $atf3 = "";  
  $atf4 = ""; $atf5 = ""; $atf6 = "";
   $atf7 = "autofocus";
    
}

 
  $staff_id = $_SESSION["staff_id"];
  $staff_cat = $_SESSION["staff_cat"];
 $authorized[] = $teacher;
 
if(in_array($staff_cat,$authorized)){

if(isset($_GET["re-assign-role"]) && isset($_SESSION["re-assign"])){
  
  $staff= $_SESSION["staff"];
  $role =  $_SESSION["role"];
$prev_holder = $_SESSION["prev_holder"];
$default_role = "Teacher";
   
 if(in_array($staff_cat, $appointers)){
     
  if(update_user_data($conn,"staffs","staff_cat","staff_id",$role,$staff,"si")){
  //remove the position from the previous holder. 
  update_user_data($conn,"staffs","staff_cat","staff_id",$default_role,$prev_holder,"si");

//notify staff  
$appt_det = collect_user_data($conn,"staffs","staff_id",$staff_id,"i");
$apptName = $appt_det["title"]." ".$appt_det["surname"]." ".$appt_det["othernames"];


$staff_det = collect_user_data($conn,"staffs","staff_id",$staff,"i");
$staffName = $staff_det["title"]." ".$staff_det["surname"]." ".$staff_det["othernames"];
 $email = $staff_det["email"];
 
 $subject = "New Role Appointment";
$body = "

We're pleased to inform you that you have been assigned to a new role on <strong>$site</strong> Result Platform.<br><br>

<strong>Role Assigned:</strong> $role<br>
<strong>Assigned By:</strong> $apptName<br><br>

This role gives you access to features and responsibilities associated with your position. Please log in to your dashboard to explore your new permissions.<br><br>

If you believe this role was assigned in error or you need clarification, kindly contact the administrator.<br><br>

Congratulations, and thank you for being part of our school! <br><br>

<i>Best regards,<br>
$staff_cat,<br>
$site</i>
";
 
 
  $msg =[
      "name" => $staffName,
      "email" => $email,
      "subject" => $subject,
      "body" => $body,
      "attach" => null,
      ];
  
 $insert = inser_into_queue($msg);
  
   $_SESSION["success_msg"] ="Appointment successful ✓";  
  unset($_SESSION["re-assign"]);
   
  if($role == "Principal" && $_SESSION["staff_cat"] == "Principal"){
// handing over of Principal, logout initial Principal
 unset($_SESSION["staff_cat"]);
if(isset($_SESSION["staff_id"])){
    
    unset($_SESSION["staff_id"]);
  }

 }
   
    echo '<script> 
    
window.location = "/home";
    
    </script>';
    exit();   
     
 }
 
 else{
   unset($_SESSION["re-assign"]);
   $_SESSION["error_msg"] ="Unable to appoint staff due to sql errors, Please try again.";  

    echo '<script> 
    window.location = "/add_new?new_appoint_ment";

    </script>';
    exit();   
     
     }    
     
     
 } 
  else{
    unset($_SESSION["re-assign"]);   
    echo '<script> 
    
    window.location = "/home?msg_report=Access denied !&report=failed";
    
    </script>';
    exit();     
      
  } 
}

if(isset($_GET["re-assign-class"]) && isset($_SESSION["re-assign"])){
  
  $staff= $_SESSION["staff"];
  $class =  $_SESSION["class"];
$prev_handler = $_SESSION["prev_handler"];
$default_class = null;
   
 if(in_array($staff_cat, $appointers)){
     
  if(update_user_data($conn,"staffs","class_handling","staff_id",$class,$staff,"si")){
  
  //remove the position from the previous holder. 
  update_user_data($conn,"staffs","class_handling","staff_id",$default_class,$prev_handler,"si");
     
//notify staff  
$appt_det = collect_user_data($conn,"staffs","staff_id",$staff_id,"i");
$apptName = $appt_det["title"]." ".$appt_det["surname"]." ".$appt_det["othernames"];


$staff_det = collect_user_data($conn,"staffs","staff_id",$staff,"i");
$staffName = $staff_det["title"]." ".$staff_det["surname"]." ".$staff_det["othernames"];
 $email = $staff_det["email"];
 $site = ucwords(strtolower($site)); 
 $subject = "New Class Assignment";
$body = "

We're pleased to inform you that you have been assigned to a new class on <strong>$site</strong> Result Platform.<br><br>

<strong>Class Assigned:</strong> $class<br>
<strong>Assigned By:</strong> $apptName<br><br>

This class assignment gives you access to features and responsibilities associated with result uploads and compilations for the assigned class. Please log in to your dashboard to explore your new permissions.<br><br>

If you believe this class was assigned in error or you need clarification, kindly contact the administrator.<br><br>

Congratulations, and thank you for being part of our school! <br><br>

<i>Best regards,<br>
$staff_cat,<br>
$site</i>
";
 
 
  $msg =[
      "name" => $staffName,
      "email" => $email,
      "subject" => $subject,
      "body" => $body,
      "attach" => null,
      ];
  
 $insert = inser_into_queue($msg);
  
$_SESSION["success_msg"] ="Class assigned successfully ✓";  

  unset($_SESSION["re-assign"]);
   
    echo '<script> 
    
window.location = "/add_new?assign_class_teachers";
    
    </script>';
    exit();   
     
 }
 
 else{
   unset($_SESSION["re-assign"]);
   $_SESSION["error_msg"] ="Unable to assign class due to sql errors, Please try again.";  

    echo '<script> 
    window.location = "/add_new?assign_class_teachers";

    </script>';
    exit();   
     
     }    
     
 } 
  else{
    unset($_SESSION["re-assign"]);   
    echo '<script> 
    
    window.location = "/home?msg_report=Access denied !&report=failed";
    
    </script>';
    exit();     
      
  } 
}


if(isset($_GET["add_new_staff"])){

$h2 = "Add New Staff";
$btnValue = "submit-staff-det";
$btnName = "Add Staff";
$staff = "";
$plswait = "Adding new staff, Please wait ...";

if(isset($_GET["action"]) && $_GET["action"] == "edit-record"){
 $action = $_GET["action"];  
 $staff = $_GET["staff"]; //staff Id
 $user_type = $_GET["user_type"];
 $h2 = "Edit Staff's Details";
 $btnValue = "edit-staff-det";
 $btnName = "Update Details";
 $plswait = "Updating staff's details, Please wait ...";

 $staff_det = collect_user_data($conn,"staffs","staff_id",$staff,"i");
 
 $surname = $staff_det["surname"];
 $othernames = $staff_det["othernames"];
 $email = $staff_det["email"];
 $num = $staff_det["number"];
 $gender = $staff_det["gender"];
 $title = $staff_det["title"];
 $qualify = $staff_det["qualifications"];
}

echo '<section id="about" class="section">
  <h2>'.$h2.'</h2>
  <div class="form-container">
  
  <form action="/includes/add_new.inc" method="post"  enctype="multipart/form-data" class="reg-form" id="reg-form">
   
  <label for="surname">Staff\'s Surname</label>
 
 <input type="hidden" name="hidden_id" value="'.$staff.'">
 <input type="text" id="surname" name="surname" placeholder="Enter surname here" value="'.$surname.'" '.$atf1.' >
  
  <label for="othernames"> Staff\'s Othername(s)</label>
  <input type="text" id="othernames" name="othernames" placeholder="Enter Othername(s) here" value="'.$othernames.'" '.$atf2.' >
      
  <label for="email"> Staff\'s Email</label>
  <input type="text" id="email" name="email" placeholder="Enter active Email Address" value="'.$email.'" '.$atf3.'>
      
 <label for="num"> Staff\'s Phone Number</label>
  <input type="tel" id="num" name="num" placeholder="Enter WhatsApp number only" value="'.$num.'" '.$atf4.'>
      
 <label for="gender"> Staff\'s Gender</label>
 <select id="gender" name="gender">';
 
  if($gender){
   echo'<option value="">'.$gender.'</option>';
 }
 echo '<option>Male</option>  
    <option>Female</option> 
     
 </select>       
  
<label for="title"> Staff\'s Title</label>
 <select id="title" name="title">';
 if($title){
   echo '<option value="">'.$title.'</option>';
 }
 $staff_titles = staff_titles();
 
 foreach ($staff_titles as $staff_title){
     
 echo '<option>'.$staff_title.'</option>'; 
 }
 
 echo '</select>       
<label for="qualify"> Staff\'s Qualification(s)</label>
<textarea id="qualify" name="qualify" rows="4" placeholder="Enter Staff\'s qualification here, use comma to seperate qualifications if they are 2 or more">'.$qualify.'</textarea>

 <div class="filesClass" id="filesClass">
 <div class="fileInputLabels">
 <label for="profile" id="prflabel">Staff\'s Profile</label>
 <label for="signature" id="signlabel">Staff\'s Signature</label>
 </div>

 <div class="fileInput" id="fileInput">
 <!-- Profile -->
<input type="file" id="profile" name="profile" accept="image/*">
<div class="preview" id="profilePreview">
</div>

<!-- Signature -->
<input type="file" id="signature" name="signature" accept="image/*">
<div class="preview sign" id="signaturePreview">
  </div> 
 
  </div>
</div>  
 
  
   <button type="submit" id="submit" name="submit-add-staff" value="'.$btnValue.'">'.$btnName.'</button>

 <div id="spinner"></div>
    <small id="prep1">'.$plswait.'</small>

  </form>
     
 </div></section>'; 
   
   echo '<style>
   .fileInputLabels label{
       
    width:130px;   
       
   }
   
   
   .preview img{
   display:block;
    margin:auto;
    width:75%;   
    height:200px;
     margin-top:10px; 
   }
   
   .sign img{
  height:100px;     
       
   }
   
  @media screen and (min-width:800px){
.preview img{  
 width:60%;
 height:400px;
 
 }
 
  .sign img{
  
  height:100px;     
       
   }
}
   </style>';
    
}

elseif(isset($_GET["add_new_stds"])){

$h2 = "Add New Students";
$btnValue = "submit-student-det";
 $btnName = "Add Student";
 $plswait = "Adding new student, Please wait ...";
 $monthValue = "";
 $dobValue = "";

 if(isset($_GET["action"]) && $_GET["action"] == "edit-record"){
 $action = $_GET["action"];  
 $std = $_GET["std"]; //std Id
 $user_type = $_GET["user_type"];
 $h2 = "Edit Student's Details";
 $btnValue = "edit-student-det";
 $btnName = "Update Details";
 $plswait = "Updating student's details, Please wait ...";

 $std_det = collect_user_data($conn,"students","std_id",$std,"i");
 
 $surname = $std_det["surname"];
 $othernames = $std_det["othernames"];
 $pname = $std_det["parent_name"];
 $pemail = $std_det["parent_email"];
 $pnum = $std_det["parent_number"];
 $gender = $std_det["gender"];
 $address = $std_det["resident"];
 $state = $std_det["std_state"];
 $lga = $std_det["std_lga"];
 $currentClass =$std_det["current_class"];

 $year = $std_det["year_admitted"];
 $dob = str_replace('/','-',$std_det["birth_date"]);

if($year){
    
$monthValue = DateTime::createFromFormat('M, Y', $year)->format('Y-m');
}

if($dob){
    
$dobValue = DateTime::createFromFormat('d-m-Y', $dob)->format('Y-m-d');
    
 }
}

echo '<section id="about" class="section">
  <h2>'.$h2.'</h2>
  <div class="form-container">
  
  <form action="/includes/add_new.inc" method="post"  enctype="multipart/form-data" class="reg-form" id="reg-form">
   
  <input type="hidden" name="hidden_id" value="'.$std.'">
  <label for="surname">Student\'s surname</label>
  <input type="text" id="surname" name="surname" placeholder="Enter surname here" value="'.$surname.'" '.$atf1.'>
  
  <label for="othernames">Student\'s Othername(s)</label>
  <input type="text" id="othernames" name="othernames" placeholder="Enter Othername(s) here" value="'.$othernames.'" '.$atf2.' >
      
  
<label for="gender">Student\'s Gender</label>
 <select id="gender" name="gender">';
 if($gender){
   echo'<option value="">'.$gender.'</option>';
 }
  
  echo '<option>Male</option>  
    <option>Female</option>    
 </select>
 
 
 <label for="current_class">Student\'s Current Class</label>
 <select id="current_class" name="current_class">';
 if($currentClass){
   echo'<option value="">'.$currentClass.'</option>';
 }
  
  
 $classes = sortClasses(collect_table_data1($conn,"variables","type","Class","s","","value"));

 if(isset($_SESSION["current_class"])){
     
 $curClass = $_SESSION["current_class"];  
 $classes = merge_into_array($curClass,$classes,"front");
 }


 foreach ($classes as $class){
  echo '<option>'.$class.'</option>'; 
     
 }
 
 echo '</select>
 
  
 <label for="year">Year of Admission</label>
<input type="month" id="year" name="year" value="'.$monthValue.'"> 
<label for="dob">Date of Birth</label>
<input type="date" id="dob" name="dob" value="'.$dobValue.'"> 

 <label for="lga">Student\'s State of Origin</label>
 <select id="state" name="state"></select>
<input type="hidden" id="edit_state" value="'.$state.'">
  <label for="lga">Student\'s LGA</label>
  
  <select id="lga" name="lga"></select>
 <input type="hidden" id="edit_lga" value="'.$lga.'">

 <label for="resident">Student\'s Residential Address</label>
  <input type="text" id="resident" name="resident" placeholder="Enter student\'s residential address" value="'.$address.'">

  <label for="pname">Parent\'s Name</label>
  <input type="text" id="pname" name="pname" placeholder="Enter parent\'s name here" value="'.$pname.'" '.$atf5.'>
     
  <label for="pemail">Parent\'s Email</label>
  <input type="text" id="pemail" name="pemail" placeholder="Enter parent\'s active Email Address" value="'.$pemail.'" '.$atf6.'>
      
 <label for="pnum">Parent\'s Phone Number</label>
  <input type="tel" id="pnum" name="pnum" placeholder="Enter parent\'s WhatsApp number here" value="'.$pnum.'" '.$atf7.'>
      
 
<div class="filesClass" id="filesClass">
 <div class="fileInputLabels">
 <label for="stdprofile" id="labeltext">Add Student\'s Profile</label>

 </div></div>

  <div class="fileInput" id="fileInput">
 <input type="file" id="stdprofile" name="stdprofile" accept="image/*">
 </div>
 
 
<div class="ignore">
<input type="checkbox" id="allow-duplicate" name="allow-duplicate">
 <label for="allow-duplicate" title="Mark this box if there are two or more students in the class you selected with the same surname and othernames">Allow Duplicate Names</label>
</div> 

 <button type="submit" id="submit" name="submit-add-students" value="'.$btnValue.'">'.$btnName.'</button>
 
  <div id="spinner"></div>
 <small id="prep1">'.$plswait.'</small>

  </form>
     
 </div></section>'; 
    
}

elseif(isset($_GET["add_stds_photo"])){
    
  echo '<section id="about" class="section">
  <h2>Add Students Photo</h2>
  <div class="form-container">
  
  <form action="/includes/add_new.inc" method="post"  enctype="multipart/form-data" class="reg-form" id="reg-form">
   
  <label for="class">Select Class</label>
 <select id="std_class" name="std_class" onchange="fetchClassStds()">';
 
 $classes = sortClasses(collect_table_data1($conn,"variables","type","Class","s","","value"));
 if(isset($_SESSION["std_class"])){
  $class = $_SESSION["std_class"];
  
 $classes = merge_into_array($class,$classes,"front");
     
 }
 
 foreach ($classes as $class){
     
  echo '<option>'.$class.'</option>'; 
     
 }
 
 echo '</select>
 
 <label for="class">Select Student</label>
 <select id="stds" name="stds" required>
 </select>
  
<div class="filesClass" id="filesClass">
 <div class="fileInputLabels">
 <label for="stdprofile" id="labeltext">Select Photo</label>

 </div></div>

  <div class="fileInput" id="fileInput">
 <input type="file" id="stdprofile" name="stdprofile" accept="image/*">
 </div>

 <button type="submit" id="submit" name="submit_add_stds_photo" value="add_stds_photo">Add Photo</button>
 
  <div id="spinner"></div>
 <small id="prep1">Adding photo, Please wait...</small>

  </form>
     
 </div></section>';   
    
    
}

elseif(isset($_GET["add_new_class"])){

 echo '<section id="about" class="section">
  <h2>Add New Class</h2>
 <div class="form-container">
  
  <form action="/includes/add_new.inc" method="post"  enctype="multipart/form-data" class="reg-form" id="reg-form">
   
  <label for="class">Enter Class</label>
  <input type="text" id="class" name="class" placeholder="Enter class here e.g SS 1A" maxlength="20" oninput="assPattern()" required>
     
 <label for="class-cat">Select Class Category</label>
 <select id="class-cat" name="class-cat">
   <option>Science</option>  
    <option>Art</option> 
    <option>Commercial</option> 
    <option>General</option> 
     
 </select> 
 

  <label for="pattern">Assessment Pattern</label>
  <select id="pattern" name="pattern">
    <option>10:10</option>
    <option>15:15</option>
    <option>20:20</option>
    <option>30:30</option>
    <option selected>10:10:10</option>
    <option>10:10:20</option>
    <option>20:20:20</option>
    <option>10:10:10:10</option>
    <option>10:10:20:20</option>
    <option>10:10:10:20</option>
  
  </select>
<div class="ignore">
<input type="checkbox" id="ignore-validation" name="ignore-validation">
 <label for="ignore-validation" title="Mark this box if the class you are trying to add is actually valid but could not be added">Ignore Class Validation</label>
</div>
<button type="submit" id="submit" name="submit-add-class">Add Class</button>
  
   <div id="spinner"></div>
      <small id="prep1">Adding new class, Please wait ...</small>

  </form>
 </div>
 
 <div class="ass_pattern">
 
 <h3>Understanding Assessment Pattern</h3>
 <p>An assessment pattern of 10:10:10 simply means 3 continuous assessment records with a maximum total of 30 marks where each assessment is over 10. Similarly, 10:10:20:20 means 4 continuous assessment records with a maximum total of 60 marks where the first and second are over 10 while the rest are over 20.</p>
 
 </div>
 
 </section>'; 

echo '<script>

function assPattern() {

    const classInput = document.getElementById("class").value.trim();
    const pattern = document.getElementById("pattern");

  const classCat = document.getElementById("class-cat");

    // Get first letter and make it uppercase
    const firstLetter = classInput.charAt(0).toUpperCase();

    // Default selected index (optional)
    // pattern.selectedIndex = 0;

    // SENIOR CLASSES (SS, SSS etc)
    if (firstLetter === "S") {

        // Select Senior pattern
        pattern.value = "10:10:10";

    }

    // JUNIOR CLASSES (JSS etc)
    else if (firstLetter === "J") {

        // Select Junior pattern
        pattern.value = "10:10:10:10";
        classCat.value = "General";
    }

    // PRIMARY CLASSES
    else if (firstLetter === "P") {

        // Select Nursery/Primary pattern
        pattern.value = "10:10:20:20";
        classCat.value = "General";
    }
    
      // GRADE CLASSES
    else if (firstLetter === "G") {

        // Select Nursery/Primary pattern
        pattern.value = "10:10:20:20";
        classCat.value = "General";
    }  
    

    // NURSERY CLASSES
    else if (firstLetter === "N") {

        // Select Nursery/Primary pattern
        pattern.value = "10:10:20:20";
        classCat.value = "General";
    }

 else{
  
  // Default selection
       pattern.value = "10:10:10";
       classCat.value = "Science";
     
 }

}

</script>';

}

elseif(isset($_GET["add_new_subject"])){

$h2 = "Add New Subject";
$btnName = "Add Subject";
$btnValue = "add_new_subject";
$plswait = "Adding new subject, please wait ...";
$subject = ""; 
$subjectId = "";
if(isset($_GET["upd-subject-name"])){
   
  $subjectId = $_GET["subj_id"];
 $subject = get_subject_name($subjectId);
 
 $h2 = "Update Existing Subject";
 $btnName = "Update Subject";
$btnValue = "upd-subject-name";
$plswait = "Updating subject, please wait ...";
    
}

echo '<section id="about" class="section">
  <h2>'.$h2.'</h2>
 <div class="form-container">
  
  <form action="/includes/add_new.inc" method="post"  enctype="multipart/form-data" class="reg-form" id="reg-form">
 
   <input type="hidden" id="subj_id" name="subj_id" value="'.$subjectId.'" >
   
  <label for="subject">Enter Subject</label>
  <input type="text" id="subject" name="subject" placeholder="Enter subject here e.g Mathematics" maxlength="100" value="'.$subject.'" required>
     
 <label for="subject-cat">Select Subject Category</label>
 <select id="subject-cat" name="subject-cat">
   <option>Science</option>  
    <option>Art</option> 
    <option>Commercial</option> 
    <option>General</option> 
     
 </select>       
  <button type="submit" id="submit" name="submit-add-subject" value="'.$btnValue.'">'.$btnName.'</button>
  
   <div id="spinner"></div>
      <small id="prep1">'.$plswait.'</small>
  </form>
     
 </div></section>'; 

    
}

elseif(isset($_GET["upd_current_session"])){

echo '<section id="about" class="section">
  <h2>Update Current Session</h2>
 <div class="form-container">
  
  <form action="/includes/add_new.inc" method="post"  enctype="multipart/form-data" class="reg-form" id="reg-form">
   
  <label for="session">Select Current Session</label>
 <select id="session" name="session">';

$sessions = generate_sessions();
   
foreach($sessions as $session){

echo '<option>'.$session.'</option>';

}
 
 echo '</select>  
 <label for="term">Select Current Term</label>
 <select id="term" name="term">';
  
  
 $terms = generate_terms();
   
foreach($terms as $term){

echo '<option>'.$term.'</option>';

}

echo '</select> 
 <label for="next-term">Next Term Begins:</label>
 <input type="date" id="next-term" name="next-term" required>
  <button type="submit" id="submit" name="submit-upd-session">Update Current Session</button>
 
 <div id="spinner"></div>
      <small id="prep1">Updating Session, Please wait ...</small>
 
  </form>
     
 </div></section>'; 

    
}

elseif(isset($_GET["new_appoint_ment"])){

if(in_array($staff_cat,$appointers)){
    
echo '<section id="about" class="section">
  <h2>Appoint New Role</h2>
 <div class="form-container">
  
  <form action="/includes/add_new.inc" method="post"  enctype="multipart/form-data" class="reg-form" id="reg-form">
   
  <label for="cat">Staff to be Appointed</label>
<select id="staff" name="staff" required>';

   $staffs = collect_table_data1($conn,"staffs","status","Active","s","surname ASC");
 
  $AllStaffs = [];
foreach($staffs as $staff){

 $AllStaff = [
     "id" => $staff["staff_id"],
     "name" =>  $staff["title"]." ".$staff["surname"]." ".$staff["othernames"],
     ];
 
 $AllStaffs[] = $AllStaff;

}

foreach($AllStaffs as $staff_det){
$name = $staff_det["name"];
$Id = $staff_det["id"];

echo '<option value="'.$Id.'">'.$name.'</option>';

}
 
 echo '</select>  
 <label for="role">Select Role</label>
 <select id="role" name="role" required>
   <option>Principal</option>  
    <option>Vice Principal</option> 
    <option>ICT Director</option>
    <option>Asst. ICT Director</option>
    <option>School Manager</option>
    <option>Asst. School Manager</option>
    <option>Accountant</option>
    <option>Secretary</option>
     <option>Teacher</option>
     <option>Asst. Teacher</option>
    <option>Exam Officer</option>
    <option>Asst. Exam Officer</option>
 </select>  
  <button type="submit" id="submit" name="submit-appoint-role">Comfirm Appointment</button>
  
   <div id="spinner"></div>
      <small id="prep1">Appointing staff\'s  role, Please wait ...</small>

  </form>
     
 </div></section>';   
    
}
else{
   echo '<script> 
    
    window.location = "/home?msg_report=Access denied !&report=failed";
    
    </script>';
    exit();   
  }
}

elseif(isset($_GET["assign_class_teachers"])){

if(in_array($staff_cat,$appointers)){
    
echo '<section id="about" class="section">
  <h2>Assign Class Teachers</h2>
 <div class="form-container">
  
  <form action="/includes/add_new.inc" method="post"  enctype="multipart/form-data" class="reg-form" id="reg-form">
   
  <label for="cat">Staff to be Assigned</label>
<select id="staff" name="staff" required>';

  $staffs = collect_table_data($conn,"staffs");
 
  $AllStaffs = [];
foreach($staffs as $staff){

 $AllStaff = [
     "id" => $staff["staff_id"],
     "name" =>  $staff["title"]." ".$staff["surname"]." ".$staff["othernames"],
     ];
 
 $AllStaffs[] = $AllStaff;

}

foreach($AllStaffs as $staff_det){
$name = $staff_det["name"];
$Id = $staff_det["id"];

echo '<option value="'.$Id.'">'.$name.'</option>';

}
 
 echo '</select>  
 <label for="class">Select Class</label>
 <select id="class" name="class" required>';

 $classes = sortClasses(collect_table_data1($conn,"variables","type","Class","s","","value"));
 foreach ($classes as $class){
     
  echo '<option>'.$class.'</option>'; 
     
 }

 echo '</select>       
  <button type="submit" id="submit" name="submit-assign-cteach">Assign Class</button>
  
   <div id="spinner"></div>
      <small id="prep1">Assigning class to  the selected staff, Please wait ...</small>

  </form>
     
 </div></section>';   
    
}
else{
   echo '<script> 
    
    window.location = "/home?msg_report=Access denied !&report=failed";
    
    </script>';
    exit();   
  }
}

elseif(isset($_GET["use_proccessed_signature"])){
   
 $signature = trim($_GET["signature"]);
 $folderName = trim($_GET["folder"]);
 
 $folderPath = $_SERVER["DOCUMENT_ROOT"]."/background-remover/uploads/".$folderName;
 $imgsource = "/background-remover/uploads/".$folderName."/".$signature;
 
    
echo '<section id="about" class="section">
  <h2>Set Staff Signatures</h2>
 
 <div class="staff-sign">
 <img src="'.$imgsource.'" alt="staff-signature" loading="lazy">
 
 </div>
 
 <div class="form-container">
  <form action="/includes/add_new.inc" method="post"  enctype="multipart/form-data" class="reg-form" id="reg-form">
   
  <label for="staff-select">Select Staff</label>
<select id="staff-select" name="staff" required>
<option value="" id="pls">--Please select the staff with the above signature--</option>';

  $staffs = collect_table_data($conn,"staffs");
 
  $AllStaffs = [];
foreach($staffs as $staff){

 $AllStaff = [
     "id" => $staff["staff_id"],
     "name" =>  $staff["title"]." ".$staff["surname"]." ".$staff["othernames"],
     ];
 
 $AllStaffs[] = $AllStaff;

}

foreach($AllStaffs as $staff_det){
$name = $staff_det["name"];
$Id = $staff_det["id"];

echo '<option value="'.$Id.'">'.$name.'</option>';

}
 
 echo '</select>  
<input type="hidden" name="signature" value="'.$signature.'">
<input type="hidden" name="folder" value="'.$folderName.'">

  <button type="submit" id="submit" name="submit-staff-signature">Set Signature</button>
  
   <div id="spinner"></div>
      <small id="prep1">Setting staff\'s signature, Please wait ...</small>

  </form>
     
 </div></section>';   
     
    
    
}

else {

    echo '<script> 
    
    window.location = "/home?msg_report=Access denied !&report=failed";
    
    </script>';
    exit();
}

}
else{
   
     echo '<script> 
    
    window.location = "/home?msg_report=Access denied !&report=failed";
    
    </script>';
    exit();  
    
}


Addfooter($site); 
?>

<script>
const imageInput = document.getElementById('stdprofile');
const fileInput = document.getElementById('fileInput');
const previewImg = document.createElement("div");
const imgh4 = document.createElement("h4");
const imgMaxsize = parseInt(5*1024*1024);

previewImg.classList.add("preview");
previewImg.setAttribute("id","preview");


// Limit images to 1
imageInput.addEventListener('change', () => {
    
  if (imageInput.files.length > 1) {
    alert("You can only upload 1 image per student.");
    imageInput.value = ""; // Clear selection
  }
  else {
  previewImg.innerHTML = ""; // Clear previous preview
  imgh4.innerHTML = "Preview Selected Profile";
      fileInput.appendChild(imgh4);
    [...imageInput.files].forEach(file => {
    
      const img = document.createElement("img");
      img.src = URL.createObjectURL(file);
      
      previewImg.appendChild(img);
      fileInput.appendChild(previewImg);
    
    document.getElementById("labeltext").innerHTML = "Select Another Profile";
       if(file.size > imgMaxsize){
       
    alert("The Selected Image is too large in size, image size must not be more than 5MB");
     previewImg.innerHTML = "";
     imgh4.innerHTML = "";
     imageInput.value = "";// Clear selection
     previewImg.remove();
    return;
       
   }    
        
    });
  }
});
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
 
  },20000); 
   
   
});

 </script>
 
 
 
 <script>
  
  let data = {};
  const editState = document.getElementById("edit_state").value;
  const editlLga = document.getElementById("edit_lga").value;
 
 const stateOpt = document.createElement("option");
 const LgaOpt = document.createElement("option");
  
fetch("scripts/nigerian-states.json")
  .then(res => res.json())
  .then(res => {

      data = res;

      let stateSelect = document.getElementById("state");
    if(editState){
         stateOpt.value = editState;
         stateOpt.textContent = editState;
       
        stateSelect.appendChild(stateOpt);
          }
     
      Object.keys(data).forEach(state => {

          let option = document.createElement("option");
          option.value = state;
          option.textContent = state;
   
          stateSelect.appendChild(option);

      });

      // LOAD FIRST STATE LGAs AUTOMATICALLY
      loadLGAs(stateSelect.value);

  });


// FUNCTION TO LOAD LGAs
function loadLGAs(state){

    let lgaSelect = document.getElementById("lga");

    lgaSelect.innerHTML = "";

        if(editlLga){
         LgaOpt.value = editlLga;
         LgaOpt.textContent = editlLga;
       
        lgaSelect.appendChild(LgaOpt);
          }
    
    data[state].forEach(lga => {

        let option = document.createElement("option");

        option.value = lga;
        option.textContent = lga;

        lgaSelect.appendChild(option);

    });

}


// CHANGE EVENT
document.getElementById("state").addEventListener("change", function(){

    loadLGAs(this.value);

});

  
 </script>
 
 <script>
     
function fetchClassStds(){
    
 const stdClass = document.getElementById("std_class").value;
 
 const studentsOptions = document.getElementById("stds");
 
   fetch("/includes/set_class.inc", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({
        button_name: "fetch_stds_class",
        class_name: stdClass,
            
        })
    })
    .then(response => response.json())
    .then(data => {
       // Output the response to the user
//  document.write(msg);

 if(data.status == "success"){
 // Clear previous classes
  studentsOptions.innerHTML = "";
  const students = data.students;
  
 if (students.length > 0) {
  // Populate the students dropdown
       students.forEach(function (std) {
        
       const option = document.createElement("option");
         
           option.value = std.id;
           option.textContent = std.name;
           studentsOptions.appendChild(option);
          });
        }
 
 else{
 
   const option = document.createElement("option");
    
    option.value = "";
    option.textContent = data.message;
    studentsOptions.appendChild(option); 
  
     
   }
 }
    
  else{

 showError(data.message, data.error);

   return;
 
   }
 
   })
   .catch(error =>{
       
     showError(error, "Ajax Error");

   return;   
       
   });
 }
 
 
 window.onload = fetchClassStds();

 </script>
 
 
<script>
const profileInput = document.getElementById('profile');
const signatureInput = document.getElementById('signature');

const profilePreview = document.getElementById('profilePreview');
const signaturePreview = document.getElementById('signaturePreview');

const MAX_SIZE = 5 * 1024 * 1024; // 5MB

function previewImage(input, previewBox, titleText)
{
    previewBox.innerHTML = "";

    const file = input.files[0];

    if (!file) return;

    if (file.size > MAX_SIZE)
    {
        alert(titleText + " must not be more than 5MB");
        input.value = "";
 
 if(titleText == "Selected Profile"){
  profilePreview.style.display = "none";
  document.getElementById("prflabel").innerHTML = "Select Another Profile";

 }
 
  if(titleText == "Selected Signature"){
  signaturePreview.style.display = "none";
 document.getElementById("signlabel").innerHTML = "Select Another Signature";
      
  }
       return;
}

    const title = document.createElement("h4");
    title.textContent = "Preview "+titleText;

    const img = document.createElement("img");
    img.src = URL.createObjectURL(file);
    
    previewBox.appendChild(title);
    previewBox.appendChild(img);
  
if(titleText == "Selected Profile"){
    
 document.getElementById("prflabel").innerHTML = "Change Profile";
} 

if(titleText == "Selected Signature"){
    
  document.getElementById("signlabel").innerHTML = "Change Signature";
  }
}


// PROFILE IMAGE PREVIEW
profileInput.addEventListener("change", function ()
{
    profilePreview.style.display = "block";
    previewImage(profileInput, profilePreview, "Selected Profile");

});


// SIGNATURE IMAGE PREVIEW
signatureInput.addEventListener("change", function ()
{
  signaturePreview.style.display = "block";
  previewImage(signatureInput, signaturePreview, "Selected Signature");
  
});



</script>

