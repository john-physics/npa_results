<?php

function student_have_results($conn,$std_id){
    // Get all tables
    $tables = [];

    $result = $conn->query("SHOW TABLES");

   while ($row = $result->fetch_array()) {
        $tables[] = $row[0];
    }

    // Loop through only result tables
    foreach ($tables as $table) {

        if (
            strpos($table, "results_") === 0 ||
            strpos($table, "subject_records_") === 0
        ) {

            $sql = "SELECT 1 FROM `$table` WHERE std_id = ? LIMIT 1";

            $stmt = $conn->prepare($sql);

            if (!$stmt) {
                continue;
            }

          $stmt->bind_param("i", $std_id);
          $stmt->execute();
          $stmt->store_result();

            if ($stmt->num_rows > 0) {
                $stmt->close();
                return true;
            }

            $stmt->close();
        }
    }

    return false;
}

function get_processed_results($conn,$staff_id,$record_id=null){
 
 if($record_id){
//fetch specific subject for staff_id using the record_id     

 $results = collect_table_data2($conn,"subject_results","staff_id","record_id",$staff_id,$record_id,"ii","serial ASC");

 }
 else{
 //fetch all subjects for staff_id   
 $results = [];
$records = collect_table_data1($conn,"subject_results","staff_id",$staff_id,"i","id DESC","record_id");
foreach ($records as $record_id){
 
 $result = collect_user_data2($conn,"subject_results","staff_id","record_id",$staff_id,$record_id,"ii");
 
   
   $resultArray = [
    "term" => $result["term"],
   "session" => $result["session"],
   "class" => $result["class"],
   "date_created" => $result["date_created"],
   "subject" => $result["subject"],
   "record_id" => $result["record_id"],  
      
       ];  
   
   $results[] = $resultArray;  
    
   }
 }
 
 return $results; 
    
}

function sort_stds($conn, $table, $students, $sort){

  $students = convert_to_array($students);
    // Nothing to sort
    if(empty($students)){
        return [];
    }

    // Convert IDs to comma-separated integers
    $ids = implode(",", array_map("intval", $students));

    // Sort by student names
    if($sort === "sortbynames"){

        $sql = "SELECT std_id
                FROM students
                WHERE std_id IN ($ids)
                ORDER BY surname ASC, othernames ASC";

      $result = mysqli_query($conn, $sql);

        $sorted = [];

        while($row = mysqli_fetch_assoc($result)){
            $sorted[] = $row['std_id'];
        }

        return $sorted;
    }

    // Sort by overall average (Highest to Lowest)
    if($sort === "sortbyaverage"){

        $sql = "SELECT std_id
                FROM `$table`
                WHERE std_id IN ($ids)
                ORDER BY overall_average DESC, std_id ASC";

    $result = mysqli_query($conn, $sql);

       $sorted = [];

        while($row = mysqli_fetch_assoc($result)){
            $sorted[] = $row['std_id'];
        }

        return $sorted;
    }

if($sort === "sortsubjects"){

    $ids = implode(",", array_map("intval", $students));

    $sql = "SELECT id
            FROM `$table`
            WHERE id IN ($ids)
            ORDER BY value ASC";

    $result = mysqli_query($conn, $sql);

    $sorted = [];

    while($row = mysqli_fetch_assoc($result)){
        $sorted[] = $row['id'];
    }

    return $sorted;
}

    // Return original order if sort type is invalid
    return $students;
}
function copy_processed_signature($sourceFile, $destinationDir)
{
    // Check if source file exists
    if (!file_exists($sourceFile)) {
        return false;
    }

    // Create destination directory if it doesn't exist
    if (!is_dir($destinationDir)) {
        if (!mkdir($destinationDir, 0755, true)) {
            return false;
        }
    }

    // Get original filename
    $fileName = basename($sourceFile);

    // Full destination path
    $destinationFile = rtrim($destinationDir, '/\\') . DIRECTORY_SEPARATOR . $fileName;

    // Copy file
    if (copy($sourceFile, $destinationFile)) {
        return true;
    }

    return false;
}


function get_staff_subjects($conn,$staff_id){
    
 // develope this later. add a new column for subjects_handling after class_handling on staffs table. 
 
 
 return "Unknown";
    
    
    
}

