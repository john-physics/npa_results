<?php

$root = $_SERVER["DOCUMENT_ROOT"];
 require $root."/page_init.php";
require_once $root."/backup/config.php";

/**
 * Get information about the latest backup.
 *
 * @return array|null
 */
function getBackupInfo(): ?array
{
    $files = glob(BACKUP_DIR . BACKUP_PREFIX . '*.json.gz');

    if (empty($files)) {
       return [
    'valid' => false,
    'reason' => "No backup file found"

];
        
    }

    usort($files, function ($a, $b) {
        return filemtime($b) <=> filemtime($a);
    });

    $file = $files[0];

    $handle = gzopen($file, 'rb');

    if (!$handle) {
             return [
    'valid' => false,
    'reason' => "Unble to open backup file"

];
    
    }

    $json = '';

    while (!gzeof($handle)) {

        $json .= gzread($handle, 8192);

    }

    gzclose($handle);

    $backup = json_decode($json, true);

    if (!is_array($backup)) {
       return [
    'valid' => false,
    'reason' => "Unble to decode backup file"

];
        
    }

  $required = [
    'version',
    'author',
    'signature',
    'created_at',
    'database',
    'php_version',
    'mysql_version',
    'tables'
];

foreach ($required as $key) {

    if (!array_key_exists($key, $backup)) {
     return [
    'valid' => false,
    'reason' => "Missing required field: $key"

];
    }

} 


    return [
        'valid' => true,
        'path' => $file,
        'name' => basename($file),
        'size' => filesize($file),
        'version' => $backup['version'] ?? '',
        'author' => $backup['author'] ?? '',
        'signature' => $backup['signature'] ?? '',
        'database' => $backup['database'] ?? '',
        'created_at' => $backup['created_at'] ?? '',
        'php_version' => $backup['php_version'] ?? '',
        'mysql_version' => $backup['mysql_version'] ?? ''

    ];
}


if ($_SERVER["REQUEST_METHOD"] === "POST") {

 $token=trim($_POST["access_token"] ?? "");

  if(!$token){
   
    $error = "Please enter access token.";
     $_SESSION["error_msg"] = $error;
    header("Location: /backup?backup_access");
        exit();  
      
  }

  if ($token === $BackupToken) {

     $_SESSION["backup_access"] = true;
   $time = time()+3600;
   setcookie("backup_access",1,$time,"/");
   
     $msg = "Token Verified";
        header("Location: /backup?backup_access_verified&report=success&msg_report=".$msg);
        exit();

    } else {

    $error = "Invalid access token.";
     $_SESSION["error_msg"] = $error;
    header("Location: /backup?backup_access");
        exit();

    }

}


head('Database Backup Utility',"$site | Database Backup Utility","Backup Database");

require $root.'/menu.php';

// <!-- Message send report -->
 if(isset($_GET["msg_report"])){
 
   $msg = $_GET["msg_report"];
   $report = $_GET["report"];
   
   report_notice($report,$msg); 
   
  echo '<script src="/scripts/report_notice.js"></script>';
     
 }
  
 require $root.'/error_suc_msg.php'; // detect and display error Messages if any
 require $root.'/custom_alert.php'; 


echo '
<style>

.back_container{

    width:100%;
    max-width:450px;
    margin:20px auto;
    background:#fff;
    padding:20px;
    border-radius:10px;
    box-shadow:0 0 15px rgba(0,0,0,.08);
  
}

.back_container h2{
    text-align:center;
    margin-bottom:25px;
    color:#333;

}

.back_container input{

    width:100%;

    padding:12px;

    border:1px solid #ccc;

    border-radius:5px;

    margin-bottom:15px;

    font-size:15px;

}

.back_container button, .section button{

    width:100%;
    padding:12px;
    border:none;
    background:#0066cc;
    color:#fff;
    font-size:15px;
    border-radius:5px;
    cursor:pointer;

}

.back_container button:hover{
    background:#004fa3;
}
.section button:hover{
    
  background:#004fa3;   
}
#toggle-password{
    
  float:right; 
  position:relative;
  top:-40px;
  left:-10px;
    
}

#backup_error{
    text-align:center;
    color:#c62828;

}

