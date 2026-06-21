<?php
require 'page_init.php';
if(!check_staff_login($conn)){

header("Location:/home");
exit();
}

head('Staff Profile',"$site | Staff Profile Page","profile"); //add header 
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
   .contact-form label{
    position:relative;
    top:10px;
    font-weight:bold;
    font-style:italic;
    color:rgb(100,200,100);
}
 .new_success{
     
  position:relative;
  left:0;
 }
 .new_errors{
     
  position:relative;
  left:0;
 }
  #spinner, #spinner2 {
        display: none;
        border: 4px solid #f3f3f3;
        border-top: 4px solid #3498db;
        border-radius: 50%;
        width: 30px;
        height: 30px;
        animation: spin 0.4s linear infinite;
        margin: 10px auto;
    }

  #spinner3 {
        display: none;
        border: 4px solid #f3f3f3;
        border-top: 4px solid #3498db;
        border-radius: 50%;
        width: 30px;
        height: 30px;
        animation: spin 0.4s linear infinite;
        margin: 10px auto;
        position:relative;
        bottom: 50px;
        left:30px;
    }

 
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
  
     #prep_cert3{
   /*  display:inline-block; */
    display:none;
     text-align:center;
     color:rgb(50,200,50);
     font-size:10px;
     position:relative;
     bottom:70px;
     left:140px;
     font-weight:bold;
 }
    #prep_cert1, #prep_cert2{
     display:none;
     text-align:center;
     color:rgb(50,200,50);
     font-size:10px;
     position:relative;
     top:1px;
     font-weight:bold;
 }
 .profile-container {
  max-width: 700px; 
  margin: 40px auto;
  padding: 25px 30px;
  font-family: "Poppins", sans-serif;
  background: #fff;
  border-left: 4px solid #004aad;
  border-radius: 10px;
  box-shadow: 0 2px 6px rgba(0,0,0,0.05);
}

.profile-top {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  margin-bottom: 25px;
}

.profile-top h2 {
  color: #003366;
  font-size: 1.8rem;
  margin: 0;
   color: rgb(50,200,150); 
}

.sub-note {
  color: #777;
  font-size: 0.9rem;
  margin-top: 4px;
  font-style:italic;
}

.edit-icon {
 position:relative;
 top:5px;
 background: #e600ff;
  color: #fff;
  border: none;
  border-radius: 50%;
  width: 38px;
  height: 38px;
  cursor: pointer;
  display: flex;
  justify-content: center;
  align-items: center;
  transition: 0.2s ease;
}
.edit-icon:hover {
  transform: scale(1.05);
}

.profile-info {
  border-top: 1px solid #e5e9f2;
  border-bottom: 1px solid #e5e9f2;
  padding: 8px 0;
}

.info-row {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 14px 0;
  border-bottom: 1px solid #f1f4fa;
  transition: all 0.25s ease;
}
.info-row:last-child {
  border-bottom: none;
}

.info-row:hover {
  background: #f8faff;
  padding-left: 10px;
}

label {
  font-weight: bold; /* made bold */
  color: #333;
  font-size: 18px;
}

.info-row span {
  color: #111;
  font-size: 0.95rem;
  font-weight: 500;
  text-align: right;
  word-break: break-word;
}

.profile-footer {
  margin-top: 25px;
  text-align: right;
}

.change-link {
  color: #004aad;
  text-decoration: none;
  font-weight: 600;
  transition: color 0.2s ease;
  cursor:pointer;
}
.change-link:hover {
  color: #00348a;
  text-decoration: underline;
}


@media (max-width: 480px) {
  .profile-container{
    max-width:330px;  
  }

  .info-row span {
    margin-top: 3px;
  font-size: 0.90rem;
  }
 
 label {
  font-size: 16px;
}

}
.section{
position:relative;

}
.section h2{
display:block;
    position:absolute;
    font-size: 1.8rem;
    text-align:center;
    left:20%;
}

.contact-form button{
    width:40%; 
    font-size:12px;
}
#file-input{
    display:none;
}

#eye{
 position:absolute; 
 top:140px; 
 left:56%;
 background:white;
 border:1px solid #ddd;
 width:25px;
 height:25px;