function upload_image_as_webp($fileArray, $targetFolder, $prefix, $uniqueId) {
    if (empty($fileArray['name'])) return null;

    $tempDir = $fileArray['tmp_name'];
    $fileExt = strtolower(pathinfo($fileArray['name'], PATHINFO_EXTENSION));
    $allowedExt = ['png', 'jpg', 'jpeg', 'webp'];

    if (!in_array($fileExt, $allowedExt)) {
        return "extension_error"; // Handle this in your main code
    }

    $rename = $uniqueId . substr(time(), 6, 4);
    $finalFilename = $prefix . $rename . '.webp';
    
    $savePath = $_SERVER["DOCUMENT_ROOT"] . $targetFolder . $finalFilename;
    
    // Try GD Conversion
    if (function_exists('imagewebp')) {
        $image = null;
        if ($fileExt == 'jpg' || $fileExt == 'jpeg') $image = imagecreatefromjpeg($tempDir);
        elseif ($fileExt == 'png') {
            $image = imagecreatefrompng($tempDir);
            imagepalettetotruecolor($image);
            imagealphablending($image, true);
            imagesavealpha($image, true);
        } elseif ($fileExt == 'webp') {
            $image = imagecreatefromwebp($tempDir);
        }

        if ($image && imagewebp($image, $savePath, 80)) {
            imagedestroy($image);
            return $finalFilename; // Success!
        }
    }

    // Fallback: Just move the file if GD fails or isn't needed
    $fallbackName = $prefix . $rename . '.' . $fileExt;
    $fallbackPath = $_SERVER["DOCUMENT_ROOT"] . $targetFolder . $fallbackName;
    
    if (move_uploaded_file($tempDir, $fallbackPath)) {
        return $fallbackName;
    }

    return null; // Failure
}


function get_class_subjects($conn,$class_set){
 
  $students = convert_to_array($class_set["students"]);
  $subjects = convert_to_array($class_set["subjects"]);
  $class = $class_set["class"];
  
   foreach ($students as $student){
   
  $std_det = collect_user_data2($conn,"students","std_id","current_class",$student,$class,"is");
     
  $added = convert_to_array($std_det["added_subjects"]);
  
  $subjects = merge_into_array($added,$subjects);
  } 

 return $subjects;   
    
}
function get_subject_code($subjectname){

    // Normalize subject name
    $subject = strtolower(trim($subjectname));
 
 if(is_numeric($subjectname)){
  
$subject = strtolower(trim(get_subject_name($subjectname)));   
 }
 
    
if(strpos($subject,"citizenship") !== false && strpos($subject,'cultural') !== false && strpos($subject,'heritage')){
  $subject = "citizenship and cultural heritage";
}

if(strpos($subject,"crop") !== false && strpos($subject,'production') !== false && strpos($subject,'horticulture')){
  $subject = "crop production and horticulture";
}



    // Known subject codes
    $codes = [
        "mathematics" => "MTH",
        "maths" => "MTH",

        "english language" => "ENG",
        "english" => "ENG",

        "chemistry" => "CHM",
        "biology" => "BIO",
        "physics" => "PHY",
       "digital technology" => "DTECH",
     "digital technologies" => "DTECH",
     "crop production and horticulture" => "HCP",
    "horticulture and crop production" => "HCP",
     "citizenship and cultural heritage" => "CCH",
   "citizenship & cultural heritage" => "CCH",
   
        "accounting" => "ACT",
        "financial accounting" => "ACT",

        "basic science" => "BSC",
        "basic science and technology" => "BST",

        "agricultural science" => "AGR",
        "commerce" => "COM",
        "economics" => "ECO",
        "government" => "GOV",
        "literature in english" => "LIT",
        "literature" => "LIT",

        "civic education" => "CVE",
        "computer studies" => "CST",
        "computer science" => "CSC",
        "data processing" => "DTP",

        "further mathematics" => "FMTH",
        "geography" => "GEO",
        "history" => "HIS",
        "nigerian history" => "HIS",
        "home economics" => "HME",
        "business studies" => "BST",
        "social studies" => "SOS",
        "social and citizenship studies" => "SCS",

        "christian religious studies" => "CRS",
        "islamic religious studies" => "IRS",

        "yoruba" => "YOR",
        "igbo" => "IGB",
        "hausa" => "HAU",

        "physical and health education" => "PHE",
        "physical education" => "PHE",

        "technical drawing" => "TDW",
        "food and nutrition" => "FON",
        "physical health education" => "PHE"
    ];

    // Return known code
    if(isset($codes[$subject])){
        return $codes[$subject];
    }

    // Default: first 3 letters
    return strtoupper(substr(preg_replace('/[^a-z]/', '', $subject), 0, 3));
}

