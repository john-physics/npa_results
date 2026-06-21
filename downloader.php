<?php

require './page_init.php';

if(!isset($_SESSION["initiate-downloads"])){
    
  http_response_code(403);
    echo '<script>
    
 alert("Error: Downloads not set, please follow due clicks to download your desired files.");
 // Check if the referrer exists
if (document.referrer) {
    // Redirect back to the referrer
    window.location.href = document.referrer;
} else {
    // If no referrer is available, redirect to a default page
    window.location.href = "/home";
}
 </script>';  
   exit();
   
}


if(isset($_GET["dwn_path"])){
    
  $dwn_path = trim($_GET["dwn_path"]);
  $dwn_file = trim($_GET["dwn_file"]);
 $unlink_file = trim($_GET["unlink_file"]);
  
  if($dwn_file){
  
  $path = $_SERVER["DOCUMENT_ROOT"]."/$dwn_path/";  
  $file = $path.$dwn_file; 
   
 if(file_exists($file)){
// Check if the file exists
    // Set headers to force download
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . basename($file) . '"');
    header('Content-Length: ' . filesize($file));
    header('Pragma: public');
    header('Cache-Control: must-revalidate');
    header('Expires: 0');

    // Clear output buffer
    ob_clean();
    flush();

    // Read the file and send it to the output buffer
    readfile($file);

if($unlink_file == "true"){
  //delete the file after downloading  
    
  unlink($file);  
}

  exit();

  }
  else{
 
    http_response_code(404);
    echo '<script>
    
 alert("Error: file Not Found !");
 // Check if the referrer exists
if (document.referrer) {
    // Redirect back to the referrer
    window.location.href = document.referrer;
} else {
    // If no referrer is available, redirect to a default page
    window.location.href = "/home";
}
 </script>';  
   exit();
    
   }
  }
  else{
      
 http_response_code(404);
   echo '<script>
 alert("Error: No Downloadable file Specified !");
 
 // Check if the referrer exists
if (document.referrer) {
    // Redirect back to the referrer
    window.location.href = document.referrer;
} else {
    // If no referrer is available, redirect to a default page
    window.location.href = "/home";
}
 

 </script>';   
     
   exit();     
      
  }
 }
else{
      
 http_response_code(404);
   echo '<script>
 alert("Error: Download path not Specified !");
 
 // Check if the referrer exists
if (document.referrer) {
    // Redirect back to the referrer
    window.location.href = document.referrer;
} else {
    // If no referrer is available, redirect to a default page
    window.location.href = "/home";
}
 

 </script>';  
    
}