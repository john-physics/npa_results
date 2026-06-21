<?php

function collect_setup_data($conn,$table,$col,$data,$datatype){
//uses 1 search fields, user_id

$sql = "SELECT * FROM $table WHERE $col=? limit 1";
  
 $stmt = mysqli_stmt_init($conn);
 if(!mysqli_stmt_prepare($stmt, $sql)) {
 
  $error = mysqli_stmt_error($stmt);    

   return "";   
  }
  else {

 mysqli_stmt_bind_param($stmt, $datatype,$data);
 mysqli_stmt_execute($stmt);
 $result = mysqli_stmt_get_result($stmt);
 $user_data = mysqli_fetch_assoc($result);
 if($user_data){
 return $user_data;
 }
}
}

function check_setup_table($conn,$table){
 
  $sql = "SHOW TABLES";

$result = mysqli_query($conn, $sql);

 $tables = mysqli_fetch_all($result);
 
 if($tables){
     
 $tableNames = array_column($tables, 0);
  
 if(in_array($table, $tableNames)){

  return true;   
     
 }
 else{
     
  return false;   
     
  }
   
 }
 else{
 
 return false;    
     
 }
  
}

function  show_setup_Error($errCat,$err){

echo '<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="John Ella">
    <meta name="description" content="Site Configuration Settings" />
  <title>Site Configuration Settings</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
  
  <style>
    /* General Reset */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f9;
      color: #333;
     line-height: 1.6; 
      overflow-x: hidden; /* Prevent horizontal scrolling */
    }

   header {
      background-color: #004080;
      color: white;
      padding: 20px;
      text-align: center;
    }

    header h2 {
      margin: 0;
      animation: fadeInDown 1s ease;
    }
    .back{
        color: white;
        margin-right: 300px;
    }
    header img {
      width: 50px;
      height: 50px;
      border-radius: 50%;
      margin-bottom: 10px;
    }
  .auth{
      position:relative;
      top:30px;
      margin:20px;
      border: 2px solid #fff;
      border-radius:20px;
  }
  .auth #warning{
    position:relative; 
    top:10px;
     font-size:24px;
     color:orange;
  }
  .auth p{
   position:relative;
   top:10px;
   text-align:justify;   
    padding:10px; 
    
  }
  .auth #p2{
     font-weight:bold; 
     font-size:15px;
  }
  .auth #p3{
      margin-bottom:15px;
  }
    .footer {
       position: relative;
       top: 400px;
        text-align: center;
        font-size: 14px;
        color: #555;
        background: #dd12;
        width: 100%;
        height: 50px;
      }
      .footer p{
      position: relative; 
      top: 20px;
      width: 100%;
          
      }
    .auth #show_dev_btn{
        display:block; 
       position:relative;
       padding:10px;
       bottom:5px;
       font-size:8px;
       color:#f1f;
       cursor:pointer;
      }
      .auth #hide_dev_btn{
       display:none; 
       position:relative;
       padding:10px;
       bottom:5px;
       font-size:8px;
       color:#f1f;
       cursor:pointer;
      }
      .show_dev{
      display:none;
          position:relative;
          padding:10px;
      }
      .show_dev span,#i{
          font-size:24px;
      }
      .show_dev a{
          text-decoration:none;
      }
      .show_dev #brline{
         display:block;
          margin-bottom:10px;
          border: 1px solid red;
          width:100%;
          
      }
  @media screen and (min-width:800px){
  .auth p{
   text-align:center;
  }
  .footer{
      top:300px;
  }
      
  }
  

  </style>
</head>
<body>';
 
 if($errCat == "err1"){
     $errDesc = $err;
 }
 else{
     $errDesc = "Database Configuration/Auth";
 }

$text ="Hi, I encountered an error using the site you developed, Please can you respond to this message so that you can help resolve this issue? (Error Description: $errDesc)";

 $whatsappText = rawurlencode($text);
 $emailText = htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
 
echo '<div class="auth">
 <center><i id="warning" class="fas fa-exclamation-triangle"></i></center>
 <p id="p1">Sorry, an error occured while starting this site. </p>

 <p id="p2"> ERROR DESC: '.$errDesc.'</p>
 
 <p id="p3">Please contact the developers of this site to help resolve this issue before the site can start up properly.
  </p>
  <small class="view_dev" id="show_dev_btn" onclick="showDev(1)">
  View Developers
   <i id="view_eye" class="fas fa-eye"></i>
  </small>
 
  <small class="view_dev" id="hide_dev_btn" onclick="showDev(2)">
  Hide Developers
   <i id="view_eye" class="fas fa-eye"></i>
  </small>
  <div class="show_dev" id="show_dev">
  <label id="dev1">
  <i id="i" class="fas fa-user"></i> <span>John Ella</span><br>
  Fullstack Developer<br>
  <a href="https://wa.me/2348152318306?text='.$whatsappText.'" target="_blank">
  <i class="fas fa-phone"></i> +2348152318306</a><br>
