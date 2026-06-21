<?php

require $_SERVER["DOCUMENT_ROOT"].'/page_init.php';

if(!check_staff_login($conn)){

header("Location:/home");
exit();
}


$BASE_ROUTE = "/background-remover";
$uploadsDir = $_SERVER["DOCUMENT_ROOT"]."/background-remover/uploads";

$folders = [];

if(is_dir($uploadsDir)){

    $items = scandir($uploadsDir);

    foreach($items as $item){

        if(
            $item === "."
            ||
            $item === ".."
        ){
            continue;
        }

        $path =
            $uploadsDir
            ."/"
            .$item;


        if(is_dir($path)){

            $images =
                glob(
                    $path."/*.png"
                );

            $folders[] = [

                'name'  => $item,

                'count' => count($images),

                'time'  => filemtime($path)

            ];

        }

    }

}



// newest first

usort(

    $folders,

    function($a,$b){

        return
            $b['time']
            <=>
            $a['time'];

    }

);

?>
<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name ="description" content="Signatures folders">
<meta name ="key words" content="Processed, Signatures,ABC">
<meta name="author" content="John Ella">
<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Processed Folders</title>

<style>

*{
    box-sizing:border-box;
}

body{

    margin:0;

    background:#f4f6f9;

    font-family:
    Arial,
    Helvetica,
    sans-serif;

    color:#222;

}



.container{

    max-width:1100px;

    margin:auto;

    padding:30px 20px;

}



.header{

    background:#fff;

    padding:25px;

    border-radius:16px;

    margin-bottom:25px;

    box-shadow:
    0 10px 30px rgba(0,0,0,.08);

}



.header h1{

    margin:0 0 10px;

}



.subtitle{

    color:#666;

}



.grid{

    display:grid;

    grid-template-columns:
    repeat(
        auto-fit,
        minmax(280px,1fr)
    );

    gap:20px;

}



.card{

    background:#fff;

    padding:20px;

    border-radius:16px;

    box-shadow:
    0 8px 25px rgba(0,0,0,.08);

}



.folder-name{

    font-weight:bold;

    font-size:18px;

    margin-bottom:10px;

    word-break:break-all;

}



.meta{

    color:#666;

    font-size:14px;

    margin-bottom:8px;

}



.btn{

    display:inline-block;

    margin-top:15px;

    padding:10px 18px;

    text-decoration:none;

    color:#fff;

    background:#5b1028;

    border-radius:10px;

    transition:.3s;

}



.btn:hover{

    opacity:.85;

}



.empty{

    background:#fff;

    padding:30px;

    border-radius:16px;

    text-align:center;

    box-shadow:
    0 8px 25px rgba(0,0,0,.08);

}

</style>

</head>

<body>


<div class="container">


<div class="header">

<h1>
Processed Signature Folders
</h1>

<div class="subtitle">

Browse previously processed signatures.

</div>

</div>



<?php if(empty($folders)): ?>

<div class="empty">

No processed folders found.

</div>

<?php else: ?>


<div class="grid">

<?php foreach($folders as $folder): ?>

<div class="card">

<div class="folder-name">

<?=htmlspecialchars(
    $folder['name']
)?>

</div>


<div class="meta">

Images:
<?=number_format(
    $folder['count']
)?>

</div>


<div class="meta">

Created:

<?=date(
    "d M Y, h:i A",
    $folder['time']
)?>

</div>


<a
class="btn"
href="<?=$BASE_ROUTE?>/view?folder=<?=urlencode($folder['name'])?>"
>

View Folder

</a>

</div>

<?php endforeach; ?>

</div>

<?php endif; ?>


</div>

</body>

</html>