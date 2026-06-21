<script>
 
 const profileInput = document.getElementById('profile');
const signatureInput = document.getElementById('signature');
const profilePreview = document.getElementById('profilePreview');
const signaturePreview = document.getElementById('signaturePreview');
const MAX_SIZE = 5 * 1024 * 1024; // 5MB

function previewImage(input, previewBox, titleText) {
    previewBox.innerHTML = "";
    const file = input.files[0];
    if (!file) return;

    // 1. File Size Validation
    if (file.size > MAX_SIZE) {
        alert(titleText + " must not be more than 5MB");
        input.value = "";
        previewBox.style.display = "none";
        if (titleText === "Selected Profile") document.getElementById("prflabel").innerHTML = "Select Another Profile";
        if (titleText === "Selected Signature") document.getElementById("signlabel").innerHTML = "Select Another Signature";
        return;
    }

    // 2. Setup Preview UI
    previewBox.style.display = "block";
    const title = document.createElement("h4");
    title.textContent = "Preview " + titleText;
    previewBox.appendChild(title);

    const reader = new FileReader();
    reader.onload = function(e) {
        const img = new Image();
        img.onload = function() {
            
            // IF SIGNATURE: Apply Background Removal & Resizing
            if (titleText === "Selected Signature") {
                const canvas = document.createElement('canvas');
                canvas.width = 200;
                canvas.height = 200;
                const ctx = canvas.getContext('2d');
                ctx.drawImage(img, 0, 0, 200, 200);
           
           
                // --- Background Quality Check ---
                const data = ctx.getImageData(0, 0, 200, 200).data;
                const corners = [0, 199, 40000 - 400, 39996]; // Corner pixel indices
                for (let i of corners) {
                    if (((data[i] + data[i+1] + data[i+2]) / 3) < 200) {
                        alert("Background too dark or dirty. Use a clean white paper.");
                        input.value = ""; previewBox.innerHTML = ""; return;
                    }
                }
                
                

                // --- Cleaning ---
                for (let i = 0; i < data.length; i += 4) {
                    const avg = (data[i] + data[i+1] + data[i+2]) / 3;
                    data[i+3] = (avg > 200) ? 0 : 255; // Transparency
                    if (data[i+3] === 255) data[i]=data[i+1]=data[i+2] = 0; // Black Ink
                }
                ctx.putImageData(new ImageData(data, 200, 200), 0, 0);
                previewBox.appendChild(canvas);
                document.getElementById('cleaned_signature_data').value = canvas.toDataURL('image/png');
            } 
            // IF PROFILE: Standard Display
            else {
                img.style.maxWidth = "200px";
                previewBox.appendChild(img);
            }
        };
        img.src = e.target.result;
    };
    reader.readAsDataURL(file);

    // 3. Update Labels
    if (titleText === "Selected Profile") document.getElementById("prflabel").innerHTML = "Change Profile";
    if (titleText === "Selected Signature") document.getElementById("signlabel").innerHTML = "Change Signature";
}

// Event Listeners
profileInput.addEventListener("change", () => previewImage(profileInput, profilePreview, "Selected Profile"));
signatureInput.addEventListener("change", () => previewImage(signatureInput, signaturePreview, "Selected Signature"));
   
   
</script>




<?php





