<?php

require $_SERVER["DOCUMENT_ROOT"].'/page_init.php';

if(!check_staff_login($conn)){

header("Location:/home");
exit();
}


// <!-- Message send report -->
 if(isset($_GET["msg_report"])){
 
   $msg = $_GET["msg_report"];
   $report = $_GET["report"];
   
   report_notice($report,$msg); 
   
  echo '<script src="/scripts/report_notice.js"></script>';
     
 }


$BASE_ROUTE = "/background-remover";

if(!isset($_GET['folder'])){


    header(
        "Location:"
        .$BASE_ROUTE
        ."?message="
        .urlencode(
            "No folder selected."
        )
    );

    exit;

}



$folderName = basename($_GET['folder']);

$folderPath = $_SERVER["DOCUMENT_ROOT"]."/background-remover/uploads/".$folderName;
$imgsource = "/background-remover/uploads/".$folderName;

if(!is_dir($folderPath)){

    header(
       "Location:"
       .$BASE_ROUTE
       ."?message="
       .urlencode("Folder does not exist.")
        );

    exit;

}



$images = glob(
    $folderPath."/*.png"
);



if(!$images){

    header(
        "Location:"
        .$BASE_ROUTE
        ."?message="
        .urlencode(
            "No processed images found."
        )
    );

    exit;

}

// sort($images);

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name ="description" content="View processed Signatures">
<meta name ="key words" content="View Signatures, NewPhase, Academy,ABC">
<meta name="author" content="John Ella">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Processed Signatures</title>

<style>

*{
    box-sizing:border-box;
}


body{

    margin:0;

    font-family:
    Arial,
    Helvetica,
    sans-serif;

    background:#f4f6f9;

    color:#222;

}



.container{

    max-width:1100px;

    margin:auto;

    padding:30px 20px;

}



.header{

    background:white;

    border-radius:16px;

    padding:25px;

    margin-bottom:25px;

    box-shadow:
    0 10px 30px rgba(0,0,0,.08);

}



.header h1{

    margin:0 0 10px;

    font-size:28px;

}



.folder-name{

    color:#666;
    font-size:14px;

}



.actions{
   display: flex;
    margin-top:20px;
    gap: 10px;
  overflow-x: auto;
  align-items: center;
  justify-content: center;
  width: 100%;
}


.btn{

    display:inline-block;
    padding:5px;
    border-radius:5px;
    text-decoration:none;
    background:#5b1028;
    color:white;
    transition:.3s;
    text-align: center;
    font-size: 10px;
    width: 60%;
   
}

.btn:hover{

    opacity:.85;

}

.gallery{

    display:grid;

    grid-template-columns:
    repeat(
        auto-fit,
        minmax(250px,1fr)
    );

    gap:20px;

}

.card{

    background:white;
    border-radius:16px;
    padding:20px;
    box-shadow:
    0 8px 25px rgba(0,0,0,.08);

}



.card img{

    width:100%;

    height:220px;

    object-fit:contain;

    background:
    repeating-conic-gradient(
        #eee 0% 25%,
        #fff 0% 50%
    )
    50% /
    20px 20px;

    border-radius:10px;

}



.filename{

    margin-top:15px;

    font-size:14px;

    color:#555;

    word-break:break-all;

}

.filename a{
    
    text-decoration: none;
    font-size: 12px;
    color: rgb(100,150,210);
    cursor: pointer;
}
.filename a:hover{
  text-decoration: underline;
}

</style>


</head>


<body>


<div class="container">


<div class="header">


<h1>
Processed Signatures
</h1>


<div class="folder-name">
<?=count($images)?> processed signature(s)
</div>

<?php
$deltoken = bin2hex(random_bytes(8));
$tokenhash = password_hash($deltoken,PASSWORD_DEFAULT);
$_SESSION["del-sign-token"] = $tokenhash;

?>

<div class="actions">

<a class="btn"
href="/background-remover/download?folder=<?=urlencode($folderName)?>">
Download Signatures
</a>

<a class="btn"
href="/background-remover/download?folder=<?=urlencode($folderName)?>&del_signa_tures=<?=urlencode($deltoken)?>">
Delete Signatures
</a>

<a class="btn"
href="/background-remover">
 New Signatures
</a>

<a class="btn"
href="/home">
Back to Dashboard
</a>
  </div>
</div>


<div class="gallery">

<?php foreach($images as $image): ?>

<div class="card">

<img src="<?=$imgsource.'/'.htmlspecialchars(basename($image))?>" loading="lazy" alt="processed signature">

<div class="filename">

<?php

echo '<a href="/add_new?use_proccessed_signature&signature='.basename($image).'&folder='.$folderName.'" target="_blank">Use as staff signature</a>';

?>

</div>


</div>
 

<?php endforeach; ?>


</div>



</div>


</body>

</html>