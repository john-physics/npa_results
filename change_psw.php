<?php

function change_psw(){
 
 echo '<style>
/* Popup styling */
.psw-popup {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.7);
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
.popup-content h2{
    font-size:14px;
}
#close-pswbtn {
    position: absolute;
    top: 10px;
    right: 10px;
    font-size: 18px;
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

#chpsw_btn {
    width: 100%;
    padding: 10px;
    background-color: #007BFF;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
    position:relative;
    top:15px;
}

#chpsw_btn:hover {
    background-color: #0056b3;
}

/* Error styling */
.error {
    color: red;
    font-size: 12px;
    margin-top: 5px;
    display: block;
}

/* Loading spinner overlay */
.spinner-overlay {
    display: none; /* Initially hidden */
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(255, 255, 255, 0.8);
    justify-content: center;
    align-items: center;
    border-radius: 10px;
}

.spinner {
    border: 6px solid #f3f3f3;
    border-top: 6px solid #007BFF;
    border-radius: 50%;
    width: 40px;
    height: 40px;
    animation: spin 0.5s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

</style>'; 

 
   echo  '<!-- Popup change_psw Form -->
    <div id="psw-popup" class="psw-popup">
        <div class="popup-content">
            <span id="close-pswbtn">&times;</span>
            <h2>Change Password</h2>
            <form id="psw-form" method="post">
           
                <div class="input-group">
                    <label for="old_psw">Old Password</label>
                    <div class="password-container">
                        <input type="password" id="old_psw" placeholder="Enter your old password" required>
                    </div>
                <small id="old_psw_error" class="error"></small> 
                </div>
             
               <div class="input-group">
                    <label for="new_psw">New Password</label>
                    <div class="password-container">
                        <input type="password" id="new_psw" placeholder="Enter a new password" required>
                    </div>
                </div>   
             
             
                <div class="input-group">
                    <label for="con_new_psw">Password</label>
                    <div class="password-container">
                        <input type="password" id="con_new_psw" placeholder="Confirm your new password" required>
                       
                    </div>
                <small id="new_psw_error" class="error"></small> 
                </div>  
       <div class="show_psw"> 
       Show password 
         <i id="show_psw" class="fas fa-eye"></i>
            </div> 
            
              <button type="submit" id="chpsw_btn" value="staff_profile_chpsw"  onclick="submit_chpsw_form()">Submit</button><br>
            </form>
            <!-- Loading Spinner -->
       <div id="loading-spinner1" class="spinner-overlay">
            <div class="spinner"></div>
        </div> 
        </div>
    </div>';



}

