<?php


 ?>
<style>

.subject-sheet-section,
.broadsheet-section{
    position: relative;
     top:20px;6h
    background:#fff;
    padding:20px;
    border-radius:20px;
    width: 95%;
    max-width: 800px;
    margin: auto;
    margin-bottom:20px;
    box-shadow:0 2px 10px rgba(0,0,0,0.08);
}

.sheet-topbar,
.broadsheet-header{
    display:block;
    align-items:center;
    justify-content:space-between;
    gap:10px;
    margin-bottom:10px;
    flex-wrap:wrap;
    font-size: 16px;
}

.sheet-details{
    flex:1;
    text-align:center;
}

.sheet-details h2{
    font-size:24px;
    margin-bottom:5px;
}

#subjectCounter{
    margin-top: 10px;
    display:inline-block;
    background:#2b78b7;
    color:#fff;
    padding:5px 12px;
    border-radius:20px;
    font-size:12px;
    width: 50%;
}

.nav-btn,
.download-btn{
    border:none;
    cursor:pointer;
    transition:0.3s ease;
}

.nav-btn{
    width:35px;
    height:35px;
    border-radius:50%;
    background:#2b78b7;
    color:#fff;
    font-size:14px;
    position: absolute; 
    top:50%;
}

 #prevBtn{
  
   left: 2%; 
 
}

#nextBtn{
  right: 2%; 
}

.nav-btn:hover{
    background:#1d5d90;
}


.broadsheet-footer{
 margin-top: 20px;   
  display: block;  
  width: 100%;
  overflow: auto;
  font-size: 9px;
}

.broadsheet-footer span{
 margin-left: 5px;
}
.download-btn{
    background:#28a745;
    color:#fff;
    padding: 3px 4px;
    border-radius:3px;
    font-size:8px;
}

.download-btn:hover{
    background:#218838;
}

.sheet-table-wrapper{
    overflow-x:auto;
}

.subject-sheet-table,
.broadsheet-table{
    width:100%;
    border-collapse:collapse;
    min-width:900px;
}

.broadsheet-table th,
 .broadsheet-table td {
    border:1px solid #ddd;
    padding:12px;
    text-align:center;
}

.subject-sheet-table th,
 .subject-sheet-table td{
 
     border:1px solid #ddd;
     padding:10px;
     text-align:center; 
   
 }

.subject-sheet-table th,
.broadsheet-table th{
    background:#2b78b7;
    color:#fff;
    position:sticky; 
    top:0;
}



  tr:nth-child(odd){
    background: rgba(0,0,0,0.04);
  }
 
 tr:nth-child(even){
    background:#f8f9fa;
}


.subject-sheet-table tbody tr:hover,
.broadsheet-table tbody tr:hover{
    background:#eef5fc;
}


.subject-sheet-table tbody td:nth-child(2),
.broadsheet-table tbody td:nth-child(2){
   text-align:left;
   width: 150px;
   word-break: break;
}

.subject-sheet-table tbody td:nth-child(1),
.broadsheet-table tbody td:nth-child(1){

   width: 50px;
 
}

small{
    font-size:11px;
    display:block;
    margin-top:3px;
}

.broadsheet-footer{
    position:relative;
}
.broadsheet-footer .downloading{
 position: relative;
 margin: 10px 0;
 color:rgb(100,200,100);  
 font-weight: 500;
    
}

 .droping {
     
transition: transform 0.3s ease;
animation: droping 1.1s linear infinite;
       
    }
 
   @keyframes droping {
    0% { transform: translateY(-8px); }
    100% { transform: translateY(10px); }
    }



</style>