/*

// LEFT LOGO
$section->addImage(
    $leftLogo,
    [
        "width" => 45,
        "height" => 45,
        "positioning" => "absolute",
        "posHorizontal" => \PhpOffice\PhpWord\Style\Image::POSITION_HORIZONTAL_LEFT,
        "posHorizontalRel" => \PhpOffice\PhpWord\Style\Image::POSITION_RELATIVE_TO_PARAGRAPH,
        "posVertical" => \PhpOffice\PhpWord\Style\Image::POSITION_VERTICAL_TOP,
        "posVerticalRel" => \PhpOffice\PhpWord\Style\Image::POSITION_RELATIVE_TO_PARAGRAPH,
        "marginLeft" => 100,
        "marginTop" => 0
    ]
);

// RIGHT LOGO
$section->addImage(
    $rightLogo,
    [
        "width" => 45,
        "height" => 45,
        "positioning" => "absolute",
        "posHorizontal" => \PhpOffice\PhpWord\Style\Image::POSITION_HORIZONTAL_RIGHT,
        "posHorizontalRel" => \PhpOffice\PhpWord\Style\Image::POSITION_RELATIVE_TO_PARAGRAPH,
        "posVertical" => \PhpOffice\PhpWord\Style\Image::POSITION_VERTICAL_TOP,
        "posVerticalRel" => \PhpOffice\PhpWord\Style\Image::POSITION_RELATIVE_TO_PARAGRAPH,
        "marginRight" => 100,
        "marginTop" => 0
    ]
);

// SCHOOL NAME
$section->addText(
    $schoolName,
    ["bold" => true, "size" => 16],
    ["alignment" => Jc::CENTER, "spaceAfter" => 0]
);

// SCHOOL ADDRESS
$section->addText(
    $schoolAddress,
    ["size" => 10],
    ["alignment" => Jc::CENTER, "spaceAfter" => 150]
);

// HORIZONTAL LINE
$line = $section->addTextRun(["alignment" => Jc::CENTER]);
$line->addText("____________________________________________________________________________________", ["size" => 10]);
*/

/*
// fix 3
// LEFT LOGO
$section->addImage(
    $leftLogo,
    [
        "width" => 45,
        "height" => 45,
        "positioning" => "absolute",
        "posHorizontal" => \PhpOffice\PhpWord\Style\Image::POSITION_HORIZONTAL_LEFT,
        "posHorizontalRel" => \PhpOffice\PhpWord\Style\Image::POSITION_RELATIVE_TO_PAGE,
        "posVertical" => \PhpOffice\PhpWord\Style\Image::POSITION_VERTICAL_TOP,
        "posVerticalRel" => \PhpOffice\PhpWord\Style\Image::POSITION_RELATIVE_TO_PAGE,
        "marginLeft" => 500,
        "marginTop" => 120
    ]
);

// RIGHT LOGO
$section->addImage(
    $rightLogo,
    [
        "width" => 45,
        "height" => 45,
        "positioning" => "absolute",
        "posHorizontal" => \PhpOffice\PhpWord\Style\Image::POSITION_HORIZONTAL_RIGHT,
        "posHorizontalRel" => \PhpOffice\PhpWord\Style\Image::POSITION_RELATIVE_TO_PAGE,
        "posVertical" => \PhpOffice\PhpWord\Style\Image::POSITION_VERTICAL_TOP,
        "posVerticalRel" => \PhpOffice\PhpWord\Style\Image::POSITION_RELATIVE_TO_PAGE,
        "marginRight" => 500,
        "marginTop" => 120
    ]
);

// SCHOOL NAME
$section->addText(
    $schoolName,
    ["bold" => true, "size" => 16],
    ["alignment" => Jc::CENTER, "spaceAfter" => 0]
);

// SCHOOL ADDRESS
$section->addText(
    $schoolAddress,
    ["size" => 10],
    ["alignment" => Jc::CENTER, "spaceAfter" => 150]
);

// HORIZONTAL LINE
$line = $section->addTextRun(["alignment" => Jc::CENTER]);
$line->addText("____________________________________________________________________________________", ["size" => 10]);



*/


/*

// LEFT LOGO

$section->addImage(
$leftLogo,
[
"width" => 45,
"height" => 45,

    "positioning" => "absolute",

    // POSITION SETTINGS
    "posHorizontal" => \PhpOffice\PhpWord\Style\Image::POSITION_HORIZONTAL_LEFT,
    "posHorizontalRel" => \PhpOffice\PhpWord\Style\Image::POSITION_RELATIVE_TO_PAGE,

    // PUSH INWARD
    "marginLeft" => 2000,

    // MOVE DOWN
    "marginTop" => 130
]

);

// RIGHT LOGO

$section->addImage(
$rightLogo,
[
"width" => 45,
"height" => 45,

    "positioning" => "absolute",

    // POSITION SETTINGS
    "posHorizontal" => \PhpOffice\PhpWord\Style\Image::POSITION_HORIZONTAL_RIGHT,
    "posHorizontalRel" => \PhpOffice\PhpWord\Style\Image::POSITION_RELATIVE_TO_PAGE,

    // PUSH INWARD FROM RIGHT
    "marginRight" => 2000,

    // MOVE DOWN
    "marginTop" => 120
]

);

// SCHOOL NAME

$section->addText(
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

// SCHOOL ADDRESS

$section->addText(
$schoolAddress,
[
"size" => 10
],
[
"alignment" => Jc::CENTER,
"spaceAfter" => 150

]
);



// HORIZONTAL LINE

$line = $section->addTextRun([
"alignment" => Jc::CENTER
]);

$line->addText(
"____________________________________________________________________________________",
[
"size" => 10
]
);

*/

