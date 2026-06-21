<?php


?>

<style>
/* ==============================
   RESULT ENQUIRY SECTION
================================ */

.result-email{
    color:#07565d;
    font-weight:600;
    text-decoration:none;
}

.result-email:hover{
    text-decoration:underline;
}

.result-enquiry{
    width:95%;
    max-width:1100px; 
    margin: auto;
    margin-top:40px;
    padding:0 15px 20px;
    box-sizing:border-box;
}

.comp-section{
    background:#07565d;
    color:#fff;
    text-align:center;
    padding:16px;
    font-size:24px;
    font-weight:700;
    border-radius:4px;
    margin-bottom:20px;
}

.enquiry-text{
    text-align:center;
    color:#555;
    font-size:15px;
    line-height:1.7;
    margin-bottom:25px;
}

/* STAFF GRID */

.staff-wrapper{

width: 100%;
 display: flex;  
 align-items: center;
 justify-content: space-between;
 gap:20px;
 overflow:auto;
   scrollbar-width: none;
    -ms-overflow-style: none;
}

 .staff-wrapper::-webkit-scrollbar{
    display: none;
 
}


/* CARD */

.staff-card{
    width: 45%;
    height: 200px;
    background:#fff;
    border:1px solid #e5e5e5;
    border-radius:12px;
    padding:18px;
    display:flex;
    gap:10px;
    align-items:flex-start; 
    transition:0.3s ease;
    box-shadow:0 2px 8px rgba(0,0,0,0.05);
    flex-shrink: 0;
    overflow: auto;
  
     scrollbar-width: none;
    -ms-overflow-style: none;  
}

 .staff-card::-webkit-scrollbar{
    display: none;
 
}

.staff-card:hover{
    transform:translateY(-5px);
    box-shadow:0 10px 25px rgba(0,0,0,0.10);
}


.staff-photo img{
    width: 120px;
    height:130px;
   object-fit:cover; 
    border-radius:10px;
    border:0.5px solid #07565d;
}

.staff-details{
    flex:1;
    margin-left:30px;
}

.staff-details h3{
    margin:0;
    font-size:18px;
    color:#333;
}

.position{
    display:inline-block;
    margin:6px 0 12px;
    color:#07565d;
    font-weight:600;
    font-size:14px;
}

.staff-details p{
    margin:8px 0;
    font-size:14px;
    color:#555;
    word-break:break-word;
}

/* COMPLAINT BOX */

.complaint-box{
    margin-top:25px;
    background:#f4f9fa;
    border-left:5px solid #07565d;
    padding:18px;
    text-align:center;
    font-size:15px;
    color:#444;
    border-radius:6px;
}



.footer-btns{
    position: relative;
    top: 15px;
    left: 10px;
    display: flex;
    gap: 20px;
   
}
.download-btn{
    background:#28a745;
    color:#fff;
    padding: 3px 4px;
    border-radius:3px;
    font-size:8px;
     border:none;
    cursor:pointer;
    transition:0.3s ease;
    width: 10%; 
    height: 20px;

}

.download-btn:hover{
    background:#218838;
}


 .downloading{
 position: relative;
 right: 25%; top: 20px;
 margin: 10px 0;
 color:rgb(100,200,100);  
 font-weight: 500;
 font-size: 10px;
 font-style: italic;
    
}

 .droping {
     
transition: transform 0.3s ease;
animation: droping 1.1s linear infinite;
       
    }
 
   @keyframes droping {
    0% { transform: translateY(-8px); }
    100% { transform: translateY(10px); }
    }
    
    
.result-container{
   width: 95%; 
    max-width:1100px; 
    margin:auto;
    background:#fff;
    border:1px solid #ddd;
    border-radius:15px;
    overflow:hidden;
    margin-top: 40px;
}

/* ======================
   SCHOOL HEADER
====================== */

.school-header{
    background:#f2f2f2;
    padding:25px;
}

.school-flex{
    display:flex;
    justify-content:space-between;
    align-items:center;
}

.school-logo{
    width:80px;
    height:80px;
    border-radius: 8px;
    object-fit:contain;
}

.school-details{
    text-align:center;
}

.school-name{
    font-size:28px;
    font-weight:700;
    margin-bottom:5px;
}

.school-address{
    color:#444;
    font-size: 15px;
    padding: 5px;
}

/* ======================
   STUDENT SECTION
====================== */

.student-section{
    padding:30px;
}

.student-name{
    text-align:center;
    font-size:30px;
    font-weight:700;
    color:#444;
    margin-bottom:40px;
}

.student-flex{
    display:flex;
    gap:30px;
    align-items:flex-start;
    overflow-x: auto;
    scrollbar-width: none;
    -ms-overflow-style: none;
}

.student-flex::-webkit-scrollbar{
    display: none;
 
}

