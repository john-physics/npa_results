<?php

?>

<!-- =========================
     REMOVE POPUP
========================= -->

<div class="popup-overlay" id="removePopup">

    <div class="popup-box">

        <!-- HEADER -->

        <div class="popup-header">
            <h2>Remove Students/Subjects</h2>

            <p id="removeInstruction">
                Please select what you want to remove.
            </p>
        </div>


        <!-- BODY -->

        <div class="popup-body">

            <div class="message" id="removeMessage"></div>


            <!-- OPTIONS -->

            <div class="remove-options">

                <label class="option-box">
                    <input type="checkbox" id="removeStudentsBox">
                    Remove Students
                </label>

                <label class="option-box">
                    <input type="checkbox" id="removeSubjectsBox">
                    Remove Subjects
                </label>

            </div>


            <!-- ACTION DESCRIPTION -->

            <div class="action-description" id="actionDescription">
                Select an option above.
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
                    Remove
                </button>
            </div>

        </div>

    </div>

</div>


<div class="popup-overlay" id="addPopup">

    <div class="popup-box">

        <!-- HEADER -->

        <div class="popup-header">
            <h2>Add Students/Subjects</h2>

            <p id="addInstruction">
                Please select what you want to add.
            </p>
        </div>


        <!-- BODY -->

        <div class="popup-body">

            <div class="message" id="addMessage"></div>


            <!-- OPTIONS -->

            <div class="remove-options">

                <label class="option-box">
                    <input type="checkbox" id="addStudentsBox">
                    Add Students
                </label>

                <label class="option-box">
                    <input type="checkbox" id="addSubjectsBox">
                    Add Subjects
                </label>

            </div>


            <!-- ACTION DESCRIPTION -->

            <div class="action-description" id="addDescription">
                Select an option above.
            </div>


            <!-- LIST -->

            <div class="list-container" id="addList">

                <div class="loading">
                    Waiting for selection...
                </div>

            </div>

        </div>


        <!-- SPINNER -->

        <div class="spinner3" id="addSpinner"></div>


        <!-- FOOTER -->

        <div class="popup-footer">

            <div id="addCount">0 selected</div>

            <div class="footer-buttons">
                <button class="btn-secondary" onclick="closePopup('addPopup')">
                    Cancel
                </button>

                <button class="btn-primary add-btn" id="addNextBtn">
                    Add
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
    background:#b91c1c; /*dark red */
    background: #ec4899; /*light red */
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

const className = document.getElementById("staff-class").value;
const termSession = document.getElementById("term_session").value;


let currentAction = "";
let btnText = "";

/* =====================================
   POPUP FUNCTIONS
===================================== */

function openPopup(id){
    document.getElementById(id).classList.add("show");
}

function closePopup(id){
    document.getElementById(id).classList.remove("show");
}

function openRemovePopup(){

    openPopup("removePopup");

    document.getElementById("removeList").innerHTML = `
        <div class="loading">
            Waiting for selection...
        </div>
    `;

    document.getElementById("actionDescription").innerHTML =
        "Select an option above.";

    document.getElementById("removeCount").innerHTML =
        "0 selected";

    document.getElementById("removeStudentsBox").checked = false;
    document.getElementById("removeSubjectsBox").checked = false;

    currentAction = "";
    btnText = "Remove";
}

function openAddPopup(){

    openPopup("addPopup");

    document.getElementById("addList").innerHTML = `
        <div class="loading">
            Waiting for selection...
        </div>
    `;

    document.getElementById("addDescription").innerHTML =
        "Select an option above.";

    document.getElementById("addCount").innerHTML =
        "0 selected";

    document.getElementById("addStudentsBox").checked = false;
    document.getElementById("addSubjectsBox").checked = false;

    currentAction = "";
    btnText = "Add";
}


/* =====================================
   CHECKBOX SWITCHING
===================================== */

const removeStudentsBox = document.getElementById("removeStudentsBox");
const removeSubjectsBox = document.getElementById("removeSubjectsBox");