.section{
    position:relative;
}

 .profile-container {
  max-width: 700px; 
  margin: 40px auto;
  padding: 25px 30px;
  font-family: "Poppins", sans-serif;
  background: #fff;
  border-left: 4px solid #004aad;
  border-radius: 10px;
  box-shadow: 0 2px 6px rgba(0,0,0,0.05);
}

.profile-top {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  margin-bottom: 25px;
}

.profile-top h2 {
  color: #003366;
  font-size: 1.4rem;
  margin: 0;
  color: rgb(50,200,150); 
}

.sub-note {
  color: #777;
  font-size: 0.9rem;
  margin-top: 4px;
  font-style:italic;
}


.profile-info {
  border-top: 1px solid #e5e9f2;
  border-bottom: 1px solid #e5e9f2;
  padding: 8px 0;
}

.info-row {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 14px 0;
  border-bottom: 1px solid #f1f4fa;
  transition: all 0.25s ease;
}
.info-row:last-child {
  border-bottom: none;
}

.info-row:hover {
  background: #f8faff;
  padding-left: 10px;
}

label {
  font-weight: bold; /* made bold */
  color: #333;
  font-size: 18px;
}

.info-row span {
  color: #111;
  font-size: 0.95rem;
  font-weight: 500;
  text-align: right;
  word-break: break-word;
}

.profile-footer {
  margin-top: 25px;
  text-align: right;
}

.change-link {
  color: #004aad;
  text-decoration: none;
  font-weight: 600;
  transition: color 0.2s ease;
  cursor:pointer;
}
.change-link:hover {
  color: #00348a;
  text-decoration: underline;
}


@media (max-width: 480px) {
  .profile-container{
    max-width:330px;  
  }

  .info-row span {
    margin-top: 3px;
  font-size: 0.90rem;
  }
 
 label {
  font-size: 16px;
}

}

.profile-container h2{
display:block;
    position:absolute;
    font-size: 1.4rem;
    text-align:center;
   
}

  #prep{
     display: none;
     text-align:center;
     color:rgb(50,200,50);
     font-size:10px;
     position:relative;
     top:1px;
     font-weight:bold;
 }
 
#spinner {
        display: none;
        border: 4px solid #f3f3f3;
        border-top: 4px solid #3498db;
        border-radius: 50%;
        width: 30px;
        height: 30px;
      animation: spin 0.5s linear infinite;
        margin: 20px auto;
    }
    
     #prep2{
     display: none;
     text-align:center;
     color:rgb(50,200,50);
     font-size:10px;
     position:absolute;
     top:30px;
     left:20%;
     font-weight:bold;
 }
    #spinner2 {
        display: none;
        border: 4px solid #f3f3f3;
        border-top: 4px solid #3498db;
        border-radius: 50%;
        width: 28px;
        height:28px;
      animation: spin 0.5s linear infinite;
      position:absolute;
        margin-bottom:20px;
       top:30px;
       left:40%;
       z-index:100;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    
 .backup_images{
  
  position:relative;
  top:10px;
  display:flex;
  align-items:center;
  justify-content:center;
  width:100%;
  margin:auto;
  
 }

 .backup_images a{
  text-align:center;
  text-decoration:none;
  background:rgba(200,150,100,0.7);
  color:#fff;
  cursor:pointer;
  border-radius:3px;
  padding:5px;
  display:block;
  width:40%;
  font-size:12px;
  position:relative;
  top:-20px;
  margin:10px auto;
 }
 
 .backup_images a:hover{
  
  background:rgba(150,200,150,0.8);
   
 }
 
 @media screen and (min-width:800px){
     
 .backup_images a{
   width:25%;
  }
  
 #spinner2{
  left:45%;
 }
 
 #prep2{
  left:40%;
 
   }
 
 }
 
</style>';

echo '<section class="section">';

