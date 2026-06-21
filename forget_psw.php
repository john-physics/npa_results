<?php
require './page_init.php';

$location = $_SERVER["HTTP_REFERER"];

if(!$location){
    $location ="/home";
}

if(isset($_GET["user_cat"])){
 
 $user = $_GET["user_cat"];   
 if($user == "staff"){
     
     $login = "/home";
 }
else{
    $login = "/home"; //for now, there maybe other user_cat later
    
}

head('forgot-password','forgot-password');

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


echo '
 <style>
  .warning i{
   font-weight: bold;
   color:rgb(200,150,250);
    font-size: 18px;
        
    }
    .logout-popup {
    display: block;
    position: relative;
    top: 50px;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.7);
    justify-content: center;
    align-items: center;
}


.popup {
    display: flex;
    position: relative;
    top: 60px;
    width: 90%;
    height: 100%;
  /* background: #fff; */
    justify-content: center;
    align-items: center;
}

.popup-content {
    background: #fff;
    padding: 30px;
    border-radius: 10px;
    width: 300px;
    text-align: center;
    position: relative;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
}

#close-btn {
    position: absolute;
    top: 10px;
    right: 10px;
    font-size: 18px;
    cursor: pointer;
    color: #555;
}

#close-bt {
    position: absolute;
    top: 10px;
    right: 15px;
    font-size: 24px;
    cursor: pointer;
    color: #555;
}



.input-group {
    margin-bottom: 15px;
    text-align: left;
}

label {
    display: block;
    margin-bottom: 5px;
    font-size: 14px;
    color: #333;
}

input {
    width: 100%;
    padding: 10px;
    margin: 0 auto;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 14px;
    box-sizing: border-box;
}

.password-container {
    position: relative;
}

.password-container i {
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    cursor: pointer;
    color: #888;
}

.password-container i:hover {
    color: #333;
}

.remember-me input{
  position:absolute; right:35%;
   margin-bottom:10px; 
    margin-right: 2px;
}

.remember-me label{
  position:relative; right:20%;
    margin-bottom:20px;
}
#mybtn,#logbtn {
    width: 100%;
    padding: 10px;
    background-color: #007BFF;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
}

#mybtn:hover {
    background-color: #0056b3;
}

.forgot-password {
    display: block;
    margin-top: 10px;
    color: #007BFF;
    text-decoration: none;
}

.forgot-password:hover {
    text-decoration: underline;
} 

.error {
    color: red;
    font-size: 12px;
    margin-top: 5px;
    display: block;
}

      .resend_ver_em a{
         text-decoration: none;
      }
     #home_icon{
      position:absolute;
      top:30px;
      left:15px;
      font-size:30px;   
     }
     .new_success, .new_errors{
     position:relative;
     top:30px;
     left:5%;
     width:85%; 
     }
     .resend_token{
         position:relative;
         top:10px;
         display:none;
     }
     .Timer{
         position:relative;
         top:10px; 
         display:block;
     }
    .show_psw{
    position: absolute;
    left:9%;
    
    }
    
 </style>';