function check_result_status($conn,$term,$session,$class){
  
 if($class == "All" || $term == "All" || $session =="All"){
 //no broadsheet for all results at the same time     
  return null; 
     
 }
  
 $resultTable = form_table_name("results_",$session);
   
 $class_set = collect_user_data3($conn,"class_set","session","term","class",$session,$term,$class,"sss");
  $class_size = count(convert_to_array($class_set["students"]));
 $cteacher = $class_set["staff_id"];
 
 $published = count_user_data3($conn,$resultTable,"term","class","result_status",$term,$class,"Published","sss");
 $unpublished = count_user_data3($conn,$resultTable,"term","class","result_status",$term,$class,"Unpublished","sss");
$totalresults = count_user_data2($conn,$resultTable,"term","class",$term,$class,"ss"); 

 $broadsheet = false;

 if($class_size && $totalresults && $totalresults == $class_size){
 $broadsheet = true;    
 }
 
 
 $resultStatus = [
     "published" => $published,
     "unpublished" => $unpublished,
     "class_size" => $class_size,
     "total_uploads" =>$totalresults,
     "broadsheet" => $broadsheet,
     "cteacher" => $cteacher,
     ];

     
  return $resultStatus;   

}

function get_student_name($conn, $std_id){

    $sql = "SELECT surname, othernames 
            FROM students 
            WHERE std_id = ? 
            LIMIT 1";

    $stmt = mysqli_prepare($conn, $sql);

    if(!$stmt){
        return null;
    }

    mysqli_stmt_bind_param($stmt, "i", $std_id);

    mysqli_stmt_execute($stmt);

  $result = mysqli_stmt_get_result($stmt);

   $row = mysqli_fetch_assoc($result);

    if($row){

        $stdname = $row["surname"]." ".$row["othernames"];

        return $stdname;
    }

    return null;
}
 
function result_signataries($conn,$resultTable,$term,$class,$std_id,$checkcomments=false){

//false from this function will Prevent publishing of the selected stds results 
 
$cteach = collect_user_data($conn,"staffs","class_handling",$class,"s");   
  $cteachSignature = $cteach["signature"];  
  $principal = collect_user_data($conn,"staffs","staff_cat","Principal","s");   
$principalSignature = $principal["signature"];
 
if(!$cteachSignature || !$principalSignature){
 return false;   
}

$path = $_SERVER["DOCUMENT_ROOT"].'/images/staff/';
 $cteachSignatureImg = $path.$cteachSignature;
$principalSignatureImg = $path.$principalSignature;
  
 if(!is_file($cteachSignatureImg) || !is_file($principalSignatureImg)){
   
   return false;  
 }
 
 
 $nextTerm = collect_user_data($conn,"variables","type","Next Term Begins","s");
$next_term = $nextTerm["value"];
$nextTermBegins = str_replace("/", "-", $next_term);
$todaysDate = date("d-m-Y");

$nextTimestamp=strtotime($nextTermBegins);
$todayTimestamp = strtotime($todaysDate);

if (empty($next_term) ||
    $nextTimestamp === false ||
    $nextTimestamp <= $todayTimestamp){
    return false;
}
 
if($checkcomments){
 
 $result = collect_user_data3($conn,$resultTable,"std_id","term","class",$std_id,$term,$class,"iss");
 
 $cteach_cmt = $result["teacher_comment"];
 $principal_cmt = $result["principal_comment"];
 
 if(!$cteach_cmt || !$principal_cmt){
   
    return false;
 }   
}

 
 return true;
}

function pos_in_class($conn,$term,$class,$resultTable){
 
  $sql = "SELECT std_id, overall_average FROM $resultTable 
            WHERE term = ? 
            AND class = ? 
            ORDER BY overall_average DESC, std_id ASC
         ";

   $stmt = mysqli_prepare($conn, $sql);
    if(!$stmt){
        return false;//Prevent publishing of this class results
    }

  mysqli_stmt_bind_param($stmt,"ss",$term,$class);
    
    mysqli_stmt_execute($stmt);
 $result = mysqli_stmt_get_result($stmt);
 $std_ids = [];
 $averages = [];
 while($row = mysqli_fetch_assoc($result)){

  $std_ids[] = $row["std_id"];
  $averages[] = $row["overall_average"];
  
   }
   
 mysqli_stmt_close($stmt);

$upd = 0;
foreach ($averages as $index =>$average){   
  $std_id = $std_ids[$index];
  $pos = array_search($average,$averages)+1;
     
   $position = format_position($pos);

 if(update_user_data3($conn,$resultTable,"position_inclass","std_id","term","class",$position,$std_id,$term,$class,"siss")){
    $upd++; 
    }   
 }
 
 if($upd == count($std_ids)){
  return true; //publish this class results.  
 }
 else{
    //something went wrong
    return false; // Prevent publishing of this class results. 
 }
}

