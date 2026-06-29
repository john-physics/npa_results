<?php

function get_pending_mails($conn, $status,$limit){
   
    $sql = "SELECT *
            FROM mail_queue
            WHERE status = ?
            AND recipient_email IS NOT NULL
            AND recipient_email != ''
            ORDER BY id ASC
            LIMIT ?";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, "si", $status, $limit);

  mysqli_stmt_execute($stmt);

  $result = mysqli_stmt_get_result($stmt);

    $data = [];

 while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }

    mysqli_stmt_close($stmt);

    return $data ?: false;
}

function allow_result_deletion(){
  global $conn; 
 
 $deletion = collect_user_data($conn,"variables","type","result_deletion","s");  
  $deletionValue = strtolower($deletion["value"]);

  if($deletionValue == "on" || $deletionValue == "enabled"){
  //allow deletion    
   return true;   
  } 
  
 else{
  //prevent deletion 
   return false;  
     
 } 
}

function result_lock($term,$session){
global $conn;

  $current = get_current_session();
  $CurrentTerm= trim($current['term']);
  $currentSession = trim($current['session']);

  $luck = collect_user_data($conn,"variables","type","result_lock","s");  
  $luckValue = strtolower($luck["value"]);
  
  if($luckValue == "on" || $luckValue == "enabled"){

 if($term == $CurrentTerm && $session == $currentSession){
  //allow only current term  
  return false;   
     
 }    
  else{
 // luck Result, prevent editing
 return true;
      
   } 
  }
  else{
      
  return false;    
  }
}

function fetch_students($conn, $class){

    // normalize class text
    $class = strtoupper(trim($class));

    preg_match('/^([A-Z\- ]+)\s*(\d+)?\s*([A-Z])?$/', $class, $matches);

    $category = trim($matches[1] ?? '');
    $level    = (int)($matches[2] ?? 0);
    $arm      = trim($matches[3] ?? '');



    // handle class aliases
    if($category == "PRIMARY"){
        $category = "GRADE";
    }

    if($category == "SSS"){
        $category = "SS";
    }


/* Note for later updates:
store categories and arms in db and load them rather than hard coding it to allow flexible class introduction. 

From add class, create another dynamic input that can switch suggested class category and max levels just like assessment pattern, so in case of a new class introduction, the system can still adapts properly.

*/

    $groupOrder = [
        "PRE-SCHOOL",
        "PRE-NURSERY",
        "NURSERY",
        "GRADE",
        "JSS",
        "SS"
    ];



    $maxLevels = [
        "PRE-SCHOOL"  => 3,
        "PRE-NURSERY" => 3,
        "NURSERY"     => 3,
        "GRADE"       => 5,
        "JSS"         => 3,
        "SS"          => 3
    ];

 

    // validate category
    if(!isset($maxLevels[$category])){
        return [];
    }



    // validate level
    if($level < 1 || $level > $maxLevels[$category]){
        return [];
    }

    // find current category position
    $currentIndex = array_search($category, $groupOrder);

    if($currentIndex === false){
        return [];
    }


    $targets = [];

    // SAME LEVEL (all arms)
    $targets[] = "{$category} {$level}%";

    // LOWER LEVEL
    if($level > 1){

      $targets[] = "{$category} ".($level - 1)."%";

    }else{

        $prevIndex = $currentIndex - 1;

        if(isset($groupOrder[$prevIndex])){

            $prevCategory = $groupOrder[$prevIndex];

            $targets[] = "{$prevCategory} ".$maxLevels[$prevCategory]."%";
        }
    }



    // UPPER LEVEL
    if($level < $maxLevels[$category]){

        $targets[] = "{$category} ".($level + 1)."%";

    }else{

        $nextIndex = $currentIndex + 1;

        if(isset($groupOrder[$nextIndex])){

            $nextCategory = $groupOrder[$nextIndex];

            $targets[] = "{$nextCategory} 1%";
        }
    }



    $students = [];

    /*
    =========================================
    FETCH EXACT CLASS FIRST
    Example:
    SS 2A only
    =========================================
    */

    $sql1 = "
        SELECT std_id, surname, othernames
        FROM students
        WHERE UPPER(current_class) = ?
        ORDER BY surname ASC
    ";

    $stmt1 = mysqli_prepare($conn, $sql1);

    if(!$stmt1){
        return [];
    }

    mysqli_stmt_bind_param($stmt1, "s", $class);

    mysqli_stmt_execute($stmt1);

    $result1 = mysqli_stmt_get_result($stmt1);

    while($row = mysqli_fetch_assoc($result1)){

        $students[] = [
            "id"   => $row["std_id"],
            "name" => $row["surname"]." ".$row["othernames"]
        ];
    }

    mysqli_stmt_close($stmt1);


    /*
    =========================================
    FETCH RELATED CLASSES
    Includes:
    - other arms of same level
    - lower level
    - upper level

    Excludes:
    - exact class already fetched in sql1
    =========================================
    */

    if(!empty($targets)){

        $conditions = [];

        foreach($targets as $target){
            $conditions[] = "UPPER(current_class) LIKE ?";
        }

        $sql2 = "
            SELECT std_id, surname, othernames
            FROM students
            WHERE (
                ".implode(" OR ", $conditions)."
            )
            AND UPPER(current_class) != ?
            ORDER BY surname ASC
        ";

        $stmt2 = mysqli_prepare($conn, $sql2);

        if($stmt2){

            // add exact class exclusion parameter
            $params = $targets;
            $params[] = $class;

            $types = str_repeat("s", count($params));

            mysqli_stmt_bind_param($stmt2, $types, ...$params);

            mysqli_stmt_execute($stmt2);

            $result2 = mysqli_stmt_get_result($stmt2);

            while($row = mysqli_fetch_assoc($result2)){

                $students[] = [
                    "id"   => $row["std_id"],
                    "name" => $row["surname"]." ".$row["othernames"]
                ];
            }

            mysqli_stmt_close($stmt2);
        }
    }

 //return [];

    return $students;
}

function form_table_name($prefix,$session){
 
  
 if(strpos($session,"/")){
     
 $session = str_replace("/","_",$session); 
 }
 
  
  $tableName = $prefix.$session;
  return $tableName;
    
}
function create_result_table($conn, $tableDetails){

    /*
    Extract table details
    */
    $tableName      = $tableDetails['table_name'];
    $columns        = $tableDetails['table_columns'];
    $types          = $tableDetails['column_type'];
    $lengths        = $tableDetails['column_length'];
    $defaults       = $tableDetails['column_default'];
    $nullValues     = $tableDetails['column_null'];
    $indexes        = $tableDetails['column_index'];
    $primaryColumn  = $tableDetails['primary_column'];

    /*
    Store all column queries
    */
    $queryParts = [];

    /*
    Loop through columns
    */
    foreach($columns as $key => $column){

        $type    = strtoupper(trim($types[$key]));

        $length  = isset($lengths[$key])
            ? trim($lengths[$key])
            : '';

        $default = isset($defaults[$key])
            ? $defaults[$key]
            : '';

        $null = isset($nullValues[$key])
            ? strtoupper(trim($nullValues[$key]))
            : 'NOT NULL';

        /*
        Start building column query
        */
        $columnQuery = "`$column` $type";

        /*
        Add length only to supported types
        */
        if(
            in_array($type, [
                'VARCHAR',
                'CHAR',
                'DECIMAL',
                'FLOAT',
                'DOUBLE'
            ])
            && !empty($length)
        ){

            $columnQuery .= "($length)";
        }

        /*
        Handle primary column
        */
        if($column == $primaryColumn){

            $columnQuery .= " NOT NULL AUTO_INCREMENT";

        }else{

            /*
            Add NULL or NOT NULL
            */
            $columnQuery .= " $null";

            /*
            Add default value if provided
            */
            if($default !== '' && $default !== null){

                /*
                CURRENT_TIMESTAMP should not have quotes
                */
                if(strtoupper($default) == 'CURRENT_TIMESTAMP'){

                    $columnQuery .= " DEFAULT CURRENT_TIMESTAMP";

                }else{

                    $safeDefault = mysqli_real_escape_string(
                        $conn,
                        $default
                    );

                    $columnQuery .= " DEFAULT '$safeDefault'";
                }
            }
        }

        /*
        Save column query
        */
        $queryParts[] = $columnQuery;
    }

    /*
    Add primary key
    */
    $queryParts[] = "PRIMARY KEY (`$primaryColumn`)";

    /*
    Add indexes
    */
    if(!empty($indexes)){

        foreach($indexes as $indexColumn){

            $queryParts[] = "INDEX (`$indexColumn`)";
        }
    }

    /*
    Build final query
    */
    $query = "

        CREATE TABLE IF NOT EXISTS `$tableName` (

            ".implode(", ", $queryParts)."

        )

    ";

    /*
    Execute query
    */
    if(mysqli_query($conn, $query)){

        return true;

    }else{
 //log the errors for debugging
  $error = mysqli_error($conn);
 log_errors("result_tables",$query,$error);

return false; 
   
    }
}

