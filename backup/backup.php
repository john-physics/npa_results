<?php

//log errors
if(!is_dir('logs')){
    mkdir('logs',0755,true);
}

ini_set('log_errors', 1);
ini_set('error_log', 'logs/backup.log'); // Adjust path if needed
ini_set('display_errors', 1); //show all errors in browser especially on live server to help track quickly. 
error_reporting(E_ALL);// Turn on error reporting Report all types of errors


require_once 'config.php';
require_once 'exporter.php';

try {

$exporter = new DatabaseExporter($conn);

$gzip = $exporter->exportDb();

//echo "export successful";
exit();


} catch (Exception $e) {

require_once 'logger.php';
$logger = new Logger($conn,"");
$logger->error($e->getMessage());
 
// echo $e->getMessage();
 exit();
  
}