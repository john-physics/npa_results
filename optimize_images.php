<?php

require 'page_init.php';

if(!check_staff_login($conn)){

header("Location:/home");
exit();
}


head('Image optimizer',"$site | Image optimizer","optimizer"); //add header 
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

body{
    background:#f4f7fb;
   /* padding:30px; */
}
/* Dashboard Wrapper */

.dashboard{
   
   width:92%;
   max-width:700px; 
    margin:auto;
    background:#fff;
    border-radius:18px;
    padding:30px;
    box-shadow:0 8px 25px rgba(0,0,0,0.08);
    margin-top:20px;
    
}

/* Heading */

.dashboard h2{
    text-align:center;
    margin-bottom:30px;
    color:#1f3c5a;
    font-size:28px;
}

/* Each Setting Row */

.setting-box{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:18px 20px;
    margin-bottom:18px;
    border:1px solid #e4e7ec;
    border-radius:14px;
    background:#fafbfd;
    transition:0.3s;
}

.setting-box:hover{
    transform:translateY(-2px);
    box-shadow:0 4px 12px rgba(0,0,0,0.05);
}

.setting-title{
    font-size:16px;
    font-weight:600;
    color:#2b3e50;
}

/* Toggle Switch */

.toggle-container{
    display:flex;
    align-items:center;
    gap:12px;
}

.status-text{
    font-size:14px;
    font-weight:bold;
    color:#888;
}

/* Switch */

.switch{
    position:relative;
    width:62px;
    height:32px;
}

.switch input{
    display:none;
}

.slider{
    position:absolute;
    inset:0;
    background:#d5d9df;
    border-radius:40px;
    cursor:pointer;
    transition:0.3s;
}

.slider::before{
    content:"";
    position:absolute;
    width:24px;
    height:24px;
    left:4px;
    top:4px;
    background:#fff;
    border-radius:50%;
    transition:0.3s;
    box-shadow:0 2px 5px rgba(0,0,0,0.2);
}

.switch input:checked + .slider{
    background:#1e90ff;
}

.switch input:checked + .slider::before{
    transform:translateX(30px);
}

/* Input Section */

.score-input-box{
    display:flex;
    flex-direction:column;
    gap:12px;
    padding:20px;
    border:1px solid #e4e7ec;
    border-radius:14px;
    background:#fafbfd;
    margin-top:10px;
    position:relative;
}

.score-input-box label{
    font-weight:600;
    color:#2b3e50;
}

.score-input-box input{
    width:100%;
    padding:14px;
    border-radius:10px;
    border:1px solid #cfd6df;
    font-size:16px;
    outline:none;
    transition:0.3s;
}

.score-input-box input:focus{
    border-color:#1e90ff;
    box-shadow:0 0 0 3px rgba(30,144,255,0.15);
}

/* Save Button */

.save-btn{
    margin-top:15px;
    padding:13px;
    border:none;
    background:#1e90ff;
    color:#fff;
    border-radius:10px;
    cursor:pointer;
    font-size:15px;
    font-weight:bold;
    transition:0.3s;
}

.save-btn:hover{
    background:#1878d6;
}

.message{
    margin-top:10px;
    font-size:14px;
    color:green;
    font-weight:bold;
    text-align:center;
    font-style:italic;
}

  #prep1{
     display:none;
     text-align:center;
     color:rgb(50,200,50);
     font-size:10px;
     position:relative;
     top:1px;
     font-weight:bold;
 }
 
.spinner{
    position:relative;
    display:none;
    border:4px solid #f3f3f3;
    border-top:4px solid rgb(100,50,200);
    border-radius:50%;
    width:35px;
    height:35px;
    animation:spin 0.4s linear infinite;
    margin:10px auto;
}

@keyframes spin{
    0%{ transform:rotate(0deg); }
    100%{ transform:rotate(360deg); }
} 

.green{
    color:green;
}