function sortClasses($classes){

    $order = [
        "PRE-SCHOOL"  => 1,
        "PRE-NURSERY" => 2,
        "NURSERY"     => 3,
        "GRADE"       => 4,
        "PRIMARY"     => 5,
        "JSS"         => 6,
        "SS"          => 7,
        "SSS"         => 8
    ];

    usort($classes, function($a, $b) use ($order) {

        $a = strtoupper(trim($a));
        $b = strtoupper(trim($b));

        preg_match('/(PRE-SCHOOL|PRE-NURSERY|NURSERY|GRADE|PRIMARY|JSS|SS|SSS)\s*(\d+)?\s*([A-Z])?/', $a, $aParts);
        preg_match('/(PRE-SCHOOL|PRE-NURSERY|NURSERY|GRADE|PRIMARY|JSS|SS|SSS)\s*(\d+)?\s*([A-Z])?/', $b, $bParts);

        $levelA = $order[$aParts[1] ?? ''] ?? 999;
        $levelB = $order[$bParts[1] ?? ''] ?? 999;

        if ($levelA !== $levelB) {
            return $levelA <=> $levelB;
        }

        $numA = (int)($aParts[2] ?? 0);
        $numB = (int)($bParts[2] ?? 0);

        if ($numA !== $numB) {
            return $numA <=> $numB;
        }

        return ($aParts[3] ?? '') <=> ($bParts[3] ?? '');
    });

    return $classes;
}

function extract_query_string($string){
   
  if(!$string){
  
    return null;  
  }
    
// base (everything before ?)
$base = strtok($string, '?');

// full query
$query = parse_url($string, PHP_URL_QUERY);
// first part after 
$first = strtok($query, '&');

// combine
$result = $base . '?' . $first;

return $result;
    
}

function normalizeClass($class) {
  
    // Trim + uppercase
    $class = strtoupper(trim($class));

    //Replace hyphens with spaces (for parsing)
    $class = str_replace('-', ' ', $class);

    // Remove extra spaces
    $class = preg_replace('/\s+/', ' ', $class);

    //Ensure space between letters and numbers (JSS2 → JSS 2)
    $class = preg_replace('/([A-Z])(\d)/', '$1 $2', $class);

    // Remove space BETWEEN number and arm (2 A → 2A)
    $class = preg_replace('/(\d)\s+([A-Z])/', '$1$2', $class);

   
  // Normalize special case: PRE NURSERY → PRE-NURSERY
if (strpos($class, 'PRE NURSERY') === 0) {
        $class = str_replace('PRE NURSERY', 'PRE-NURSERY', $class);
   }

 elseif (strpos($class, 'PRE-NUR') === 0){
        $class = str_replace('PRE-NUR', 'PRE-NURSERY', $class);
    }
 
 elseif (strpos($class, 'PRE NUR') === 0){
        $class = str_replace('PRE NUR', 'PRE-NURSERY', $class);
    }   
    
    // Normalize special case: PRE SCHOOL → PRE-SCHOOL
     
 elseif(strpos($class, 'PRE SCHOOL') === 0){
      $class = str_replace('PRE SCHOOL', 'PRE-SCHOOL', $class);
    }
    
  // Normalize special case: PRE SCH → PRE-SCHOOL
     
 elseif(strpos($class, 'PRE SCH') === 0) {
        $class = str_replace('PRE SCH', 'PRE-SCHOOL', $class);
    } 
   
   elseif (strpos($class, 'PRE-SCH') === 0){
       $class = str_replace('PRE-SCH', 'PRE-SCHOOL', $class);
    } 
   

    return trim($class);
}

function validateClass($class,$IgnoreValidation=false) {
    // Normalize input
   $class = strtoupper(trim($class));

// Must start with letters
if (!preg_match('/^[A-Z]/', $class)) {
    return false;
}
//must be alpa-numeric
elseif (!preg_match('/^[A-Z0-9\s-]+$/', $class)) {
    return false;
}
else{
 
 // Extract level (letters at the beginning)
preg_match('/^[A-Z-]+/', $class, $levelMatch);
$level = $levelMatch[0] ?? null;

// Extract number
preg_match('/\d+/', $class, $numMatch);
$number = $numMatch[0] ?? null;

// Extract arm (optional)
preg_match('/[A-Z]$/', $class, $armMatch);
$arm = $armMatch[0] ?? null;

 //echo $secondlevel; die;
$max3 = ['SSS','SS','JSS','NURSERY','PRE-NURSERY','PRE-SCHOOL'];
$max6 = ['PRIMARY','GRADE'];
$preClass = ['PRE-NURSERY','PRE-SCHOOL'];

if(in_array($level,$max3)){
  
  if(!$number || $number > 3){
      
  return false;   
      
  }
  else{
    //valid class
  return true;
  }
    
}

elseif(in_array($level,$max6)){
  
if(!$number || $number > 6){
      
  return false;   
      
  }
  else{
      //valid class
      return true;
  }
}   
  else{
  //Unfarmiliar class    
  //new or Unknown pattern
  
  if($IgnoreValidation){
      
  return true;    
  }
  else{
      return false;
   }
  } 
    
 }
}

function generate_sessions(){
    
 $iniYear = 2024;
   $nextYear = $iniYear+1;
  $currentYear = date("Y");
   $diff = $currentYear - $iniYear;
  $sessions = [];
for($i=0; $i<=$diff; $i++){
$session=($iniYear+$i).'/'.($nextYear+$i);

$sessions[] = $session;

}   
 
$current = get_current_session();
$currentSession = $current['session'];

if($currentSession){
    
 // Remove current session if it already exists in the generated sessions
$sessions = array_filter($sessions, fn($s) => $s !== $currentSession);
//Reset index (optional but good practice)
$sessions = array_values($sessions);

// Add current session to the front
array_unshift($sessions, $currentSession);
 
}

 return $sessions;
    
}

function generate_terms($capslock=false){
 
 if($capslock){
     
 $first = "FIRST TERM";
 $second = "SECOND TERM";
 $third = "THIRD TERM";
 
 }
 
 else{
 
 $first = "First Term";
 $second = "Second Term";
 $third = "Third Term";
 
 }
 

return [$first,$second,$third];
    
    
}

function null_check($value,$return){
    
 if(is_null($value)){
     
 return $return;    
     
 }
 elseif(!$value){
  return $return;    
 }
 else{
     
  return $value;   
 }
}

function generatePin($length = 8) {
 $characters = 'ABCDEFGHIJKLMNPQRSTUVWXYZ123456789';
    $pin = '';

    for ($i = 0; $i < $length; $i++) {
        $index = random_int(0, strlen($characters) - 1);
        $pin .= $characters[$index];
    }

    return $pin;
}