border-radius:5px;
display:flex;
align-items:center;
justify-contents:center;
cursor:pointer;
z-index:99;
font-style:standard;
 color:#333;
}

@media screen and (min-width:800px){
 
 #eye{
 top:145px; 
 left:52%;

 }
    
}
.edit_input input{
  font-size:10px;  
  height:30px;
  padding:5px;
  
}

.edit_input select{
  font-size:10px;  
  height:30px;
  padding:5px;
  
}
.close{
display:block;
  position:relative;
  left:90%; top:-10px;
  background:#ddd;
  color:red;
  width:30px;
  height:30px;
  padding:5px;
  font-size:14px;
    cursor:pointer;
}
.close i{
   display:block;
   text-align:center;
   position:relative;
   right:4px;
   bottom:15px;
    
}
#edit_icon{
     position:relative;
  left:90%; top:0;
    background:#f1f;
    color:white;
     width:25px;
  height:25px;
  padding:5px;
  
 
}

#edit_section{
    display:none;
}
.edit_psw a{
    color:black;
    text-decoration-color:black;
}
.save_profile{
   display:none;
    position:relative;
    top:20px;
    
}

.save_profile #save_profile_btn{
  display:block;
  position:relative;
  left:10%;
  background: #00348a;
  color:#fff;
  padding:10px;
  border-radius:5px;
  width:120px;
  text-align:center;  
  cursor:pointer;
}
  @media screen and (min-width:800px){
 .save_profile #save_profile_btn{
 left:25%;
 }
  }
 </style>';

$staff_id = $_SESSION["staff_id"];

$user_det = collect_user_data($conn,'staffs','staff_id',$staff_id,'i');

$email = null_check($user_det["email"],"None");
$num = null_check($user_det["number"],"None");
$sur = null_check($user_det["surname"],"Unknown");
$oth = null_check($user_det["othernames"],"Unknown");
$gender = null_check($user_det["gender"],"Unknown");
$title = null_check($user_det["title"],"Unknown");
$staff_cat = null_check($user_det["staff_cat"],"Unknown");


 if(isset($_SESSION["changes_errors"])){
   
  $errors = $_SESSION["changes_errors"];   
  
  if(is_array($errors)){
   $count_errors = count($errors); 
  }
  
  else{
   $count_errors = 1;    
      
  } 
  
echo '<section class="section" id="about">
 <div class ="new_errors">ERRORS: '.$count_errors.'';
  foreach ($errors as $error){
  echo "<br>* ".$error;    
  }
  echo '</div></section>';
  unset($_SESSION["changes_errors"]);
  
 } 
   
 if(isset($_SESSION["changes_made"])){
     
  $changes = $_SESSION["changes_made"];   
  
  if(is_array($changes)){
   $count_changes = count($changes); 
  }
  
  else{
   $count_changes = 1;    
      
  } 
  
 echo '<section class="section" id="about">
  <div class ="new_success">Changes Made: '.$count_changes.'';
  foreach ($changes as $change){
  echo "<br>• ".$change;    
  }
  echo '</div></section>';
  unset($_SESSION["changes_made"]);
 } 

 echo '<div class="save_profile" id="save_profile">
 <label id="save_profile_btn" for="save_changes_btn">Save Changes</label>

  <div id="spinner3"></div>
<small id="prep_cert3">Updating your profile, Please wait ...</small>
</div>';

echo '<section id="profile_section" class="profile-container">
  <div class="profile-top">
    <div>
      <h2>Profile Settings</h2>
      <p class="sub-note">View and Manage your personal details</p>
    </div>
    <button class="edit-icon" onclick="showEditInput()" title="Edit your personal details"><i class="fa fa-pen"></i></button>
  </div>

  <div class="profile-info">
       <div class="info-row">
      <label>Surname</label>
      <span>'.$sur.'</span>
    </div>
    <div class="info-row">
      <label>Other Name(s)</label>
      <span>'.$oth.'</span>
    </div>
    <div class="info-row">
      <label>Email</label>
      <span>'.$email.'</span>
    </div>
    <div class="info-row">
      <label>Phone Number</label>
      <span>'.$num.'</span>
    </div>
    <div class="info-row">
      <label>Gender</label>
      <span>'.$gender.'</span>
    </div>
    <div class="info-row">
      <label>User Category</label>
      <span>'.$staff_cat.'</span>
    </div>

  </div>

 <div class="profile-footer" id="edit_psw">
  <a href="#" class="change-link" id="changepsw-link">Change Password</a>
     </div>

