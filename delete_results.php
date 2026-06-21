<?php

?>

<!-- Popup Modal -->
<div id="deleteModal" class="delete-modal">
    
    <div class="delete-modal-content">
        
        <h3>Delete Result</h3>
        
        <p>
            Are you sure you want to delete this student's result?
            <br>
            This action cannot be undone.
        </p>

       <div class="spinner2" id="deleteSpinner2"></div>
        <div class="delete-modal-actions">
            
            <button type="button" id="cancelDelete" class="cancel-btn">
                Cancel
            </button>

            <button type="button" id="confirmDelete" class="confirm-btn">
                Continue
            </button>

        </div>

    </div>

</div>

<!-- =========================
     REMOVE POPUP
========================= -->

<div class="popup-overlay" id="deletePopup">

    <div class="popup-box">

        <!-- HEADER -->

        <div class="popup-header">
            <h2>Delete All Results</h2>

   <p id="deleteInstruction">
     <i class="fa-solid fa-exclamation-triangle"></i>
      Warning: You are about to delete All Results for <?php echo $termSession; ?>.
      All data will be lost without any recovery. are you sure you want to proceed ?
            </p>
        </div>


        <!-- BODY -->

        <div class="popup-body">

            <div class="message" id="deleteMessage"></div>

            <!-- OPTIONS -->

        <div class="delete-reason">
        <input type="text" id="delete-reason" placeholder="Enter Reasons here">
          <input type="password" id="staff-psw" placeholder="Enter your password">
         <i id="toggle-password" class="fa-solid fa-eye"></i>
            </div>

            <!-- ACTION DESCRIPTION -->
            <div class="action-description" id="actionDescription">
                Please tell us briefly why you want to delete All Results.
            </div>

        </div>


        <!-- SPINNER -->
        <div class="spinner" id="deleteSpinner"></div>

        <!-- FOOTER -->
        <div class="popup-footer">
          <div class="footer-buttons">
                <button class="btn-secondary" onclick="closePopup('deletePopup')">
                    Cancel
                </button>
                <button class="btn-primary" id="deleteNextBtn">
                  Yes, Delete
                </button>
            </div>
        </div>

    </div>

</div>
<style>
    
 *{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial, sans-serif;
}

body{
    background:#f3f4f6;
}

.fa-exclamation-triangle{
    color: #f59e0b;
    font-size: 20px;
}
.open-delete-btn{
    background:#dc2626;
    color:#fff;
    border:none;
    padding:12px 18px;
    border-radius:8px;
    cursor:pointer;
    font-weight:bold;
}

.open-delete-btn:hover{
    background:#b91c1c;
}

/* =========================
   OVERLAY
========================= */

.popup-overlay{
    position:fixed;
    top:0;
    left:0;
    width:100%;
    height:100%;
    background:rgba(0,0,0,0.55);
    display:flex;
    justify-content:center;
    align-items:center;
    opacity:0;
    visibility:hidden;
    transition:0.35s ease;
    z-index:9999;
}

.popup-overlay.show{
    opacity:1;
    visibility:visible;
}

/* =========================
   POPUP BOX
========================= */

.popup-box{
    width:95%;
    max-width:520px;
    background:#fff;
    border-radius:16px;
    overflow:hidden;
    transform:translateY(40px) scale(0.9);
    transition:0.35s ease;
    box-shadow:0 10px 30px rgba(0,0,0,0.2);
}

.popup-overlay.show .popup-box{
    transform:translateY(0) scale(1);
}

/* =========================
   HEADER
========================= */

.popup-header{
  /*  background:#dc2626; */
     background:#2563eb;
    color:#fff;
    padding:18px;
}

.popup-header h2{
    font-size:20px;
    margin-bottom:10px;
}

.popup-header p{
    font-size:14px;
    line-height:1.5;
    text-align: center;
}

/* =========================
   BODY
========================= */

.popup-body{
    padding:18px;
}

.delete-reason{
    display:flex;
    gap:12px;
    margin-bottom:15px;
    position: relative;
}

.delete-reason input{
    width:50%;
    height:50px;
   padding: 10px; 
   border-radius: 10px;
   outline: none;
   border: 1px solid #ddd;
}

.delete-reason input:focus{
    
  border: 1px solid rgb(100,100,200);  
    
}
.delete-reason i{
   position: absolute;
   right: 1%;
    top: 20px;
    cursor: pointer;
}
.action-description{
    background:#f1f5f9;
    border-radius:10px;
    padding:12px;
    font-size:14px;
    margin-bottom:15px;
    line-height:1.5;
}


/* =========================
   FOOTER
========================= */

.popup-footer{
    padding:14px 18px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:10px;
}

.footer-buttons{
    width: 100%;
    display:flex;
    gap:100px;
    justify-content: center;
    align-items: center;
}

.popup-footer button{
    border:none;
    padding:12px 18px;
    border-radius:8px;
    cursor:pointer;
    font-weight:bold;
}

.btn-primary{
    background:#dc2626;
    color:#fff;
}

.btn-primary:hover{
    background:#b91c1c;
    
    background: #ec4899;
}

.btn-secondary{
    background:#e5e7eb;
}

.add-btn{
    
  background:rgb(100,150,250);
  
}


/* =========================
   MESSAGE
========================= */

.message{
    margin-bottom:12px;
    padding:12px;
    border-radius:8px;
    font-size:14px;
    display:none;
}