.student-photo{
    width:180px;
    height:200px; 
    border-radius:8px;
    margin-top: 25px;
    object-fit: cover;
}

.student-info table{
    border-collapse:collapse;
}

.student-info td{
    padding:10px;
    font-size:16px;
}

/* ======================
   SECTION TITLE
====================== */

.section-title{
    text-align:center;
    font-size:40px;
    font-weight:700;
    color:#444;
    margin:20px 0 10px 0;
}

/* ======================
   DETAILS TABLE
====================== */
.details-section{
  overflow-x: auto;

    /* Firefox */
    scrollbar-width: none;
    /* IE and old Edge */
    -ms-overflow-style: none;
}

/* Chrome, Safari, Opera */
.details-section::-webkit-scrollbar{
    display: none;
 
}

.details-table{
    width:100%;
    border-collapse:collapse;
    
}

.details-table td{
    border:1px solid #ddd;
   padding:12px; 
   
    
}

/* ======================
   GRADE SHEET HEADER
====================== */

.grade-header{
    background:#004c52;
    color:white;
    text-align:center;
    padding:30px;
    font-size:30px;
    font-weight:700;
    position: relative;
    left: 9px;
     border-radius:6px;
}

/* ======================
   RESULT GRID
====================== */

.result-grid{
    display:grid;
    grid-template-columns:3fr 1fr;
}

.table-scroll{
    overflow-x: auto;

    /* Firefox */
    scrollbar-width: none;

    /* IE and old Edge */
    -ms-overflow-style: none;
}

/* Chrome, Safari, Opera */
.table-scroll::-webkit-scrollbar{
    display: none;
}

/* ======================
   SUBJECT TABLE
====================== */

.subject-table{
    width:100%;
    border-collapse:collapse;
    min-width:800px;
}
.subject-table th,
.side-table th{
 /*   background: #99CCCC; */
     background: #A3D1D1;

}

.subject-table th,
.subject-table td{
    border:1px solid #ddd;
    padding:10px;
    text-align:center;
}

.subject-table td:nth-child(2),
.subject-table th:nth-child(2){
    text-align:left;
}

/* ======================
   PSYCHOMOTOR TABLE
====================== */

.side-table{
    width:100%;
    border-collapse:collapse;
}


.side-table th,
.side-table td{
    border:1px solid #ddd;
    padding:10px;
}

/* ======================
   SUMMARY
====================== */

.overview-section{
    overflow-x: auto;

    /* Firefox */
    scrollbar-width: none;

    /* IE and old Edge */
    -ms-overflow-style: none;
}

/* Chrome, Safari, Opera */
.overview-section::-webkit-scrollbar{
    display: none;
}
.summary-table{
    width:100%;
    border-collapse:collapse;
  }

.summary-table td{
    border:1px solid #ddd;
    padding:15px;
    text-align:center;
}

.quick-overview{
    
  background: #A3D1D1;
  text-align: center;  
  font-size: 20px;
  color: #fff;
   position: relative;
    left: 9px;
    
}

#nav-section{
    
    position:relative;
    padding: 25px 0;

}

#menu-toggle{
    
  position: absolute;  
  left:2%;
 
}




/* ======================
   MOBILE
====================== */

@media(max-width:768px){

.result-container{
    margin-top: 20px;
}
 .downloading{
   
   right: 35%;  
 }

  .staff-wrapper{
      flex-direction: column;
  }
    .staff-card{
      flex-direction:column; 
      align-items: center;
      align-content: center;
      width: 100%;
      height: auto;
      text-align: center;
    }

    .staff-details{
        width:100%;
    }

    .staff-photo img{
        width:100px;
        height:100px;
    }

    .section-title{
        font-size:20px;
    } 
    
.grade-header{
 position: relative;
 left: 10px;
 font-size:20px;
}

 .quick-overview{
 position: relative;
 left: 10px;
  font-size: 18px;
}  
   
    .school-flex{
      gap:15px;
    }

    .school-name{
        font-size:14.6px;
    }
    
    .school-address{
     font-size: 12px;   
        
    }
.school-logo{
    width:50px;
    height:50px;
    
}

    .student-name{
        font-size:22px;
    }

    .section-title{
        font-size:24px;
    }

    .student-flex{
     
     gap:20px; 
    }

    .result-grid{
        grid-template-columns:1fr;
    }

    .student-photo{
        width:100px;
        height: 100px;
    }

}

/* reset table general styles */

   table{
      margin:10px;
      border-top: none; 
  /*   border-bottom: 1px solid red; */
     padding:0;
       
   }
  
  tr:nth-child(even){
      background-color: #fff;
  }
  tr:nth-child(odd){
      background-color: #fff;
  }

.fa-envelope{
    
    color: #dc3545;
    color: #fd7e14;
    color: #6f42c1;
}


.print-watermark{
    display:none;
}

.print-remarks{
    display:none;
     width: 100%; 
    
}

