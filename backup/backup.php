<?php

require_once 'config.php';
require_once 'exporter.php';

try {

$exporter = new DatabaseExporter($conn);

$gzip = $exporter->exportDb();

echo "export successfull";
exit();


} catch (Exception $e) {

require_once 'logger.php';
$logger = new Logger($conn);
$logger->error($e->getMessage());
 
 exit();
  
}