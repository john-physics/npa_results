<?php

function new_popup(){
 
 echo '<style>
/* Popup styling */
.logout-popup {
   display: flex;
  opacity: 0;
   visibility: hidden;
    transition: opacity 0.3s ease, transform 0.3s ease;   
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.7);
    justify-content: center;
    align-items: center;
    
}


.popup {
   display: flex; 
  
  opacity: 0;
   visibility: hidden;
    transition: opacity 0.3s ease, transform 0.3s ease;
  
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.7);
    justify-content: center;
    align-items: center;
    
}

.popup.active,
.logout-popup.active {
    opacity: 1;
    visibility: visible;
    z-index:5;
}


.popup-content {
    background: #fff;
    padding: 30px;
    border-radius: 10px;
    width: 300px;
    text-align: center;
    position: relative;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
    transform: scale(0.8);
    transition: transform 0.3s ease;
}


.popup.active .popup-content,
.logout-popup.active .popup-content {
    transform: scale(1);
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

.remember-me input{
  position:absolute; right:35%;
   margin-bottom:10px; 
    margin-right: 2px;
}

.remember-me label{
  position:relative; right:18%;
    margin-bottom:26px;
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

 
   echo  '<!-- Popup Login Form -->
    <div id="login-popup" class="popup">
        <div class="popup-content">
            <span id="close-btn">&times;</span>
            <h2>Staff Login</h2>
            <form id="login-form" method="post">
                <div class="input-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Enter your Email" required>
                <small id="email-error" class="error"></small>
                </div>
                <div class="input-group">
                    <label for="password">Password</label>
                    <div class="password-container">
                        <input type="password" id="password" placeholder="Enter your password" required>
                        <i id="toggle-password" class="fas fa-eye"></i>
                    </div>
                <small id="password-error" class="error"></small> 
                </div>
                <div class="remember-me">
                    <input type="checkbox" id="remember-me" checked>
                    <label id="rme" for="remember-me">Remember Me</label>
                </div>
                <button type="submit" id="mybtn" value="npa_staff_login">Login</button>
               <a href="forget_psw?user_cat=staff" class="forgot-password" target="_blank" title="Change your password if you forgot it">Forgot Password?</a>
            </form>
            <!-- Loading Spinner -->
       <div id="loading-spinner" class="spinner-overlay">
            <div class="spinner"></div>
        </div> 
        </div>
    </div>';


 echo  '<!-- Popup logout Form -->
    <div id="logout-popup" class="logout-popup">
        <div class="popup-content">
            <span id="close-bt">&times;</span>
            <h2>Logout</h2>
            <form id="logout-form" method="post">
               
        
                <label id="rme" for="remember-me">Are you sure you want to Logout ?</label>
             
                <button type="submit" id="logbtn" value="npa_staff_logout"  onclick="submit_logout_form()">Yes, Logout</button>
            </form>
                  <!-- Loading Spinner -->
       <div id="loading-spinner2" class="spinner-overlay">
            <div class="spinner"></div>
        </div>
        </div>
    </div>';

  
echo '<script>

const logoutPopup = document.getElementById("logout-popup");

const closeBt = document.getElementById("close-bt");

closeBt.addEventListener("click", () => {
   
   // logoutPopup.style.display = "none";
 
 logoutPopup.classList.remove("active");
 
 document.getElementById("nav-section").style.display="block"; 
  document.getElementById("dashb-section").style.display="block";
  document.getElementById("footer").style.display="block";

});

  window.addEventListener("click", (e) => {
    if (e.target === logoutPopup) {
  
    // logoutPopup.style.display = "none";
   logoutPopup.classList.remove("active");


  document.getElementById("nav-section").style.display="block"; 
  document.getElementById("dashb-section").style.display="block";
  document.getElementById("footer").style.display="block";
  
    }
}); 



function submit_logout_form(){
 
 const logoutbtn = document.getElementById("logbtn").value;
  const loadingSpinner2 = document.getElementById("loading-spinner2");

 // Show spinner
    loadingSpinner2.style.display = "flex";

fetch("/includes/logout.inc", {
    method: "POST",
    headers: {
        "Content-Type": "application/json"
    },
    body: JSON.stringify({
        submit_button_name: logoutbtn
    })
})

.then(response => {

    // Catch HTTP errors (404, 500 etc.)
    if (!response.ok) {
        throw new Error("HTTP error: " + response.status);
    }

    return response.json();
})

.then(data => {

    const status = data.stat;
    const msg = data.message;

    if(status === "success"){

        window.location = `/home?msg_report=${encodeURIComponent(msg)}&report=suc`;

    } else {

        window.location = `/home?msg_report=${encodeURIComponent(msg)}&report=failed`;

    }

    loadingSpinner2.style.display = "none";

})

.catch(error => {

    // Catch network errors / JSON errors / thrown errors
    console.error("Logout Error:", error);

    loadingSpinner2.style.display = "none";

    window.location = `/home?msg_report=Logout failed. Try again.&report=failed`;

});
   
}

</script>';



echo '<script>

document.addEventListener("DOMContentLoaded",(e)=>{
    
 // Popup show and hide functionality
const loginLink = document.getElementById("dwn_ass");
const loginPopup = document.getElementById("login-popup");

const closeBtn = document.getElementById("close-btn");

loginLink.addEventListener("click", (e) => {

 e.preventDefault();  
   
    loginPopup.classList.add("active");
    
 document.querySelector(".section").style.display="none";   
 document.querySelector(".quotes-section").style.display="none"; 
document.querySelector(".slideshow-container").style.display="none"; 
document.querySelector(".footer").style.display="none"; 
document.getElementById("nav-section").style.display="none";
 
     
});

closeBtn.addEventListener("click", () => {
    loginPopup.classList.remove("active");
    
 document.querySelector(".section").style.display="block";   
 document.querySelector(".quotes-section").style.display="block"; 
document.querySelector(".slideshow-container").style.display="flex"; 
document.querySelector(".footer").style.display="block"; 
document.getElementById("nav-section").style.display="block";
 
    
});

  window.addEventListener("click", (e) => {
    if (e.target === loginPopup) {
     loginPopup.classList.remove("active");
       document.querySelector(".section").style.display="block";   
 document.querySelector(".quotes-section").style.display="block"; 
document.querySelector(".slideshow-container").style.display="flex"; 
document.querySelector(".footer").style.display="block";
document.getElementById("nav-section").style.display="block";
 
    }
}); 


// Toggle show/hide password
const togglePassword = document.getElementById("toggle-password");
const passwordField = document.getElementById("password");

togglePassword.addEventListener("click", () => {
    if (passwordField.type === "password") {
        passwordField.type = "text";
        togglePassword.classList.remove("fa-eye");
        togglePassword.classList.add("fa-eye-slash");
    } else {
        passwordField.type = "password";
        togglePassword.classList.remove("fa-eye-slash");
        togglePassword.classList.add("fa-eye");
    }
});

// Attach event listener once page loads
document.getElementById("login-form").addEventListener("submit", submit_login_form);

function submit_login_form(e) {

    e.preventDefault();

    const loginForm = document.getElementById("login-form");
    const loadingSpinner = document.getElementById("loading-spinner");

    const emailField = document.getElementById("email").value.trim();
    const passwordField = document.getElementById("password").value.trim();
    const remember = document.getElementById("remember-me").checked;

    const btn_name = document.getElementById("mybtn").value;

    const emailError = document.getElementById("email-error");
    const passwordError = document.getElementById("password-error");

    // Clear previous errors
    emailError.innerText = "";
    passwordError.innerText = "";

    // Show spinner
    loadingSpinner.style.display = "flex";

    fetch("/includes/login.inc", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({
            submit_button_name: btn_name,
            user_email: emailField,
            user_psw: passwordField,
            rememberme: remember
        })
    })
    .then(response => response.json())
    .then(data => {

        const stat = data.stat;
        const err = data.err;
        const msg = data.message;

        if (stat === "success") {

            window.location = `/home?msg_report=${msg}&report=suc`;

        } else {

            if (err === "em") {

                emailError.innerText = msg;

            } 
            else if (err === "psw") {

                passwordError.innerText = msg;

            } 
            else {

                passwordError.innerText = "Unknown Error, Please try again!";
            }
        }

        loadingSpinner.style.display = "none";

    })
    .catch(error => {

        loadingSpinner.style.display = "none";
     //   passwordError.innerText = "Network error. Please check your connection.";
     passwordError.innerText = error;

        console.error(error);

    });
}

 


});





</script>'; 


}

