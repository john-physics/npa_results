<?php
// Increase execution time for large file operations
set_time_limit(300);

// --- 1. INCLUDE DATABASE CONNECTION ---
// Assumes dbcon.php initializes $conn as a MySQLi object
 require $_SERVER["DOCUMENT_ROOT"].'/page_init.php';


if (!isset($conn)) {
    die("Error: Database connection (\$conn) is not initialized or is not a valid MySQLi instance.");
}


  $class = "SS 3B";
  $students = collect_table_data1($conn,'students','current_class',$class,'s');
$upd =0;$stds=0;
$resultTable = "results_2026_2027";
foreach ($students as $std){
  $stdId = $std["std_id"];
  $profile = $std["profile"];
    
   if($profile && $stdId){
    $stds++;   
     if(update_user_data($conn,$resultTable,'std_profile','std_id',$profile,$stdId,'si')){
      
  $upd++;    
     }    
   }
 
}


echo "Number of students: $stds <br>Total Updates: $upd";

/*

// --- 2. DIRECTORY SETUP ---
$baseDir = __DIR__ . '/images/students/';
$dir2024 = $baseDir . '20242025/';
$dir2025 = $baseDir . '20252026/';

// Create target folders if they do not exist
foreach ([$dir2024, $dir2025] as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
}

// --- 3. SCAN & PROCESS FILES ---
$files = scandir($baseDir);
$counter = 0;
$successCount = 0;
$errorCount = 0;

$allowedExtensions = ['png', 'jpg', 'jpeg', 'webp', 'gif'];

// Prepare MySQLi statement
$stmt = $conn->prepare("UPDATE students SET profile = ? WHERE profile = ?");
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

echo "<pre>";
echo "Starting migration using MySQLi...\n\n";

foreach ($files as $file) {
    $sourcePath = $baseDir . $file;

    // Skip directories, current/parent paths, and non-image files
    if ($file === '.' || $file === '..' || $file === "npa-logo.jpg" || is_dir($sourcePath)) {
        continue;
    }

    $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
    if (!in_array($ext, $allowedExtensions)) {
        continue;
    }

    $counter++;

    // Split logic: First 300 to 20242025, remainder to 20252026
    if ($counter <= 300) {
        $targetFolder = $dir2024;
        $relativePath = 'images/students/20242025/' . $file;
    } else {
        $targetFolder = $dir2025;
        $relativePath = 'images/students/20252026/' . $file;
    }

    $destPath = $targetFolder . $file;

    // Move file
    if (rename($sourcePath, $destPath)) {
        // Bind parameters ("ss" means two string parameters) and execute
        $stmt->bind_param("ss", $relativePath, $file);
        $stmt->execute();
        $rowsAffected = $stmt->affected_rows;

        echo "[OK] Moved: $file -> $relativePath (DB Rows Updated: $rowsAffected)\n";
        $successCount++;
    } else {
        echo "[ERROR] Failed to move file: $file\n";
        $errorCount++;
    }
}

// Clean up statement
$stmt->close();

echo "\n--- Migration Summary ---\n";
echo "Total Images Processed: $counter\n";
echo "Successfully Moved & Updated: $successCount\n";
echo "Errors Encountered: $errorCount\n";
echo "</pre>";

*/