<section class="subject-sheet-section">

    <div class="sheet-topbar">

        <button class="nav-btn" id="prevBtn">
            <i class="fa-solid fa-chevron-left"></i>
        </button>
         <button class="nav-btn" id="nextBtn">
            <i class="fa-solid fa-chevron-right"></i>
        </button>

        <div class="sheet-details">

            <h2 id="subjectTitle">
                Mathematics Performance Sheet
            </h2>

            <span id="subjectCounter">
                Subject 1 of 15
            </span>

        </div>


  <div class="sheet-table-wrapper">

   <table class="subject-sheet-table">

    <thead id="subjectTableHead"></thead>
    <tbody id="subjectTableBody"></tbody>

    </table>

    </div>
   
  <div class="broadsheet-footer">
    
 <button class="download-btn" id="scoresheet-btn" value="Maths" title="Download this score sheet" onclick="downloadScoresheet()">
 <i class="fa-solid fa-download" id="scoresheet-droping"></i>
    </button>
  <span id="subjectcompby"></span><br> 
  <span class="downloading" id="scoresheet-downloading"></span>  
 
</div>

</section>



<section class="broadsheet-section">

    <div class="broadsheet-header">

        <h2>
            Class Broadsheet
        </h2>


    </div>


    <div class="sheet-table-wrapper">

        <table class="broadsheet-table">

  <thead id="broadsheetTableHead"></thead>
   <tbody id="broadsheetTableBody"></tbody>


        </table>
    
    </div>

<div class="broadsheet-footer">
    
 <button class="download-btn" title="Download this broad sheet" onclick="downloadBroadsheet()">
 <i class="fa-solid fa-download" id="broadsheet-droping"></i>
    </button>
  <span id="broadsheetcompby"></span><br> 
  <span class="downloading" id="broadsheet-downloading"></span>   
</div>

        
</section>


<?php

  if($notpublished > 0){
 // show warning Message.  
echo '<style>

.result-warning-card{
 position:relative;
 top:20px;
   width:93%;
    max-width: 800px;
    background: #fff8e6;
    border: 1px solid #f5c542;
    border-left: 6px solid #ff9800;
    border-radius: 12px;
    padding: 20px;
    margin: 20px auto;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    font-family: Arial, sans-serif;
}

.result-warning-header{
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 15px;
}

.result-warning-icon{
    width: 50px;
    height: 50px;
    background: #ff9800;
    color: white;
    font-size: 26px;
    font-weight: bold;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.result-warning-title{
    font-size: 22px;
    font-weight: bold;
    color: #cc7000;
}

.result-warning-text{
    color: #444;
    line-height: 1.7;
    font-size: 15px;
}

.result-warning-list{
    margin-top: 10px;
    padding-left: 20px;
}

.result-warning-list li{
    margin-bottom: 8px;
}

.publish-btn{
    display: inline-block;
    margin-top: 20px;
    padding: 12px 22px;
    background: #ff9800;
    color: white;
    text-decoration: none;
    border-radius: 8px;
    font-size: 15px;
    font-weight: bold;
    transition: 0.3s ease;
}

.publish-btn:hover{
    background: #e68900;
    transform: translateY(-2px);
}
.btn-spinner{
    position:relative;
}

 .btn-spinner #spinner {
        display: none;
        border: 4px solid #f3f3f3;
        border-top: 4px solid #3498db;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        animation: spin 0.4s linear infinite;
        margin: 10px auto;
        position:absolute;
        top: 15px;
        left:60px;
        z-index:100;
    }

 
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

</style>

<div class="result-warning-card">

    <div class="result-warning-header">
        <div class="result-warning-icon">!</div>
        <div class="result-warning-title">
            Results Not Yet Published
        </div>
    </div>

    <div class="result-warning-text">

        Some compiled results are yet to be published. 
        Students and parents will not be able to view unpublished results.

        <br><br>

        One or more of the following conditions may be preventing publication:

        <ul class="result-warning-list">
            <li>Missing class teacher\'s signature</li>
            <li>Missing principal\'s signature</li>
            <li>No principal\'s or class teacher\'s comment</li>
        <li>Resumption date not set</li>
        </ul>

        Please ensure all required information is properly set, then click the button below to publish the results again.

        <br>
     <div class="btn-spinner">   
     <div id="spinner"></div>
        <a href="/includes/compile_results?done_with_uploads&std_class='.$staff_class.'&term='.$term.'&session='.$session.'" class="publish-btn">
            Publish Results Again
        </a>
    </div>
    </div>

</div>';

      
   }   
  

