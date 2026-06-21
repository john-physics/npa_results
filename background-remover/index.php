<?php

require $_SERVER["DOCUMENT_ROOT"].'/page_init.php';


if(!check_staff_login($conn)){

header("Location:/home");
exit();
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name ="description" content="process Signatures">
<meta name ="key words" content=" process Signatures, NewPhase, Academy,ABC">
<meta name="author" content="John Ella">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Signature Cleaner</title>
<link rel="stylesheet" href="assets/style.css">

</head>

<body>


<div class="container">

    <div class="card">

<?php

if(isset($_GET['message'])){

echo "

<div class='message'>

".htmlspecialchars($_GET['message'])."

</div>";

}

?>


 <h1>✍ Signature Cleaner</h1>

      
        <p>
            Upload up to 5 signature images
            and remove the paper background.
        </p>


    <form action="upload" method="POST" enctype="multipart/form-data" id="upload-form">


<div class="upload-box" id="uploadBox">

<div class="icon">
📄
</div>

<h3>
Drop your images here
</h3>

<span>
or
</span>


<label class="button">

Choose Images

<input 
type="file"
name="images[]"
id="images"
accept="image/*"
multiple
hidden>

</label>


<small>
Maximum 5 images
</small>

</div>


<div class="preview" id="preview"></div>

<div class="spinner" id="spinner"></div>
<button class="process-btn">

Process Signatures

</button>

</form>
    

<a
href="/background-remover/folders"
class="btn"
>
View Processed Signatures
</a>
 </div>
 
 
 <div class="upload-tips">

    <h3>📌 For Best Results</h3>

    <ul>

        <li>Use a pure white background.</li>

        <li>Ensure good lighting.</li>

        <li>Avoid shadows on the paper.</li>

        <li>Upload a sharp, high-resolution image.</li>

    </ul>

</div>
 
</div>

<script src="assets/script.js"></script>

</body>
</html>