function generate_psw($len = 10) {
    if ($len < 1) {
      $len = 10;
    }

    $special = '#@$&';
    $safe_hex = '123456789abcdef'; // removed '0'

    // Step 1: Generate base hex string
    $bytes_needed = ceil($len / 2);
    $base = bin2hex(random_bytes($bytes_needed));

    // Step 2: Remove all '0' characters
    $base = str_replace('0', '', $base);

    // Step 3: Ensure we still have enough length
    while (strlen($base) < $len) {
        $base .= $safe_hex[random_int(0, strlen($safe_hex) - 1)];
    }

    // Step 4: Trim to required length
    $password = substr($base, 0, $len);

    // Step 5: Insert exactly one special character
    $pos = random_int(0, $len - 1);
    $password[$pos] = $special[random_int(0, strlen($special) - 1)];

    // Step 6: Shuffle
    return str_shuffle($password);
}

function get_data_id($conn,$table){
    
  $sql = "SELECT id FROM $table ORDER BY id DESC LIMIT 1"; 
  $result = mysqli_query($conn,$sql);
  
  if($result){
      
  $row = mysqli_fetch_assoc($result); 
  $data_id = $row['id'];
$response = "Query executed successfully"; 
 $data = [
     'data_id' => $data_id,
     'response' => $response
     ];
 
  }
  else{
   $data_id = "";    
   $response = "Error executing query";
  
  $data = [
     'data_id' => $data_id,
     'response' => $response
     ];    
  }
  return $data;  
    
}