// LEFT LOGO

$section->addImage(
$leftLogo,
[
"width" => 45,
"height" => 45,

    "positioning" => "absolute",

    // POSITION SETTINGS
    "posHorizontal" => \PhpOffice\PhpWord\Style\Image::POSITION_HORIZONTAL_LEFT,
    "posHorizontalRel" => \PhpOffice\PhpWord\Style\Image::POSITION_RELATIVE_TO_PAGE,

    // PUSH INWARD
    "marginLeft" => 1200,

    // MOVE DOWN
    "marginTop" => 120
]

);

// RIGHT LOGO

$section->addImage(
$rightLogo,
[
"width" => 45,
"height" => 45,

    "positioning" => "absolute",

    // POSITION SETTINGS
    "posHorizontal" => \PhpOffice\PhpWord\Style\Image::POSITION_HORIZONTAL_RIGHT,
    "posHorizontalRel" => \PhpOffice\PhpWord\Style\Image::POSITION_RELATIVE_TO_PAGE,

    // PUSH INWARD FROM RIGHT
    "marginRight" => 1200,

    // MOVE DOWN
    "marginTop" => 120
]

);







// ==========================
// HEADER TABLE (NO BORDERS)
// ==========================

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
"size" => 14
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

// SMALL SPACE

$section->addTextBreak(1);

// CENTERED HORIZONTAL LINE

$line = $section->addTextRun([
"alignment" => Jc::CENTER
]);

$line->addText(
"____________________________________________________________________________",
[
"size" => 8
]
);












// ===============================
// HEADER SECTION (NO TABLE)
// ===============================

$section->addLine([
"weight" => 1,
"width" => 500,
"height" => 0,
"color" => "000000"
],

[
"alignment" => Jc::CENTER,
"spaceAfter" => 100
]

);



// LEFT LOGO

$section->addImage(
$leftLogo,
[
"width" => 50,
"height" => 50,
"positioning" => "absolute",
"posHorizontal" => \PhpOffice\PhpWord\Style\Image::POSITION_HORIZONTAL_LEFT,
"posHorizontalRel" => "margin",
"posVerticalRel" => "line"
]
);

// RIGHT LOGO

$section->addImage(
$rightLogo,
[
"width" => 50,
"height" => 50,
"positioning" => "absolute",
"posHorizontal" => \PhpOffice\PhpWord\Style\Image::POSITION_HORIZONTAL_RIGHT,
"posHorizontalRel" => "margin",
"posVerticalRel" => "line"
]
);

// SCHOOL NAME

$section->addText(
$schoolName,
[
"bold" => true,
"size" => 14
],
[
"alignment" => Jc::CENTER,
"spaceAfter" => 0
]
);

// SCHOOL ADDRESS

$section->addText(
$schoolAddress,
[
"size" => 8
],
[
"alignment" => Jc::CENTER,
"spaceAfter" => 200
]
);

// HORIZONTAL LINE

$section->addLine([
"weight" => 1,
"width" => 450,
"height" => 0,
"color" => "000000"
]);

$section->addTextBreak(1);

// ===============================
// INFORMATION SECTION (NO TABLE)
// ===============================

// FIRST LINE

$section->addText(
"Subject: ".$scoresheet["subject_name"].
"          Class: ".$scoresheet["class_name"].
"          Term: ".$scoresheet["term"],
[
"bold" => true,
"size" => 8
],
[
"alignment" => Jc::BOTH,
"spaceAfter" => 150
]
);

// SECOND LINE

$section->addText(
"Class Teacher: ".$scoresheet["compiledby"].
"          Date Compiled: ".$scoresheet["date_created"],
[
"bold" => true,
"size" => 8
],
[
"alignment" => Jc::BOTH,
"spaceAfter" => 200
]
);