@media(max-width:600px){

    .setting-box{
        flex-direction:column;
        align-items:flex-start;
        gap:15px;
    }

    .toggle-container{
        width:100%;
        justify-content:space-between;
    }

}


</style>';


 $staff_id = $_SESSION["staff_id"];
 $staff_cat = $_SESSION["staff_cat"];
 $user = get_user_name($staff_id);
$fullname =  ucwords($user["fullname"]);

 if(in_array($staff_cat,$reserved) || password_verify($fullname,$developerToken)){


$directory =""; $batch_size="";
$image_size =""; $image_height="";
$image_width =""; $quality="";

if(isset($_SESSION["submit_attempt"])){
 
 $directory = $_SESSION["directory"];
 $batch_size = $_SESSION["batch_size"];
 $image_size = $_SESSION["image_size"];
 $image_width = $_SESSION["image_width"];
 $image_height = $_SESSION["image_height"];
 $quality = $_SESSION["quality"];

}


 echo '<div class="dashboard">

    <h2>Image Optimizer</h2>

  <form action="/includes/optimizer" method="post" id="optForm">
   
    <div class="setting-box">
        <div class="setting-title">
         Preserve transparency   
        </div>

        <div class="toggle-container">
            <span class="status-text green" id="showpos_text">
                ON
            </span>
            <label class="switch">
                <input type="checkbox" name="transparency" id="transparency" checked>
            <span class="slider"></span>
            </label>
        </div>

    </div>


    <div class="score-input-box">

    <label>
  Directory 
 <small id="min-score">(relative to document root):</small>
        </label>

        <input 
            type="text"
            id="directory"
            name="directory"
            placeholder="Enter Images Directory"
            value ="'.$directory.'"
            required
            >

        <label>
           Batch size:
           <small id="min-score">Maximum of 20</small>
        </label>

        <input 
            type="number"
            id="batch_size"
            name="batch_size"
            placeholder="Enter batch size"
            min="1"
            max="20"
            value ="'.$batch_size.'"
            required
        >
        
      <label>
           Maximum Image size:
           <small id="min-score">Maximum of 500KB</small>
        </label>

        <input 
            type="number"
            id="image_size"
            name="image_size"
            placeholder="Enter image size"
            min="10"
            max="500"
             value ="'.$image_size.'"
            required
        >
     
           
      <label>
           Maximum Image Width:
           <small id="min-score">Maximum of 500</small>
        </label>

        <input 
            type="number"
            id="image_width"
            name="image_width"
            placeholder="Enter image width"
            min="10"
            max="500"
           value ="'.$image_width.'"
            required
        > 
        
      <label>
           Maximum Image Height:
           <small id="min-score">Maximum of 500</small>
        </label>

        <input 
            type="number"
            id="image_height"
            name="image_height"
            placeholder="Enter image height"
            min="10"
            max="500"
           value ="'.$image_height.'"
            required
        > 

      <label>
           WebP Quality:
           <small id="min-score">Maximum of 80%</small>
        </label>

        <input 
            type="number"
            id="quality"
            name="quality"
            placeholder="Enter image quality"
            min="50"
            max="100"
            value ="'.$quality.'"
            required
        > 

  
        <button type="submit" class="save-btn" id="submit_optimize_images" name="submit_optimize_images">
            Optimize Images
        </button>
<div class="spinner" id="spinner"></div>
     <span id="prep1"></span>
    </div>

</div>';

 
 }
 else{
     
 echo '<script>
 
 window.location = "/home";
 
 </script>';
 exit();
     
 }
 

Addfooter($site); 

?>

<script>
 
const optForm = document.getElementById("optForm");

optForm.addEventListener("submit",(e)=>{
  
  const spinner = document.getElementById("spinner");
  const prep1 = document.getElementById("prep1");
  const Directory = document.getElementById("directory").value.trim();
  
  spinner.style.display="flex";
  prep1.style.display="block";
  prep1.innerHTML = `Optimizing Images in ${Directory} folder please wait..`;
  
  
  e.preventDefault();
  
  
});
    
</script>