function posInSubject($conn,$table,$record_id,$staff_id,$totalscore){
  
  $sql = "SELECT total FROM $table 
            WHERE staff_id = ? 
            AND record_id = ?";

   $stmt = mysqli_prepare($conn, $sql);
    if(!$stmt){
        return null;
    }

  mysqli_stmt_bind_param($stmt,"ii",$staff_id,$record_id);
    
    mysqli_stmt_execute($stmt);
 $result = mysqli_stmt_get_result($stmt);
 $records = [];

 while($row = mysqli_fetch_assoc($result)){
  $records[] = $row["total"];
    }
   mysqli_stmt_close($stmt);

  rsort($records);
  
  if(!in_array($totalscore,$records)){
   return null;   
  }
  
 $pos = array_search($totalscore,$records)+1;
  
  $position = format_position($pos);
  
  return $position;
    
}


function pos_in_subject($conn,$subjectTable,$term,$class,$subject,$totalscore){
  
  $sql = "SELECT total FROM $subjectTable 
            WHERE term = ? 
            AND class = ? 
            AND subject = ?";

   $stmt = mysqli_prepare($conn, $sql);
    if(!$stmt){
        return null;
    }

  mysqli_stmt_bind_param($stmt,"sss",$term,$class,$subject);
    
    mysqli_stmt_execute($stmt);
 $result = mysqli_stmt_get_result($stmt);
 $records = [];

 while($row = mysqli_fetch_assoc($result)){
  $records[] = $row["total"];
    }
   mysqli_stmt_close($stmt);

  rsort($records);
  
  if(!in_array($totalscore,$records)){
   return null;   
  }
  
 $pos = array_search($totalscore,$records)+1;
  
  $position = format_position($pos);
  
  return $position;
    
}

function format_position($number){

    // Handle 11th, 12th, 13th specially
    if($number % 100 >= 11 && $number % 100 <= 13){
        return $number . "th";
    }

    switch($number % 10){

        case 1:
            return $number . "st";

        case 2:
            return $number . "nd";

        case 3:
            return $number . "rd";

        default:
            return $number . "th";
    }
}

function get_subject_name($subject_id){
   global $conn;
    
  $subject_name ="";
  $subject = collect_user_data2($conn,"variables","type","id","Subject",$subject_id,"si");
 if($subject){
     
 $subject_name = null_check($subject["value"],"Unknown");  
 }
 
 return $subject_name;
}

function show_position_inclass($conn){
    
 $settings = collect_user_data($conn,"variables","type","show_position_inclass","s");
 $showpos =  strtolower(null_check($settings["value"],"off"));
    
  if($showpos === "on"){
      return true; //write all failure with red ink 
  }
  else{
    return false; //don't use red ink at all no matter the case
  }   
    
}

function redink_for_failure($conn){
 
 $settings = collect_user_data($conn,"variables","type","red_ink","s");
 $redink =  strtolower(null_check($settings["value"],"off"));
    
  if($redink === "on"){
      return true; //write all failure with red ink 
  }
  else{
    return false; //don't use red ink at all no matter the case
  }
}

function minimum_total_score(){
  global $conn;
  
 $minscore = 0;
 $score = collect_user_data($conn,"variables","type","minimum_score","s");
 if($score){
     
 $minscore = null_check($score["value"],0);  
 }
 
 return $minscore;
    
}

function variable_contain_results($conn,$value,$type,$ses=null,$class=null,$std_id=null){
    
 $valueDet = collect_user_data2($conn,"variables","type","value",$type,$value,"ss");
 $value_Id = $valueDet["id"];
 $sessions = collect_table_data($conn,"class_set","","session");
  
  if($type =="Class"){
   
  foreach ($sessions as $session){
      
 $tablename = form_table_name("results_",$session); 
  if(check_exist($conn,$tablename,"class",$value,"s")){
  // class contain atleast 1 result   
   return true;   
   }    
}
   
 //no result on this class yet 
 return false;
  }
  
  if($type =="Subject"){
   
   $subjectValue = $value_Id;   
  if(is_numeric($value)){
      $subjectValue = $value;
    }
    
  if($ses && $class && $std_id){
 $tablename = form_table_name("subject_records_",$ses); 

 if(check_exist3($conn,$tablename,"std_id","class","subject",$std_id,$class,$subjectValue,"iss")){
  // subject contains result, clear result
 
 delete_user_data3($conn,$tablename,"std_id","class","subject",$std_id,$class,$subjectValue,"iss");
   
   return false;   
      
   }   
  }
 elseif($ses && $class){
  $tablename = form_table_name("subject_records_",$ses); 
   if(check_exist2($conn,$tablename,"class","subject",$class,$subjectValue,"ss")){
  // subject contain atleast 1 result   
 //  clear all;   
   delete_user_data2($conn,$tablename,"class","subject",$class,$subjectValue,"ss");
   return false; 
      
   }
 
}

else{
    
 foreach ($sessions as $session){
 $tablename = form_table_name("subject_records_",$session); 
  if(check_exist($conn,$tablename,"subject",$subjectValue,"s")){
  //General subject removal from db, subject contain atleast 1 result, block removal   
   return true;   
    }      
   
  }    
    
}

 //no result on this subject yet 
 return false;
  }

 return true; //block removal of Unknown variable type  
    
}

