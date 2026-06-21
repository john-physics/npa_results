<?php


if($_SERVER["REQUEST_METHOD"] ==="POST"){
 
 require  $_SERVER["DOCUMENT_ROOT"].'/page_init.php';

require_once $_SERVER["DOCUMENT_ROOT"].'/fpdf/fpdf.php';
require_once $_SERVER["DOCUMENT_ROOT"].'/fpdi/src/autoload.php';


 $data = json_decode(file_get_contents('php://input'), true);
  $btn = trim($data["button_name"]); 


if($btn == "print_results"){

 $class = trim($data["std_class"]);
 $std_id = trim($data["std_id"]);
 $term = trim($data["term"]);
 $session = trim($data["session"]);
 
 if(!$class || !$std_id || !$term || !$session){
 
  $response = [
     "status" => "failed",
     "error" => "Empty Input",
     "message" => "Something went wrong, please refresh the page and try again.",
      ];
echo json_encode($response);
exit();    
     
 }
 
/*
constant variables:
$conn : mysqli databse object
$siteName :use this variable as school name
$schoolAddress
$rurl : this is result portal url variable
$passmark : 50 by default settings. can be modified by school admin

Always use this variables globally and avoid over writing them, they are all defined in page_init.php alongside with helper functions. 
*/

$resultTable = form_table_name("results_",$session); 
 $subjectTable = form_table_name("subject_records_",$session); 
   
  $std_details = collect_user_data($conn,"students","std_id",$std_id,"i");
  $std_name = normalize_user_name($std_details["surname"]." ".$std_details["othernames"],"upper");
  $std_pin = $std_details["std_pin"];
  $profile = null_check($std_details["profile"],"null.jpg");
 
 $class_set = collect_user_data3($conn,"class_set","session","term","class",$session,$term,$class,"sss");
$totalStds = count(convert_to_array($class_set["students"]));
 
$classDet = collect_user_data2($conn,"variables","type","value","Class",$class,"ss");
$caPattern = convert_to_array($classDet["assessment_pattern"]);
 $maxtotal = 100;
  $maxexam = $maxtotal- array_sum($caPattern);

$nextTerm = collect_user_data($conn,"variables","type","Next Term Begins","s");
 
$nextTermDate = $nextTerm["value"];
$results = collect_user_data3($conn,$resultTable,"term","class","std_id",$term,$class,$std_id,"sss");
$examType =strtoupper("$term EXAMINATION");
$cteach_id = $results["staff_id"];
$std_cat  = $results["std_cat"];
$total_score  = $results["total_score"];
$total_scorable=$results["total_scorable"];
$subject_num = $results["subject_num"];
$overall_average = $results["overall_average"];
$overall_grade = $results["overall_grade"];
$general_remark = $results["general_remark"];
$position_inclass = $results["position_inclass"];
$teacher_comment = $results["teacher_comment"];
$principal_comment = $results["principal_comment"];
       
$activeness = $results["activeness"];
$attendance = $results["attendance"];
$punctuality = $results["punctuality"];
$self_control = $results["self_control"];
$honesty = $results["honesty"];
$humility =  $results["humility"];
$leadership = $results["leadership"];
$hand_writing =  $results["hand_writing"];
$fluency =        $results["fluency"];  
$musical_skills = $results["musical_skills"];
$sports = $results["sports"];
$date_created  = $results["date_created"];
 $datestrtotime = strtotime(str_replace("/","-",$date_created));
 $converted_date = date("d/m/Y",$datestrtotime);
$result_status= $results["result_status"];
$redink = redink_for_failure($conn);
$showpos = show_position_inclass($conn);
   
$passedFailed = "Failed";
if($overall_average >= $passmark){
 $passedFailed = "Passed";   
}

$logoPath =  $_SERVER["DOCUMENT_ROOT"]."/images/npa-logo.jpg";
$prfPath = $_SERVER["DOCUMENT_ROOT"]."/images/students/$profile";
 if(!is_file($prfPath)){
$prfPath = $logoPath; 
 }
  
 $pp_det = collect_user_data($conn,"staffs","staff_cat","Principal","s");
 $cteach_det = collect_user_data($conn,"staffs","staff_id",$cteach_id,"i");

 $pp_name = normalize_user_name($pp_det["title"]." ".$pp_det["surname"]." ".$pp_det["othernames"],"ucwords");
$cteach_name = normalize_user_name($cteach_det["title"]." ".$cteach_det["surname"]." ".$cteach_det["othernames"],"ucwords");
$pp_sign = $pp_det["signature"];
$cteach_sign = $cteach_det["signature"];

$ppsignPath = $_SERVER["DOCUMENT_ROOT"]."/images/staff/$pp_sign";
$cteachsignPath = $_SERVER["DOCUMENT_ROOT"]."/images/staff/$cteachsignPath";

$subjectRecords = collect_table_data3($conn,$subjectTable,"term","class","std_id",$term,$class,$std_id,"ssi"); 
/* 
$subjectRecords contains all subject records upploaded for this std in rows. this includes ca1, ca2 ... caN where N is the number of assessment_pattern. exam, total, subject grade, and position in subject. 
*/

if(strtolower($result_status) !== "published"){

  $response = [
     "status" => "failed",
     "error" => "Unpublished Result",
     "message" => "The selected student's result cannot be downloaded at the moment, please publish your results and try again. Result Status: $result_status",
      ];
echo json_encode($response);
exit();  
    
}


//temporarily block downloads until code is balanced.

  $response = [
     "status" => "failed",
     "error" => "Coding in progress",
     "message" => "Downloading of result sheet is not available at the moment, coding in progress...",
      ];
echo json_encode($response);
exit();


//proceed to generate result sheet in pdf
// ....write codes the here....

// 1. Initialize FPDF with a Dynamic Footer
class ResultPDF extends FPDF {
    function Header() {
        // Left blank for manual layout control in the main block
    }
    
    function Footer() {
        // Bring in your global URL variable defined in page_init.php
        global $rurl;
        
        // Generate current timestamp (Format: DD/MM/YYYY HH:MM:SS)
        $current_date_time = date("d/m/Y h:i A");
        
        // Position at 1.5 cm from bottom
        $this->SetY(-15);
        
        // Use a clean, subtle light grey text for metadata
        $this->SetFont('Arial', 'I', 8);
        $this->SetTextColor(120, 120, 120);
        
        // Draw a decorative thin line above the footer text
        $this->SetDrawColor(220, 220, 220);
        $this->Line(10, $this->GetY(), 200, $this->GetY());
        
        // Construct the footer string
        $footerText = "Date printed: " . $current_date_time . "   |   Portal URL: " . $rurl;
        
        // Print the left-aligned metadata and right-aligned page numbers
        $this->Cell(130, 8, $footerText, 0, 0, 'L');
        $this->Cell(60, 8, 'Page ' . $this->PageNo() . ' of {nb}', 0, 0, 'R');
    }
}

$pdf = new ResultPDF('P', 'mm', 'A4');
// Define an alias for total number of pages (used for '{nb}' in the footer)
$pdf->AliasNbPages(); 
$pdf->SetAutoPageBreak(true, 15); // Increased bottom margin slightly to avoid footer collision
$pdf->AddPage();

// --- COLOR PALETTE DEFINITION ---
$primaryColor = [24, 43, 73];    // Deep Navy
$secondaryColor = [220, 53, 69]; // Subtle Accent
$gridLight = [245, 247, 250];    // Light background for alternating rows
$borderDark = [180, 180, 180];   // Clean border line color

// --- 2. HEADER SECTION (School Branding) ---
if (is_file($logoPath)) {
    $pdf->Image($logoPath, 10, 10, 24, 24);
}

$pdf->SetFont('Arial', 'B', 18);
$pdf->SetTextColor($primaryColor[0], $primaryColor[1], $primaryColor[2]);
$pdf->SetXY(38, 10);
$pdf->Cell(100, 6, strtoupper($siteName), 0, 1, 'L');

$pdf->SetFont('Arial', '', 9);
$pdf->SetTextColor(80, 80, 80);
$pdf->SetX(38);
$pdf->MultiCell(110, 4, $schoolAddress, 0, 'L');

if (is_file($prfPath)) {
    $pdf->Image($prfPath, 165, 10, 35, 35);
}

$pdf->Ln(15);

// --- 3. BIODATA GRID ---
$pdf->SetDrawColor($borderDark[0], $borderDark[1], $borderDark[2]);
$pdf->SetLineWidth(0.2);

$pdf->SetFont('Arial', 'B', 10);
$pdf->SetTextColor($primaryColor[0], $primaryColor[1], $primaryColor[2]);

// Row 1
$pdf->SetX(10);
$pdf->Cell(32, 7, "Name of Student:", 1, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell(78, 7, $std_name, 1, 0, 'L');

$pdf->SetFont('Arial', 'B', 10);
$pdf->SetTextColor($primaryColor[0], $primaryColor[1], $primaryColor[2]);
$pdf->Cell(45, 7, "Next Term Resumption:", 1, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell(35, 7, date("Y-m-d", strtotime($nextTermDate)), 1, 1, 'C');

// Row 2
$pdf->SetFont('Arial', 'B', 10);
$pdf->SetTextColor($primaryColor[0], $primaryColor[1], $primaryColor[2]);
$pdf->Cell(32, 7, "Class:", 1, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell(33, 7, strtoupper($class), 1, 0, 'C');

$pdf->SetFont('Arial', 'B', 10);
$pdf->SetTextColor($primaryColor[0], $primaryColor[1], $primaryColor[2]);
$pdf->Cell(15, 7, "Year:", 1, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell(30, 7, $session, 1, 0, 'C');

$pdf->SetFont('Arial', 'B', 10);
$pdf->SetTextColor($primaryColor[0], $primaryColor[1], $primaryColor[2]);
$pdf->Cell(45, 7, "Exam Type:", 1, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell(35, 7, $examType, 1, 1, 'C');

$pdf->Ln(5);

// --- 4. GRADE SHEET (Academic Performance Table) ---
$pdf->SetFont('Arial', 'B', 11);
$pdf->SetTextColor($primaryColor[0], $primaryColor[1], $primaryColor[2]);
$pdf->Cell(190, 6, "ACADEMIC PERFORMANCE SHEET", 0, 1, 'C');
$pdf->Ln(2);

$pdf->SetFont('Arial', 'B', 9);
$pdf->SetFillColor($primaryColor[0], $primaryColor[1], $primaryColor[2]);
$pdf->SetTextColor(255, 255, 255);

$widths = [10, 55, 15, 15, 15, 20, 20, 20, 20];

$pdf->Cell($widths[0], 8, "No.", 1, 0, 'C', true);
$pdf->Cell($widths[1], 8, "Subject", 1, 0, 'L', true);
$pdf->Cell($widths[2], 8, "CA1 (10%)", 1, 0, 'C', true);
$pdf->Cell($widths[3], 8, "CA2 (10%)", 1, 0, 'C', true);
$pdf->Cell($widths[4], 8, "CA3 (10%)", 1, 0, 'C', true); //this is hard coded, CA should be looped according to assessment_pattern, and its not always 10%, the assessment_pattern forms the maximum ca, each class has his own pattern. also maxexam is not fixed at 70 but changes depending on Total max ca 
$pdf->Cell($widths[5], 8, "Exam (70%)", 1, 0, 'C', true);
$pdf->Cell($widths[6], 8, "Total (100%)", 1, 0, 'C', true);
$pdf->Cell($widths[7], 8, "Position", 1, 0, 'C', true);
$pdf->Cell($widths[8], 8, "Grade", 1, 1, 'C', true);

$pdf->SetFont('Arial', '', 9);
$pdf->SetTextColor(0, 0, 0);

$count = 1;
$fill = false;

foreach ($subjectRecords as $row) {
    if ($fill) {
        $pdf->SetFillColor($gridLight[0], $gridLight[1], $gridLight[2]);
    } else {
        $pdf->SetFillColor(255, 255, 255);
    }
    
    $pdf->Cell($widths[0], 7, $count . ".", 1, 0, 'C', true);
    $pdf->Cell($widths[1], 7, ucwords(strtolower($row["subject_name"])), 1, 0, 'L', true);
    $pdf->Cell($widths[2], 7, $row["ca1"], 1, 0, 'C', true);
    $pdf->Cell($widths[3], 7, $row["ca2"], 1, 0, 'C', true);
    $pdf->Cell($widths[4], 7, $row["ca3"], 1, 0, 'C', true);
    $pdf->Cell($widths[5], 7, $row["exam"], 1, 0, 'C', true);
    
    // TWO-CONDITION RED INK CHECK
    if (isset($redink) && $redink === true && $row["total"] < $passmark) {
        $pdf->SetTextColor(220, 53, 69); // Failure Red
    } else {
        $pdf->SetTextColor(0, 0, 0);    // Normal Black
    }
    
    $pdf->Cell($widths[6], 7, $row["total"], 1, 0, 'C', true);
    $pdf->SetTextColor(0, 0, 0); // Reset color
    
    $pdf->Cell($widths[7], 7, $row["position"], 1, 0, 'C', true);
    $pdf->Cell($widths[8], 7, strtoupper($row["grade"]), 1, 1, 'C', true);
    
    $count++;
    $fill = !$fill;
}

$pdf->Ln(4);

// --- 5. DEVELOPMENT & SKILLS METRICS ---
$pdf->SetFont('Arial', 'B', 10);
$pdf->SetTextColor($primaryColor[0], $primaryColor[1], $primaryColor[2]);
$pdf->Cell(92, 6, "AFFECTIVE & PSYCHOMOTOR DEVELOPMENT", 0, 0, 'L');
$pdf->Cell(6, 6, "", 0, 0, 'C'); 
$pdf->Cell(92, 6, "PERFORMANCE QUICK OVERVIEW", 0, 1, 'L');
$pdf->Ln(1);

$currentY = $pdf->GetY();

// Column A: Behavioral Ratings
$pdf->SetFont('Arial', '', 9);
$pdf->SetTextColor(0, 0, 0);

$behaviors = [
    "Activeness" => $activeness, "Attendance" => $attendance, 
    "Punctuality" => $punctuality, "Self Control" => $self_control,
    "Honesty" => $honesty, "Humility" => $humility, "Leadership" => $leadership,
    "Handwriting" => $hand_writing, "Fluency" => $fluency, 
    "Musical Skills" => $musical_skills, "Sports" => $sports
];

foreach ($behaviors as $behaviorName => $ratingValue) {
    $pdf->SetX(10);
    $pdf->Cell(60, 5.5, $behaviorName, 1, 0, 'L');
    $pdf->Cell(32, 5.5, $ratingValue . " / 10", 1, 1, 'C');
}

$endYOfBehaviors = $pdf->GetY();
$pdf->SetY($currentY);

// Column B: Performance Overview Table (Dynamic Grid Height based on $showpos)
$overviewRowHeight = (isset($showpos) && $showpos === true) ? 6.0 : 7.0;

$pdf->SetX(108);
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(47, $overviewRowHeight, "Number of Subjects:", 1, 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(45, $overviewRowHeight, $subject_num, 1, 1, 'C');

$pdf->SetX(108);
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(47, $overviewRowHeight, "Total Obtainable Marks:", 1, 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(45, $overviewRowHeight, $total_scorable, 1, 1, 'C');

$pdf->SetX(108);
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(47, $overviewRowHeight, "Total Marks Obtained:", 1, 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(45, $overviewRowHeight, $total_score, 1, 1, 'C');

$pdf->SetX(108);
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(47, $overviewRowHeight, "Cumulative Average:", 1, 0, 'L');
$pdf->SetFont('Arial', 'B', 9);
$pdf->SetTextColor($primaryColor[0], $primaryColor[1], $primaryColor[2]);
$pdf->Cell(45, $overviewRowHeight, number_format($overall_average, 2) . "%", 1, 1, 'C');
$pdf->SetTextColor(0, 0, 0);

// DYNAMIC POSITION IN CLASS
if (isset($showpos) && $showpos === true) {
    $pdf->SetX(108);
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(47, $overviewRowHeight, "Position in Class:", 1, 0, 'L');
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(45, $overviewRowHeight, $position_inclass . " / " . $totalStds, 1, 1, 'C');
}

$pdf->SetX(108);
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(47, $overviewRowHeight, "Term Outcome Status:", 1, 0, 'L');
$pdf->SetFont('Arial', 'B', 9);
if (strtolower($passedFailed) == "passed") {
    $pdf->SetTextColor(40, 167, 69); // Green Pass
} else {
    $pdf->SetTextColor(220, 53, 69); // Red Fail
}
$pdf->Cell(45, $overviewRowHeight, strtoupper($passedFailed), 1, 1, 'C');
$pdf->SetTextColor(0, 0, 0);

if ($pdf->GetY() < $endYOfBehaviors) {
    $pdf->SetY($endYOfBehaviors);
}
$pdf->Ln(4);

// --- 6. REMARKS & SIGNATURES BLOCK ---
$pdf->SetFont('Arial', 'B', 10);
$pdf->SetTextColor($primaryColor[0], $primaryColor[1], $primaryColor[2]);
$pdf->Cell(190, 5, "OFFICIAL VALIDATION & REMARKS", 0, 1, 'L');
$pdf->Ln(1);

// Class Teacher
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(40, 7, "Class Teacher Remarks:", 0, 0, 'L');
$pdf->SetFont('Arial', 'I', 9);
$pdf->Cell(150, 7, '"' . $teacher_comment . '"', "B", 1, 'L');

$pdf->SetFont('Arial', '', 8.5);
$pdf->Cell(95, 5, "Assigned Teacher: " . $cteach_name, 0, 0, 'L');
$pdf->Cell(95, 5, "Date Verified: " . $converted_date, 0, 1, 'R');

if (is_file($cteachsignPath)) {
    $pdf->Image($cteachsignPath, 50, $pdf->GetY() - 2, 22, 10);
}
$pdf->Ln(4);

// Principal
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(40, 7, "Principal's Remarks:", 0, 0, 'L');
$pdf->SetFont('Arial', 'I', 9);
$pdf->Cell(150, 7, '"' . $principal_comment . '"', "B", 1, 'L');

$pdf->SetFont('Arial', '', 8.5);
$pdf->Cell(95, 5, "Principal Signature Authority: " . $pp_name, 0, 0, 'L');
$pdf->Cell(95, 5, "Date Authorized: " . $converted_date, 0, 1, 'R');

if (is_file($ppsignPath)) {
    $pdf->Image($ppsignPath, 50, $pdf->GetY() - 2, 22, 10);
}

// --- 7. FILE STORAGE SYSTEM PIPELINE ---
$fileName = "result_" . str_replace(" ", "_", $std_name) . "_" . strtolower(str_replace(" ","_",$term)) . "_" . str_replace("/","_",$session) . ".pdf";
$directoryPath = $_SERVER["DOCUMENT_ROOT"] . "/downloads/";

if (!is_dir($directoryPath)) {
    mkdir($directoryPath, 0755, true);
}

$fullFileStorageDestination = $directoryPath . $fileName;
$pdf->Output('F', $fullFileStorageDestination);

// done generating pdf: initialize downloads  
 
$_SESSION["initiate-downloads"] = true;
  
   $response = [
      
     "status" => "success",
    "file_path" => "downloads",
     "file_name" => $fileName,
     "unlink_file" => "true",
     "message" => "Result sheet generated successfully",
      "error" =>"none"
      ];
    
  echo json_encode($response);
 exit(); 


}

//more btns goes here
else{
    
  $response = [
     "status" => "failed",
     "error" => "Button Name",
     "message" => "Unrecognized button name !",
      ];
echo json_encode($response);
exit();       
 }
}
else{
    
  $response = [
     "status" => "failed",
     "error" => "REQUEST_METHOD",
     "message" => "Unauthorized request method !",
      ];
echo json_encode($response);
exit();      
     
    
}