// ===============================
// TABLE GOES HERE
// ===============================

// AFTER TABLE

$section->addTextBreak(1);

// ===============================
// SUMMARY SECTION (NO TABLE)
// ===============================

$section->addText(
"Highest Score: ".$highest.
"          Lowest Score: ".$lowest.
"          Class Average: ".$classaverage,
[
"bold" => true,
"size" => 8
],
[
"alignment" => Jc::CENTER
]
);








set_time_limit(0);
ignore_user_abort(true);

function redirect_back($message, $home="/home"){

echo '<script>

alert("'.$message.'");

if(document.referrer){
    window.location.href = document.referrer;
}
else{
    window.location.href = "'.$home.'";
}

</script>';

exit();

}

require 'start_session.php';

if(!isset($_SESSION["initiate-downloads"])){
    
   http_response_code(403);
   redirect_back("Error: Downloads not set, please follow due clicks to download your desired files.");  
    
}

// CHECK DOWNLOAD PATH
if(!isset($_GET["dwn_path"])){

    http_response_code(404);
    redirect_back("Error: Download path not specified!");

}


// GET VALUES
$dwn_path   = trim($_GET["dwn_path"] ?? "");
$dwn_file   = trim($_GET["dwn_file"] ?? "");
$unlinkFile = trim($_GET["unlink_file"] ?? "");


// CHECK FILE NAME
if(empty($dwn_file)){

    http_response_code(404);
    redirect_back("Error: No downloadable file specified!");

}


// BASE DIRECTORY
$baseDir = realpath($_SERVER["DOCUMENT_ROOT"] . "/".$dwn_path);

if(!$baseDir){

    http_response_code(403);
    redirect_back("Error: Invalid download directory!");

}


// BUILD SAFE FILE PATH
$file = realpath($baseDir . "/" . $dwn_file);


// SECURITY CHECK
if(
    !$file ||
    !file_exists($file) ||
    strpos($file, $baseDir) !== 0
){

    http_response_code(404);
   redirect_back("Error: File not found!");

}


// CLEAR OUTPUT BUFFER
if(ob_get_level()){
    ob_end_clean();
}


// DOWNLOAD HEADERS
header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="' . basename($file) . '"');
header('Content-Length: ' . filesize($file));
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');

flush();


// SEND FILE
readfile($file);


// DELETE FILE IF REQUIRED
if($unlinkFile === "true"){

    unlink($file);

}


exit();

 
 
 
 
 
 
 
 
 
 

//HEADER SECTION

$headerTable = $section->addTable([
    "alignment" => JcTable::CENTER,
    "borderSize" => 0,
    "cellMargin" => 20
]);

$headerTable->addRow();


// LEFT LOGO
$cell = $headerTable->addCell(1500);

if(file_exists($leftLogo)){

    $cell->addImage($leftLogo,[
        "width" => 50,
        "height" => 50,
        "alignment" => Jc::CENTER
    ]);
}