function validate_cas($cas, $maxcas,$exam){
  $validate = true; //initialize validation

    foreach ($cas as $index => $ca) {

        $max = $maxcas[$index] ?? null;
        $label = "CA" . ($index + 1);

     if($ca){
    
         // Must be numeric if provided
        if (!is_numeric($ca)) {
         $validate = false;
         
     if (!isset($_SESSION["error_msg"])) {
        $_SESSION["error_msg"] = "Error:";
    } 
     $_SESSION["error_msg"] .= "<br>{$label} must be a number";
            continue;
        }

        $ca = (float)$ca;

        // Range validation
        if ($max !== null && ($ca < 1 || $ca > $max)) {
            $validate = false;
       
      if (!isset($_SESSION["error_msg"])) {
        $_SESSION["error_msg"] = "Error:";
    }   
         $_SESSION["error_msg"] .= "<br>{$label} must be between 1 and {$max}";
        }     
         
     }
    }

//validate Exams
// Skip if empty (flexible entry)
       
   if($exam){
       
   // Exams must be numeric if provided
    if (!is_numeric($exam)) {
    $validate = false;
 if (!isset($_SESSION["error_msg"])) {
        $_SESSION["error_msg"] = "Error:";
    }
    
    $_SESSION["error_msg"] .= "<br>Exam scores must be a number";
        }
  $exam = (float)$exam; 
  $maxexam = 100 - array_sum($maxcas);
  // Range validation
   if ($maxexam !== null && ($exam < 10 || $exam > $maxexam)) {
        $validate = false;
      if (!isset($_SESSION["error_msg"])) {
        $_SESSION["error_msg"] = "Error:";
    }
        $_SESSION["error_msg"] .= "<br>Exam scores must be between 10 and {$maxexam}";
        }   
    
   }

  
  return $validate;
}

function normalize_user_name($username,$normalizer){
    
  $username = strtolower($username);
  $normalizer = strtolower($normalizer);
  
  if($normalizer == "ucwords"){
   $username = ucwords($username); 
  }
  
  elseif($normalizer == "ucfirst"){
      $username = ucfirst($username);
  }
  
  
  elseif($normalizer == "upper"){
      $username = strtoupper($username);
  }
 
  elseif($normalizer == "lower"){
      $username = strtolower($username);
  }
  else{
   //Default
    $username = ucwords($username);   
      
  }
  
  
   return trim($username);
    
}

function table_contains_data($conn, $table) {

    // Prevent SQL injection through table name
    $table = trim($table);

    if (empty($table)) {
        return false;
    }

    // Check if at least one row exists
$query = "SELECT 1 FROM `$table` LIMIT 1";
$result = mysqli_query($conn, $query);

  if ($result && mysqli_num_rows($result) > 0) {
        return true;
    }

    return false;
}

function remove_from_array($value = null, $array = null){

    // Ensure array is valid
    if ($array === null) {
        return [];
    }

    // Convert non-array into array
    $result = is_array($array) ? $array : [$array];

    // Convert value into array for uniform handling
    $values = is_array($value) ? $value : [$value];

    // Remove all matching values
    $result = array_filter(
        $result,
        fn($item) => !in_array($item, $values, true)
    );

    // Reset indexes
    return array_values($result);
}

function update_stds_class($conn,$students,$class){
 
 //get class cat 
  $classVar = collect_user_data2($conn,"variables","type","value","Class",$class,"ss");
 $classCat = $classVar["classification"];
   
   if(is_array($students)){
   //$students is an array of std Ids  
   foreach ($students as $std){
    update_user_data($conn,"students","current_class","std_id",$class,$std,"si"); 
    
     update_user_data($conn,"students","std_cat","std_id",$classCat,$std,"si");  
 
 //reset added_subjects & removed_subjects
  $null = null;
  update_user_data($conn,"students","added_subjects","std_id",$null,$std,"si");
  update_user_data($conn,"students","removed_subjects","std_id",$null,$std,"si");
     
   }
       
    return true;    
   }
   else{
    //single std id
  if(update_user_data($conn,"students","current_class","std_id",$class,$students,"si")){
     
     update_user_data($conn,"students","std_cat","std_id",$classCat,$students,"si");  
    
     return true;
     }  
   }
    
 return false;   
}
 
function log_errors($errorname,$request,$error){
    
 $errorfile = $errorname.".log";
 $errorSavePath = $_SERVER["DOCUMENT_ROOT"] . "/logs";

if(!is_dir($errorSavePath)){

   mkdir($errorSavePath, 0755, true);
}

$logFile = $errorSavePath."/".$errorfile;

$logMessage = "

[" . date("Y-m-d h:i:s A") . "]

ERROR Name: ".strtoupper($errorname)."

REQUEST: $request

ERROR DESCRIPTION: $error

==================================================

";

if(file_put_contents($logFile,$logMessage, FILE_APPEND)){
    
    return true;
} 
    
  else{
      return false;
  }  
}

