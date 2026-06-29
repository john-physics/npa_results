<?php

use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Style\Table;
use PhpOffice\PhpWord\SimpleType\Jc;
use PhpOffice\PhpWord\SimpleType\JcTable;
use PhpOffice\PhpWord\Style\Image;

 require './vendor/autoload.php'; 
 
if($_SERVER["REQUEST_METHOD"] =="POST"){
 
 require  $_SERVER["DOCUMENT_ROOT"].'/page_init.php';


if(isset($_SESSION["staff_id"])){
    
 $staff_id = $_SESSION["staff_id"];
 $userCat = $_SESSION["staff_cat"];
 
}
else{
  
    $response = [
     "status" => "failed",
     "error" => "SESSION LOGIN",
     "message" => "Please login to view broad sheet !",
      ];
echo json_encode($response);
exit();  
    
}


  $data = json_decode(file_get_contents('php://input'), true);
  $btn = trim($data["button_name"]); 

 if($btn == "get_class_subjects"){
     
  $class = trim($data["class_name"]);
  $term_session =  trim($data["term_session"]);
  
  $explode = explode(" ",$term_session);
  $term = $explode[0]." ".$explode[1];
  $session = $explode[2];
  
  $class_set = collect_user_data3($conn,"class_set","session","term","class",$session,$term,$class,"sss");
  
  $subjects = convert_to_array($class_set["subjects"]);
  $students = convert_to_array($class_set["students"]);
  
 
  foreach ($students as $student){
   
  $std_det = collect_user_data2($conn,"students","std_id","current_class",$student,$class,"is");
     
  $added = convert_to_array($std_det["added_subjects"]);
  
  $subjects = merge_into_array($added,$subjects);
  }
  
  
  if($subjects){
  $subjectsDetails = [];
  foreach ($subjects as $subject){
 $subjectname = get_subject_name($subject);
 $dets = [
      "id" => $subject,
      "name" => $subjectname
      
      ];
      
    $subjectsDetails[] = $dets;
      
  }
  
   
     $response = [
     "status" => "success",
     "error" => "None",
     "message" => "subjects fetched successfully",
     "subjects" => $subjectsDetails
      ];
echo json_encode($response);
exit();   
 
      
  }
  else{
   
   $response = [
     "status" => "failed",
     "error" => "Empty Subjects",
     "message" => "There are no subjects in $class",
     "subjects" => []
      ];
echo json_encode($response);
exit();     
      
     
  }
 }

elseif($btn == "get_subject_results"){

  $class = trim($data["class_name"]);
  $subject = trim($data["subject"]);
 
  $term_session =  trim($data["term_session"]);
  
  $explode = explode(" ",$term_session);
  $term = $explode[0]." ".$explode[1];
  $session = $explode[2];
  
  $subjectTable = form_table_name("subject_records_",$session);
  $class_set = collect_user_data3($conn,"class_set","session","term","class",$session,$term,$class,"sss");
  
 $staff_id = $class_set["staff_id"];
 
 $staff = collect_user_data($conn,"staffs","staff_id",$staff_id,"i");
 $staffname = $staff["title"]." ".$staff["surname"]." ".$staff["othernames"];
 
  $students = convert_to_array($class_set["students"]);
  
  $Asspattern = collect_user_data2($conn,"variables","type","value","Class",$class,"ss"); 
  $pattern = convert_to_array($Asspattern["assessment_pattern"]);
$maxtotal = 100;
$maxexam = $maxtotal - array_sum($pattern);
  
  // gather each std results in this subj 
  $rows = [];
 foreach ($students as $std_id){
$stdname = get_student_name($conn,$std_id);   
  $records = collect_user_data4($conn,$subjectTable,"std_id","term","class","subject",$std_id,$term,$class,$subject,"isss");
  
 $exam = null_check($records["exam"],"-");
 $total=null_check($records["total"],"-");
 $position = null_check($records["position"],"-");
 $grade=null_check($records["grade"],"-");
 $dateCreated = $records["date_created"];
   $cas = []; //gather cas as array 
   foreach ($pattern as $index => $value){
   $cacol = "ca".($index+1);
 $cas[] =null_check($records[$cacol],"-");
   }
  
 $row = [
     "student" => $stdname,
     "cas" => $cas,
     "exam" => $exam,
     "total" => $total,
     "position" => $position,
     "grade" => $grade
     
     ];
     
    $rows[] = $row;
 } 
  
  $response = [
      
     "status" => "success",
     "assessment_pattern" => $pattern,
     "maxexam" => $maxexam,
     "maxtotal" => $maxtotal,
     "rows" => $rows,
     "compby" => $staffname,
     "date_created" => $dateCreated
    
      ];
    
  echo json_encode($response);
 exit(); 
    
}

elseif($btn == "get_broad_sheet"){
    
 $subjects = $data["subjects"];
 $class = trim($data["class_name"]);
  $term_session =  trim($data["term_session"]);
  
  $explode = explode(" ",$term_session);
  $term = $explode[0]." ".$explode[1];
  $session = $explode[2];
  
  $resultTable = form_table_name("results_",$session);
  $subjectTable = form_table_name("subject_records_",$session);
  
 $class_set = collect_user_data3($conn,"class_set","session","term","class",$session,$term,$class,"sss");
  
 $staff_id = $class_set["staff_id"];
 $staff = collect_user_data($conn,"staffs","staff_id",$staff_id,"i");
 $staffname = $staff["title"]." ".$staff["surname"]." ".$staff["othernames"];
 
 $students = sort_stds($conn,$resultTable, $class_set["students"],"sortbyaverage");

   // gather each std results 
  $sheets = [];
 foreach ($students as $std_id){
$stdname =get_student_name($conn,$std_id);
$scores = [];
$subjectcodes = [];
foreach ($subjects as $subject){
    
   $subject_id = $subject["id"];
   $subjectname = $subject["name"];
   $subjectcode = get_subject_code($subjectname);
    
   $total = collect_user_data4($conn,$subjectTable,"std_id","term","class","subject",$std_id,$term,$class,$subject_id,"isss"); 
   $totalscore = null_check($total["total"],"-");
   
   $subjectcodes[] = $subjectcode;
   $scores[] = $totalscore;
   
}
 
  $result = collect_user_data3($conn,$resultTable,"std_id","term","class",$std_id,$term,$class,"iss");
  
 $totalscore = null_check($result["total_score"],"-");
 $totalscorable = null_check($result["total_scorable"],"-");
  $average = null_check($result["overall_average"],"-");
  $position = null_check($result["position_inclass"],"-");
  $grade = null_check($result["overall_grade"],"-");
  $remark = null_check($result["general_remark"],"-");
  $dateCreated = $result["date_created"];
  
 $sheet = [
     "student" => $stdname,
     "scores" => $scores,
     "total_score" => $totalscore,
     "total_scorable" => $totalscorable,
     "average" => $average, 
     "position" => $position,
     "grade" => $grade,
     "remark" => $remark
     
     ];
     
    $sheets[] = $sheet;
 } 
  
  $response = [
      
     "status" => "success",
    "subjectcodes" => $subjectcodes,
     "sheets" => $sheets,
     "compby" => $staffname,
     "date_created" => $dateCreated
    
      ];
    
  echo json_encode($response);
 exit(); 
 
    
}

elseif($btn == "download_score_sheet"){
    
  $class = trim($data["class_name"]);
  $subject = trim($data["subject_id"]);
 
  $term_session =  trim($data["term_session"]);
  
  $explode = explode(" ",$term_session);
  $term = $explode[0]." ".$explode[1];
  $session = $explode[2];
 $subjectname =get_subject_name($subject);
 
  $subjectTable = form_table_name("subject_records_",$session);
 $class_set = collect_user_data3($conn,"class_set","session","term","class",$session,$term,$class,"sss");
  
 $staff_id = $class_set["staff_id"];
 
 $staff = collect_user_data($conn,"staffs","staff_id",$staff_id,"i");
 $staffname = $staff["title"]." ".$staff["surname"]." ".$staff["othernames"];
 
  $students = convert_to_array($class_set["students"]);
  
  $Asspattern = collect_user_data2($conn,"variables","type","value","Class",$class,"ss"); 
  $pattern = convert_to_array($Asspattern["assessment_pattern"]);
$maxtotal = 100;
$maxexam =$maxtotal - array_sum($pattern);
  
  // gather each std results in this subj 
  $rows = [];
 foreach ($students as $std_id){
$stdname= get_student_name($conn,$std_id);   
  $records = collect_user_data4($conn,$subjectTable,"std_id","term","class","subject",$std_id,$term,$class,$subject,"isss");
  
$exam = null_check($records["exam"],"-");
$total =null_check($records["total"],"-");
$position = null_check($records["position"],"-");
$grade =null_check($records["grade"],"-");
$dateCreated = $records["date_created"];
   $cas = []; //gather cas as array 
   foreach ($pattern as $index => $value){
  $cacol = "ca".$index+1;
 $cas[] =null_check($records[$cacol],"-");
   }
  
 $row = [
     "student" => $stdname,
     "cas" => $cas,
     "exam" => $exam,
     "total" => $total,
     "position" => $position,
     "grade" => $grade
     
     ];
     
    $rows[] = $row;
 } 
 
 $datestrtotime = strtotime(str_replace("/","-",$dateCreated));
 $convertedDate = date("D d/m/Y",$datestrtotime);
 
  $scoresheet = [
      "term" => $term,
      "session" => $session,
     "term_session" => $term." ".$session,
      "class_name" => $class,
      "subject_name" => $subjectname,
     "assessment_pattern" => $pattern,
     "maxexam" => $maxexam,
     "maxtotal" => $maxtotal,
     "rows" => $rows,
     "compiledby" => $staffname,
     "date_created" => $convertedDate
    
      ];
    

// generate scoresheet as word file here

try{

//SCHOOL LOGOS

$leftLogo  = $_SERVER["DOCUMENT_ROOT"]."/images/npa-logo.jpg";
$rightLogo = $_SERVER["DOCUMENT_ROOT"]."/images/npa-logo.jpg";

$totals = [];

foreach($scoresheet["rows"] as $row){

    if(is_numeric($row["total"])){
        $totals[] = $row["total"];
    }
}

$highest = !empty($totals) ? max($totals) : 0;
$lowest  = !empty($totals) ? min($totals) : 0;
$classaverage = !empty($totals) ? round(array_sum($totals)/count($totals),2) : 0;

$saveDir = $_SERVER["DOCUMENT_ROOT"]."/downloads/";

if(!file_exists($saveDir)){
    mkdir($saveDir,0755,true);
}


$phpWord = new PhpWord();

$phpWord->setDefaultFontName("Arial");
$phpWord->setDefaultFontSize(10);

$section = $phpWord->addSection([
    "marginTop" => 500,
    "marginBottom" => 700,
    "marginLeft" => 400,
    "marginRight" => 400
]);


 //FOOTER

$footer = $section->addFooter();
$footer->addText(
    "Date Printed: ".date("d/m/Y h:i A")." | ".$rurl,
    [
        "size" => 8
    ],
    [
        "alignment" => Jc::END
    ]
);

$headerTable = $section->addTable([
"alignment" => JcTable::CENTER,
"borderSize" => 0,
"cellMargin" => 0
]);

$headerTable->addRow();

// LEFT LOGO CELL

$leftCell = $headerTable->addCell(
1800,
[
"borderSize" => 0,
"borderColor" => "FFFFFF",
"valign" => "center"
]
);

$leftCell->addImage(
$leftLogo,
[
"width" => 45,
"height" => 45,
"alignment" => Jc::CENTER
]
);

// CENTER TEXT CELL

$centerCell = $headerTable->addCell(
6000,
[
"borderSize" => 0,
"borderColor" => "FFFFFF",
"valign" => "center"
]
);

$centerCell->addText(
$schoolName,
[
"bold" => true,
"size" => 16
],
[
"alignment" => Jc::CENTER,
"spaceAfter" => 0
]
);

$centerCell->addText(
$schoolAddress,
[
"size" => 8
],
[
"alignment" => Jc::CENTER
]
);

// RIGHT LOGO CELL

$rightCell = $headerTable->addCell(
1800,
[
"borderSize" => 0,
"borderColor" => "FFFFFF",
"valign" => "center"
]
);

$rightCell->addImage(
$rightLogo,
[
"width" => 45,
"height" => 45,
"alignment" => Jc::CENTER
]
);


// CENTERED HORIZONTAL LINE

$line = $section->addTextRun([
"alignment" => Jc::CENTER
]);

$line->addText(
"________________________________________________________________________________________________",
[
"size" => 10
]
);




$section->addTextBreak(2);

// INFORMATION SECTION (NO BORDERS)

$section->addText(
    strtoupper(
"SCORESHEET FOR ".$scoresheet["subject_name"].
"  ".$scoresheet["class_name"].
"  ".$scoresheet["term_session"]),
[
"bold" => true,
"size" => 10
],
[
"alignment" => Jc::CENTER,
"spaceAfter" => 150,


]
);


$section->addTextBreak(1);

// TABLE STYLE

$tableStyle = [
"borderSize" => 4,
"borderColor" => "000000",
"alignment" => JcTable::CENTER,
"cellMargin" => 40
];

$firstRowStyle = [
"bgColor" => "D9D9D9"
];

$phpWord->addTableStyle(
"ScoreSheetTable",
$tableStyle,
$firstRowStyle
);

$table = $section->addTable("ScoreSheetTable");

// TABLE HEADER

$table->addRow();

$table->addCell(500)->addText(
"S/N",
["bold"=>true,"size"=>10],
["alignment"=>Jc::CENTER]
);

$table->addCell(3000)->addText(
"Student Name",
["bold"=>true,"size"=>10],
["alignment"=>Jc::CENTER]
);

// CA HEADERS

foreach($scoresheet["assessment_pattern"] as $index => $mark){

$caNo = $index + 1;

$table->addCell(800)->addText(
    "CA".$caNo."\n(".$mark.")",
    [
        "bold" => true,
        "size" => 10
    ],
    [
        "alignment" => Jc::CENTER
    ]
);

}

// OTHER HEADERS

$table->addCell(900)->addText(
"Exam\n(".$scoresheet["maxexam"].")",
[
"bold" => true,
"size" => 10
],
[
"alignment" => Jc::CENTER
]
);

$table->addCell(900)->addText(
"Total\n(".$scoresheet["maxtotal"].")",
[
"bold" => true,
"size" => 10
],
[
"alignment" => Jc::CENTER
]
);

$table->addCell(900)->addText(
"Position",
[
"bold" => true,
"size" => 10
],
[
"alignment" => Jc::CENTER
]
);

$table->addCell(800)->addText(
"Grade",
[
"bold" => true,
"size" => 10
],
[
"alignment" => Jc::CENTER
]
);

// TABLE DATA

foreach($scoresheet["rows"] as $key => $row){

$table->addRow();

// SERIAL NUMBER

$table->addCell(500)->addText(
    $key + 1,
    ["size"=>10],
    ["alignment"=>Jc::CENTER]
);


// STUDENT NAME WITH WORD WRAP

$table->addCell(
    3000,
    [
        "valign" => "center"
    ]
)->addText(
    wordwrap($row["student"],50,"\n",true),
    [
        "size" => 10
    ],
    [
        "alignment" => Jc::START
    ]
);


// CA SCORES

foreach($row["cas"] as $ca){

    $table->addCell(800)->addText(
        $ca,
        ["size"=>10],
        ["alignment"=>Jc::CENTER]
    );
}


// EXAM

$table->addCell(900)->addText(
    $row["exam"],
    ["size"=>10],
    ["alignment"=>Jc::CENTER]
);


// TOTAL

$table->addCell(900)->addText(
    $row["total"],
    ["size"=>10],
    ["alignment"=>Jc::CENTER]
);


// POSITION

$table->addCell(900)->addText(
    $row["position"],
    ["size"=>10],
    ["alignment"=>Jc::CENTER]
);


// GRADE

$table->addCell(800)->addText(
    $row["grade"],
    ["size"=>10],
    ["alignment"=>Jc::CENTER]
);

}

// BOTTOM SUMMARY SECTION (NO BORDERS)

$section->addTextBreak(2);
$section->addText(
"Highest Score: ".$highest.
"          Lowest Score: ".$lowest.
"          Class Average: ".$classaverage,
[
"bold" => true,
"size" => 10
],
[
"alignment" => Jc::CENTER,
  "spaceAfter" => 100
]
);
$section->addText(
    "Compiled By: ".$scoresheet["compiledby"].
    "          Date Compiled: ".$scoresheet["date_created"],
    [
        "bold" => true,
        "size" => 10
    ],
    [
        "alignment" => Jc::CENTER
    
    ]
);


// SAVE FILE
$safeClass = preg_replace("/[^A-Za-z0-9]/","_",$scoresheet["class_name"]);

$safeSubject = preg_replace("/[^A-Za-z0-9]/","_",$scoresheet["subject_name"]);

$fileName = $safeClass."_".$safeSubject."_Scoresheet_".time().".docx";

$fullPath = $saveDir.$fileName;

$writer = IOFactory::createWriter($phpWord,"Word2007");

$writer->save($fullPath);

 //initialize downloads  
 
$_SESSION["initiate-downloads"] = true;
  
   $response = [
      
     "status" => "success",
     "subjectname" => $scoresheet["subject_name"],
    "file_path" => "downloads",
     "file_name" => $fileName,
     "unlink_file" => "true",
     "message" => "Scoresheet generated successfully",
      "error" =>"none"
      ];
    
  echo json_encode($response);
 exit(); 


}catch(Exception $e){

    $error = $e->getMessage();
    
    $response = [
     "status" => "failed",
     "error" => "Failed To Generate Scoresheet",
     "message" => "Error Description: $error",
      ];
echo json_encode($response);
exit();    

} 

}

elseif($btn == "download_broad_sheet"){
    
 $class = trim($data["class_name"]);
  $term_session =  trim($data["term_session"]);
  
  $explode = explode(" ",$term_session);
  $term = $explode[0]." ".$explode[1];
  $session = $explode[2];
 
  $resultTable = form_table_name("results_",$session);
    $subjectTable = form_table_name("subject_records_",$session);
  
 $class_set = collect_user_data3($conn,"class_set","session","term","class",$session,$term,$class,"sss");
  
 $staff_id = $class_set["staff_id"];
 $staff = collect_user_data($conn,"staffs","staff_id",$staff_id,"i");
 $staffname = $staff["title"]." ".$staff["surname"]." ".$staff["othernames"];
 
 $subjects = get_class_subjects($conn,$class_set); 
 
 $students = sort_stds($conn,$resultTable, $class_set["students"],"sortbyaverage");

   // gather each std results 
  $rows = [];
 foreach ($students as $std_id){
$stdname = get_student_name($conn,$std_id);
$scores = [];
$subjectcodes = [];
foreach ($subjects as $subject){
    
$subjectcode = get_subject_code($subject);
    
  $total = collect_user_data4($conn,$subjectTable,"std_id","term","class","subject",$std_id,$term,$class,$subject,"isss"); 
  $score =null_check($total["total"],"-");
   
   $subjectcodes[] = $subjectcode;
   $scores[] = $score;
   
}
 
 $result = collect_user_data3($conn,$resultTable,"std_id","term","class",$std_id,$term,$class,"iss");
  
 $totalscore = null_check($result["total_score"],"-");
 $totalscorable = null_check($result["total_scorable"],"-");
  $average = null_check($result["overall_average"],"-");
  $position = null_check($result["position_inclass"],"-");
  $grade = null_check($result["overall_grade"],"-");
  $remark = null_check($result["general_remark"],"-");
  $dateCreated = $result["date_created"];
 
 $row = [
     "student" => $stdname,
     "scores" => $scores,
     "total_score" => $totalscore,
     "total_scorable" => $totalscorable,
     "average" => $average, 
     "position" => $position,
     "grade" => $grade,
     "remark" => $remark,
     "date_created" => $dateCreated
     ];
     
    $rows[] = $row;
 } 
  
  $datestrtotime = strtotime(str_replace("/","-",$dateCreated));
 $convertedDate = date("D d/m/Y",$datestrtotime);
 
  $broadsheet = [
      "term" => $term,
      "session" => $session,
     "term_session" => $term." ".$session,
      "class_name" => $class,
      "subject_codes" => $subjectcodes,
      "rows" => $rows,
     "compiledby" => $staffname,
     "date_created" => $convertedDate
    
      ];
    
 
// generate broadsheet as word file here

try{

//SCHOOL LOGOS

$leftLogo  = $_SERVER["DOCUMENT_ROOT"]."/images/npa-logo.jpg";
$rightLogo = $_SERVER["DOCUMENT_ROOT"]."/images/npa-logo.jpg";

$totals = [];
$scorables = [];

foreach($broadsheet["rows"] as $row){

    if(is_numeric($row["total_score"])){
        $totals[] = $row["total_score"];
    }
    
  if(is_numeric($row["total_scorable"])){
  $scorables[] = $row["total_scorable"];
    }  
    
}


$classPerformance = !empty($totals) ? round((array_sum($totals)/array_sum($scorables))*100,2) : 0;

$gradeRemark = result_grades($classPerformance,'None');
$classRemark = $gradeRemark["remark"];

$saveDir = $_SERVER["DOCUMENT_ROOT"]."/downloads/";

if(!file_exists($saveDir)){
    mkdir($saveDir,0755,true);
}

$subjectnum = count($broadsheet["subject_codes"]);

$phpWord = new PhpWord();

$phpWord->setDefaultFontName("Arial");
$phpWord->setDefaultFontSize(10);

$orientation = "portrait";
if ($subjectnum >= 9) {
    $orientation = "landscape";
}

$section = $phpWord->addSection([
    "orientation" => $orientation,
    "marginTop" => 600,
    "marginBottom" => 700,
    "marginLeft" => 400,
    "marginRight" => 400
]);


 //FOOTER

$footer = $section->addFooter();
$footer->addText(
    "Date Printed: ".date("d/m/Y h:i A")." | ".$rurl,
    [
        "size" => 8
    ],
    [
        "alignment" => Jc::END
    ]
);

$headerTable = $section->addTable([
"alignment" => JcTable::CENTER,
"borderSize" => 0,
"cellMargin" => 0
]);

$headerTable->addRow();

// LEFT LOGO CELL

$leftCell = $headerTable->addCell(
1800,
[
"borderSize" => 0,
"borderColor" => "FFFFFF",
"valign" => "center"
]
);

$leftCell->addImage(
$leftLogo,
[
"width" => 45,
"height" => 45,
"alignment" => Jc::CENTER
]
);

// CENTER TEXT CELL

$centerCell = $headerTable->addCell(
8000,
[
"borderSize" => 0,
"borderColor" => "FFFFFF",
"valign" => "center"
]
);

$centerCell->addText(
$schoolName,
[
"bold" => true,
"size" => 18
],
[
"alignment" => Jc::CENTER,
"spaceAfter" => 0
]
);

$centerCell->addText(
$schoolAddress,
[
"size" => 10
],
[
"alignment" => Jc::CENTER
]
);

// RIGHT LOGO CELL

$rightCell = $headerTable->addCell(
2000,
[
"borderSize" => 0,
"borderColor" => "FFFFFF",
"valign" => "center"
]
);

$rightCell->addImage(
$rightLogo,
[
"width" => 45,
"height" => 45,
"alignment" => Jc::CENTER
]
);


// CENTERED HORIZONTAL LINE

$line = $section->addTextRun([
"alignment" => Jc::CENTER
]);

$line->addText(
"________________________________________________________________________________________________________________________",
[
"size" => 10
]
);



$section->addTextBreak(2);

// INFORMATION SECTION (NO BORDERS)

$section->addText(
    strtoupper(
"BROADSHEET FOR ".$broadsheet["class_name"].
" ".$broadsheet["term_session"]),
[
"bold" => true,
"size" => 12
],
[
"alignment" => Jc::CENTER,
"spaceAfter" => 150,

]
);


$section->addTextBreak(1);

// TABLE STYLE

$tableStyle = [
"borderSize" => 4,
"borderColor" => "000000",
"alignment" => JcTable::CENTER,
"cellMargin" => 40
];

$firstRowStyle = [
"bgColor" => "D9D9D9"
];

$phpWord->addTableStyle(
"ScoreSheetTable",
$tableStyle,
$firstRowStyle
);

$table = $section->addTable("ScoreSheetTable");

// TABLE HEADER

$fontsize = 8;
$width400 = 500;// 400;
$width500 = 600;// 500;
$width600 = 650;//600;
$width800 = 850;//800;
$width2000 = 2500;//2000;

if ($subjectnum > 18) {

    $reduce = $subjectnum - 18;
    $fontsize = max(5, 7 - floor($reduce / 2));

    $width400  = max(220, 400 - ($reduce * 20));
    $width500  = max(300, 500 - ($reduce * 20));
    $width600  = max(350, 600 - ($reduce * 20));
    $width800  = max(450, 800 - ($reduce * 25));

    $width2000 = max(1000, 2000 - ($reduce * 80));
}

$table->addRow();

$table->addCell($width400)->addText(
"S/N",
["bold"=>true,"size"=>$fontsize],
["alignment"=>Jc::CENTER]
);

$table->addCell($width2000)->addText(
"Student Name",
["bold"=>true,"size"=>$fontsize],
["alignment"=>Jc::CENTER]
);

// CA HEADERS

foreach($broadsheet["subject_codes"] as $index => $code){
    
$table->addCell($width400)->addText(
    $code,
    [
        "bold" => true,
        "size" => $fontsize
    ],
    [
        "alignment" => Jc::CENTER
    ]
);

}

// OTHER HEADERS

$table->addCell($width500)->addText(
"Total Score",
[
"bold" => true,
"size" => $fontsize
],
[
"alignment" => Jc::CENTER
]
);

$table->addCell($width500)->addText(
"Total Scorable",
[
"bold" => true,
"size" => $fontsize
],
[
"alignment" => Jc::CENTER
]
);

$table->addCell($width600)->addText(
"Overall Average",
[
"bold" => true,
"size" => $fontsize
],
[
"alignment" => Jc::CENTER
]
);

$table->addCell($width500)->addText(
"Position",
[
"bold" => true,
"size" => $fontsize
],
[
"alignment" => Jc::CENTER
]
);

$table->addCell($width600)->addText(
"Overall Grade",
[
"bold" => true,
"size" => $fontsize
],
[
"alignment" => Jc::CENTER
]
);

$table->addCell($width800)->addText(
"General Remark",
[
"bold" => true,
"size" => $fontsize
],
[
"alignment" => Jc::CENTER
]
);

// TABLE DATA

foreach($broadsheet["rows"] as $key => $row){

$table->addRow();

// SERIAL NUMBER

$table->addCell($width400)->addText(
    $key + 1,
    ["size"=>$fontsize],
    ["alignment"=>Jc::CENTER]
);


// STUDENT NAME WITH WORD WRAP

$table->addCell(
    $width2000,
    [
        "valign" => "center"
    ]
)->addText(
    wordwrap($row["student"],50,"\n",true),
    [
        "size" => $fontsize
    ],
    [
        "alignment" => Jc::START
    ]
);


// SUBJECT SCORES

foreach($row["scores"] as $score){

    $table->addCell($width400)->addText(
        $score,
        ["size"=>$fontsize],
        ["alignment"=>Jc::CENTER]
    );
}


// TOTAL SCORE

$table->addCell($width500)->addText(
    $row["total_score"],
    ["size"=>$fontsize],
    ["alignment"=>Jc::CENTER]
);


// TOTAL Scorable

$table->addCell($width500)->addText(
    $row["total_scorable"],
    ["size"=>$fontsize],
    ["alignment"=>Jc::CENTER]
);


// Average

$table->addCell($width600)->addText(
    $row["average"],
    ["size"=>$fontsize],
    ["alignment"=>Jc::CENTER]
);


// POSITION

$table->addCell($width500)->addText(
    $row["position"],
    ["size"=>$fontsize],
    ["alignment"=>Jc::CENTER]
);


// GRADE

$table->addCell($width600)->addText(
    $row["grade"],
    ["size"=>$fontsize],
    ["alignment"=>Jc::CENTER]
);


// Remark

$table->addCell($width600)->addText(
    $row["remark"],
    ["size"=>$fontsize],
    ["alignment"=>Jc::CENTER]
);

}

// BOTTOM SUMMARY SECTION (NO BORDERS)

$section->addTextBreak(2);
$section->addText(
"General Class Performance: ".$classPerformance."%  Class Remark: ".$classRemark,
[
"bold" => true,
"size" => 10
],
[
"alignment" => Jc::CENTER,
 "spaceAfter" => 100,
]
);

$section->addText(
    "Compiled By: ".$broadsheet["compiledby"].
    "          Date Compiled: ".$broadsheet["date_created"],
    [
        "bold" => true,
        "size" => 10
    ],
    [
        "alignment" => Jc::CENTER
        
        ]
);


// SAVE FILE
$safeClass = preg_replace("/[^A-Za-z0-9]/","_",$broadsheet["class_name"]);

$fileName = $safeClass."_Broadsheet_".time().".docx";

$fullPath = $saveDir.$fileName;

$writer = IOFactory::createWriter($phpWord,"Word2007");

$writer->save($fullPath);

 //initialize downloads  
 
$_SESSION["initiate-downloads"] = true;
  
   $response = [
      
     "status" => "success",
     "class_name" => $broadsheet["class_name"],
    "file_path" => "downloads",
     "file_name" => $fileName,
     "unlink_file" => "true",
     "message" => "Broadsheet generated successfully",
      "error" =>"none"
      ];
    
  echo json_encode($response);
 exit(); 


}catch(Exception $e){

    $error = $e->getMessage();
    
    $response = [
     "status" => "failed",
     "error" => "Failed To Generate Scoresheet",
     "message" => "Error Description: $error",
      ];
echo json_encode($response);
exit();    

} 


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