?>

<script>


const publishBtn = document.querySelector(".publish-btn");

publishBtn.addEventListener("click", (e) => {

const spinner = document.getElementById("spinner");
  
  spinner.style.display = "flex";

    publishBtn.disabled = true;

    setTimeout(() => {

    spinner.style.display = "none";
    publishBtn.disabled = false;

    }, 60000);

});

</script>

<script>

document.addEventListener("DOMContentLoaded",()=>{
  
 const staffClass = document.getElementById("staff_class").value;
const termSession = document.getElementById("term_session").value;

const subjectTitle = document.getElementById("subjectTitle");
const subjectCounter = document.getElementById("subjectCounter");

const prevBtn = document.getElementById("prevBtn");
const nextBtn = document.getElementById("nextBtn");

const tableHead = document.getElementById("subjectTableHead");
const tableBody = document.getElementById("subjectTableBody");


const BStableHead = document.getElementById("broadsheetTableHead");
const BStableBody = document.getElementById("broadsheetTableBody");



let subjects = [];
let currentIndex = 0;


/* LOAD CLASS SUBJECTS */

function get_class_subjects(){

    return fetch("/includes/broad_sheet.inc", {

        method:"POST",

        headers:{
            "Content-Type":"application/json"
        },

        body:JSON.stringify({
            button_name:"get_class_subjects",
            class_name:staffClass,
            term_session:termSession
        })

    })

    .then(res => res.json())

    .then(data => {

        if(data.status == "success"){

            subjects = data.subjects;

            if(subjects.length < 1){

                showError(
                    "No subjects found for this class",
                    "EMPTY SUBJECT LIST"
                );

                return;
            }

        }
        else{

            showError(data.message, data.error);

        }

    })

    .catch(error => {

        showError(error, "AJAX ERROR");

    });

}


/* UPDATE TOP UI */

function updateSubjectUI(){

    if(subjects.length < 1){
        return;
    }

    subjectTitle.innerText =
        decodeHtmlEntities(subjects[currentIndex].name) + " Performance Sheet";

    subjectCounter.innerText =
        `Subject ${currentIndex + 1} of ${subjects.length}`;

}


/*
| LOAD SUBJECT RESULTS

*/

function loadSubject(){

    if(subjects.length < 1){
        return;
    }

    tableBody.innerHTML = `
        <tr>
            <td colspan="20">Loading results...</td>
        </tr>
    `;


    fetch("/includes/broad_sheet.inc", {

        method:"POST",

        headers:{
            "Content-Type":"application/json"
        },

        body:JSON.stringify({

            button_name:"get_subject_results",

            class_name:staffClass,

            term_session:termSession,

            subject:subjects[currentIndex].id

        })

    })

    .then(response => response.json())

    .then(results => {

        if(results.status == "success"){

            renderTable(results);
   document.getElementById("scoresheet-btn").value = subjects[currentIndex].id;


        }
        else{

            showError(results.message, results.error);

        }

    })

    .catch(error => {

        showError(error, "AJAX ERROR");

    });

}


function renderTable(results){

    let headHTML = `
        <tr>

            <th>S/N</th>

            <th>Student Name</th>
    `;


    /*
     DYNAMIC CA HEADERS
    */

    results.assessment_pattern.forEach((mark, index) => {

        let caNo = index + 1;

        headHTML += `
            <th>
                CA${caNo}
                <small>(${mark})</small>
            </th>
        `;

    });


    headHTML += `

          <th>
                Exam
        <small>(${results.maxexam})</small>
            </th>

            <th>Total
          <small>(${results.maxtotal})</small>
       
            </th>

            <th>Position 
        <small>In Subject</small></th>

            <th>Grade</th>

        </tr>
    `;


    tableHead.innerHTML = headHTML;



    /*
    | TABLE BODY
 
    */

    let bodyHTML = "";

    results.rows.forEach((row, index) => {

        bodyHTML += `
            <tr>

                <td>${index + 1}</td>

                <td>${row.student}</td>
        `;


        /*  CA SCORES */
        row.cas.forEach(score => {

            bodyHTML += `
                <td>${score}</td>
            `;

        });


        bodyHTML += `

                <td>${row.exam}</td>

                <td>${row.total}</td>

                <td>${row.position}</td>

                <td>${row.grade}</td>

            </tr>
        `;

    });



    /* EMPTY RESULT */

    if(results.rows.length < 1){

        bodyHTML = `
            <tr>
                <td colspan="20">
                    No results available
                </td>
            </tr>
        `;
    }


    tableBody.innerHTML = bodyHTML;


/*compiled by */

document.getElementById("subjectcompby").innerHTML = `Compiled by: ${results.compby} • ${results.date_created}`;


}



/* NEXT SUBJECT */

nextBtn.addEventListener("click", () => {

    if(currentIndex < subjects.length - 1){

        currentIndex++;

        updateSubjectUI();

        loadSubject();

    }

});


/* PREVIOUS SUBJECT */

prevBtn.addEventListener("click", () => {

    if(currentIndex > 0){

        currentIndex--;

        updateSubjectUI();

        loadSubject();

    }

});


function loadBroadsheet(){

    if(subjects.length < 1){
        return;
    }

    BStableBody.innerHTML = `
        <tr>
            <td colspan="20">Loading broad sheet...</td>
        </tr>
    `;


    fetch("/includes/broad_sheet.inc", {

        method:"POST",

        headers:{
            "Content-Type":"application/json"
        },

        body:JSON.stringify({

            button_name:"get_broad_sheet",
            class_name:staffClass,
            term_session:termSession,
            subjects:subjects

        })

    })

    .then(res => res.json())

    .then(broadsheet => {

        if(broadsheet.status == "success"){

         renderBroadsheet(broadsheet);

        }
        else{

       showError(broadsheet.message, broadsheet.error);

        }

    })

    .catch(error => {

        showError(error, "AJAX ERROR");

    });

}


function renderBroadsheet(broadsheet){

    let BSheadHTML = `
        <tr>

            <th>S/N</th>

            <th>Student Name</th>
    `;


    /*
     DYNAMIC Subject HEADERS
    */

    broadsheet.subjectcodes.forEach((subjectcode, subIndex) => {

        BSheadHTML += `
            <th>
                ${subjectcode}
                
            </th>
        `;

    });


    BSheadHTML += `

          <th>Total Score</th>
          <th>Total Scorable</th>
          <th>Overall Average</th>

            <th>Position 
        <small>In Class</small></th>

          <th>Overall Grade</th>
         <th>General Remark</th>

        </tr>
    `;


    BStableHead.innerHTML = BSheadHTML;



    /*
    | TABLE BODY
 
    */

    let BSbodyHTML = "";

    broadsheet.sheets.forEach((sheet, index) => {

        BSbodyHTML += `
            <tr>

                <td>${index + 1}</td>

                <td>${sheet.student}</td>
        `;


        /*  subject total scores */
        sheet.scores.forEach(score => {

            BSbodyHTML += `
                <td>${score}</td>
            `;

        });


        BSbodyHTML += `

          <td>${sheet.total_score}</td>
         <td>${sheet.total_scorable}</td>

           <td>${sheet.average}</td>

               <td>${sheet.position}</td>

               <td>${sheet.grade}</td>
              
              <td>${sheet.remark}</td>

           
            </tr>
        `;

    });



    /* EMPTY RESULT */

    if(broadsheet.sheets.length < 1){

        BSbodyHTML = `
            <tr>
                <td colspan="20">
                Broadsheet not available
                </td>
            </tr>
        `;
    }


    BStableBody.innerHTML = BSbodyHTML;


/*compiled by */

document.getElementById("broadsheetcompby").innerHTML = `Compiled by: ${broadsheet.compby} • ${broadsheet.date_created}`;

}



/* INITIAL PAGE LOAD  */

get_class_subjects().then(() => {

    updateSubjectUI();

    loadSubject();
  
  loadBroadsheet(); 
   
});

});