.remarks-table{
    width: 100%;
}
  .remarks-table th{
    background: #A3D1D1;
     padding:10px;
    text-align:center;
    font-style: 700;
    font-size: 24px;
      
}
.remarks-table td{
    padding: 0;
}

 

@page {
    size: A4;
    margin: 8mm;
}

@media print {

    /* Preserve colors and backgrounds */
    *{
        -webkit-print-color-adjust: exact !important;
        print-color-adjust: exact !important;
        color-adjust: exact !important;
    }

    /* Hide unwanted sections */
    .footer-btns,
    .menu,
    .result-enquiry,
    .footer,
    .head-section,
    .errorlog,
    #menu-toggle,
    .download-btn,
    .downloading{
        display:none !important;
    }

    /* Remove page whitespace */
    html,
    body{
        margin:0 !important;
        padding:0 !important;
        background:#fff !important;
        font-size:11pt !important;
    }

    /* Main container */
    .result-container{
        width:100% !important;
        max-width:none !important;
        margin:0 !important;
        padding:0 !important;
        border:none !important;
        border-radius:0 !important;
        box-shadow:none !important;
        overflow:visible !important;
    }

    /* Compact school header */
    .school-header{
        padding:10px !important;
    }

    .school-logo{
        width:60px !important;
        height:60px !important;
    }

    .school-name{
        font-size:18pt !important;
    }

    .school-address{
        font-size:10pt !important;
    }

    /* Compact student section */
    .student-section{
        padding:10px !important;
    }

    .student-name{
        font-size:16pt !important;
        margin-bottom:15px !important;
    }

    .student-flex{
        gap:15px !important;
    }

    .student-photo{
        width:110px !important;
        height:120px !important;
        margin-top:0 !important;
    }

    .student-info td{
        padding:4px 8px !important;
        font-size:10pt !important;
    }

    /* Section titles */
    .section-title{
        font-size:18pt !important;
        margin:10px 0 !important;
    }

    /* Grade header */
    .grade-header{
        padding:10px !important;
        font-size:16pt !important;
        left:0 !important;
        margin-top:10px !important;
    }

    /* Quick overview header */
    .quick-overview{
        left:0 !important;
        font-size:14pt !important;
        padding:6px !important;
    }

    /* Remove horizontal scrolling containers */
    .table-scroll,
    .details-section,
    .overview-section{
        overflow:visible !important;
    }

    /* Stack result grid vertically for print */
    .result-grid{
        display:block !important;
    }

    /* Tables */
    table{
        width:100% !important;
        margin:0 !important;
       border-collapse:collapse !important;
    }

    .subject-table{
        width:100% !important;
        min-width:100% !important;
    }

  
   
   
     .details-table td,
      .side-table td,
    .subject-table td,
    .subject-table th,
     .side-table th,
    .summary-table td{
        padding:4px !important;
        font-size:8pt !important;
        text-align:center !important;
        vertical-align:middle !important;
    }

 .remarks-table th{
     font-size: 12pt !important;
   padding: 5px !important;
   margin-bottom: 20px !important;
 }
 .remarks-table td{
       height: 70px;
     padding: 5px !important;
      vertical-align:middle !important;

 }
 
 .quick-overview{
    margin-top: 10px !important;
    padding: 5px !important;
 }
 
    /* Center subject names too */
    .subject-table td:nth-child(2),
    .subject-table th:nth-child(2){
        text-align:justify !important;
    }

    /* Prevent rows splitting across pages */
    tr,
    td,
    th{
        page-break-inside:avoid !important;
    }

    /* Place psychomotor table below grades */
    .side-table{
        margin-top:10px !important;
    }

    /* Remove unnecessary spacing */
    .summary-table td{
        padding:5px !important;
    }
    
 
     .print-watermark{
        display:block !important;
        position:fixed;
        top:40%;
        left:20%;
        font-size:60px;
        font-weight:bold;
        opacity:0.08;
        transform:rotate(-30deg);
        pointer-events:none;
    }   
    

   .print-remarks{
        display:block !important;
        margin-top:10px;
    }
 
  .underline{
 
 text-decoration: underline dashed;
text-decoration-thickness: 2px;
text-underline-offset: 12px;

  }


 .signature-line{
   display: block !important;
    min-width: 100px !important;
    border-bottom: 2px dashed;
    position: relative !important;
    top: -5px !important;
    height: 60px !important;
     padding-bottom: 4px;
}

.remarks-cell {
    position: relative;
    padding-bottom: 0 !important;
    line-height: 1.0 !important;
}

.remarks-cell::after {
    content: "";
    position: absolute;
    left: 0;
    right: 0;
    bottom: 2px; /* adjust this */
    border-bottom: 2px dashed;
}

.rmk-cell, .remarks-cell{
    height: 40px !important; 
    
}

}


</style>