<a href="mailto:ellaj3482@gmail.com?subject=Website%20Start%20up%20Error&body='.$emailText.'">
   <i class="fas fa-envelope"></i> ellaj3482@gmail.com</a><br>
  </label>
 <label id="brline"></label>
   
 <!--  <label id="dev2">
  <i id="i" class="fas fa-user"></i> <span>Kolawole Ayomide</span><br>
  HTML, CSS and Javascript (Frontend)<br>
  <a href="https://wa.me/2347030318983?text='.$whatsappText.'" target="_blank">
  <i class="fas fa-phone"></i> +2347030318983</a><br>
<a href="mailto:kolawoleayomide28@gmail.com?subject=Website%20Start%20up%20Error&body='.$emailText.'">
   <i class="fas fa-envelope"></i> kolawoleayomide28@gmail.com</a><br>
  </label>
  -->
    </div>
  </div>';   
      
  $dev = "John Ella";
  
  $yr = date("Y");
  echo '<div class="footer">
 <p>'.$dev.' &copy; '.$yr.', copyright reserved</p></div>'; 
 
 echo '<script>
 function showDev(event){
     
 const Dev = document.getElementById("show_dev");
 
 const showDevBtn = document.getElementById("show_dev_btn");
  
const hideDevBtn = document.getElementById("hide_dev_btn");


if(event == "1"){
    
Dev.style.display="block";
 showDevBtn.style.display ="none";
 hideDevBtn.style.display ="block";    
}
else if(event == "2"){
 Dev.style.display="none";
 showDevBtn.style.display ="block";
 hideDevBtn.style.display ="none";    
    
  }
  else{
 Dev.style.display="none";
 showDevBtn.style.display ="block";
 hideDevBtn.style.display ="none";    
        
  }
 }
 </script>';
 
 exit();
}

