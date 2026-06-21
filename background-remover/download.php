<?php

require $_SERVER["DOCUMENT_ROOT"].'/start_session.php';

$BASE_ROUTE = "/background-remover";

if(!isset($_GET['folder'])){

    header(
        "Location:"
        .$BASE_ROUTE
    );

    exit;

}


$folderName =
    basename(
        $_GET['folder']
    );


$UPLOADS_DIR = $_SERVER['DOCUMENT_ROOT']."/background-remover/uploads";

$folderPath =
$UPLOADS_DIR."/".$folderName;


if(!is_dir($folderPath)){

    header(
        "Location:"
        .$BASE_ROUTE
        ."?message="
        .urlencode(
            "File folder not found."
        )
    );


    exit;

}


if(isset($_GET["del_signa_tures"]) && isset($_SESSION["del-sign-token"])){
    
 $deltoken = $_GET["del_signa_tures"];
 $tokenhash = $_SESSION["del-sign-token"];
 
if(password_verify($deltoken,$tokenhash)) {
    
 $dirconts = scandir($folderPath);
 
 foreach ($dirconts as $cont){
  
  if($cont == '.' || $cont == '..'){
      continue;
  }
  
 $targetfile = $folderPath.'/'.$cont;
  unlink($targetfile);
      
 }
 
 rmdir($folderPath);
    
 header(
        "Location:"
        .$BASE_ROUTE
        ."?message="
        .urlencode(
            "All proceed signatures in $folderName were deleted successfully"
        )
    );

    exit;    
  
}
    
 else{
     
    header(
        "Location:"
        .$BASE_ROUTE
        ."?message="
        .urlencode(
            "Invalid delete authorization token."
        )
    );

    exit;  
     
 }   
    
}


// CHECK ZIP SUPPORT
if(!class_exists('ZipArchive')){

    header(
        "Location:"
        .$BASE_ROUTE
        ."?message="
        .urlencode(
            "ZIP support is not enabled on this server. Download cannot continue."
        )
    );

    exit;

}


$zipName =
    "signatures_"
    .$folderName
    .".zip";

$tempZip =
    sys_get_temp_dir()
    ."/"
    .$zipName;

$zip = new ZipArchive();

if(
    $zip->open(
        $tempZip,
        ZipArchive::CREATE |
        ZipArchive::OVERWRITE
    ) !== true
){


    header(
        "Location:"
        .$BASE_ROUTE
        ."?message="
        .urlencode(
            "Unable to create ZIP file."
        )
    );


    exit;

}




$files = glob(
    $folderPath."/*.png"
);



foreach($files as $file){


    $zip->addFile(
        $file,
        basename($file)
    );


}



$zip->close();


if(!file_exists($tempZip)){


    header(
        "Location:"
        .$BASE_ROUTE
        ."?message="
        .urlencode(
            "ZIP creation failed."
        )
    );


    exit;

}




// Send ZIP to browser


header(
    "Content-Type: application/zip"
);


header(
    "Content-Disposition: attachment; filename=\""
    .$zipName
    ."\""
);


header(
    "Content-Length: "
    .filesize($tempZip)
);


// Send ZIP

readfile($tempZip);

// Cleanup after script finishes

register_shutdown_function(function() use ($tempZip){

    if(file_exists($tempZip)){

        unlink($tempZip);

    }

});


exit;