<?php

?>

<!-- =========================
     REMOVE POPUP
========================= -->

<div class="popup-overlay" id="removePopup">

    <div class="popup-box">

        <!-- HEADER -->

        <div class="popup-header">
            <h2>Remove/Add Subjects</h2>

            <p id="removeInstruction">
                Please select an action.
            </p>
        </div>


        <!-- BODY -->

        <div class="popup-body">

            <div class="message" id="removeMessage"></div>


            <!-- OPTIONS -->

            <div class="remove-options">

                <label class="option-box">
                    <input type="checkbox" id="addSubjectsBox">
                   Add Subjects
                </label>

                <label class="option-box">
                    <input type="checkbox" id="removeSubjectsBox">
                    Remove Subjects
                </label>

            </div>


            <!-- ACTION DESCRIPTION -->

            <div class="action-description" id="actionDescription">
                <b>Note</b>: You are adding or removing subjects against the selected student only. If you wish to add or remove subjects against the general class, return to <b>Class Results</b> and use the provided buttons on  that page. Consult the ICT Director for guidiance if you are not sure of what to do.
            </div>


            <!-- LIST -->

            <div class="list-container" id="removeList">

                <div class="loading">
                    Waiting for selection...
                </div>

            </div>

        </div>


        <!-- SPINNER -->

        <div class="spinner" id="removeSpinner"></div>


        <!-- FOOTER -->

        <div class="popup-footer">

            <div id="removeCount">0 selected</div>

            <div class="footer-buttons">
                <button class="btn-secondary" onclick="closePopup('removePopup')">
                    Cancel
                </button>

                <button class="btn-primary" id="removeNextBtn">
                    Add/Remove
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

.open-remove-btn{
    background:#dc2626;
    color:#fff;
    border:none;
    padding:12px 18px;
    border-radius:8px;
    cursor:pointer;
    font-weight:bold;
}

