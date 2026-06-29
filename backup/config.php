<?php
/**
 * Backup System Configuration
 * Version 1.0
 */

date_default_timezone_set('Africa/Lagos');

/*
|--------------------------------------------------------------------------
| Backup Settings
|--------------------------------------------------------------------------
*/

define('BACKUP_VERSION', '1.0');
define('BACKUP_AUTHOR', 'John Ella');
define('BACKUP_SIGNATURE', 'NPA_DB_BACKUP');
define('ADMIN_NAME', 'John Ella');
define('ADMIN_EMAIL', 'ellaj3482@gmail.com');

/*
|--------------------------------------------------------------------------
| Backup Folder
|--------------------------------------------------------------------------
*/

define('BACKUP_DIR', __DIR__ . '/backups/');

/*
|--------------------------------------------------------------------------
| Backup File Prefix
|--------------------------------------------------------------------------
*/

define('BACKUP_PREFIX', 'database_backup_');

/*
|--------------------------------------------------------------------------
| JSON Formatting
|--------------------------------------------------------------------------
*/

define('JSON_FLAGS',
    JSON_PRETTY_PRINT |
    JSON_UNESCAPED_UNICODE |
    JSON_UNESCAPED_SLASHES
);


//$dirname = "/home/newphase/domains";
$dirname = "/storage/emulated/0";
$configfile = $dirname . '/config/npa.config.ini';

if(file_exists($configfile)){
    
$config = parse_ini_file($configfile,true);

$host = $config["data"]["hostname"];
$user = $config["data"]["username"];
$dbpsw = $config["data"]["dbpsw"];
$dbname = $config["data"]["dbname"];
$dbname = "npa_backup";

   if($dbname){
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // Enable error exceptions 
try{
  
 $conn = mysqli_connect($host,$user,$dbpsw,$dbname);
 
}
catch(mysqli_sql_exception $error){
    
   $error -> getMessage();
   
 file_put_contents(
    __DIR__ . "/error_debug.log",
    date("Y-m-d H:i:s") . " $error\n",
    FILE_APPEND
);
 
 exit();
 
    }   
}

else{
  $error = "Database name not specified"; 
   
 file_put_contents(
    __DIR__ . "/error_debug.log",
    date("Y-m-d H:i:s") . " $error\n",
    FILE_APPEND
);

exit();
  
 }
}
else{
 
  $error = "Configuration file not found"; 
 
 file_put_contents(
    __DIR__ . "/error_debug.log",
    date("Y-m-d H:i:s") . " $error\n",
    FILE_APPEND
);
 
 exit();
  
}