function pluralize($word, $count = 2){

    // Singular
    if($count == 1){
        return $word;
    }

    // Irregular plurals
    $irregular = [

        "man" => "men",
        "woman" => "women",
        "child" => "children",
        "person" => "people",
        "mouse" => "mice",
        "goose" => "geese",
        "tooth" => "teeth",
        "foot" => "feet",
        "ox" => "oxen",
        "cactus" => "cacti",
        "focus" => "foci",
        "fungus" => "fungi",
        "nucleus" => "nuclei",
        "syllabus" => "syllabi",
        "analysis" => "analyses",
        "diagnosis" => "diagnoses",
        "thesis" => "theses",
        "crisis" => "crises",
        "phenomenon" => "phenomena",
        "criterion" => "criteria",
        "datum" => "data"

    ];

    // Check irregular words
    $lower = strtolower($word);

    if(isset($irregular[$lower])){

        $plural = $irregular[$lower];

        // Preserve first letter capitalization
        if(ctype_upper($word[0])){
            $plural = ucfirst($plural);
        }

        return $plural;
    }

    // Words ending with consonant + y
    if(preg_match('/[^aeiou]y$/i', $word)){
        return substr($word, 0, -1) . "ies";
    }

    // Words ending with s, x, z, ch, sh
    if(preg_match('/(s|x|z|ch|sh)$/i', $word)){
        return $word . "es";
    }

    // Words ending with f or fe
    if(preg_match('/(f|fe)$/i', $word)){

        if(substr($word, -2) == "fe"){
            return substr($word, 0, -2) . "ves";
        }

        return substr($word, 0, -1) . "ves";
    }

    // Default plural
    return $word . "s";
}

function staff_titles(){
  
  $titles = ['Mr.','Mrs.','Miss.','Dr.','Prof.','Pst.','Fr.','Rev.','Rev. Dr.','Rev. Fr.','Dr. Mrs.','Dr. Miss.','Prof. Mrs.','Prof. Miss.','Pst. Mrs.','Pst. Dr.'];
    
 
return $titles;

}

function get_class_dets($type,$value){
global $conn;


if($type == "class"){

 $current =  get_current_session(); 
 $term = $current["term"];
 $session = $current["session"];
 
 $stdNum = count_user_data($conn,"students","current_class",$value,"s");
 $det = collect_user_data2($conn,"variables","type","value","Class",$value,"ss");

$cat = $det["classification"];
$assPattern = $det["assessment_pattern"];
 
  //get current class' teacher
 $staff = collect_user_data($conn,"staffs","class_handling",$value,"s");
if($staff){
 $classTeacher = trim($staff["title"]." ".$staff["surname"]." ".$staff["othernames"]);
}

 $classTeacher = null_check($classTeacher,"Unknown");
 
 $classDets = [
     "teacher"=>$classTeacher,
     "std_num"=>$stdNum,
     "class_cat" => $cat,
     "ass_pattern" => $assPattern,
     "term" => $term,
     "session" => $session
     ];
    
 
  return $classDets;    
    
}

elseif($type == "subject"){
    
  $det = collect_user_data2($conn,"variables","type","value","Subject",$value,"ss");
  $cat = $det["classification"];  
  $id = $det["id"];
  $subjectcode = get_subject_code($value);
 
 $subjDets = [
     "teacher"=>"Unknown",
     "subj_cat" => $cat,
     "subj_code" => $subjectcode,
      "subj_id" =>$id, 
     ];
    
 
  return $subjDets;  
  }
}

function validate_phone_number($phone) {

    // Remove spaces, brackets, hyphens
    $phone = preg_replace('/[\s\-\(\)]/', '', $phone);

    // Remove leading +
    $digits_only = ltrim($phone, '+');

    // Ensure digits only
    if (!ctype_digit($digits_only)) {
        return false;
    }

    // Normalize formats
    if (preg_match('/^0\d{10}$/', $phone)) {
        return true;
    }

    if (preg_match('/^234\d{10}$/', $phone)) {
        return true;
    }

    if (preg_match('/^\+234\d{10}$/', $phone)) {
        return true;
    }

    return false;
}

