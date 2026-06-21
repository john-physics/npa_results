<?php

echo '<style>



body{
    background:#efefef;
   
    color:#333;
}

/* ================= TITLE ================= */

.page-title{
    text-align:center;
    margin-top:10px;
}

.page-title h1{
    font-size:40px;
    color:#005f63;
    font-weight:700;
}

.title-line{
    width:80%;
    height:14px;
    margin:auto;
    border-radius:20px;

    background:linear-gradient(
        to right,
        rgba(0,95,99,0),
        rgba(0,95,99,0.95),
        rgba(0,95,99,0)
    );
}

/* ================= FILTER CARD ================= */

.filter-card{
    width:90%;
    margin:50px auto 35px;
    background:#fff;
    border-radius:20px;
    padding:20px 30px;
    box-shadow:0 2px 10px rgba(0,0,0,0.08);
   
    
}

.filter-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(280px,1fr));
    gap:30px 40px;
}

.filter-group label{
    display:block;
    font-size:18px;
    margin-bottom:10px;
    color:#444;
}

.filter-group select{
    width:100%;
    height:50px;
    border:2px solid #d8d8d8;
    border-radius:10px;
    font-size:16px;
    padding:0 5px;
    outline:none;
    background:#fff;
    color:#333;
}

.filter-group select:focus{
    border-color:#2b78b7;
    box-shadow:0 0 0 3px rgba(43,120,183,0.1);
}

/* ================= TOTAL FOUND ================= */

.total-found{
    text-align:center;
    margin:20px 0 25px;
    font-size:14px;
    font-weight:600;
    color:#555;
     padding:0 20px;
}


/* ================= TABLE ================= */

.table-wrapper{
    display: block;
    width:100%;
    overflow:auto;
    padding: 0 1px;
    border-radius: 20px;
}

.results-table{
    width:100%;
    border-collapse:collapse;
    background:#fff;
    border-radius: 20px;
}

.results-table thead{
    background:#00bf4f;
    
}

.results-table th{
    color:#fff;
    padding:10px 8px;
    font-size:14px;
    font-weight:600;
   border:1px solid rgba(255,255,255,0.15);
    text-align:center;
      background:#00bf4f;
    
}

.results-table td{
    padding:5px 8px;
    border:1px solid #e5e5e5;
    text-align:center;
    font-size:12px;
    vertical-align:middle;
    background:#fff;
    
}

.results-table td:nth-child(3){
    
  width: 200px;  
    
}
.results-table tbody tr:hover{
    background:#fafafa;
}

.student-photo{
    width:80px;
    height:80px;
    object-fit:cover;
    border-radius: 6px;
}

.student-name{
    text-align:left;
    font-weight:600;
    line-height:1.2;
}

.na{
    color:red;
    font-weight:bold;
}

/* ================= ACTION MENU ================= */

.action-area{
    position:relative;
}

.menu-btn{
    width:50px;
    height:50px;
    border-radius:10px;
    border:2px solid #7eb4db;
    background:#fff;
    cursor:pointer;
    font-size:24px;
    color:#2c7fb7;
}

.menu-btn:hover{
    background:#f1f9ff;
}

.action-menu{
    position:absolute;
    top:0;
    right:10%; 
    background:#fff;
    border-radius:10px;
    box-shadow:0 5px 15px rgba(0,0,0,0.15);
    padding:8px;
    display:none;

    flex-direction:row;
    gap:10px;
    z-index:100;
}

.action-menu form{
    margin:0;
}

.action-menu button{
    width:40px;
    height:40px;
    border:none;
    border-radius:8px;
    cursor:pointer;
    color:#fff;
    font-size:14px;
}

.view-btn{
    background:#00a651;
}

.edit-btn{
    background:#2b78b7;
}
.delete-btn{
    background:#d9534f;
    color:#fff;
}

.view-btn:hover{
    opacity:0.9;
}

.edit-btn:hover{
    opacity:0.9;
}

.delete-btn:hover{
    opacity:0.9;
}

.filter-btn button{
  display: block; 
  position: relative;
  top:20px;
  width: 80%;
  padding: 10px;
  border:none;
  color: #fff;
 background:linear-gradient(135deg,#134e5e,#71b280);
 
margin: auto;
text-align: center;
font-size: 14px;
font-weight: bold;
margin-bottom: 15px;
border-radius: 10px;
cursor: pointer;
}

@media screen and (min-width:800px){

.total-found{
    
    font-size:18px;
}
    .page-title h1{
        font-size:42px;
    }

    .title-line{
        width:60%;
    }

    .filter-card{
        padding:35px 25px;
    }

    .filter-group label{
        font-size:20px;
    }

    .filter-group select{
        height:70px;
        font-size:22px;
    }

    .results-table th,
    .results-table td{
        font-size:18px;
    }

}

.add-remove{

 display:flex;
 flex-direction:row;
 justify-contents:center;
 align-items:center;
 gap:10px;
}
.add-remove i{
    font-size:20px;
}


</style>

';