removeStudentsBox.addEventListener("change", () => {

    if(removeStudentsBox.checked){

        removeSubjectsBox.checked = false;

        currentAction = "remove_students";
        document.getElementById("actionDescription").innerHTML =
            `Select the students you want to remove from <b>${className}</b>.`;

        loadStudents();
    }

});


removeSubjectsBox.addEventListener("change", () => {

    if(removeSubjectsBox.checked){

        removeStudentsBox.checked = false;

        currentAction = "remove_subjects";
        document.getElementById("actionDescription").innerHTML =
            `Select the subjects you want to remove from <b>${className}</b>.`;

        loadSubjects();
    }

});


/* =====================================
   LOAD STUDENTS
===================================== */

function loadStudents(){
   
    const list = document.getElementById("removeList");

    list.innerHTML = `
        <div class="loading">
            Loading students...
        </div>
    `;

  clearMessage("removeMessage");//clear previous error messages
    fetch("/includes/set_class.inc", {

        method:"POST",

        headers:{
            "Content-Type":"application/json"
        },

        body:JSON.stringify({
            button_name:"load_remove_students",
            class_name:className
        })

    })

    .then(res => res.json())

    .then(data => {

        if(data.status == "success"){

            let html = "";

            data.students.forEach(student => {

                html += `

                    <div class="list-item">

                        <input
                            type="checkbox"
                            class="remove-checkbox"
                            id="student_${student.id}"
                            value="${student.id}">

                        <label for="student_${student.id}">
                            ${student.name}
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
   LOAD SUBJECTS
===================================== */

function loadSubjects(){

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
            button_name:"load_remove_subjects",
            class_name:className,
            term_session:termSession
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

    fetch("/includes/set_class.inc", {

        method:"POST",
        headers:{
            "Content-Type":"application/json"
        },

        body:JSON.stringify({
            button_name:currentAction,
            selected:selected,
            class_name:className
        })

    })

    .then(res => res.json())

    .then(data => {

        spinner.style.display = "none";

        btn.disabled = false;
        
        if(data.status == "success"){

            showMessage(
                "removeMessage",
                data.message,
                "success"
            );
         
         btn.innerHTML = "Reloading...";
           setTimeout(() => {
                closePopup("removePopup");
            window.location.reload();

            }, 1000);
            
        }else{
         btn.innerHTML = btnText;
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
        btn.innerHTML = btnText;

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


/* =====================================
   CHECKBOX SWITCHING FOR addSubjects & stds
===================================== */

const addStudentsBox = document.getElementById("addStudentsBox");
const addSubjectsBox = document.getElementById("addSubjectsBox");

addStudentsBox.addEventListener("change", () => {

    if(addStudentsBox.checked){

      addSubjectsBox.checked = false;

      currentAction = "save_add_students";

        document.getElementById("addDescription").innerHTML =
            `Select the students you want to add from <b>${className}</b>.`;

        loadaddStudents("load_students");
    }

});


addSubjectsBox.addEventListener("change", () => {

    if(addSubjectsBox.checked){

     addStudentsBox.checked = false;

      currentAction = "save_add_subjects";

        document.getElementById("addDescription").innerHTML =
            `Select the subjects you want to add from <b>${className}</b>.`;

        loadaddSubjects("load_subjects");
    }

});


/* =====================================
   LOAD add STUDENTS
===================================== */

function loadaddStudents(Button){

    const list = document.getElementById("addList");

    list.innerHTML = `
        <div class="loading">
            Loading students...
        </div>
    `;

   clearMessage("addMessage");
    fetch("/includes/set_class.inc", {

        method:"POST",

        headers:{
            "Content-Type":"application/json"
        },

        body:JSON.stringify({
            button_name:Button,
            class_name:className,
            term_session: termSession
        })

    })

    .then(res => res.json())
    .then(data => {

        if(data.status == "success"){

            let html = "";
            data.students.forEach(student => {

                html += `

                   <div class="list-item">

                        <input
                            type="checkbox"
                            class="add-checkbox"
                            id="student_${student.id}"
                            value="${student.id}">

                        <label for="student_${student.id}">
                            ${student.name}
                        </label>

                    </div>
                `;

            });

            list.innerHTML = html;
            addCountaddListener();

        }else{

            showMessage(
                "addMessage",
               data.message,
                "error"
            );
        }

    })

    .catch(error => {

        showMessage(
            "addMessage",
            error,
            "error"
        );

    });

}


/* =====================================
   LOAD SUBJECTS
===================================== */

function loadaddSubjects(Button){

    const list = document.getElementById("addList");

    list.innerHTML = `
        <div class="loading">
            Loading subjects...
        </div>
    `;
 
   clearMessage("addMessage");
    fetch("/includes/set_class.inc", {

        method:"POST",

        headers:{
            "Content-Type":"application/json"
        },

        body:JSON.stringify({
            button_name:Button,
            class_name:className,
            term_session: termSession
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
                            class="add-checkbox"
                            id="subject_${subject.id}"
                            value="${subject.id}">

                        <label for="subject_${subject.id}">
                            ${subject.name}
                        </label>

                    </div>
                `;

            });

            list.innerHTML = html;

            addCountaddListener();

        }else{

            showMessage(
                "addMessage",
                data.message,
                "error"
            );
        }

    })

    .catch(error => {

        showMessage(
            "addMessage",
            error,
            "error"
        );

    });

}


