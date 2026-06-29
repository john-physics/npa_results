<?php

set_time_limit(0);
ini_set('memory_limit', '-1');
ignore_user_abort(true);

$root = $_SERVER["DOCUMENT_ROOT"];
 require $root."/page_init.php";

if (!isset($_SESSION['backup_access']) ||
    $_SESSION['backup_access'] !== true) {
  
 $msg = "Unauthorized Access";
 header("Location: /home?msg_report=".$msg."&report=failed");
 die();
 
}


$sourceFolder = rtrim($_SERVER['DOCUMENT_ROOT'], "/\\") . "/images";

$zipFile = __DIR__ . "/npa_images_backup_" . date("Ymd_His") . ".zip";


if (!is_dir($sourceFolder)) {
  
  $location = $_SERVER["HTTP_REFERER"];
    $_SESSION["error_msg"]= "Images folder not found.";

  header("Location: $location");
 die();  
    
}

// Create Zip Archive

$zip = new ZipArchive();

if (
    $zip->open(
        $zipFile,
        ZipArchive::CREATE | ZipArchive::OVERWRITE
    ) !== true
) {
   
   $location = $_SERVER["HTTP_REFERER"];
    $_SESSION["error_msg"]=  "Unable to create zip archive.";

  header("Location: $location");
 die();   
    
    
}

$files = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator(
        $sourceFolder,
        RecursiveDirectoryIterator::SKIP_DOTS
    ),
    RecursiveIteratorIterator::SELF_FIRST
);

foreach ($files as $file) {

    $filePath = $file->getRealPath();

    $relativePath = substr(
        $filePath,
        strlen(dirname($sourceFolder)) + 1
    );

    if ($file->isDir()) {

        $zip->addEmptyDir($relativePath);

    } else {

        $zip->addFile(
            $filePath,
            $relativePath
        );

    }

}

$zip->close();


// Verify Zip Created

if (!file_exists($zipFile)) {
    
    $location = $_SERVER["HTTP_REFERER"];
    $_SESSION["error_msg"]= "Zip file was not created.";

  header("Location: $location");
 die();    
    
}

//download zip

if (ob_get_length()) {
    ob_end_clean();
}

header("Content-Type: application/zip");
header("Content-Description: File Transfer");
header(
    "Content-Disposition: attachment; filename=\"" .
    basename($zipFile) .
    "\""
);
header("Content-Length: " . filesize($zipFile));
header("Pragma: public");
header("Cache-Control: must-revalidate");
header('Expires: 0');

flush();

readfile($zipFile);


// delete zip from server
unlink($zipFile);

exit();