function show_dev_prev($home_db,$prev,$aware,$site1){
    
   echo '<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="John Ella">
    <meta name="description" content="Site Authentication" />
  <title>Site Authentication</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
  
  <style>
    /* General Reset */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f9;
      color: #333;
     line-height: 1.6; 
      overflow-x: hidden; /* Prevent horizontal scrolling */
    }

   header {
      background-color: #004080;
      color: white;
      padding: 20px;
      text-align: center;
    }

    header h2 {
      margin: 0;
      animation: fadeInDown 1s ease;
    }
    .back{
        color: white;
        margin-right: 300px;
    }
    header img {
      width: 50px;
      height: 50px;
      border-radius: 50%;
      margin-bottom: 10px;
    }
  .auth{
      position:relative;
      top:30px;
      
  }
  .auth i{
     font-size:24px;
     color:orange;
  }
  .auth p{
   
   text-align:center;   
      
  }
    .footer {
       position: relative;
       top: 200px;
        text-align: center;
        font-size: 14px;
        color: #555;
        background: #dd12;
        width: 100%;
        height: 50px;
      }
      .footer p{
      position: relative; 
      top: 20px;
      width: 100%;
          
      }
      .popup {
    display: flex;
    position: relative;
    top: 80px;
    width: 90%;
    height: 100%;
   
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


/* Form styling */
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

input,select {
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
.error {
    color: red;
    font-size: 12px;
    margin-top: 5px;
    display: block;
}
.suc {
    color: green;
    font-size: 12px;
    margin-top: 5px;
    display: block;
}
  </style>
</head>
<body>';
  
 if($prev){
 
  if($home_db){
 $auth_table = "Developers";
if(check_exist_table($home_db,$auth_table)){
    
$auth = collect_user_data($home_db,$auth_table,'Stake','Major','s');
$auth_status = $auth["Auth_Status"];
$auth_freq = $auth["Auth_Frequency"];
$devPrev = $auth["Privilege"];

 }
 
 if(password_verify($prev,$devPrev)){
  echo '<div class="auth">
 <center><i class="fas fa-exclamation-triangle"></i></center>
  <p>Welcome To Developer\'s Tools<br>
  Awareness: '.$aware.'</p>
  </div>'; 
  
 if($aware == "true"){
    
  echo '<center>
 <div id="login-popup" class="popup">
        <div class="popup-content">
          <span id="close-btn" onclick="closebtn()">&times;</span> 
           <h2>Site Authentication</h2>
            <form id="login-form" method="post">
                <div class="input-group">
        
              <label for="auth_token">
              Authentication Token</label>
               <input type="text" id="dev_auth" placeholder="Enter Authentication Token" autofocus required> 
                <input type="hidden" id="auth_table" value="'.$auth_table.'">
               <input type="hidden" id="dev_prev" value="'.$prev.'">
               
                <small id="email-error" class="error"></small>
                </div>
         
              <button type="submit" id="mybtn" value="submit_dev_auth_token"  onclick="submit_auth_form()">Next</button>
            </form>
           
  </div>';
 $path = $_SERVER["DOCUMENT_ROOT"];          
   require $path.'/loading_spinner.php';      
        echo '</div>
        </div></center>'; 

echo '<script>
function submit_auth_form(){
    
const loginForm = document.getElementById("login-form");
const loadingSpinner = document.getElementById("loading-spinner");

const authToken = document.getElementById("dev_auth").value;
const authTable = document.getElementById("auth_table").value;

const devPrev = document.getElementById("dev_prev").value;

const btn_name = document.getElementById("mybtn").value;

const emailError = document.getElementById("email-error");

loginForm.addEventListener("submit", (e) => {
    e.preventDefault();

    // Show loading spinner
    loadingSpinner.style.display = "flex";

fetch("/setup.inc", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({
            submit_button_name: btn_name,
            dev_auth: authToken, 
            auth_table: authTable,
            dev_prev: devPrev,
        })
    })
    .then(response => response.json())
    .then(data => {
      
  // Output the response to the user
  var status = data.status;
   var err = data.err;
   var msg = data.message;
   
 if(status == "success"){

window.location.href = "?msg_report="+msg+"&report=suc";

  // hide loading spinner
  loadingSpinner.style.display = "none";
  
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
    
</script>';
         
     
 }
  
 else{ 
     //not aware
    echo '<center>
 <div id="login-popup" class="popup">
        <div class="popup-content">
          <span id="close-btn" onclick="closebtn()">&times;</span> 
           <h2>Site Authentication</h2>
            <form id="login-form" method="post">
                <div class="input-group">
                    <label for="auth_stat">Authentication Status:<span id="stat"> '.$auth_status.'</span>
                     </label>
                 
         <select id="auth_stat" name="auth_stat">
         <option value="">Change Authentication Status</option>
         <option value="On">On</option>
         <option value="Off">Off</option>
               
               </select>
                  <br><br>
              <label for="auth_freq">Authentication Frequency (days)</label>
               <input type="text" id="auth_freq" value="'.$auth_freq.'" placeholder="Authentication frequency"> 
             <input type="hidden" id="ini_auth_stat" value="'.$auth_status.'"> 
               
                <input type="hidden" id="auth_table" value="'.$auth_table.'">
               
                <small id="email-error" class="error"></small>
               <small id="email-suc" class="suc"></small>
                 
                </div>
         
              <button type="submit" id="mybtn" value="submit_dev_auth_stat"  onclick="submit_auth_form()">Next</button>
            </form>
           
  </div>';
 $path = $_SERVER["DOCUMENT_ROOT"];          
   require $path.'/loading_spinner';      
        echo '</div>
        </div></center>'; 

echo '<script>
function submit_auth_form(){
    
const loginForm = document.getElementById("login-form");
const loadingSpinner = document.getElementById("loading-spinner");

const AuthStat = document.getElementById("auth_stat").value;

const IniAuthStatus = document.getElementById("ini_auth_stat");
const IniAuthStat = IniAuthStatus.value;

const AuthFreq = document.getElementById("auth_freq");
const Auth_Freq = AuthFreq.value;

const authTable = document.getElementById("auth_table").value;

const btn_name = document.getElementById("mybtn").value;

const emailError = document.getElementById("email-error");

const emailSuc = document.getElementById("email-suc");

const Stat = document.getElementById("stat");

loginForm.addEventListener("submit", (e) => {
    e.preventDefault();

    // Show loading spinner
    loadingSpinner.style.display = "flex";

fetch("/setup.inc", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({
            submit_button_name: btn_name,
            auth_stat: AuthStat, 
            auth_table: authTable,
           ini_auth_stat: IniAuthStat,
           auth_freq: Auth_Freq
        })
    })
    .then(response => response.json())
    .then(data => {
      
  // Output the response to the user
  var status = data.status;
   var err = data.err;
   var msg = data.message;
   var new_stat = data.new_stat;


 if(status == "success"){

  // hide loading spinner
  loadingSpinner.style.display = "none";
  
   emailSuc.innerText = msg;
   emailError.innerText = "";
   
   IniAuthStatus.value = new_stat;
   Stat.innerText = new_stat;
   AuthFreq.value = Auth_Freq;   
   }
    
  else{
 
   // hide loading spinner
  loadingSpinner.style.display = "none";
      
 
  emailError.innerText = msg;
  emailSuc.innerText = ""; 
  }

 })
   .catch((error) => {
                // Hide the spinner and display error message
                loadingSpinner.style.display = "none";
                emailError.innerText = error;
     });
 
 });
}
    
</script>';
     
  }     
 }
 else{
     
    $msg = "Unknown Developer, if you are not one of the developers of this site, Please stop using this tool because you will be restricted from using this site forever after much attempt";
   echo '<div class="auth">
 <center><i class="fas fa-exclamation-triangle"></i></center>
  <p>'.$msg.'</p>
  </div>';  
  echo '<style>
  .footer{
      top:300px;
  }
  </style>';      
     
    }    
  
 }
 else{
  $msg = "Unable to connect to database, Please reload the page again.";
  
   echo '<div class="auth">
 <center><i class="fas fa-exclamation-triangle"></i></center>
  <p>'.$msg.'</p>
  </div>';  
  echo '<style>
  .footer{
      top:300px;
  }
  </style>';  
     
  }
      
 } 
  
   else{
 $msg = "Unknown privilige, if you are not one of the developers of this site, Please stop using this tool because you will be restricted from using this site forever after much attempt";
  
   echo '<div class="auth">
 <center><i class="fas fa-exclamation-triangle"></i></center>
  <p>'.$msg.'</p>
  </div>';
  
   echo '<center>
 <div id="login-popup" class="popup">
        <div class="popup-content">
          <span id="close-btn" onclick="closebtn()">&times;</span> 
           <h2>Site Authentication</h2>
            <form id="login-form" method="post">
                <div class="input-group">
                    
              <label for="auth_freq">Developer\'s Privilege</label>
               <input type="text" id="prev" name="prev" placeholder="Enter your privilege" required autofocus> 
             <input type="hidden" id="aware" name="aware" value="'.$aware.'"> 
               
                <small id="email-error" class="error"></small>
              
                </div>
         
              <button type="submit" id="mybtn" name="submit_dev_auth_prev">Next</button>
            </form>
           
  </div></div>
     </div></center>'; 

  echo '<style>
  .footer{
      top:300px;
  }
  </style>';  
   } 
   $yr = date("Y");
  echo '<div class="footer">
 <p>&copy; '.$yr."\n".$site1.'</p></div>';    
 exit(); 
} 

function update_data_New($conn, $table, $upd_col, $id_col , $upd_value, $id_value,$param){
    
//this function is meant to update the database using one search field, the $param must be two values, one for the update you want to make and the other for the id field. (e.g si or ii because id is integer except for only students id that is string (s))
    
 $sql = "UPDATE $table SET $upd_col =? WHERE $id_col =?";
  $stmt = mysqli_stmt_init($conn);
 if(!mysqli_stmt_prepare($stmt, $sql)){

$err = mysqli_stmt_error($stmt);

die("Error: ".$err);
     
 }
 else{
mysqli_stmt_bind_param($stmt, $param,
 $upd_value, $id_value);
if(mysqli_stmt_execute($stmt)){
  return true;  
 }
 else{
     return false;
  }
 }
}

function SiteSetup($home_db,$site1,$url){
 
  if ($_SERVER['SERVER_NAME'] == 'localhost' || $_SERVER['SERVER_ADDR'] == '127.0.0.1') {
  // echo "Running on Local Server";

  }
 else {
//  echo "Running on Live Server";

 $table = "Developers";
 date_default_timezone_set("Africa/Lagos");
  $DateTime = date("D d/m/Y h:i A");
  $time = time();

if(check_exist_table($home_db,$table)){
  
 $dev = collect_user_data($home_db,$table,'Stake','Major','s');  
    
 $devEmail = $dev["Email"];
 $devName = $dev["Developer"];
 $aware = $dev["Awareness"];
 $lastNotify = $dev["Last_Notify"];
 
 if($aware == "false" && $lastNotify !="Received"){
     
$diff = $time - $lastNotify;
$Notifyfreq = (60*60)*24;//1 day frequency

if($diff >= $Notifyfreq){
 
// Get the protocol (http or https)
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";

// Get the domain name
$host = $_SERVER['HTTP_HOST'];

// Get the request URI (path + query string)
$requestUri = $_SERVER['REQUEST_URI'];

// Construct the absolute URL
$absoluteUrl = $protocol."://".$host.$requestUri;

 $send = send_Site_Notify($devEmail,$devName,$absoluteUrl,$DateTime,$site1,$url);   
 
  update_data_New($home_db,$table,"Site_Live_Date","Stake",$DateTime,"Major","ss");
  update_data_New($home_db,$table,"Last_Notify","Stake",$time,"Major","ss");
    
  }
 }
}
else{
 //create the table    
    
  }

 }  
}