// CENTER DETAILS
$centerCell = $headerTable->addCell(7000);
$centerCell->addText(
    $schoolName,
    [
        "bold" => true,
        "size" => 14
    ],
    [
        "alignment" => Jc::CENTER
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


// RIGHT LOGO
$cell = $headerTable->addCell(1500);
if(file_exists($rightLogo)){
    $cell->addImage($rightLogo,[
        "width" => 50,
        "height" => 50,
        "alignment" => Jc::CENTER
    ]);
}


// HORIZONTAL LINE


$section->addText(
    "__________________________________________________________________________________________________________",
    [
        "size" => 8
    ],
    [
        "alignment" => Jc::CENTER
    ]
);

$section->addTextBreak(1);

//INFORMATION SECTION

$infoTable = $section->addTable([
    "borderSize" => 0,
    "alignment" => JcTable::CENTER,
    "cellMargin" => 40
]);


// FIRST ROW
$infoTable->addRow();
$infoTable->addCell(4500)->addText(
    "Subject: ".$scoresheet["subject_name"],
    [
        "bold" => true,
        "size" => 8
    ],
    [
        "alignment" => Jc::START
    ]
);

$infoTable->addCell(4500)->addText(
    "Class: ".$scoresheet["class_name"],
    [
        "bold" => true,
        "size" => 8
    ],
    [
        "alignment" => Jc::START
    ]
);


// SECOND ROW
$infoTable->addRow();
$infoTable->addCell(4500)->addText(
    "Class Teacher: ".$scoresheet["compiledby"],
    [
        "bold" => true,
        "size" => 8
    ]
);

$infoTable->addCell(4500)->addText(
    "Date Compiled: ".$scoresheet["date_created"],
    [
        "bold" => true,
        "size" => 8
    ]
);

$section->addTextBreak(1);


// TABLE STYLE

$tableStyle = [
    "borderSize" => 4,
    "borderColor" => "000000",
    "alignment" => JcTable::CENTER,
    "cellMargin" => 20
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


 //TABLE HEADER

$table->addRow();

$table->addCell(500)->addText(
    "S/N",
    ["bold"=>true,"size"=>7],
    ["alignment"=>Jc::CENTER]
);

$table->addCell(2800)->addText(
    "Student Name",
    ["bold"=>true,"size"=>7],
    ["alignment"=>Jc::CENTER]
);



//CA HEADERS


foreach($scoresheet["assessment_pattern"] as $index => $mark){

    $caNo = $index + 1;
    $table->addCell(700)->addText(
        "CA".$caNo."\n(".$mark.")",
        [
            "bold" => true,
            "size" => 7
        ],
        [
            "alignment" => Jc::CENTER
        ]
    );
}


//OTHER HEADERS

$table->addCell(800)->addText(
    "Exam\n(".$scoresheet["maxexam"].")",
    [
        "bold" => true,
        "size" => 7
    ],
    [
        "alignment" => Jc::CENTER
    ]
);

$table->addCell(800)->addText(
    "Total\n(".$scoresheet["maxtotal"].")",
    [
        "bold" => true,
        "size" => 7
    ],
    [
        "alignment" => Jc::CENTER
    ]
);

$table->addCell(800)->addText(
    "Position",
    [
        "bold" => true,
        "size" => 7
    ],
    [
        "alignment" => Jc::CENTER
    ]
);

$table->addCell(700)->addText(
    "Grade",
    [
        "bold" => true,
        "size" => 7
    ],
    [
        "alignment" => Jc::CENTER
    ]
);


//TABLE DATA

foreach($scoresheet["rows"] as $key => $row){

    $table->addRow();
    $table->addCell(500)->addText(
        $key + 1,
        ["size"=>7],
        ["alignment"=>Jc::CENTER]
    );

    $table->addCell(2800)->addText(
        $row["student"],
        ["size"=>7],
        ["alignment"=>Jc::START]
    );

    // CAS
    foreach($row["cas"] as $ca){

        $table->addCell(700)->addText(
            $ca,
            ["size"=>7],
            ["alignment"=>Jc::CENTER]
        );
    }

    // EXAM
    $table->addCell(800)->addText(
        $row["exam"],
        ["size"=>7],
        ["alignment"=>Jc::CENTER]
    );

    // TOTAL
    $table->addCell(800)->addText(
        $row["total"],
        ["size"=>7],
        ["alignment"=>Jc::CENTER]
    );

    // POSITION
    $table->addCell(800)->addText(
        $row["position"],
        ["size"=>7],
        ["alignment"=>Jc::CENTER]
    );

    // GRADE
    $table->addCell(700)->addText(
        $row["grade"],
        ["size"=>7],
        ["alignment"=>Jc::CENTER]
    );
}


// BOTTOM SUMMARY

$section->addTextBreak(1);
$summaryTable = $section->addTable([
    "borderSize" => 0,
    "alignment" => JcTable::CENTER
]);

$summaryTable->addRow();
$summaryTable->addCell(3000)->addText(
    "Highest Score: ".$highest,
    [
        "bold" => true,
        "size" => 8
    ],
    [
        "alignment" => Jc::CENTER
    ]
);

$summaryTable->addCell(3000)->addText(
    "Lowest Score: ".$lowest,
    [
        "bold" => true,
        "size" => 8
    ],
    [
        "alignment" => Jc::CENTER
    ]
);

$summaryTable->addCell(3000)->addText(
    "Class Average: ".$average,
    [
        "bold" => true,
        "size" => 8
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