if(isset($_GET["token_sent"])){
    
 $valid = $_SESSION["token_valid"];   
 $msg = $_GET["msg_report"]; 
 $token_report = $_SESSION["token_report"];
   
// $token = $_SESSION["token"];
 // echo $token;
 
 if($token_report == "sent"){
     
  echo '<div class ="new_success">
  Enter the token that was sent to your email in the input box below, the token is valid for only '.$valid.' minutes. </div>';
 
   echo '<center>
 <div id="login-popup" class="popup">
        <div class="popup-content">
          <span id="close-btn" onclick="closebtn()">&times;</span> 
           <h2>Reset your password</h2>
            <form id="login-form" method="post">
                <div class="input-group">
                    <label for="token">Authentication Token</label>
                    <input type="tel" id="email" name="email" placeholder="Enter authentication token here..." required>
                  <input type="hidden" id="user_cat" name="user_cat" value="'.$user.'">   
                    <input type="hidden" id="new_psw" name="new_psw" value="">  
                    <input type="hidden" id="con_new_psw" name="con_new_psw" value="">   
                <small id="email-error" class="error"></small>
              <small id="resend_ver_em" class="resend_ver_em">
                </small>
                </div>
            
              <button type="submit" id="mybtn" value="forgot_psw_submitToken"  onclick="submit_form()">Next</button>
            </form>
            <div class="Timer" id="Timer">Did not receive the token? Resend after <span id="counter">60</span> seconds</div>
  <div class="resend_token" id="resend_token">
<a href="/forget_psw?resend_token=true&user_cat='.$user.'">Resend token</a>
  </div>';
            
   require './loading_spinner.php';      
        echo '</div>
        </div></center>';  

 echo '<script>
 
 const timer = document.getElementById("Timer");
 const counter = document.getElementById("counter");
 const Resend = document.getElementById("resend_token");
 
var timerId = setInterval(countdown, 1000);

var timeLeft = 60;
function countdown() {
 
  if (timeLeft == -1) {
      
 timer.style.display = "none";
  Resend.style.display = "block";
     
  } 
  else {
  
  timer.style.display = "block";
   Resend.style.display = "none";   
     
 counter.innerHTML = timeLeft;
    timeLeft--;
  }
  
}

 </script>';   
     
     
 }
 elseif($token_report == "verified"){
    
   $em = $_SESSION["user_email"]; 
   echo '<center>
 <div id="login-popup" class="popup">
        <div class="popup-content">
          <span id="close-btn" onclick="closebtn()">&times;</span> 
           <h2>Reset your password</h2>
           <p>You may now Enter a new password</p>
            <form id="login-form" method="post">
                <div class="input-group">
                    <label for="email">Email</label>
                    <input type="text" id="email" name="email" placeholder="User Email" value="'.$em.'" readonly>
                  <input type="hidden" id="user_cat" name="user_cat" value="'.$user.'">   
                 <br><br>
                   <label for="new_psw">New Password</label>
                    <input type="password" id="new_psw" name="new_psw" placeholder="Enter a new and memorable password" required>  
                
                <br><br>
                  <label for="con_new_psw"> Confirm New Password</label>
                    <input type="password" id="con_new_psw" name="con_new_psw" placeholder="Confirm your password" required>  
                    
                <small id="email-error" class="error"></small>
                </div>
              <div class="show_psw"> 
       Show password 
         <i id="show_psw" class="fas fa-eye"></i>
            </div> <br><br>
              <button type="submit" id="mybtn" value="forgotpswSubmitNewpsw"  onclick="submit_form()">Next</button>
             
               <a href="'.$login.'" class="forgot-password">Cancel</a>
            </form>';
            
        require './loading_spinner.php';      
        echo '</div>
        </div></center>';  
     
    echo '<style>
    .footer{
        top:120px;
    }
    </style>';
     
 }
 elseif($token_report == "psw_changed"){
     
   echo '<div class="new_success">

 Your login password was changed successfully, You can use your new password to  <a href="'.$login.'" target="_blank">login now</a>
 
  </div><br><br><br>';     
  
     echo '<style>
     .new_success{
         top:60px;
     }
    .footer{
        top:250px;
    }
    </style>';   
     
 }
 else{
     
 echo '<div class="new_errors">
 Sorry an unexpected error occured, please <a href="/forget_psw?user_cat='.$user.'">try again</a></div><br><br>';       
     
 }
 
}
elseif(isset($_GET["resend_token"])){
 
 if(isset($_SESSION["user_email"])){
     
 $em = $_SESSION["user_email"]; 
   echo '<center>
 <div id="login-popup" class="popup">
        <div class="popup-content">
          <span id="close-btn" onclick="closebtn()">&times;</span> 
           <h2>Reset your password</h2>
           <p>Resend Token</p>
            <form id="login-form" method="post">
                <div class="input-group">
                    <label for="email"> Email</label>
                    <input type="text" id="email" name="email" placeholder="User Email" value="'.$em.'" readonly>
                  <input type="hidden" id="user_cat" name="user_cat" value="'.$user.'">  
                  <input type="hidden" id="new_psw" name="new_psw" value="">  
                    <input type="hidden" id="con_new_psw" name="con_new_psw" value="">   
                    
                <small id="email-error" class="error"></small>
              <small id="resend_ver_em" class="resend_ver_em">
                </small>
                </div>
            
              <button type="submit" id="mybtn" value="forgot_psw_submitEmail"  onclick="submit_form()">Next</button>
             
               <a href="'.$location.'" class="forgot-password">Cancel</a>
            </form>';
            
        require './loading_spinner.php';      
        echo '</div>
        </div></center>';
        
     
 }
  
  else{
      
 echo '<div class="new_errors">
 Sorry an unexpected error occured, please <a href="/forget_psw?user_cat='.$user.'">try again</a></div><br><br>';   
      
  }  
}
else{
 
 echo '<center>
 <div id="login-popup" class="popup">
        <div class="popup-content">
          <span id="close-btn" onclick="closebtn()">&times;</span> 
           <h2>Reset your password</h2>
            <form id="login-form" method="post">
                <div class="input-group">
                    <label for="email"> Email</label>
                    <input type="text" id="email" name="email" placeholder="Enter your Email Address" required>
                  <input type="hidden" id="user_cat" name="user_cat" value="'.$user.'"> 
                  <input type="hidden" id="new_psw" name="new_psw" value="">  
                    <input type="hidden" id="con_new_psw" name="con_new_psw" value="">   
                    
                <small id="email-error" class="error"></small>
              <small id="resend_ver_em" class="resend_ver_em">
                </small>
                </div>
            
              <button type="submit" id="mybtn" value="forgot_psw_submitEmail"  onclick="submit_form()">Next</button>
             
               <a href="'.$location.'" class="forgot-password">Cancel</a>
            </form>';
            
        require './loading_spinner.php';      
        echo '</div>
        </div></center>';
}


