<?php

$string = $_SERVER["HTTP_REFERER"];
$location = extract_query_string($string);

if(!$location){
    $location = "/home";
}



if($_SERVER["REQUEST_METHOD"] == "POST"){
  $root = $_SERVER["DOCUMENT_ROOT"];
 require $root.'/page_init.php';
  require $root.'/functions/optimizer_functions.php';
 
  
  $staff_id = $_SESSION["staff_id"];
  $staff_cat = $_SESSION["staff_cat"];

if(!$staff_id || !$staff_cat){
    
  $_SESSION["error_msg"] ="*Please login to continue !";  
    header("Location:$location");
    die();   
    
}
else{
  
$user = get_user_name($staff_id);
$fullname =  ucwords($user["fullname"]);

 if(in_array($staff_cat,$reserved) || password_verify($fullname,$developerToken)){
if(isset($_POST["submit_optimize_images"])){
 
 $transparency = trim($_POST["transparency"]);
$directory = trim($_POST["directory"]);
$batch_size   = (int) trim($_POST["batch_size"]);
$image_size   = (int) trim($_POST["image_size"]);
$image_width  = (int) trim($_POST["image_width"]);
$image_height = (int) trim($_POST["image_height"]);
$quality  = (int) trim($_POST["quality"]);


 $_SESSION["submit_attempt"] = true;
  $_SESSION["directory"] = $directory;
 $_SESSION["batch_size"] = $batch_size;
 $_SESSION["image_size"] = $image_size;
 $_SESSION["image_width"] = $image_width;
 $_SESSION["image_height"] = $image_height;
 $_SESSION["quality"] =  $quality;
 

if ($directory === "") {

    $_SESSION["error_msg"] = "Please enter a directory to scan.";
    header("Location:$location");
    die(); 

}

if ($batch_size < 1) {

    $_SESSION["error_msg"] = "Batch size must be at least 1.";
  header("Location:$location");
    die(); 

}

if ($image_size < 1) {

    $_SESSION["error_msg"] = "Maximum image size must be greater than zero.";
   header("Location:$location");
    die(); 

}

if ($image_width < 1 || $image_height < 1) {

    $_SESSION["error_msg"] = "Please enter valid maximum image dimensions.";
   header("Location:$location");
    die(); 

}

if ($quality < 1 || $quality > 100) {

    $_SESSION["error_msg"] = "WebP quality must be between 1 and 100.";
   header("Location:$location");
    die(); 

}
 
 
 $scanPath = rtrim($_SERVER['DOCUMENT_ROOT'], "/\\") . "/" . trim($directory, "/\\");

if (!is_dir($scanPath)) {

    $_SESSION["error_msg"] = "The specified directory does not exist.";
    header("Location:$location");
    die(); 

}

//validate path 
$documentRoot = realpath($_SERVER["DOCUMENT_ROOT"]);
$scanPath  = realpath($scanPath);

if ($scanPath === false || strpos($scanPath, $documentRoot) !== 0) {

    $_SESSION["error_msg"] = "Invalid directory.";
    header("Location:$location");
    die();

} 
 
// build processing Queue 
$queue = buildQueue(
    $scanPath,
    $image_size,
    $batch_size
);


 if (empty($queue)) {

    $_SESSION["success_msg"] =
        "No images larger than {$image_size}KB found in the specified directory.";
   
    header("Location:$location");
    die();
}


$totalProcessed = 0;
$totalOptimized = 0;
$totalFailed = 0;

$totalSaved = 0;

$totalRenamed = 0;
$totalDatabaseUpdates = 0;

$errors = [];

foreach ($queue as $image) {

    $result = optimizeImage(

        $image,
        $image_width,
        $image_height,
        $quality,
        $transparency

    );

    $totalProcessed++;

    if (!$result["status"]) {
        $totalFailed++;
        $errors[] = basename($image) .
            " : " .
            $result["message"];
        continue;

    }

    if ($result["saved"] > 0) {

        $totalOptimized++;
        $totalSaved += $result["saved"];

    }

    if (!empty($result["renamed"])) {

        $totalRenamed++;

    }

    if (!empty($result["database"])) {
        $totalDatabaseUpdates++;

    }

}


$message =

"Batch completed.<br><br>" .

"Processed : {$totalProcessed}<br>" .

"Optimized : {$totalOptimized}<br>" .

"Failed : {$totalFailed}<br>" .

"Renamed : {$totalRenamed}<br>" .

"Database Updates : {$totalDatabaseUpdates}<br>" .

"Space Saved : " .

formatBytes($totalSaved);

if (!empty($errors)) {

    $message .=

    "<br><br><strong>Errors</strong><br>" .

    implode("<br>", $errors);

}

$_SESSION["success_msg"] = $message;
$msg = "Optimization completed successfully";
  header("Location: /optimize_images?msg_report=".$msg."&report=success");
    die();
 
}
else{
 
    $_SESSION["error_msg"] ="*unknown button name !";  
    header("Location:$location");
    die();    
    
  }
}
else{
 
   $_SESSION["error_msg"] ="*Unauthorized request !";  
    header("Location:$location");
    die();    
     
     
  }   
    
 }
}
else{
    $_SESSION["error_msg"] ="unknown request method";  
    header("Location:$location");
    die();
}