.open-remove-btn:hover{
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

.remove-options{
    display:flex;
    gap:12px;
    margin-bottom:15px;
}

.option-box{
    flex:1;
    border:1px solid #ddd;
    border-radius:10px;
    padding:12px;
    display:flex;
    align-items:center;
    gap:8px;
    cursor:pointer;
    transition:0.2s;
    font-size:14px;
}

.option-box:hover{
    background:#f9fafb;
}

.option-box input{
    width:16px;
    height:16px;
    cursor:pointer;
}

.action-description{
    background:#f1f5f9;
    border-radius:10px;
    padding:12px;
    font-size:14px;
    margin-bottom:15px;
    line-height:1.5;
    text-align: justify;
}

.list-container{
    max-height:300px;
    overflow-y:auto;
    border:1px solid #ddd;
    border-radius:10px;
    padding:5px;
}

.list-item{
    display:flex;
    align-items:center;
    gap:5px;
    padding:5px 8px;
    border-radius:6px;
    transition:0.2s;
    cursor:pointer;
    font-size:14px;
}

.list-item:hover{
    background:#f1f5f9;
}

.list-item input{
    width:15px;
    height:15px;
    cursor:pointer;
}

.list-item label{
    cursor:pointer;
    flex:1;
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
    display:flex;
    gap:10px;
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
    text-align: center;
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

@keyframes spin{
    0%{ transform:rotate(0deg); }
    100%{ transform:rotate(360deg); }
}   
    
</style>

<script>
    
/* =====================================
   CONFIG
===================================== */


const std_name = document.getElementById("std_name").value;
const std_id = document.getElementById("std_id").value;
const std_class = document.getElementById("std_class").value;
const term = document.getElementById("term").value;
const session = document.getElementById("session").value;

let currentAction = "";
let primaryBtn = document.getElementById("removeNextBtn");

/* =====================================
   POPUP FUNCTIONS
===================================== */

function openPopup(id){
    document.getElementById(id).classList.add("show");
}

function closePopup(id){
    document.getElementById(id).classList.remove("show");
}

function addRemoveSubjects(){

    openPopup("removePopup");

    document.getElementById("removeList").innerHTML = `
        <div class="loading">
            Waiting for selection...
        </div>
    `;

  /*  document.getElementById("actionDescription").innerHTML =
        "Select an option above.";
 */
  primaryBtn.style.background = "#ec4899";
  document.getElementById("removeCount").innerHTML =
        "0 selected";

    document.getElementById("addSubjectsBox").checked = false;
    document.getElementById("removeSubjectsBox").checked = false;

    currentAction = "";
    
}



/* =====================================
   CHECKBOX SWITCHING
===================================== */

const addSubjectsBox = document.getElementById("addSubjectsBox");
const removeSubjectsBox = document.getElementById("removeSubjectsBox");

addSubjectsBox.addEventListener("change", () => {

    if(addSubjectsBox.checked){

        removeSubjectsBox.checked = false;
        currentAction = "add_subjects";

       document.getElementById("actionDescription").innerHTML =
            `Select the subjects you want to add for <b>${std_name}</b>.`;

        loadSubjects(currentAction);
        primaryBtn.innerHTML = "Add";
        primaryBtn.style.background ="#74c69d";
    }

});


removeSubjectsBox.addEventListener("change", () => {

    if(removeSubjectsBox.checked){

        addSubjectsBox.checked = false;
        currentAction = "remove_subjects";

        document.getElementById("actionDescription").innerHTML =
            `Select the subjects you want to remove.`;

        loadSubjects(currentAction);
        primaryBtn.innerHTML = "Remove";
        primaryBtn.style.background ="#dc2626";
    }

});


/* =====================================
   LOAD Subjects
===================================== */

function loadSubjects(action){

    const list = document.getElementById("removeList");

    list.innerHTML = `
        <div class="loading">
            Loading subjects...
        </div>
    `;

clearMessage("removeMessage");//clear previous error messages
    
fetch("/includes/set_class.inc", {

        method:"POST",

        headers:{
            "Content-Type":"application/json"
        },

        body:JSON.stringify({
        button_name:"load_subjects_action",
            action_type: action,
            std_id:std_id,
            std_class:std_class,
            term:term,
            session:session
        })

    })

    .then(res => res.json())

    .then(data => {

        if(data.status == "success"){

            let html = "";

           data.subjects.forEach(subject => {

                html += `

                    <div class="list-item">

                        <input
                            type="checkbox"
                            class="remove-checkbox"
                            id="subject_${subject.id}"
                            value="${subject.id}">

                        <label for="subject_${subject.id}">
                           ${subject.name}
                        </label>

                    </div>
                `;

            });

            list.innerHTML = html;

            addCountListener();

        }else{

            showMessage(
                "removeMessage",
              data.message,
                "error"
            );
        }

    })

    .catch(error => {

        showMessage(
            "removeMessage",
            error,
            "error"
        );

    });

}


/* =====================================
   COUNT SELECTED ITEMS
===================================== */

function addCountListener(){

    document.querySelectorAll(".remove-checkbox")
    .forEach(box => {

        box.addEventListener("change", updateCount);

    });

}


function updateCount(){

    const checked = document.querySelectorAll(
        ".remove-checkbox:checked"
    ).length;

   document.getElementById("removeCount").innerHTML =
        `${checked} selected`;
}


/* =====================================
   NEXT BUTTON
===================================== */

document.getElementById("removeNextBtn")
.addEventListener("click", () => {

    const selected = [];

    document.querySelectorAll(".remove-checkbox")
    .forEach(box => {

        if(box.checked){
            selected.push(box.value);
        }

    });


    if(currentAction == ""){

        showMessage(
            "removeMessage",
            "Please select an option first.",
            "error"
        );

        return;
    }


    if(selected.length < 1){

        showMessage(
            "removeMessage",
            "Please select at least one item.",
            "error"
        );

        return;
    }


    const btn = document.getElementById("removeNextBtn");
    const spinner = document.getElementById("removeSpinner");

    btn.disabled = true;
    btn.innerHTML = "Processing...";
    spinner.style.display = "flex";

   clearMessage("removeMessage");//clear previous error messages
    fetch("/includes/set_class.inc", {

        method:"POST",

        headers:{
            "Content-Type":"application/json"
        },

        body:JSON.stringify({
            button_name:"save_action_type",
            action_type:currentAction,
            selected:selected,
            std_id:std_id,
            std_class:std_class,
            term:term,
            session:session
          
        })

    })

    .then(res => res.json())

    .then(data => {

        spinner.style.display = "none";

        btn.disabled = false;
        btn.innerHTML = "Add/Remove";

        if(data.status == "success"){

            showMessage(
                "removeMessage",
                data.message,
                "success"
            );

        setTimeout(() => {
        closePopup("removePopup");
      
    // document.getElementById("update-btn").click();
      window.location.reload();

            }, 1000);
            
        }else{

            showMessage(
                "removeMessage",
                data.message,
                "error"
            );
        }

    })

    .catch(error => {

        spinner.style.display = "none";

        btn.disabled = false;
        btn.innerHTML = "Add/Remove";

        showMessage(
            "removeMessage",
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

</script>