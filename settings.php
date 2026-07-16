<?php

require 'page_init.php';

if(!check_staff_login($conn)){

header("Location:/home");
exit();
}


head('Admin Control Dashboard',"$site | Admin Control Dashboard",""); //add header 
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


.spinner{
    position:absolute;
    right:50%;
    top:125px;
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


 if(in_array($staff_cat, $appointers)){
 
 $setting1 = collect_user_data($conn,"variables","type","site_lock","s");
 $site_lock = strtoupper(null_check($setting1["value"],"OFF"));
 
 $setting2 = collect_user_data($conn,"variables","type","result_lock","s");
 $result_lock = strtoupper(null_check($setting2["value"],"ON"));
 
 $setting3 = collect_user_data($conn,"variables","type","result_deletion","s");
 $result_deletion =  strtoupper(null_check($setting3["value"],"OFF"));
 
  $setting4 = collect_user_data($conn,"variables","type","red_ink","s");
 $red_ink =  strtoupper(null_check($setting4["value"],"OFF"));
 
 $setting5 = collect_user_data($conn,"variables","type","show_position_inclass","s");

 $showpos =  strtoupper(null_check($setting5["value"],"OFF"));

 $setting6 = collect_user_data($conn,"variables","type","minimum_score","s");
 
 $minscore =  null_check($setting6["value"],"0");
 
 $site_lock_color ="";
 $site_lock_checked ="";
 $result_lock_color ="";
 $result_lock_checked="";
 $delete_result_color="";
 $delete_result_checked="";
 $red_ink_color="";
 $red_ink_checked="";
 $showpos_color="";
 $showpos_checked="";
 
if($site_lock =="ON"){
    $site_lock_color = "green";
    $site_lock_checked = "checked";
}

if($result_lock =="ON"){
    $result_lock_color = "green";
    $result_lock_checked = "checked";
}

if($result_deletion =="ON"){
    $delete_result_color = "green";
    $delete_result_checked = "checked";
}

if($red_ink =="ON"){
    $red_ink_color = "green";
    $red_ink_checked = "checked";
}

if($showpos =="ON"){
    $showpos_color = "green";
    $showpos_checked = "checked";
}

 echo '<div class="dashboard">

    <h2>Central Control Dashboard</h2>

    <!-- Site Lock -->

    <div class="setting-box">

        <div class="setting-title">
            Site Lock
        </div>

        <div class="toggle-container">

            <span class="status-text '.$site_lock_color.'" id="site_lock_text">
                '.$site_lock.'
            </span>

            <label class="switch">
                <input type="checkbox" id="site_lock" '.$site_lock_checked.'>
               <span class="slider"></span>
            </label>

        </div>

    </div>';
    
 if(in_array($staff_cat,$reserved) || password_verify($fullname,$developerToken)){
  
  echo ' <!-- Result Lock -->

    <div class="setting-box">

        <div class="setting-title">
            Result Lock
        </div>

        <div class="toggle-container">

            <span class="status-text '.$result_lock_color.'" id="result_lock_text">
                '.$result_lock.'
            </span>

            <label class="switch">
                <input type="checkbox" id="result_lock" '.$result_lock_checked.'>
            <span class="slider"></span>
            </label>

        </div>

    </div>

    <!-- Allow Result Deletion -->

    <div class="setting-box">

        <div class="setting-title">
            Allow Result Deletion
        </div>

        <div class="toggle-container">

            <span class="status-text '.$delete_result_color.'" id="delete_result_text">
                '.$result_deletion.'
            </span>

            <label class="switch">
                <input type="checkbox" id="delete_result" '.$delete_result_checked.'>
                <span class="slider"></span>
            </label>

        </div>

    </div>';
    
   }
   else{
  //set some ids for js   
  
 echo '<span id="result_lock_text"></span>
  <span id="result_lock"></span>
 <span id="delete_result_text"></span> 
 <span id="delete_result"></span> ';
    
}
   echo '<!-- Show Failure Red Ink -->

    <div class="setting-box">

        <div class="setting-title">
            Show Failure With Red Ink
        </div>

        <div class="toggle-container">

            <span class="status-text '.$red_ink_color.'" id="red_ink_text">
                '.$red_ink.'
            </span>

            <label class="switch">
                <input type="checkbox" id="red_ink" '.$red_ink_checked.'>
                <span class="slider"></span>
            </label>

        </div>

    </div>

<!-- Show position in class -->

    <div class="setting-box">

        <div class="setting-title">
            Show Position in Class
        </div>

        <div class="toggle-container">

            <span class="status-text '.$showpos_color.'" id="showpos_text">
                '.$showpos.'
            </span>

            <label class="switch">
                <input type="checkbox" id="show_position_inclass" '.$showpos_checked.'>
            <span class="slider"></span>
            </label>

        </div>

    </div>



    <!-- Minimum Exam Score -->

    <div class="score-input-box">

        <label>
            Minimum Exam Total Score: <small id="min-score">'.$minscore.'</small>
        </label>

        <input 
            type="number"
            id="minimum_score"
            placeholder="Enter minimum score"
            min="0"
        >
   <div class="spinner" id="spinner"></div>
        <button class="save-btn" id="save_score">
            Save Score
        </button>

        <div class="message" id="score_message"></div>

    </div>

</div>';

 
 }
 else{
     
 echo '<script>
 
 window.location = "/home?msg_report=Access  to General settings denied !&report=failed";
 
 </script>';
 exit();
     
 }
 

Addfooter($site); 

?>

<script>

/* Handle Toggle Buttons */

const toggles = [
    {
        checkbox:"site_lock",
        text:"site_lock_text"
    },
    {
        checkbox:"result_lock",
        text:"result_lock_text"
    },
    {
        checkbox:"delete_result",
        text:"delete_result_text"
    },
    {
        checkbox:"red_ink",
        text:"red_ink_text"
    },
    {
        checkbox:"show_position_inclass",
        text:"showpos_text"
    }
];
 
toggles.forEach(item => {

    const checkbox = document.getElementById(item.checkbox);
    const text = document.getElementById(item.text);

    checkbox.addEventListener("change", function(){

        if(this.checked){

            text.innerHTML = "ON";
            text.style.color = "green";

        }else{

            text.innerHTML = "OFF";
            text.style.color = "#888";

        }

    
        fetch("/includes/set_class.inc",{
            method:"POST",
            headers:{
                "Content-Type":"application/json"
            },
            body:JSON.stringify({
               button_name: "general_settings",
                setting:item.checkbox,
                value:this.checked ? 1 : 0
            })
        })
        
 // showError(item.checkbox,"setting");   
        
        
    });

});

/* Save Minimum Score */

document.getElementById("save_score")
.addEventListener("click", function(){

    const score = document.getElementById("minimum_score").value;
    const message = document.getElementById("score_message");
  const spinner = document.getElementById("spinner");

    if(score === ""){

        message.style.color = "red";
        message.innerHTML = "Please enter minimum score";
        return;

    }

    message.innerHTML = "";
    spinner.style.display ="flex";
    fetch("/includes/set_class.inc",{
        method:"POST",
        headers:{
            "Content-Type":"application/json"
        },
        body:JSON.stringify({
           button_name:"min_result_score",
            minimum_score:score
        })
    })
     .then(res => res.json())

    .then(data => {

        spinner.style.display = "none";
           
        if(data.status == "success"){
         
        showToast(data.message);
        
 document.getElementById("min-score").innerHTML= score;
            
        }
     else{
       showError(data.message,data.error);
        }

    })

    .catch(error => {

    spinner.style.display = "none";
        
    showError(error,"Ajax Error");

    });
    

});

</script>