function log_admin_action(
    $conn,
    $staff_id,
    $staff_name,
    $action,
    $reason,
    $records = 0,
    $session = null,
    $term = null,
    $backup
){

    $ip = $_SERVER['REMOTE_ADDR'] ?? 'UNKNOWN';

    $user_agent = $_SERVER['HTTP_USER_AGENT'] ?? 'UNKNOWN';

    $session_id = session_id();

    $stmt = mysqli_prepare($conn,"
        INSERT INTO admin_activity_logs(
            staff_id,
            staff_name,
            action_type,
            action_reason,
            records_affected,
            session,
            term,
            ip_address,
            user_agent,
            session_id,
            backup_file
        )
        VALUES(?,?,?,?,?,?,?,?,?,?,?)
    ");

    mysqli_stmt_bind_param(
        $stmt,
        "isssissssss",
        $staff_id,
        $staff_name,
        $action,
        $reason,
        $records,
        $session,
        $term,
        $ip,
        $user_agent,
        $session_id,
        $backup
    );

  return mysqli_stmt_execute($stmt); 
    
}

function backup_results($conn,$session,$term){

$subjectTable = form_table_name("subject_records_",$session);
$resultTable = form_table_name("results_",$session);

    $time = date("Y_m_d_H_i_s");

    $sessionReplace = str_replace("/","",$session);
    $termReplace = strtolower(str_replace(" ","",$term));

    // Save as JSON
    $filename = "results_backup_{$sessionReplace}_{$termReplace}_{$time}.json";

    $path = "backups";
    $filepath = $path . "/" . $filename;

    // Create backup folder if it doesn't exist
    if(!is_dir($path)){
        mkdir($path,0755,true);
    }

    // Tables you want to backup
    $tables = [
        $resultTable,
        $subjectTable
    ];

    $backupData = [];

    foreach($tables as $table){
    
  $sql = "
   SELECT * FROM `$table`
    WHERE term = ?";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param($stmt,"s",$term);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
 
  $rows = [];
 while($row = mysqli_fetch_assoc($result)){
        
    $rows[] = $row;
        }

      // Store using table name as key
        $backupData[$table] = $rows;
    }

    // No data found
    if(empty($backupData)){
        return false;
    }

    // Convert array to formatted JSON
    $json = json_encode(
        $backupData,
        JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
    );

  
    // Save file
if(file_put_contents($filepath,$json) !== false){
 
  // Protect backup folder
    $htaccessFile = rtrim($path, "/") . "/.htaccess";

    $content = "
    # restrict direct access to backup folder
    
    Options -Indexes

   Require all denied
";
  if(!file_exists($htaccessFile)){
        file_put_contents($htaccessFile,$content);
    }
    
    return $filename;  
 }
 else{
  
  return false;    
  }
}

function restore_backup_results($conn,$backupfile){
  
 $data = json_decode(file_get_contents($backupfile), true);

foreach ($data as $table => $rows) {

    if (empty($rows)) {
        continue;
    }

    foreach ($rows as $row) {

        $columns = array_keys($row);
        $values  = array_values($row);

        // Build placeholders (?, ?, ?)
        $placeholders = implode(",", array_fill(0, count($values), "?"));

       // Build SQL safely with backticks for columns
      $sql = "INSERT INTO `$table` (`"
            . implode("`,`", $columns)
            . "`) VALUES ($placeholders)";

      $stmt = mysqli_prepare($conn, $sql);

        if (!$stmt) {
            continue;
        }

        // ALL values treated as strings (safe for restore system)
        $types = str_repeat("s", count($values));

        // Bind values
        mysqli_stmt_bind_param($stmt, $types, ...$values);

        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
  }
 return true;
}

function insert_user_data($data){
 
 /*
 format to supply $data
 
 $data = [
    'conn' => $home_db,
    'table' => 'Users',
    'cols' => [
        'User_id','Last_login','Name'
        ],
    'vals' => [
        $user_id,$date,$name],
    'params' => 'iss',
    
    ];
 
 */
 
 
 $conn = $data['conn'];
 $table = $data['table'];
 $cols = $data['cols'];
 $vals = $data['vals'];
 $param = $data['params'];
 $params = str_split($param);
 
 if(empty($conn)){
  
   $feedback = [
     'status' => 'Failed',
     'message' => 'Failed to insert data',
     'error' => 'Database connections was not supplied',
     ];       
     
     
 }
 else{
     
  if(empty($table)){
      
    $feedback = [
     'status' => 'Failed',
     'message' => 'Failed to insert data',
     'error' => 'Database Table was not supplied',
         ];     
      
  }
  else{
      
 if(is_array($cols)){
 if(count($cols) != count($vals)){
     
 $feedback = [
     'status' => 'Failed',
     'message' => 'Failed to insert data',
     'error' => 'The Number of supplied columns is not equal to the number of supplied  values',
     
     ];    
     
 }
 elseif(count($vals) != count($params)){
     
  $feedback = [
     'status' => 'Failed',
     'message' => 'Failed to insert data',
     'error' => 'The Number of supplied params is not equal to the number of supplied  values',
     
     ];        
     
 }
 else{
    // insert only the first column first
 $col1 = $cols[0];
 $val1 = $vals[0];
 $param1 = $params[0];
  
 $sql = "INSERT INTO $table($col1) VALUES(?)"; 
 $stmt = mysqli_stmt_init($conn);
 if(!mysqli_stmt_prepare($stmt,$sql)){
     
   $feedback = [
     'status' => 'Failed',
     'message' => 'Failed to insert data',
     'error' => mysqli_stmt_error($stmt)
     
     ];
     
 }
 else{
     
     mysqli_stmt_bind_param($stmt,$param1,$val1);
     mysqli_stmt_execute($stmt);
     
   //insert the remaining data as update  
  $id_col = 'id';
  $id_param = 'i';
  $id = get_data_id($conn,$table);
  $id_val = $id['data_id'];
  $response = $id['response'];
  
  if(empty($id_val)){
      
   $feedback = [
     'status' => 'Failed',
     'message' => 'Failed to update data',
     'error' => $response,
     
     ];            
      
  }
  else{
  
  for($i = 1; $i < count($cols); $i++){
      
    $col = $cols[$i];
    $col_val = $vals[$i];
    $param = $params[$i].$id_param;
     
  update_user_data($conn,$table,$col,$id_col,$col_val,$id_val,$param);  
  
  }
  
   $feedback = [
     'status' => 'success',
     'message' => 'Data inserted successfully',
     'error' => 'No errors',
     'data_id' => $id_val,
     ];       
   
   }
 }
  
 }
 
 }
 else{
     
 $sql = "INSERT INTO $table($cols) VALUES(?)"; 
 $stmt = mysqli_stmt_init($conn);
 if(!mysqli_stmt_prepare($stmt,$sql)){
     
   $feedback = [
     'status' => 'Failed',
     'message' => 'Failed to insert data',
     'error' => mysqli_stmt_error($stmt)
     
     ];
     
 }
 else{
     
     mysqli_stmt_bind_param($stmt,$param,$vals);
     mysqli_stmt_execute($stmt);
     
     
     $feedback = [
     'status' => 'success',
     'message' => 'Data inserted successfully',
     'error' => 'No errors',
     
     ];   
  }
 }  
 
  }
 }

 return $feedback;
}

function collect_user_data($conn,$table,$col,$data,$datatype){
//uses 1 search fields, std_id

$sql = "SELECT * FROM $table WHERE $col=? limit 1";
  
 $stmt = mysqli_stmt_init($conn);
 if(!mysqli_stmt_prepare($stmt, $sql)) {
     
die("Error : ".mysqli_stmt_error($stmt));      
  }
  else {

 mysqli_stmt_bind_param($stmt, $datatype,$data);
 mysqli_stmt_execute($stmt);
 $result = mysqli_stmt_get_result($stmt);
 $user_data = mysqli_fetch_assoc($result);
 if($user_data){
 return $user_data;
 }
}
}

function collect_user_data2($conn,$table,$col1,$col2,$col1_value,$col2_value,$param){

//uses 2 search fields, std_id,  ,subject

$sql = "SELECT * FROM $table WHERE $col1=? AND $col2=? limit 1";
  
 $stmt = mysqli_stmt_init($conn);
 if(!mysqli_stmt_prepare($stmt, $sql)) {
     
die("Error : ".mysqli_stmt_error($stmt));      
  }
  else {

 mysqli_stmt_bind_param($stmt, $param, $col1_value, $col2_value);
 mysqli_stmt_execute($stmt);
 $result = mysqli_stmt_get_result($stmt);
 $user_data = mysqli_fetch_assoc($result);
 if($user_data){
 return $user_data;
 }
}
}

function collect_user_data3($conn,$table,$col1,$col2, $col3,$col1_value,$col2_value,$col3_value,$param){

//uses 3 search fields, std_id, std_id ,subject

$sql = "SELECT * FROM $table WHERE $col1=? AND $col2=? AND $col3=? limit 1";
  
 $stmt = mysqli_stmt_init($conn);
 if(!mysqli_stmt_prepare($stmt, $sql)) {
     
die("Error : ".mysqli_stmt_error($stmt));      
  }
  else {

 mysqli_stmt_bind_param($stmt, $param, $col1_value, $col2_value,$col3_value);
 mysqli_stmt_execute($stmt);
 $result = mysqli_stmt_get_result($stmt);
 $user_data = mysqli_fetch_assoc($result);
 if($user_data){
 return $user_data;
 }
}
}

function collect_user_data4($conn,$table,$col1,$col2, $col3,$col4, $col1_value,$col2_value,$col3_value,$col4_value,$param){

//uses 4 search fields

$sql = "SELECT * FROM $table WHERE $col1=? AND $col2=? AND $col3=? AND $col4=? limit 1";
  
 $stmt = mysqli_stmt_init($conn);
 if(!mysqli_stmt_prepare($stmt, $sql)) {
     
die("Error : ".mysqli_stmt_error($stmt));      
  }
  else {

 mysqli_stmt_bind_param($stmt, $param, $col1_value, $col2_value,$col3_value,$col4_value);
 mysqli_stmt_execute($stmt);
 $result = mysqli_stmt_get_result($stmt);
 $user_data = mysqli_fetch_assoc($result);
 if($user_data){
 return $user_data;
 }
}
}

function check_staff_login($conn){

if(isset($_SESSION["std_id"])){
    
 unset($_SESSION["std_id"]);  
    
}
  
if(isset($_SESSION["std_cat"])){
    
 unset($_SESSION["std_cat"]);  
    
}

 $allowed = ['Active','Expired'];
 if(isset($_SESSION['staff_id'])){

	$id =$_SESSION['staff_id'];
	
if(check_exist($conn,"staffs","staff_id",$id,"i")){
  
 $det = collect_user_data($conn,'staffs','staff_id',$id,'i');
$status = $det["status"];

if(in_array($status,$allowed)){
    
 return true;    
}
else{
    
 setcookie('staff_cookie','',time()-(100), '/');
session_destroy();
    return false;   
  }  
 }
    else{
setcookie('staff_cookie','',time()-(100), '/');
session_destroy();
    return false;
    }
  }
     //check for cookie
elseif(isset($_COOKIE['staff_cookie'])){

 $cookie = $_COOKIE['staff_cookie'];
  $parts = explode('::',$cookie);
  $token_key = $parts[0];
  $token_value = $parts[1];
 

 $token = collect_user_data($conn,'staffs','token_key',$token_key,'s');

 
 if(password_verify($token_value,$token['token_value'])){

$status = $token["status"];

if(in_array($status,$allowed)){
  
   $_SESSION['staff_id'] = $token['staff_id'];
$_SESSION['staff_cat'] = $token['staff_cat'];

 
date_default_timezone_set('Africa/Lagos');
 $day = date("d/m/Y h:i A");
 update_user_data($conn,'staffs','lastlogin','staff_id',$day,$token['staff_id'],'si'); 
  
    return true;      
    
}
else{
 // acct Status not Active   
 setcookie('staff_cookie','',time()-(100), '/');
 
   return false;   
    
  }
 }
else{
 //password_verify is false   
setcookie('staff_cookie','',time()-(100), '/');

   return false;    
 } 
 
}
  
 else {
    //both session and cookie are not set
 
   return false;
   }
   
   
 }

function count_user_data($conn,$table,$col1,$col1_value,$param){
 
 //1 search fields
   $sql= "SELECT * FROM $table WHERE $col1=?";
 $stmt = mysqli_stmt_init($conn);
 if(!mysqli_stmt_prepare($stmt, $sql)) {
      
     die("Error :".mysqli_stmt_error($stmt));      
      }
    else {
 mysqli_stmt_bind_param($stmt, $param,$col1_value);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
   $result = mysqli_stmt_num_rows($stmt);

return $result;

  }   
}

function count_user_data2($conn,$table,$col1,$col2,$col1_value,$col2_value,$param){
 
 //2 search fields
   $sql= "SELECT * FROM $table WHERE $col1=? AND $col2=?";
 $stmt = mysqli_stmt_init($conn);
 if(!mysqli_stmt_prepare($stmt, $sql)) {
      
     die("Error :".mysqli_stmt_error($stmt));      
      }
    else {
 mysqli_stmt_bind_param($stmt, $param,$col1_value, $col2_value);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
   $result = mysqli_stmt_num_rows($stmt);

return $result;

  }   
}

function count_user_data3($conn,$table,$col1,$col2,$col3,$col1_value,$col2_value,$col3_value,$param){
 
 //2 search fields
   $sql= "SELECT * FROM $table WHERE $col1=? AND $col2=? AND $col3=?";
 $stmt = mysqli_stmt_init($conn);
 if(!mysqli_stmt_prepare($stmt, $sql)) {
      
     die("Error :".mysqli_stmt_error($stmt));      
      }
    else {
 mysqli_stmt_bind_param($stmt, $param,$col1_value, $col2_value,$col3_value);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
   $result = mysqli_stmt_num_rows($stmt);

return $result;

  }   
}
function check_exist($conn,$table,$col,$data,$datatype){
   $sql= "select * from $table where $col =? limit 1";
 $stmt = mysqli_stmt_init($conn);
 if(!mysqli_stmt_prepare($stmt, $sql)) {
      
     die("Error :".mysqli_stmt_error($stmt));      
      }
    else {
    mysqli_stmt_bind_param($stmt, $datatype,$data);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    $result = mysqli_stmt_num_rows($stmt);
    if($result > 0){
    return true;
}
else {
    return false;
   }
  }
}

function check_exist2($conn, $table, $col1, $col2, $col1_value, $col2_value, $param){
//2 search fields
   $sql= "SELECT * FROM $table WHERE $col1=? AND $col2=? limit 1";
 $stmt = mysqli_stmt_init($conn);
 if(!mysqli_stmt_prepare($stmt, $sql)) {
      
     die("Error :".mysqli_stmt_error($stmt));      
      }
    else {
 mysqli_stmt_bind_param($stmt, $param,$col1_value, $col2_value);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    $result = mysqli_stmt_num_rows($stmt);
    if($result > 0){
    return true;
}
else {
    return false;
   }
  }
}

function check_exist3($conn, $table, $col1, $col2, $col3, $col1_value, $col2_value, $col3_value, $param){
//3 search fields
   $sql= "SELECT * FROM $table WHERE $col1=? AND $col2=? AND $col3=? limit 1";
 $stmt = mysqli_stmt_init($conn);
 if(!mysqli_stmt_prepare($stmt, $sql)) {
      
     die("Error :".mysqli_stmt_error($stmt));      
      }
    else {
 mysqli_stmt_bind_param($stmt, $param,$col1_value, $col2_value, $col3_value);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    $result = mysqli_stmt_num_rows($stmt);
    if($result > 0){
    return true;
}
else {
    return false;
   }
  }
}

function check_exist4($conn, $table, $col1, $col2, $col3, $col4, $col1_value, $col2_value, $col3_value, $col4_value, $param){
//4 search fields
   $sql= "SELECT * FROM $table WHERE $col1=? AND $col2=? AND $col3=? AND $col4=? limit 1";
 $stmt = mysqli_stmt_init($conn);
 if(!mysqli_stmt_prepare($stmt, $sql)) {
      
     die("Error :".mysqli_stmt_error($stmt));      
      }
    else {
 mysqli_stmt_bind_param($stmt, $param,$col1_value, $col2_value, $col3_value, $col4_value);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    $result = mysqli_stmt_num_rows($stmt);
    if($result > 0){
    return true;
}
else {
    return false;
   }
  }
}

function delete_user_data($conn, $table, $id_col, $id_value, $param){
//this function deletes data using 1 search field, the param is just one for the id value.
    
  $sql = "DELETE FROM $table WHERE $id_col =?";
 $stmt = mysqli_stmt_init($conn);
 if(!mysqli_stmt_prepare($stmt, $sql)){
 die("Error: ".mysqli_stmt_error($stmt));
 }
 else{
mysqli_stmt_bind_param($stmt, $param, $id_value);

if(mysqli_stmt_execute($stmt)){

return true;
}
else{
    return false;
}
 
 }  
    
}

function delete_user_data2($conn, $table, $col1, $col2, $col1_value, $col2_value, $param){
//this function deletes data using 2 search fields, the param is 2.
    
  $sql = "DELETE FROM $table WHERE $col1=? AND $col2=?";
 $stmt = mysqli_stmt_init($conn);
 if(!mysqli_stmt_prepare($stmt, $sql)){
 die("Error: ".mysqli_stmt_error($stmt));
 }
 else{
mysqli_stmt_bind_param($stmt, $param, $col1_value,$col2_value);

if(mysqli_stmt_execute($stmt)){
    
    return true;
}
else{
    return false;
  }
 
 }  
    
}

function delete_user_data3($conn, $table, $col1, $col2, $col3, $col1_value, $col2_value, $col3_value, $param){
//this function deletes data using 3 search fields, the param is 3.
    
  $sql = "DELETE FROM $table WHERE $col1=? AND $col2=? AND $col3=?";
 $stmt = mysqli_stmt_init($conn);
 if(!mysqli_stmt_prepare($stmt, $sql)){
 die("Error: ".mysqli_stmt_error($stmt));
 }
 else{
mysqli_stmt_bind_param($stmt, $param, $col1_value,$col2_value,$col3_value);

if(mysqli_stmt_execute($stmt)){
    return true;
}
 else{
     return false;
 }
 }  
    
}


function delete_user_data4($conn, $table, $col1, $col2, $col3, $col4, $col1_value, $col2_value, $col3_value,  $col4_value, $param){
//this function deletes data using 4 search fields, the param is 4.
    
 $sql = "DELETE FROM $table WHERE $col1=? AND $col2=? AND $col3=? AND $col4=?";
 $stmt = mysqli_stmt_init($conn);
 if(!mysqli_stmt_prepare($stmt, $sql)){
 die("Error: ".mysqli_stmt_error($stmt));

 }
 else{
mysqli_stmt_bind_param($stmt, $param, $col1_value,$col2_value,$col3_value,$col4_value);

mysqli_stmt_execute($stmt);

if (mysqli_stmt_affected_rows($stmt) > 0) {
    return true; // rows deleted
} 

else {
    return false; // no matching rows
    }
  
 }  
    
}



function update_user_data($conn, $table, $upd_col, $id_col , $upd_value, $id_value,$param){
    
//this function is meant to update the database using one search field, the $param must be two values, one for the update you want to make and the other for the id field. (e.g si or ii because id is integer except for only students id that is string (s))
    
 $sql = "UPDATE $table SET $upd_col =? WHERE $id_col =?";
  $stmt = mysqli_stmt_init($conn);
 if(!mysqli_stmt_prepare($stmt, $sql)){
die("Error: ".mysqli_stmt_error($stmt));  
 }
 else{
mysqli_stmt_bind_param($stmt, $param,
 $upd_value, $id_value);

if(mysqli_stmt_execute($stmt)){
    return true;
}

else{
    return false;
  }
 }
}

function update_user_data2($conn,$table,$upd_col,$col1,$col2,$upd_value,$col1_value,$col2_value,$param){
 // this function update 1 value in the database using 2 search fields
 
  $sql = "UPDATE $table SET $upd_col =? WHERE $col1 =? AND $col2 =?";
  $stmt = mysqli_stmt_init($conn);
 if(!mysqli_stmt_prepare($stmt, $sql)){
die("Error: ".mysqli_stmt_error($stmt));  
 }
 else{
mysqli_stmt_bind_param($stmt, $param,
 $upd_value, $col1_value,$col2_value);

if(mysqli_stmt_execute($stmt)){
  
  return true;  
}
else{
    return false;
    
  }
 }
}

function update_user_data3($conn,$table,$upd_col,$col1,$col2,$col3,$upd_value,$col1_value,$col2_value,$col3_value,$param){
 // this function update 1 value in the database using 3 search fields
 
  $sql = "UPDATE $table SET $upd_col =? WHERE $col1 =? AND $col2 =? AND $col3=?";
  $stmt = mysqli_stmt_init($conn);
 if(!mysqli_stmt_prepare($stmt, $sql)){
die("Error: ".mysqli_stmt_error($stmt));  
 }
 else{
mysqli_stmt_bind_param($stmt, $param,
 $upd_value, $col1_value,$col2_value,$col3_value);
if(mysqli_stmt_execute($stmt)){
    
    return true;
} 
  else{
      return false;
  }  
 }
}

function update_user_data4($conn,$table,$upd_col,$col1,$col2,$col3,$col4,$upd_value,$col1_value,$col2_value,$col3_value,$col4_value,$param){
 // this function update 1 value in the database using 3 search fields
 
  $sql = "UPDATE $table SET $upd_col =? WHERE $col1 =? AND $col2 =? AND $col3=? AND $col4=?";
  $stmt = mysqli_stmt_init($conn);
 if(!mysqli_stmt_prepare($stmt, $sql)){
die("Error: ".mysqli_stmt_error($stmt));  
 }
 else{
mysqli_stmt_bind_param($stmt, $param,
 $upd_value, $col1_value,$col2_value,$col3_value,$col4_value);
if(mysqli_stmt_execute($stmt)){
    
    return true;
} 
  else{
      return false;
  }  
 }
}

function collect_table_data($conn, $table,$order=null,$all=null,$limit=null){
// This function collect all data in a table without condition and also checks if a table has any value at all or not

if(!$order){
//use descending order
$order = "id DESC";
}

if($order == "DESC" || $order == "ASC"){
    
  $order = "id $order";  
}

 if(!$all){
    $all = "*";
}
 
 $sql = "SELECT $all FROM $table ORDER BY $order";   
 
 if($limit){
     
 $sql.= " limit $limit";   
 } 
  
 $result  = mysqli_query($conn, $sql);
 $num_row = mysqli_num_rows($result);

$data = [];

if($num_row > 0){
  while($row = mysqli_fetch_assoc($result)){
 
 if($all == "*"){
     
     $data[] = $row;   
     
 }
 else{
    
 if(!in_array($row[$all],$data)){
        
    $data[] = $row[$all];   
          
    }
       
   }
    
  } 
}
 return $data;
}

function collect_table_data1($conn,$table,$col1,$col1_value,$param,$order=null,$all=null,$limit=null){
// This function collect all data in a table with 1 conditions

$order = null_check($order,"id DESC");
$all = null_check($all,"*");

if($order == "DESC" || $order == "ASC"){
  $order = "id $order";  
}
 
 $sql = "SELECT $all FROM $table WHERE $col1=? ORDER BY $order";   
 
 if($limit){
     
 $sql.= " limit $limit";   
 }
 
 
 $stmt = mysqli_stmt_init($conn);
 if(!mysqli_stmt_prepare($stmt,$sql)){
     
  die("Sql Error: ".mysqli_stmt_error($stmt));   
  $data = [];
   
 }
 else{
  
 mysqli_stmt_bind_param($stmt,$param,$col1_value);
 mysqli_stmt_execute($stmt);
     
 $result  = mysqli_stmt_get_result($stmt);
$data = [];
 while($row = mysqli_fetch_assoc($result)){
 
 if($all == "*"){
   
     $data[] = $row;   
     
 }
 else{
 
 if(!in_array($row[$all],$data)){
        
    $data[] = $row[$all];   
          
    }
       
   }
    
  } 

}

 return $data;
}

function collect_table_data2($conn,$table,$col1,$col2,$col1_value,$col2_value,$param,$order=null,$all=null,$limit=null){
// This function collect all data in a table with two conditions

$order = null_check($order,"id DESC");
$all = null_check($all,"*");
if($order == "DESC" || $order == "ASC"){
  $order = "id $order";  
}
 
 $sql = "SELECT $all FROM $table WHERE $col1=? AND $col2=? ORDER BY $order";   
 if($limit){
     
 $sql.= " limit $limit";   
 }
 
 $stmt = mysqli_stmt_init($conn);
 if(!mysqli_stmt_prepare($stmt,$sql)){
     
  die("Sql Error: ".mysqli_stmt_error($stmt));   
  $data = [];
   
 }
 else{
  
 mysqli_stmt_bind_param($stmt,$param,$col1_value,$col2_value);
 mysqli_stmt_execute($stmt);
     
 $result  = mysqli_stmt_get_result($stmt);
$data = [];
 while($row = mysqli_fetch_assoc($result)){
 
 if($all == "*"){
   
     $data[] = $row;   
     
 }
 else{
 
 if(!in_array($row[$all],$data)){
        
    $data[] = $row[$all];   
          
    }
       
   }
    
  } 

}

 return $data;
}

function collect_table_data3($conn,$table,$col1,$col2,$col3,$col1_value,$col2_value,$col3_value,$param,$order=null,$all=null,$limit=null){
// This function collect all data in a table with 3 conditions

$order = null_check($order,"id DESC");
$all = null_check($all,"*");
if($order == "DESC" || $order == "ASC"){
  $order = "id $order";  
}

 $sql = "SELECT $all FROM $table WHERE $col1=? AND $col2=? AND $col3=? ORDER BY $order";   
 
 if($limit){
     
 $sql.= " limit $limit";   
 }
 
 $stmt = mysqli_stmt_init($conn);
 if(!mysqli_stmt_prepare($stmt,$sql)){
     
  die("Sql Error: ".mysqli_stmt_error($stmt));   
  $data = [];
   
 }
 else{
  
mysqli_stmt_bind_param($stmt,$param,$col1_value,$col2_value,$col3_value);
 mysqli_stmt_execute($stmt);
     
 $result  = mysqli_stmt_get_result($stmt);
$data = [];
 while($row = mysqli_fetch_assoc($result)){
 
 if($all == "*"){
   
     $data[] = $row;   
     
 }
 else{
 
 if(!in_array($row[$all],$data)){
        
    $data[] = $row[$all];   
          
    }
       
   }
    
  } 

}

 return $data;
}

function collect_table_data4($conn,$table,$col1,$col2,$col3,$col4,$col1_value,$col2_value,$col3_value,$col4_value,$param,$order=null,$all=null,$limit=null){
// This function collect all data in a table with 4 conditions


$order = null_check($order,"id DESC");
$all = null_check($all,"*");

if($order == "DESC" || $order == "ASC"){
  $order = "id $order";  
}
 
 $sql = "SELECT $all FROM $table WHERE $col1=? AND $col2=? AND $col3=? AND $col4=? ORDER BY $order";   
 
 if($limit){
     
 $sql.= " limit $limit";   
 }
 
 $stmt = mysqli_stmt_init($conn);
 if(!mysqli_stmt_prepare($stmt,$sql)){
     
  die("Sql Error: ".mysqli_stmt_error($stmt));   
  $data = [];
   
 }
 else{
  
mysqli_stmt_bind_param($stmt,$param,$col1_value,$col2_value,$col3_value,$col4_value);
 mysqli_stmt_execute($stmt);
     
 $result  = mysqli_stmt_get_result($stmt);
$data = [];
 while($row = mysqli_fetch_assoc($result)){
 
 if($all == "*"){
   
     $data[] = $row;   
     
 }
 else{
 
 if(!in_array($row[$all],$data)){
        
    $data[] = $row[$all];   
          
    }
       
   }
    
  } 

}

 return $data;
}

function count_table_data($conn, $table){
// This function collect all data in a table without condition and also checks if a table has any value at all or not
$table = trim($table);
$sql = "SELECT * FROM $table";
 
 $result  = mysqli_query($conn, $sql);
 $num_rows = mysqli_num_rows($result);

return $num_rows;
    
}
function generate_id($len){

    $num = rand(1,9);
    
   if($len < 4){
        $len = 4;
   }
    for($i=1; $i < $len; $i++){
        $num.= rand(0,9);
    }
  
    return $num;
}

function result_grades($total,$prefix=null){
   
  if($prefix == "None"){
      
  if($total >=0 && $total<40){
        $grade= 'F';
        $remark = "Poor";
    }
    elseif($total >=40 && $total<45){
        $grade= 'E';
        $remark = "Fair"; 
    }
    elseif($total >=45 && $total<50){
        $grade= 'D';
        $remark = "Pass";
    }
    elseif($total >=50 && $total<55){
        $grade= 'C';
        $remark = "Credit";
    }
    elseif($total >=55 && $total<60){
        $grade= 'C';
        $remark = "Credit";
    }
    elseif($total >=60 && $total<65){
        $grade= 'C';
        $remark = "Good";
    }
    elseif($total >=65 && $total<70){
        $grade= 'B';
        $remark = "Good";
    }
    elseif($total >=70 && $total<75){
        $grade= 'B';
        $remark = "Very Good";
    }
    elseif($total >=75 && $total<=100){
        $grade= 'A';
        $remark = "Excellent";
    }
    else{
     $grade = null;
     $remark = null;
    }
      
      
  }
  else{
      
      
  if($total >=0 && $total<40){
        $grade= 'F9';
         $remark = "Poor";
    }
    elseif($total >=40 && $total<45){
        $grade= 'E8';
         $remark = "Fair";
    }
    elseif($total >=45 && $total<50){
        $grade= 'D7';
        $remark = "Pass";
    }
    elseif($total >=50 && $total<55){
        $grade= 'C6';
        $remark = "Lower Credit";
    }
    elseif($total >=55 && $total<60){
        $grade= 'C5';
        $remark = "Credit";
    }
    elseif($total >=60 && $total<65){
        $grade= 'C4';
        $remark = "Upper Credit";
    }
    elseif($total >=65 && $total<70){
        $grade= 'B3';
        $remark = "Good";
    }
    elseif($total >=70 && $total<75){
        $grade= 'B2';
        $remark = "Very Good";
    }
    elseif($total >=75 && $total<=100){
        $grade= 'A1';
        $remark = "Excellent";
    }
    else{
      
       $grade= null;
        $remark = null;   
        
    }
      
  }
    
    $GradeRemark = [
        "grade" => $grade,
        "remark" => $remark,
        ];
    
    return $GradeRemark;
}

function sec_to_time($seconds) {
$days = floor($seconds/86400);
$hours = floor(($seconds % 86400)/3600);
$minutes = floor((($seconds % 86400)%3600) /60);
$remainingSeconds = $seconds % 60;

 
 if($days){
     
 return $days . 'days '. $hours . 'hr ' . $minutes . 'm and ' . $remainingSeconds . 's';
     
 }
 
 elseif($hours){
     
 return  $hours . 'hr ' . $minutes . 'm and ' . $remainingSeconds . 's';
    
     
 }
 
elseif($minutes){
     
 return  $minutes . 'm and ' . $remainingSeconds . 's';
    
 } 
 else{
     
  return $remainingSeconds . 's';   
     
 }
 
}

function mailing_list($user_email,$mailing,$reasons){
 global $conn;
 
 $check_email = check_exist($conn,'mailing_list','email',$user_email,'s');
 
 if($mailing == "Subscribe"){
 
 if($check_email == true){
  // email exist but might not be Subscribed, so we update it to Subscribe
  
  update_user_data($conn,'mailing_list','mailing','email',$mailing,$user_email,'ss');  
  
  update_user_data($conn,'mailing_list','reasons','email',$reasons,$user_email,'ss');  
  
     
  $report = "email Subscribed successfully";   
     
 }
 else{
  // email does not exist, enter new record for Subscription 
  $data = [
    'conn' => $conn,
    'table' => 'mailing_list',
    'cols' => [
        'email','mailing','reasons'
        ],
    'vals' => [
        $user_email,$mailing,$reasons],
    'params' => 'sss',
    
    ];    

$insert = insert_user_data($data); 
   
$report = "email Subscribed successfully";  
     
  }
 }
 elseif($mailing == "Unsubscribe"){
  
 if($check_email == true){
 // email exist and user wants  to Unsubscribe
 
  $email_det = collect_user_data($conn,'mailing_list','email',$user_email,'s');
 
 $stat = $email_det['mailing'];
 
 if($stat == $mailing){
// email exist but not subscribed before     
$report = "The email $user_email exist on our mailing list but not subscribed";       
 }
 else{
  // email exist and subscribed, Unsubscribe enail
  
  update_user_data($conn,'mailing_list','mailing','email',$mailing,$user_email,'ss');  
 
 update_user_data($conn,'mailing_list','reasons','email',$reasons,$user_email,'ss'); 
     
  $report = "The email $user_email has been unsubscribed successfully";       
     
 }
  
 }   
 else{
     
 $report = "The email $user_email does not exist on our mailing list";       
  }  
    
 } 
else{
    
  $report = "Unknown Request";     
}

 return $report;

} 
  
function isValidAndReachableUrl($url) {
    // Step 1: Validate URL format
    if (!filter_var($url, FILTER_VALIDATE_URL)) {
        return false;
    }

    // Step 2: Use cURL to check if the URL is reachable
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_NOBODY, true); // We only care about the response status
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // Follow redirects
    curl_setopt($ch, CURLOPT_TIMEOUT, 10); // Set timeout
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Optional: skip SSL verification

    curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    return ($httpCode >= 200 && $httpCode < 400); // Accept 2xx and 3xx responses
}

function verify_email($home_db,$conn,$email,$signup){

$stdCats = collect_table_data($conn,"staffs","","staff_cat");
$adminCats = collect_table_data($home_db,"admins","","admin_cat");
$adminCats[] = "admin";
$adminCats[] = "Developer";
 
    
if(in_array($signup,$adminCats)){
      $table = "admins";
     $conn = $home_db;
  }
  elseif(in_array($signup,$stdCats)){
      $table = "staffs";
      $conn = $conn;
  } 
  else{
      
  $response = [
     "status" => "failed",
     "error" => "Unknown_signup_category",
      "message" => "Unknown Signup Category"
      ];
    return $response;
      
  }
 if(check_exist($conn,$table,'email',$email,'s')){

 $email_det = collect_user_data($conn,$table,'email',$email,'s');
$name = $email_det["surname"]."\n".$email_det["othernames"];

$psw = uniqid();

if(!$psw){
    
 $id = generate_id(6);
 $sur = strtolower($email_det["surname"]);
 $prefix = '@webdevhub';
   
   $psw = $sur.$id.$prefix;
}

$psw_hash = password_hash($psw, PASSWORD_DEFAULT);

if($email_det["Status"] == "Pending"){
    
  update_user_data($conn,$table,"Status","email","Active",$email,"ss");  
 
  update_user_data($conn,$table,"Reasons","email","Account verified",$email,"ss");  
    
  update_user_data($conn,$table,"Password","email",$psw_hash,$email,"ss");
  
  $response = [
      "status" => "success",
      "error" => "None",
      "message" => "Your email has been verified successfully ✓",
      "user_name" => $name,
      "user_psw" => $psw,
      "msg_report" => "New $signup Signup Verified successfully ✓",
     "report" => "success",
      ];   
    
}
else{
       
  $response = [
      "status" => "success",
      "error" => "Double-Verification",
      "message" => " This email is already verified for $signup Account",
     "msg_report" => "email already Verified, Please login",
     "report" => "success",
      ];   
    
  }
     
 }
 else{
   
   $response = [
      "status" => "failed",
      "error" => "Invalid email",
      "message" => "This email is not registered on this site, Please use the signup button to register afresh",
      "msg_report" => "failed to verify New $signup",
     "report" => "failed",
      ];  
     
     
 }
 
return $response;
}

function phrase_contains($phrase, $word) {
   $phrase = trim($phrase);
   
    if (!$phrase || $word === null) {
        return false;
    }

    // Case 1: Check for at least one normal space
    if ($word === " ") {
        return strpos($phrase, " ") !== false;
    }

    // Case 2: Check for multiple spaces, tabs, or special characters
    if ($word === "xspacechar") {
        // Matches:
        //   - 2 or more spaces
        //   - tabs
        //   - any non-alphanumeric character (excluding single normal space)
        return preg_match('/(\s{2,}|\t|[^a-zA-Z0-9 ])/u', $phrase) === 1;
    }

    // Case 3: Normal whole-word, case-insensitive search
    return preg_match('/\b' . preg_quote($word, '/') . '\b/i', $phrase) === 1;
}

function check_numeric_data($dataArray){
  
   global $NumericField;
  
  if(is_array($dataArray)){
      
   $fields = $dataArray["fields"];
   $values = $dataArray["values"];
     
   foreach ($values as $value){
   
    if(!is_numeric($value)){
        
    $valueIndex = array_search($value,$values);   
    $field = $fields[$valueIndex];    
     $NumericField = $field;
     
     return false;
     }   
    } 
  
  //all values are numeric 
   return true;   
  }
  else{
 
 if(is_numeric($dataArray)){
     
  return true;   
     
 }
 else{
       
     return false;
 }
      
  }
}

function get_user_name($userId=null,$userCat=null){

 global $conn;
 $fetchdgn = false;
 $dgn = "";
 
 if(!$userId && !$userCat){
 // both parameters are not passed
 
  if(isset($_SESSION["staff_id"])){

  $userId = $_SESSION["staff_id"];
  $table = "staffs";
  $idcol = "staff_id";
  $catcol = "staff_cat"; 
  $prfcol = "profile";
  $param = "i";
  $prfDir = "/images/staff";
   $fetchIdcol = "staff_id";
   $emailcol = "email";
   $numcol = "number";
 }
elseif(isset($_SESSION["std_id"])){

  $userId = $_SESSION["std_id"];
  $table = "students";
  $idcol = "std_id";
  $catcol = "std_cat"; 
  $prfcol = "profile";
  $param = "i";
  $prfDir = "/images/students";
   $fetchIdcol = "std_id";
   $emailcol = "parent_email";
   $numcol = "parent_number";
 }
 else{
     
  $conn = "";
  $userId = "";
  $table = "";
  $idcol = "";
   
   }   
 }
 
 elseif($userId && !$userCat){
     
   // only one of them was sent 1st one 
  //determine the nature of $userId   
   
 if(filter_var($userId, FILTER_VALIDATE_EMAIL)){
  // passed value is email    

 if(check_exist($conn,"staffs","email",$userId,"s")){
  
  $table = "staffs";
  $idcol = "email";
  $catcol = "staff_cat"; 
  $prfcol = "profile";
  $param = "s";
   $prfDir = "/images/staff";
    $fetchIdcol = "staff_id";
    $emailcol = "email";
   $numcol = "number";
  }
 else{
    //std dont have email 
  $conn = "";
  $userId = "";
  $table = "";
  $idcol = "";
    
   } 
  
  }
 elseif(is_numeric($userId)){
 //$userId is either std_id or staff_id   
 
 if(check_exist($conn,"staffs","staff_id",$userId,"i")){
      
  $table = "staffs";
  $idcol = "staff_id";
  $catcol = "staff_cat"; 
  $prfcol = "profile";
  $param = "i";
   $prfDir = "/images/staff";
    $fetchIdcol = "staff_id";
    $emailcol = "email";
   $numcol = "number";
  }
  
  elseif(check_exist($conn,"students","std_id",$userId,"i")){
      
  $table = "students";
  $idcol = "std_id";
  $catcol = "std_cat"; 
  $prfcol = "profile";
  $param = "i";
  $prfDir = "/images/students";
  $fetchIdcol = "std_id";
  $emailcol = "parent_email";
   $numcol = "parent_number";
  }
   else{
  $conn = "";
  $userId = "";
  $table = "";
  $idcol = "";
    
   } 

 } 
 
 else{

//Unknown_user_category
 $conn = "";
  $userId = "";
  $table = "";
  $idcol = "";
   
  }    
     
 }
 
 else{
 //$userId & $userCat was passed   

 $staffCats = collect_table_data($conn,"staffs","","staff_cat");

 if(in_array($userCat,$staffCats)){
  
   if(filter_var($userId, FILTER_VALIDATE_EMAIL)){
  // $userId is email, set param to s  
    $param = "s";
    $idcol = "email"; //same for both db
     
 }
 
 else{
  //$userId is not email, set param to i  
    $param = "i";
    $idcol = "staff_id"; //for era db 
    
 }
  
  $table = "staffs";
  $catcol = "staff_cat";  
  $prfcol = "profile";
  $prfDir = "/images/staff";
   $fetchIdcol = "staff_id";
   $emailcol = "email";
   $numcol = "number";
 }
    
 else{
  //Unknown_user_category   
  
  $conn = "";
  $userId = "";
  $table = "";
  $idcol = "";
  $catcol = "";
   
  }
 }
 
 

 $userName = [];
 if($userId && $conn){
 
 $userDet = collect_user_data($conn,$table,$idcol,$userId,$param);
 if($userDet){
 
 $lastlogin=timeAgo($userDet["lastlogin"],'d/m/Y h:i A');
  if(!$lastlogin){
    if($table == "students"){
    $lastlogin = "Class: ".null_check($userDet["current_class"],'Unknown');   
    }
    else{
    $lastlogin ="Unknown";     
        
    }
  }
  
 $fullnameTitle ="None";
if($fetchIdcol =="staff_id"){
  $fullnameTitle = $userDet["title"]." ".$userDet["surname"]." "
     .$userDet["othernames"];
}

 $userName = [
  
     "fullname_title" => $fullnameTitle,
     "fullname" => $userDet["surname"]." "
     .$userDet["othernames"],
     "surname" => $userDet["surname"],
     "othernames" => $userDet["othernames"],
     "email" => null_check($userDet[$emailcol],'No Email'),
     "number" => $userDet[$numcol],
     "gender" => $userDet["gender"],
     "user_psw" => $userDet["login_psw"],
     "user_id" => $userDet[$fetchIdcol],
     "user_cat" => $userDet[$catcol]??'Student',
     "user_prf" => $userDet[$prfcol],
     "prf_dir" => $prfDir.'/'.$userDet[$prfcol],
    "conn"  => $conn,
    "table" => $table,
    "id_col" => $idcol,
     "lastlogin" => $lastlogin,
   
      ];
     
  }

 }  

     
return $userName;
     
}

function timeAgo($dateString,$format=null){
   
  if(!$dateString){
      
      return "";
  }
   
 if(!$format){
 $date = DateTime::createFromFormat("D d/m/Y h:i A", $dateString);
 }
  else{
  $date = DateTime::createFromFormat($format, $dateString);
 }    
      
  if (!$date) return ""; // in case of invalid format

    $now = new DateTime();
    $diff = $now->diff($date);

    if ($diff->y > 0) {
        return $diff->y . " year" . ($diff->y > 1 ? "s" : "") . " ago";
    } elseif ($diff->m > 0) {
        return $diff->m . " month" . ($diff->m > 1 ? "s" : "") . " ago";
    } elseif ($diff->d >= 7) {
        $weeks = floor($diff->d / 7);
        return $weeks . " week" . ($weeks > 1 ? "s" : "") . " ago";
    } elseif ($diff->d > 0) {
        return $diff->d . " day" . ($diff->d > 1 ? "s" : "") . " ago";
    } elseif ($diff->h > 0) {
        return $diff->h . " hour" . ($diff->h > 1 ? "s" : "") . " ago";
    } elseif ($diff->i > 0) {
        return $diff->i . " minute" . ($diff->i > 1 ? "s" : "") . " ago";
    } else {
        return "Just now";
    }
}

function validate_user_email($email){
    // 1. Check valid email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return false;
    }

    // 2. Check DNS MX records
$domain = substr(strrchr($email, "@"), 1);

    if (!checkdnsrr($domain, "MX")) {
        return false;
    }

    // Passed both tests
    return true;
}

