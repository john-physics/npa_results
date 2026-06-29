<?php

$root = $_SERVER["DOCUMENT_ROOT"];
require $root."/page_init.php";
require_once $root."/backup/config.php";
require_once $root."/backup/importer.php";


try {

 $filename = $_POST["backup_file"];
 $file = BACKUP_DIR.$filename;
 
   if (!is_file($file)) {

     throw new Exception("No backup file found.");

    }

    $importer = new DatabaseImporter($conn);

    $importer->importDb($file);
    
    $_SESSION["success_msg"] = "Database Restored successfully ✓";
      header("Location: /backup?backup_access");
      exit();
      

} catch (Exception $e) {

   
 $_SESSION["error_msg"] = $e->getMessage();

  header("Location: /backup?backup_access");
      exit();

}