function inser_into_queue($msg){
   global $conn,$DateTime; 
    
  $name = $msg["name"];
  $email = $msg["email"];
  $msg_subj = $msg["subject"];
  $msg_body = $msg["body"];
  $attach = $msg["attach"]??null;


$search  = ["’", "‘", "“", "”"];
$replace = ["'", "'", '"', '"'];

$msg_subj = str_replace($search, $replace, $msg_subj);
$msg_body    = str_replace($search, $replace, $msg_body);

  
 $EmailData = [
     "conn" => $conn,
     "table" => "mail_queue",
     "cols" => ['recipient_name','recipient_email','subject','message','attachment','created_at'],
     "vals" => [$name,$email,$msg_subj,$msg_body,$attach,$DateTime],
     "params" => 'ssssss'
     ];

$queue = insert_user_data($EmailData);
    
return $queue;
    
}

function std_num($num, $std = 'cc') {

//cc: country Code
//ncc: no country Code
 $clean = preg_replace('/\D/', '', $num);

if ($std === 'cc') {
    
 if (substr($clean, 0, 3) === '234' && strlen($clean) == 13) {
            return $clean;
        }

if (substr($clean, 0, 1) === '0' && strlen($clean) == 11) {
            return '234' . substr($clean, 1);
        }

      
  if (strlen($clean) == 10) {
            return '234' . $clean;
        }

        return null; // invalid number
    }

 
 if ($std === 'ncc') {

  if (substr($clean, 0, 1) === '0' && strlen($clean) == 11) {
            return $clean;
        }

 
  if (substr($clean, 0, 3) === '234' && strlen($clean) == 13) {
            return '0' . substr($clean, 3);
        }


   if (strlen($clean) == 10) {
            return '0' . $clean;
        }

        return null;
    }

    // If $std is unknown
    return null;
}

function get_current_session(){
 global $conn; 
 $current = ["term" =>"","session"=>""];

$session = collect_user_data($conn, "variables","type","Current Session","s");
$term = collect_user_data($conn, "variables","type","Current Term","s");
 
if($session && $term){

$current = [
  "term" => $term["value"],
  "session" => $session["value"],
];

}

return $current;
}

function switch_user($user_cat=null){
 
 global $conn;
  $staffCats = collect_table_data($conn,"staffs","","staff_cat");


 $switch = [
   "conn"  => "",
   "table" => "",
   "id_col" => "",
    "user_id" => "",
    "user_cat" => "" ,
    "user_type" => "",
   ]; 


if($user_cat){
    
 if(in_array($user_cat,$staffCats)){
 
 
 $switch = [
   "conn"  => $conn,
   "table" => "staffs",
   "id_col" => "staff_id",
   "user_id" => "",
   "user_cat" => $user_cat,  
  "user_type" => "Staff",
   "prf_dir" => "/images/staff"
 
     ];
} 
 else{
 
 $switch = [
   "conn"  => $conn,
   "table" => "students",
   "id_col" => "std_id",
   "user_id" => "",
    "user_cat" => $user_cat, 
    "user_type" => "Student",
    "prf_dir" => "/images/students"
     ];
 }
}
elseif(isset($_SESSION["staff_id"]) && isset($_SESSION["staff_cat"])){
    
  $user_id = $_SESSION["staff_id"];
  $user_cat = $_SESSION["staff_cat"];

 $switch = [
   "conn"  => $conn,
   "table" => "staffs",
   "id_col" => "staff_id",
     "user_id" => $user_id,
     "user_cat" => $user_cat,
     "user_type" => "Staff",
    "prf_dir" => "/images/staff"
    
     ];

}
elseif(isset($_SESSION["std_id"]) && isset($_SESSION["std_cat"])){
    
$user_id = $_SESSION["std_id"];
$user_cat = $_SESSION["std_cat"];
 $switch = [
   "conn"  => $era_db,
   "table" => "students",
   "id_col" => "std_id",
     "user_id" => $user_id,
     "user_cat" => $user_cat,
     "user_type" => "Student",
    "prf_dir" => "/images/students"

     ];

}


    
 return $switch;   
}

function addBtn($btn,$dir,$id="addbtn"){


 echo '<a class="addbtn" id="'.$id.'" href="'.$dir.'">'.$btn.'</a>
 
 <style>
 .addbtn {
   position:relative;
   top:10px;
   padding:5px;
   border-radius:10px;
    color:white;
    background: rgb(200,50,50);
    cursor:pointer;
    display:flex;
    flex-direction:column;
    align-items:center;
    text-decoration:none;
    margin:20px;
 }
 </style>';
   
}