</section>';

 require 'change_psw.php';
   change_psw();
  
 echo '<label id="eye" for ="file-input" class="fas fa-eye" title="Update your profile image"></label>';   

echo '<section id="edit_section" class="section">
       <h2>Edit Your Profile</h2>';
 
 echo '<form action="/includes/profile.inc" method="POST" class="contact-form" id="contact-form" enctype="multipart/form-data">
 
<input type ="file" id="file-input" name="prf" accept ="image/*" onchange="previewImage(this)">

  <span class="close" id="close" onclick="closeInput()" title="Cancel editting">&#10060</span>
 
   <label for="new_sur">Surname: '.$sur.'
   </label>
  <div class="edit_input" id="edit_sur"> 
  <input type="text" id="new_sur" name="new_sur" placeholder="Correct your surname">
  </div> 
  
  <label for="new_oth">Other Name(s): '.$oth.'</label>
  <div class="edit_input" id="edit_oth"> 
  <input type="text" id="new_oth" name="new_oth" placeholder="Correct your Other Name(s)">
  </div>

 <label for="new_email">Email: '.$email.'</label>
  <div class="edit_input" id="edit_email"> 
  <input type="email" id="new_email" name="new_email" placeholder="Change your Email Address">
  </div>  
 
 <label for="new_num">Phone Number: '.$num.'
 </label>
  <div class="edit_input" id="edit_num"> 
  <input type="tel" id="new_num" name="new_num" placeholder="Change your phone number">
  </div> 
  
 <label for="new_gender">Gender: '.$gender.'</label>
  <div class="edit_input" id="edit_gender">
 <select id="new_gender" name="new_gender">
  <option value="">---Update your Gender---</option>
  <option>Male</option>
  <option>Female</option>
  </select>
  </div> 
 
  <label for="new_title">Title: '.$title.'</label>
  <div class="edit_input" id="edit_title">
 <select id="new_title" name="new_title">
  <option value="">---Update your Title---</option>';
 
 $staff_titles = staff_titles();
 foreach ($staff_titles as $staff_title){
     
 echo '<option>'.$staff_title.'</option>'; 
 }
  
  echo '</select>
  </div> 
  
  
 <button type="submit" id="save_changes_btn"  name="save_profile_changes">Save Changes</button>
 </form>
 <div id="spinner"></div>
<small id="prep_cert1">Updating your profile, Please wait ...</small>

</section>



<script>
function showEditInput(){
  
 document.getElementById("edit_section").style.display = "block";
 
  document.getElementById("profile_section").style.display = "none";
 
 document.getElementById("save_profile").style.display = "none";
 
  
}

function closeInput(){
 
 document.getElementById("edit_section").style.display = "none";
 
  document.getElementById("profile_section").style.display = "block";
 
 //show or hide Save profile btn  
 const saveProfile = document.getElementById("save_profile");
if(saveProfile.classList.contains("active")){
    
  saveProfile.style.display = "block";  
}
 else{
     
   saveProfile.style.display = "none";  
 }
  
 
}

</script>

<script>
 const EditForm = document.getElementById("contact-form");

 const Spinner = document.getElementById("spinner");
  const prep = document.getElementById("prep_cert1");


 EditForm.addEventListener("submit",(e)=>{
 // e.preventDefault();
  Spinner.style.display = "flex";
  prep.style.display = "block";
  
 });

 </script>
<script>

function previewImage(input) {
  if (input.files && input.files[0]) {
    const reader = new FileReader();
    reader.onload = function (e) {
      document.getElementById("profile-pic").src = e.target.result;
    };
    reader.readAsDataURL(input.files[0]);
  }
 
 const saveProfile = document.getElementById("save_profile");
 
 saveProfile.style.display ="block";
 saveProfile.classList.add("active");
 
}

