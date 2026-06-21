<?php 
// Run this inside your fpdf/makefont/ folder
// Usage: http://localhost:8080/pdf/fpdf/makefont/convert_font.php?file=GreatVibes-Regular.ttf

require('makefont.php');

// Check if file is provided
if (!isset($_GET['file'])) {
    die("Please provide a TTF file name, e.g. ?file=GreatVibes-Regular.ttf");
}

$ttfFile = $_GET['file'];

// Make sure file exists
if (!file_exists($ttfFile)) {
    die("font file not found: " . htmlspecialchars($ttfFile));
}

// Convert to FPDF font format
try {
    MakeFont($ttfFile, 'cp1252');

    echo "Font converted successfully.<br>";
    echo " Copy the generated .php and .z files into your fpdf/font/ folder.<br>";
    echo "Then use it like this in your code:<br><br>";
    echo "<pre>";
    echo "\$pdf->AddFont('GreatVibes','','GreatVibes-Regular.php');\n";
    echo "\$pdf->SetFont('GreatVibes','',48);";
    echo "</pre>";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
} 