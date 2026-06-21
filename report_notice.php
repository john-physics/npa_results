<?php

// <!-- Message send report -->

function report_notice($report,$msg){
  
  if($report == "suc" || $report == "success"){
   //echo $report;
  // die;   
   echo '
    <div id="report" class="report">
    <span>&#10004</span> '.$msg.'<br>
    </div></section>'; 
  echo '<style>
  .report{
           display: none; /* Initially hidden */
            width: 80%;
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            border-radius: 5px;
            font-size: 16px;
            z-index: 1000;
            opacity: 1;
            transition: opacity 2s ease-out;
      font-size:14px;
  }
  .report span{
  position:relative; left:5px;
   color:white;
   padding:10px;
   border-radius:5px;
   font-size:14px;
    text-align:center;  
      
      
  }
  
  </style>';   
      
      
  }
  elseif($report =="fail" || $report == "failed"){
 
  echo '
    <div id="report" class="report">
    <span>&#10060</span> '.$msg.'<br>    </div></section>'; 
  echo '<style>
  
  .report{
           display: none; /* Initially hidden */
            width: 80%;
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            border-radius: 5px;
            font-size: 16px;
            z-index: 1000;
            opacity: 1;
            transition: opacity 2s ease-out;
      font-size:14px;
  }
  .report span{
   background:white;
   padding:5px;
   border-radius:5px;
   font-size:12px;
    text-align:center;  
      
      
  }
  
  </style>';    
      
      
  }
}
  

  



