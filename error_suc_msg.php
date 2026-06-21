<?php

 function error_suc_msg($ses,$class){
     
   if(isset($_SESSION[$ses])){
     
  $msg = $_SESSION[$ses];
echo '<p class="'.$class.'">'.$msg.'</p>';
 unset($_SESSION[$ses]);
  
  echo '<style>

.new_success{
position:relative
 top:20px;
 text-align: justify; 
 padding:10px;
 font-size:12px;
 border: 1px solid #fff;
 border-radius:10px;
 background:#007BFF;
 color:white;
 display:block;
 left:0;
 width:90%;
 margin:20px auto;

}
.new_errors{
position:relative;
 top:20px;
 text-align: justify; 
 padding:10px;
 font-size:12px;
 border: 1px solid #fff;
 border-radius:10px;
 background:red;
 color:white;
 display:block;
 left:0;
 width:90%;
 margin:auto;

}
</style>';  


if(strlen($msg) <= 50){
    
   echo '<style>
  .new_errors,.new_success{
  
  text-align:center;
  
  }
   
   </style>';
    
    }
  }
 }

 //check for errors msg
  $ses = "error_msg";
  $class = "new_errors";
  
  error_suc_msg($ses,$class);
 
 //check for success msg 
  $ses = "success_msg";
  $class = "new_success";
  
  error_suc_msg($ses,$class);
 
 
