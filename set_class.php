<?php

?>


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

#spinner, #spinner2 {
        position: absolute;
        right: 10%; bottom: 8px;
        display: none; 
        border: 4px solid #f3f3f3;
        border-top: 4px solid #3498db;
        border-radius: 50%;
        width: 35px;
        height:35px;
        animation: spin 0.4s linear infinite;
        margin: 10px auto;
    }

 
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
  
/* Overlay */

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

/* Popup */

.popup-box{
    width:95%;
    max-width:500px;
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

/* Header */

.popup-header{
    background:#2563eb;
    color:#fff;
    padding:18px;
}

.popup-header h2{
    font-size:20px;
    margin-bottom:10px;
    text-decoration: none;
}

.popup-header p{
    font-size:14px;
    line-height:1.5;
}

/* Body */

.popup-body{
    padding:18px;
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

/*pop up Footer */

.popup-footer{
    padding:14px 18px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:10px;
}

button{
    border:none;
    padding:12px 18px;
    border-radius:8px;
    cursor:pointer;
    font-weight:bold;
  
}

.btn-primary{
    background:#2563eb;
    color:#fff;
}

.btn-primary:hover{
    background:#1d4ed8;
}

.btn-secondary{
    background:#e5e7eb;
}

.message{
    margin-bottom:12px;
    padding:12px;
    border-radius:8px;
    font-size:14px;
    display:none;
    text-align: center;
}

.message.error{
    position: relative;
    background:#fee2e2;
    color:#b91c1c;
    display:block;
}

.message.success{
    position: relative; 
    top: -5px;
    background:#dcfce7;
    color:#166534;
    display:block;
}

/* Loading */

.loading{
    text-align:center;
    padding:20px;
    color:#666;
}

.close-btn{
 display: none;  
}
</style>
</head>
<body>

<!-- =======================
     POPUP 1 : STUDENTS
======================== -->

<div class="popup-overlay" id="studentPopup">

    <div class="popup-box">

        <div class="popup-header">
            <h2 id="welcomeText">Welcome Teacher!</h2>

            <p id="studentInstruction">
                Please select all students.
            </p>
        </div>

        <div class="popup-body">

            <div class="message" id="studentMessage"></div>

            <div class="list-container" id="studentList">

                <div class="loading">
                    Loading students...
                </div>

            </div>

        </div>
  <div class="spinner" id="spinner">
         </div>
        <div class="popup-footer">
      <div id="studentCount">0 selected</div>
            <button class="btn-primary" id="studentNextBtn">
                Next
            </button>
            
         <button class="close-btn" id="studentCloseBtn" onclick="backHome()">
                Close
            </button>
        </div>

    </div>

</div>



<!-- =======================
     POPUP 2 : SUBJECTS
======================== -->

<div class="popup-overlay" id="subjectPopup">

    <div class="popup-box">

        <div class="popup-header">
            <h2>Students Saved Successfully</h2>

            <p>
                Please select the subjects offered by this class.
            </p>
        </div>

        <div class="popup-body">

          <div class="message success" id="subjectFeedback">
              
                Students were saved successfully.
            </div>
          
            <div class="message" id="subjectMessage"></div>

            <div class="list-container" id="subjectList">

                <div class="loading">
                    Loading subjects...
                </div>

            </div>

        </div>
   <div class="spinner" id="spinner2">
         </div>
        <div class="popup-footer">
      <div id="subjectCount">0 selected</div>
          
            <button class="btn-primary" id="finishBtn">
                Finish
            </button>
            
         <button class="close-btn" id="closeSubjBtn" onclick="backHome()">
                Close
            </button>
        </div>

    </div>

</div>



<script>

/* ===================================
   CONFIG
=================================== */

const teacherId = document.getElementById("staff_id").value;
const teacherName = document.getElementById("staff_name").value;
const className = document.getElementById("staff_class").value;
const termSession = document.getElementById("term_session").value;

/* ===================================
   PAGE LOAD
=================================== */
//alert("term_session: "+className);
window.addEventListener("load", () => {

    document.getElementById("welcomeText").innerHTML =
        `Welcome ${teacherName}!`;

    document.getElementById("studentInstruction").innerHTML =
        `Please select all students in <b>${className}</b> for <b>${termSession}</b> from the list below.`;

    openPopup("studentPopup");

    loadStudents();

});


/* ===================================
   POPUP FUNCTIONS
=================================== */

function openPopup(id){
    document.getElementById(id).classList.add("show");
}

function closePopup(id){
    document.getElementById(id).classList.remove("show");
}


/* ===================================
   LOAD STUDENTS
=================================== */

function loadStudents(){

    const studentList = document.getElementById("studentList");

    studentList.innerHTML = `
        <div class="loading">Loading students...</div>
    `;


    fetch("/includes/set_class.inc", {
        method:"POST",
        headers:{
            "Content-Type":"application/json"
        },
        body:JSON.stringify({
            button_name:"load_students",
            class_name:className,
            term_session:termSession,
            staff_id: teacherId
            
        })
    })

    .then(res => res.json())

    .then(data => {

        /*
            EXPECTED RESPONSE

            {
                status:success,
                students:[
                    {
                        id:1,
                        name:"John Doe"
                    }
                ]
            }
        */

        if(data.status == "success"){
   clearMessage("studentMessage","error");

            if(data.students.length < 1){

                studentList.innerHTML = `
                    <div class="loading">
                        No students found.
                    </div>`;

document.getElementById("studentNextBtn").style.display = "none";

document.getElementById("studentCloseBtn").style.display = "block";

  return;
    
     }

      let html = "";

      data.students.forEach(student => {

      html += `
     <div class="list-item">

           <input 
              type="checkbox"
           id="student_${student.id}"
                        value="${student.id}"
                class="student-checkbox">

                    <label for="student_${student.id}">
                        ${student.name}
                    </label>

                </div>

                `;

            });

            studentList.innerHTML = html;

      
      document.querySelectorAll(".student-checkbox").forEach(box => {

    box.addEventListener("change", updateStudentCount);

});
      
      
        }else{

            showMessage(
                "studentMessage",
                data.message+" Reloading...",
                "error"
            );

           setTimeout(loadStudents, 2000);

        }

    })

    .catch(error => {
     const errorMsg = "Network error while loading students.";
        showMessage(
            "studentMessage",
            error+" Retrying...",
            "error"
        );

        setTimeout(loadStudents, 2000);

    });

}



/* ===================================
   SAVE STUDENTS
=================================== */

document.getElementById("studentNextBtn")
.addEventListener("click", () => {

  //  updateStudentCount();
    const checkedStudents = [];

    document.querySelectorAll(".student-checkbox")
    .forEach(box => {

        if(box.checked){
           checkedStudents.push(box.value);
        }

    });

    if(checkedStudents.length < 1){

        showMessage(
            "studentMessage",
            "Please select at least one student.",
            "error"
        );

        return;
    }


    const btn = document.getElementById("studentNextBtn");
    const spinner = document.getElementById("spinner");
    
    btn.innerHTML = "Saving...";
    btn.disabled = true;

   spinner.style.display = "flex";

    fetch("/includes/set_class.inc", {

        method:"POST",

        headers:{
            "Content-Type":"application/json"
        },

        body:JSON.stringify({
            button_name:"save_students",
            class_name:className,
            term_session:termSession,
            students:checkedStudents,
            staff_id: teacherId

        })

    })

    .then(res => res.json())

    .then(data => {

        /*
            EXPECTED RESPONSE

            {
                status:success,
                message:"Saved successfully"
            }
        */

        btn.innerHTML = "Next";
        btn.disabled = false;
       
        if(data.status == "success"){

       spinner.style.display = "none";

        clearMessage("studentMessage","error");
            closePopup("studentPopup");

            openPopup("subjectPopup");

            loadSubjects();

        }else{

            showMessage(
                "studentMessage",
                data.message || "Failed to save students. Retrying...",
                "error"
            );

            setTimeout(loadStudents, 2000);

        }

    })

    .catch(error => {

        btn.innerHTML = "Next";
        btn.disabled = false;

        showMessage(
            "studentMessage",error,
            "error"
        );

        setTimeout(loadStudents, 2000);

    });

});



/* ===================================
   LOAD SUBJECTS
=================================== */

function loadSubjects(){

    const subjectList = document.getElementById("subjectList");

    subjectList.innerHTML = `
        <div class="loading">Loading subjects...</div>
    `;

    fetch("/includes/set_class.inc", {

        method:"POST",

        headers:{
            "Content-Type":"application/json"
        },

        body:JSON.stringify({
            button_name:"load_subjects",
            class_name:className,
            term_session:termSession,
            
        })

    })

    .then(res => res.json())

    .then(data => {

        /*
            EXPECTED RESPONSE

            {
                status:success,
                subjects:[
                    {
                        id:1,
                        name:"Mathematics"
                    }
                ]
            }
        */

        if(data.status == "success"){

          clearMessage("subjectMessage","error");
  
      if(data.subjects.length < 1){

 subjectList.innerHTML = `
      <div class="loading">
           No subject found.
                </div>`;

document.getElementById("finishBtn").style.display = "none";

document.getElementById("closeSubjBtn").style.display = "block";

  return;
    
     }     
    
        
        
            let html = "";

            data.subjects.forEach(subject => {

                html += `

                <div class="list-item">

                    <input 
                        type="checkbox"
                        id="subject_${subject.id}"
                        value="${subject.id}"
                        class="subject-checkbox"
                    >

                    <label for="subject_${subject.id}">
                        ${subject.name}
                    </label>

                </div>

                `;

            });

            subjectList.innerHTML = html;

      document.querySelectorAll(".subject-checkbox").forEach(box => {
    box.addEventListener("change", updateSubjectCount);
}); 
       
        }else{

            showMessage(
                "subjectMessage",
                "Failed to load subjects. Retrying...",
                "error"
            );

            setTimeout(loadSubjects, 2000);

        }

    })

    .catch(error => {

        showMessage(
            "subjectMessage",
            "Network error while loading subjects. Retrying...",
            "error"
        );

        setTimeout(loadSubjects, 2000);

    });

}



/* ===================================
   SAVE SUBJECTS
=================================== */

document.getElementById("finishBtn")
.addEventListener("click", () => {

    const checkedSubjects = [];

    document.querySelectorAll(".subject-checkbox")
    .forEach(box => {

        if(box.checked){
            checkedSubjects.push(box.value);
        }

    });

    if(checkedSubjects.length < 1){

        showMessage(
            "subjectMessage",
            "Please select at least one subject.",
            "error"
        );

        return;
    }

    const btn = document.getElementById("finishBtn");
   const spinner2 = document.getElementById("spinner2");
    btn.innerHTML = "Saving...";
    btn.disabled = true;
    spinner2.style.display = "flex";

    fetch("/includes/set_class.inc", {

        method:"POST",

        headers:{
            "Content-Type":"application/json"
        },

        body:JSON.stringify({

            button_name:"save_subjects",
            class_name:className,
            subjects:checkedSubjects,
            staff_id:teacherId,
            term_session:termSession

        })

    })

    .then(res => res.json())

    .then(data => {

        btn.innerHTML = "Finish";
        btn.disabled = false;
      
        if(data.status == "success"){
      spinner2.style.display = "none";

            showMessage(
                "subjectMessage",
                "Subjects saved successfully. Redirecting...",
                "success"
            );
            
      setTimeout(() => {

         window.location.href = "/upload_results";

            }, 1000);

        }else{

            showMessage(
                "subjectMessage",
                data.message || "Failed to save subjects. Retrying...",
                "error"
            );
    setTimeout(loadSubjects, 2000);
        }

    })

    .catch(error => {

        btn.innerHTML = "Finish";
        btn.disabled = false;

        showMessage(
            "subjectMessage",
            "Network error while saving subjects. Retrying...",
            "error"
        );
        
      setTimeout(loadSubjects, 2000);

    });

});



/* ===================================
   MESSAGE FUNCTION
=================================== */

function showMessage(id, text, type){

const box = document.getElementById(id);

    box.className = `message ${type}`;

    box.innerHTML = text;

}

function clearMessage(id,type){
    
  const boxCont = document.getElementById(id);

    boxCont.innerHTML = "";
    boxCont.classList.remove(type);
}

function backHome(){
    
 window.location.href = "/home"; 
    
}

function updateStudentCount(){

    const count = document.querySelectorAll(".student-checkbox:checked").length;
    document.getElementById("studentCount").innerText = `${count} selected`;

}

function updateSubjectCount(){
    const count = document.querySelectorAll(".subject-checkbox:checked").length;
    document.getElementById("subjectCount").innerText = `${count} selected`;
}

</script>