function check_exist_id($value){
global $conn;

$tables = ["students","staffs"];
$cols = [
    "students"=>"std_id",
    "staffs" => "staff_id"
    ];
$params = [
    "students"=>"i",
    "staffs" => "i"
    ];
 
foreach ($tables as $table){
 $col  = $cols[$table];
 $param = $params[$table];
  if(check_exist($conn,$table,$col,$value,$param)){
     
  return true;   
   }   
}
 
 return false; 
}
    
function check_exist_table($conn,$table){
 
  $sql = "SHOW TABLES";
 $table = trim($table);
$result = mysqli_query($conn, $sql);

 $tables = mysqli_fetch_all($result);
 
 if($tables){
     
 $tableNames = array_column($tables, 0);
  
 if(in_array($table, $tableNames)){

  return true;   
     
    }
  }

 
 return false;  
}

function collect_all_tables($conn){
  
  $tableNames = [];     
 $sql = "SHOW TABLES";
$result = mysqli_query($conn, $sql);
 $tables = mysqli_fetch_all($result);
 
 if($tables){
     
 $tableNames = array_column($tables, 0);  
 
 }
 
 return $tableNames;
}

function merge_into_array(
    $value = null,
    $array = null,
    $pos = "end",
    $allow_duplicate = false
){

    // Ensure destination is array
    if ($array === null) {
        $result = [];
    }

    elseif (is_array($array)) {
        $result = $array;
    }

    else {
        $result = [$array];
    }

    // Convert value into array for uniform processing
    $values = is_array($value) ? $value : [$value];

    // Remove null values
    $values = array_filter($values, fn($v) => $v !== null);

    // Normalize position
    $pos = strtolower(trim($pos));

    // Prevent duplicates if needed
    if (!$allow_duplicate) {
    $values = array_values(array_unique($values, SORT_REGULAR));

        foreach ($values as $v) {

            // remove existing occurrence
            $result = array_filter(
                $result,
                fn($item) => $item !== $v
            );

            $result = array_values($result);
        }
    }

    // Push to front
    if ($pos === "front") {

        // reverse to preserve order
        foreach (array_reverse($values) as $v) {
            array_unshift($result, $v);
        }

    }

    // Push to end
    else {

        foreach ($values as $v) {
            array_push($result, $v);
        }
    }

    return array_values($result);
}