/* =====================================
   COUNT SELECTED ITEMS
===================================== */

function addCountaddListener(){

    document.querySelectorAll(".add-checkbox")
    .forEach(box => {

        box.addEventListener("change", updateaddCount);

    });

}

function updateaddCount(){

    const checked = document.querySelectorAll(
        ".add-checkbox:checked"
    ).length;

    document.getElementById("addCount").innerHTML =
        `${checked} selected`;
}


/* =====================================
   NEXT BUTTON
===================================== */

document.getElementById("addNextBtn")
.addEventListener("click", () => {

    const selected = [];

    document.querySelectorAll(".add-checkbox")
    .forEach(box => {

        if(box.checked){
            selected.push(box.value);
        }

    });


    if(currentAction == ""){

        showMessage(
          "addMessage",
         "Please select an option first.",
           "error"
        );

        return;
    }


    if(selected.length < 1){

        showMessage(
            "addMessage",
            "Please select at least one item.",
            "error"
        );

        return;
    }


    const btn = document.getElementById("addNextBtn");
    const spinner = document.getElementById("addSpinner");

    btn.disabled = true;
    btn.innerHTML = "Processing...";

    spinner.style.display = "flex";


    fetch("/includes/set_class.inc", {

        method:"POST",

        headers:{
            "Content-Type":"application/json"
        },

        body:JSON.stringify({
            button_name:currentAction,
            selected:selected,
            class_name:className
        })

    })

    .then(res => res.json())

    .then(data => {

        spinner.style.display = "none";

        btn.disabled = false;
       
        if(data.status == "success"){
         btn.innerHTML = "Reloading...";

            showMessage(
                "addMessage",
                data.message,
                "success"
            );

            setTimeout(() => {
                closePopup("addPopup");
           
            window.location.reload();

            }, 1000);
            
 
        }else{

      btn.innerHTML = btnText;

          showMessage(
                "addMessage",
                data.message,
                "error"
            );
        }

    })

    .catch(error => {

        spinner.style.display = "none";

        btn.disabled = false;
        btn.innerHTML =  btnText;

        showMessage(
            "addMessage",
            error,
            "error"
        );

    });

});


//close POPUP if clicked outside the popup area 

 document.addEventListener("click", (e) => {

    const overlay = e.target;

    // Close only if the background overlay itself was clicked
    if (overlay.classList.contains("popup-overlay")) {
        overlay.classList.remove("show");
    }

});

</script>