.message.error{
    background:#fee2e2;
    color:#b91c1c;
    display:block;
}

.message.success{
    background:#dcfce7;
    color:#166534;
    display:block;
}

/* =========================
   LOADING
========================= */

.loading{
    text-align:center;
    padding:20px;
    color:#666;
}

/* =========================
   SPINNER
========================= */

.spinner{
    position:absolute;
    right:10%;
    bottom:8px;
    display:none;
    border:4px solid #f3f3f3;
    border-top:4px solid #dc2626;
    border-radius:50%;
    width:35px;
    height:35px;
    animation:spin 0.4s linear infinite;
    margin:10px auto;
}

.spinner2{
    position:absolute;
    right:30%;
    
    display:none;
    border:4px solid #f3f3f3;
    border-top:4px solid #dc2626;
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
  

/* Modal Background */
.delete-modal{
    position:fixed;
    top:0;
    left:0;
    width:100%;
    height:100%;
    background:rgba(0,0,0,0.5);
    
    display:none;
    
    justify-content:center;
    align-items:center;
    
    z-index:9999;
}

/* Modal Box */
.delete-modal-content{
    background:#fff;
    width:90%;
    max-width:600px;
    
    padding:20px;
    border-radius:10px;
    
    text-align:center;
    
    animation:popup .2s ease;
}

/* Animation */
@keyframes popup{
    from{
        transform:scale(0.8);
        opacity:0;
    }
    
    to{
        transform:scale(1);
        opacity:1;
    }
}

/* Buttons */
.delete-modal-actions{
    margin-top:20px;
    
    display:flex;
    justify-content:center;
    gap:20%;
}

.cancel-btn,
.confirm-btn{
    border:none;
    padding:10px 18px;
    border-radius:5px;
    cursor:pointer;
}

.cancel-btn{
    background:#ccc;
}

.confirm-btn{
    background:#d9534f;
    color:#fff;
}
.delete-modal-content h3{
    color:#2b78b7;
    
    margin-bottom:10px;
    
    font-size:22px;
    
    font-weight:600;
}

</style>
<script>
    
/* =====================================
   CONFIG
===================================== */

const termSession = document.getElementById("term-session").value;
let currentAction = "";

/* =====================================
   POPUP FUNCTIONS
===================================== */

function openPopup(id){
 document.getElementById(id).classList.add("show");
}

function closePopup(id){
  document.getElementById(id).classList.remove("show");
}

function openDeletePopup(){

    openPopup("deletePopup");
    currentAction = "";
}

/* =====================================
   NEXT BUTTON
===================================== */

document.getElementById("deleteNextBtn")
.addEventListener("click", () => {

    const deleteReason = document.getElementById("delete-reason").value.trim();
  const staffPsw = document.getElementById("staff-psw").value.trim();
    

    if(!deleteReason){

        showMessage(
            "deleteMessage",
            "Please Enter the Reasons for this action.",
            "error"
        );

        return;
    }
    
 const cleanReason = deleteReason.trim().replace(/\s+/g, " ");
const wordCount = cleanReason.split(" ").filter(word => word.length > 0).length;

if (wordCount < 3) {

    showMessage(
        "deleteMessage",
        "Please enter a valid reason (at least 3 words).",
        "error"
    );

    return;
}   

  if(!staffPsw){
    
       showMessage(
            "deleteMessage",
            "Please Enter your login password to authorize this action.",
            "error"
        );

        return;
    }


    const btn = document.getElementById("deleteNextBtn");
    const spinner = document.getElementById("deleteSpinner");

    btn.disabled = true;
    btn.innerHTML = "Processing...";
    spinner.style.display = "flex";
    fetch("/includes/set_class.inc", {

        method:"POST",
        headers:{
            "Content-Type":"application/json"
        },

        body:JSON.stringify({
            button_name:"delete_all_results",
            term_session:termSession,
            delete_reason: deleteReason,
            staff_psw:staffPsw
        })

    })

    .then(res => res.json())

    .then(data => {

        spinner.style.display = "none";
        btn.disabled = false;
        btn.innerHTML = "Yes, Delete";

        if(data.status == "success"){
            showMessage(
                "deleteMessage",
                data.message,
                "success"
            );

            setTimeout(() => {
                closePopup("deletePopup");
            window.location.reload();

            }, 1000);
            
        }else{

            showMessage(
                "deleteMessage",
                data.message,
                "error"
            );
        }

    })

    .catch(error => {

        spinner.style.display = "none";
        btn.disabled = false;
        btn.innerHTML = "Yes, Delete";

        showMessage(
            "deleteMessage",
            error,
            "error"
        );

    });

});


/* =====================================
   MESSAGE FUNCTIONS
===================================== */

function showMessage(id, text, type){

  const box = document.getElementById(id);

    box.className = `message ${type}`;

    box.innerHTML = text;
}


function clearMessage(id){

  const box = document.getElementById(id);
    box.className = "message";

    box.innerHTML = "";
}


//close POPUP if clicked outside the popup area 

 document.addEventListener("click", (e) => {

    const overlay = e.target;
    // Close only if the background overlay itself was clicked
    if (overlay.classList.contains("popup-overlay")) {
        overlay.classList.remove("show");
    }

});


// Toggle show/hide password
const togglePassword = document.getElementById("toggle-password");
const passwordField = document.getElementById("staff-psw");

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

</script>