function downloadScoresheet(){
    
const staffClass = document.getElementById("staff_class").value;
const termSession = document.getElementById("term_session").value;
const subject = document.getElementById("scoresheet-btn").value;
const scoresheetDroping = document.getElementById("scoresheet-droping");
const scoresheetdownloading = document.getElementById("scoresheet-downloading");

  scoresheetdownloading.innerHTML = "Preparing file, please wait...";
  scoresheetDroping.classList.add("droping");
 
   fetch("/includes/broad_sheet.inc", {

        method:"POST",
        headers:{
            "Content-Type":"application/json"
        },

        body:JSON.stringify({

            button_name:"download_score_sheet",
            class_name:staffClass,
            term_session:termSession,
            subject_id:subject

        })

    })

    .then(res => res.json())

    .then(download => {

        if(download.status == "success"){

      scoresheetdownloading.innerHTML = `File Prepared, downloading ${download.subjectname} scoresheet please wait...`;
   
    window.location.href = `/downloader?dwn_path=${download.file_path}&dwn_file=${download.file_name}&unlink_file=${download.unlink_file}`;
   
     setTimeout(()=>{
    
     scoresheetdownloading.innerHTML =""; 
     scoresheetDroping.classList.remove("droping");
         
     },5000); 
      
       
        }
        else{

       showError(download.message, download.error);
    scoresheetdownloading.innerHTML =""; 
    scoresheetDroping.classList.remove("droping");
        }

    })

    .catch(error => {

        showError(error, "AJAX ERROR");
    scoresheetdownloading.innerHTML =""; 
    scoresheetDroping.classList.remove("droping");
    });
    
    
    
}


