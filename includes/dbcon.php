<?php

$dirname = dirname($_SERVER['DOCUMENT_ROOT']);
$configfile = $dirname.'/config/npa.config.ini';

if(file_exists($configfile)){
    
 $config = parse_ini_file($configfile,true);

$host = $config["data"]["hostname"];
$user = $config["data"]["username"];
$dbpsw = $config["data"]["dbpsw"];
$dbname = $config["data"]["dbname"];


   if($dbname){
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // Enable error exceptions 
try{
  
 $conn = mysqli_connect($host,$user,$dbpsw,$dbname);
 
}
catch(mysqli_sql_exception $err){
    
   $err -> getMessage();
   
   show_setup_Error('err2',$err);
    
    }   
}

else{
  $err = "Database name not specified"; 
    show_setup_Error('err1',$err);  
  
 }
}
else{
  $err = "Configuration file not found"; 
  show_setup_Error('err1',$err);     
}