function addTableBtn($btns){

 echo '<div class="table_btn">';
 
 if(is_array($btns)){
 
  foreach ($btns as $btn){
   $btnName = $btn["btn_name"];
   $btnDir = $btn["btn_dir"];
   $btnId = $btn["btn_id"];
   $att1 = $btn["btn_att1"];
   $att2 = $btn["btn_att2"];
   $attv1 = $btn["btn_attv1"];
   $attv2 = $btn["btn_attv2"];
    
  if(!$btnId){
      $btnId = "view_ass";//default btn Id
  }
  
 if(!$att1){
     $att1 = "data-id";
 }
  
  if(!$att2){
     $att2 = "data-name";
 } 
 
  echo ' <a id="'.$btnId.'" href="'.$btnDir.'" '.$att1.'="'.$attv1.'" '.$att2.'="'.$attv2.'">'.$btnName.'</a>';   
      
  }   
    
 }
 echo '</div>
 
 <style>
   .table_btn{
    
    display:flex;
    flex-direction:horizontal;
    gap:10px;

    }
    
    .table_btn a{
    text-decoration:none;
    color:white;
    padding:8px;
    border-radius:4px;
    cursor:pointer;
    font-size:10px;
    font-weight:bold;
    display:block;
        width:90px;
        text-align:center;
    }
  
   .table_btn #share_cert{
        
     background:rgba(250,50,50,0.5);
      
    }
     .table_btn #remove_ass{
    
    background:rgba(250,50,50,0.5);
    
    }
     .table_btn #view_ass{
    
    background:rgba(10,100,250,0.5);
    
    } 
     .table_btn #dwn_ass{
    
    background:rgba(150,100,150,0.5);
    
    } 
     .table_btn #grade_ass{
    
    background:rgba(10,200,150,0.5);
    
    } 
  

 </style>';
   
}


function Addfooter($site){
    
   $year = date("Y");
 echo '<footer class="footer" id="footer">
     <p>'.$site.' &copy; '.$year.'. All Rights Reserved.</p>
    </footer>';  
    
}

function switch_gender($gender = null, $type = 'pronoun') {
    // Normalize inputs
  
    
 $gender = strtolower(trim($gender ?? ''));
 $type   = strtolower(trim($type ?? ''));

    // Define gender-based comparison list
    $comparison = [
        'pronoun'        => ['male' => 'He', 'female' => 'She'],
        'object'         => ['male' => 'Him', 'female' => 'Her'],
        'possessive_adj' => ['male' => 'His', 'female' => 'Her'],    // e.g., his book
        'possessive_pro' => ['male' => 'His', 'female' => 'Hers'],   // e.g., the book is his
        'reflexive'      => ['male' => 'Himself', 'female' => 'Herself'],
        'noun'           => ['male' => 'Man', 'female' => 'Woman'],
        'title'          => ['male' => 'Mr.', 'female' => 'Ms.'],
        'parent'         => ['male' => 'Father', 'female' => 'Mother'],
        'child'          => ['male' => 'Son', 'female' => 'Daughter'],
        'sibling'        => ['male' => 'Brother', 'female' => 'Sister']
    ];

    // If the type exists in the comparison list
    if (isset($comparison[$type])) {
        $maleWord   = $comparison[$type]['male'];
        $femaleWord = $comparison[$type]['female'];

        if ($gender === 'male') {
            return $maleWord;
        } elseif ($gender === 'female') {
            return $femaleWord;
        } else {
            // Gender is null or unspecified
            return $maleWord . '/' . $femaleWord; // e.g., He/She
        }
    }

    // Unknown type
    return null;
}

function convert_to_array($value){

    // If already an array
    if(is_array($value)){
        return $value;
    }

    // Convert to string
    $value = trim((string)$value);

    // Detect separator
    if(strpos($value, '/') !== false){

        $values = explode("/", $value);

    }
    elseif(strpos($value, '&') !== false){

        $values = explode("&", $value);

    }
    elseif(strpos($value, ',') !== false){

        $values = explode(",", $value);

    }
    elseif(strpos($value, ':') !== false){

        $values = explode(":", $value);

    }
    elseif(phrase_contains($value, 'and')){

        $values = explode("and", $value);

    }
    elseif(strpos($value, ' ') !== false){

        $values = explode(" ", $value);

    }
    else{

        $values = [$value];

    }

    // Trim values and remove empties
    $trimedValues = [];

    foreach($values as $item){

        $trimValue = trim($item);

        if($trimValue !== ''){
            $trimedValues[] = $trimValue;
        }
    }

    return $trimedValues;
}

function numberToRoman($num) {
    // Map of Roman numerals
    $map = [
        'M'  => 1000,
        'CM' => 900,
        'D'  => 500,
        'CD' => 400,
        'C'  => 100,
        'XC' => 90,
        'L'  => 50,
        'XL' => 40,
        'X'  => 10,
        'IX' => 9,
        'V'  => 5,
        'IV' => 4,
        'I'  => 1
    ];

    $result = '';

    foreach ($map as $roman => $value) {
        // Repeat while the number is >= to the current value
        while ($num >= $value) {
            $result .= $roman;
            $num -= $value;
        }
    }

    return $result;
}