if(isset($_GET["backup_access_verified"]) && isset($_SESSION["backup_access"])){
    
$backup = getBackupInfo();

if ($backup['valid'] === true){
  
 if($backup['signature'] === BACKUP_SIGNATURE){
  
  echo '<div id="profile_section" class="profile-container">
  <div class="profile-top">
    <div>
 <!--    <h2>Database Backup Utility</h2></h2> -->
      <p class="sub-note">View and Restore Database Backup</p>
    </div>
  </div>

  <div class="profile-info">
       <div class="info-row">
      <label>Backup File</label>
      <span>Available</span>
    </div>
    <div class="info-row">
      <label>Database</label>
      <span>'.htmlspecialchars($backup["database"]).'</span>
    </div>
    <div class="info-row">
      <label>Backup Version</label>
      <span>'. htmlspecialchars($backup['version']) .'</span>
    </div>
    <div class="info-row">
      <label>Required PHP</label>
     <span>'.htmlspecialchars($backup['php_version']) .'</span>
    </div>
    <div class="info-row">
      <label>Required MySQL</label>
      <span>'. htmlspecialchars($backup['mysql_version']).'</span>
    </div>
    <div class="info-row">
      <label>Time Created</label>
     <span>'.$backup["created_at"].'</span>
    </div>
    
 <div class="info-row">
      <label>Size</label>
    <span>'.round($backup["size"]/1024,2).' KB</span>
    </div>
  </div>

<form action="/backup/restore" method="post" id="regForm">
<input type="hidden" name="backup_file" value="'.$backup["name"].'">
<button>
Restore Backup
</button>
<div id="spinner"></div>
<span id="prep">Restoring Database, please wait...</span>
</form></div>';
     
 }  
    
 else{
     
  echo '
   <div class="back_container">
<h2>Database Backup Utility</h2>
  <p id="backup_error">
Invalid Backup Signature.
</p></div>'; 
     
 }   
    
}
 else{

   echo '
   <div class="back_container">
<h2>Database Backup Utility</h2>
<p id="backup_error">
 '.$backup["reason"].'
</p></div>'; 
     
 }
 
 echo '<div class="backup_images">
 <a href="backup_images" id="backup-images-btn">Backup Images</a> 
  <a href="backup" id="backup-database-btn">Backup Database</a> 
 <div id="spinner2"></div>
<span id="prep2">Preparing backup, please wait...</span>
 </div>';
 
}

elseif(isset($_GET["backup_access"])){
    
 echo '<div class="back_container">
<h2>Database Backup Utility</h2>
 <form method="post" id="regForm">
<input
type="password"
name="access_token"
id="access_token"
placeholder="Enter Access Token"
required
autocomplete="off">
<i id="toggle-password" class="fa-solid fa-eye"></i>
<button type="submit">
Verify Access
</button>
<div id="spinner"></div>
<span id="prep">Validating token, please wait...</span>
</form>
</div>';
 
}
else{
    
 // redirect to home page   
    
 echo '<script>
 window.location.href = "/404.shtml";
 
 </script>';
 exit();
   
    
}

echo '</section>';
Addfooter($site);

?>

<script>
 
 const backup = document.getElementById("backup-images-btn");
 backup.addEventListener("click",(e)=>{
 
// e.preventDefault();
  const spinner2 = document.getElementById("spinner2");
  const prep2 = document.getElementById("prep2");
  
 spinner2.style.display ="flex";
 prep2.style.display = "block";
 
 setTimeout(()=>{
  
 spinner2.style.display ="none";
 prep2.style.display = "none";
     
 },10000);
 
 });
 
 
 const database = document.getElementById("backup-database-btn");
 database.addEventListener("click",(e)=>{
 
// e.preventDefault();
  const spinner2 = document.getElementById("spinner2");
  const prep2 = document.getElementById("prep2");
  
 spinner2.style.display ="flex";
 prep2.style.display = "block";
 
 setTimeout(()=>{
  
 spinner2.style.display ="none";
 prep2.style.display = "none";
     
 },10000);
 
 });
 
</script>


<script>
 
 const form = document.getElementById("regForm");
 form.addEventListener("submit",(e)=>{
  
  const spinner = document.getElementById("spinner");
  const prep = document.getElementById("prep");
  
 spinner.style.display ="flex";
 prep.style.display = "block";
 
 
 setTimeout(()=>{
  
 spinner.style.display ="none";
 prep.style.display = "none";
     
 },20000);
 
 });
 
    
</script>
<script>

// Toggle show/hide password
const togglePassword = document.getElementById("toggle-password");
const passwordField = document.getElementById("access_token");

togglePassword.addEventListener("click", () => {
    if (passwordField.type === "password") {
        passwordField.type = "text";
        togglePassword.classList.remove("fa-eye");
        togglePassword.classList.add("fa-eye-slash");
    } else {
        passwordField.type = "password";
        togglePassword.classList.remove("fa-eye-slash");
        togglePassword.classList.add("fa-eye");
    }
});   
    
</script>

</body>
</html>