function downloadBroadsheet(){
  
const staffClass = document.getElementById("staff_class").value;
const termSession = document.getElementById("term_session").value;
const broadsheetDroping = document.getElementById("broadsheet-droping");
const broadsheetdownloading = document.getElementById("broadsheet-downloading");

  broadsheetdownloading.innerHTML = "Preparing file, please wait...";
  broadsheetDroping.classList.add("droping");
 
 
   fetch("/includes/broad_sheet.inc", {

        method:"POST",
        headers:{
            "Content-Type":"application/json"
        },

        body:JSON.stringify({

            button_name:"download_broad_sheet",
            class_name:staffClass,
            term_session:termSession,
            

        })

    })

    .then(response => response.json())

    .then(broadsheet => {

      if(broadsheet.status == "success"){

       broadsheetdownloading.innerHTML = `File Prepared, downloading ${broadsheet.class_name} broadsheet please wait...`;
   
    window.location.href = `/downloader?dwn_path=${broadsheet.file_path}&dwn_file=${broadsheet.file_name}&unlink_file=${broadsheet.unlink_file}`;
   
     setTimeout(()=>{
    
     broadsheetdownloading.innerHTML =""; 
     broadsheetDroping.classList.remove("droping");
         
     },5000); 
      
       
        }
        else{

       showError(broadsheet.message, broadsheet.error);

    broadsheetdownloading.innerHTML =""; 
     broadsheetDroping.classList.remove("droping");

        }

    })

    .catch(error => {

        showError(error, "AJAX ERROR");
    broadsheetdownloading.innerHTML =""; 
     broadsheetDroping.classList.remove("droping");

    });
 
 
}




</script>