const saveProfileBtn = document.getElementById("save_profile_btn");
const Spinner3 = document.getElementById("spinner3");
const prep3 = document.getElementById("prep_cert3");

saveProfileBtn.addEventListener("click",(e)=>{
  
 Spinner3.style.display = "flex";
 prep3.style.display = "inline-block";
  
});

</script>';


echo '<script>

const pswLink = document.getElementById("changepsw-link");
const pswPopup = document.getElementById("psw-popup");

const closePsw = document.getElementById("close-pswbtn");


pswLink.addEventListener("click", (e) => {
  
  e.preventDefault();
  
    pswPopup.style.display = "flex";
 
  document.getElementById("eye").style.display="none";
    
 document.getElementById("edit_icon").style.display="none";
    
});

closePsw.addEventListener("click", () => {
    pswPopup.style.display = "none";

 document.getElementById("eye").style.display="block";
    
 document.getElementById("edit_icon").style.display="block";
});

  window.addEventListener("click", (e) => {
    if (e.target === pswPopup) {
        pswPopup.style.display = "none";

  document.getElementById("eye").style.display="block";
     
  document.getElementById("edit_icon").style.display="block";
    }
}); 


function submit_chpsw_form(){
 

  // Form validation and loading spinner
const pswForm = document.getElementById("psw-form");
const loadingSpinner1 = document.getElementById("loading-spinner1");
const oldpsw = document.getElementById("old_psw").value;
const newpsw = document.getElementById("new_psw").value;
const conpsw = document.getElementById("con_new_psw").value;

//document.write(remember);
const btn_name = document.getElementById("chpsw_btn").value;

const oldpswError = document.getElementById("old_psw_error");
const newpswError = document.getElementById("new_psw_error");


pswForm.addEventListener("submit", (e) => {
    e.preventDefault();

 //clear initial error msg
 oldpswError.innerText = "";
 newpswError.innerText = "";   
 
 
if(!oldpsw){
 
 oldpswError.innerText = "Old password must not be empty";   
   return; 
}

else if(!newpsw){
  
   newpswError.innerText = "New password must not be empty";   
   return;  
    
}

else if(!conpsw){
    
  newpswError.innerText = "Confirm New password must not be empty";   
   return; 
   
}
  
 else{
 
   // Show loading spinner
  loadingSpinner1.style.display = "flex";

  fetch("/includes/profile.inc", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({
            submit_button_name: btn_name,
            old_psw: oldpsw,
            new_psw: newpsw,
            con_psw: conpsw
        })
    })
    .then(response => response.json())
    .then(data => {
       // Output the response to the user
    
   var status = data.status;
   var err = data.err;
   var msg = data.message;
  
//  document.write(msg);

 // Redirect if no error
       
 if(status == "success"){
  
 window.location  = "profile?msg_report="+msg+"&report=suc"; 
  
  loadingSpinner1.style.display = "none";
     
   }
    
  else{
  loadingSpinner1.style.display = "none";
       
  if(err == "old_psw"){
  
  oldpswError.innerText = msg;
  
  }
  else if(err == "new_psw"){
   newpswError.innerText = msg;   
      
  }
  else{
     newpswError.innerText = "Error: " + msg;     
      
   }

  }

  });
  
 }
  
});

}

// Toggle show/hide password
const showPsw = document.getElementById("show_psw");
const oldpsw = document.getElementById("old_psw");
const newpsw = document.getElementById("new_psw");
const conpsw = document.getElementById("con_new_psw");

showPsw.addEventListener("click", () => {
    if (oldpsw.type === "password") {
        oldpsw.type = "text";
        newpsw.type = "text";
        conpsw.type = "text";
          
        showPsw.classList.remove("fa-eye");
        showPsw.classList.add("fa-eye-slash");
    } else {
        oldpsw.type = "password";
        newpsw.type = "password";
        conpsw.type = "password";
         
        showPsw.classList.remove("fa-eye-slash");
        showPsw.classList.add("fa-eye");
    }
});
 
</script>'; 



Addfooter($site); 