?> 
<script>

// Toggle show/hide password
const showPsw = document.getElementById("show_psw");
const newpsw = document.getElementById("new_psw");
const conpsw = document.getElementById("con_new_psw");

showPsw.addEventListener("click", () => {
    if (newpsw.type === "password") {
        newpsw.type = "text";
        conpsw.type = "text";
          
        showPsw.classList.remove("fa-eye");
        showPsw.classList.add("fa-eye-slash");
    } else {
        newpsw.type = "password";
        conpsw.type = "password";
         
        showPsw.classList.remove("fa-eye-slash");
        showPsw.classList.add("fa-eye");
    }
});

function closebtn() {
 
 var ref = document.referrer;  

if(!ref){
    
 ref = "index.php";   
    
}
window.location = ref;

 }


function submit_form(){
 
  // Form validation and loading spinner
const loginForm = document.getElementById("login-form");
const loadingSpinner = document.getElementById("loading-spinner");
const emailField = document.getElementById("email").value;
const userCat = document.getElementById("user_cat").value;
const Newpsw = document.getElementById("new_psw").value;
const ConNewpsw = document.getElementById("con_new_psw").value;

const btn_name = document.getElementById("mybtn").value;

const emailError = document.getElementById("email-error");

loginForm.addEventListener("submit", (e) => {
    e.preventDefault();
  emailError.innerText = ""; //clear previous error message if any
    // Show loading spinner
    loadingSpinner.style.display = "flex";

  fetch("/includes/forgetpsw.inc", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({
            submit_button_name: btn_name,
            user_email: emailField,
            user_cat: userCat,
            new_psw: Newpsw,
            con_new_psw: ConNewpsw
        })
    })
    .then(response => response.json())
    .then(data => {
      
  // Output the response to the user
  const status = data.status;
  const err = data.error;
  const msg = data.message;

 // Redirect if no error
 if(status == "success"){

 window.location  = "/forget_psw?user_cat="+userCat+"&msg_report="+msg+"&report=suc&token_sent=true"; 
       
   }
    
  else{
 
   // hide loading spinner
  loadingSpinner.style.display = "none";
      
  emailError.innerText = msg;
   
  }

 })
   .catch((error) => {
                // Hide the spinner and display error message
                loadingSpinner.style.display = "none";
                emailError.innerText = error;
     });
 });  
}


</script>
</body>
</html>  
<?php

echo '<br><br><br>';
 Addfooter($site); 
}
else{
    
 header("Location:$location");
 die();
    
}

