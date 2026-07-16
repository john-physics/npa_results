<?php

require $_SERVER["DOCUMENT_ROOT"].'/start_session.php';

// Application route

$BASE_ROUTE = "/background-remover";

// CHECK GD FIRST

if(!extension_loaded('gd')){


    header(
        "Location:"
        .$BASE_ROUTE
        ."?message="
        .urlencode(
            "GD library is not enabled on this server. Image processing cannot continue without it."
        )
    );

    exit;

}




// CHECK FILES

if(
    !isset($_FILES['images'])
    ||
    empty($_FILES['images']['name'][0])
){


    header(
        "Location:"
        .$BASE_ROUTE
        ."?message="
        .urlencode(
            "No images selected."
        )
    );


    exit;

}




$files = $_FILES['images'];



// MAXIMUM LIMIT

if(count($files['name']) > 5){


    header(
        "Location:"
        .$BASE_ROUTE
        ."?message="
        .urlencode(
            "Maximum of 5 images allowed."
        )
    );


    exit;

}





try{


    // LOAD PROCESSOR

    require_once "process.php";

    // CREATE UNIQUE FOLDER

    $folderName =
        date("Ymd_His")
        ."_"
        .substr(
            md5(uniqid()),
            0,
            8
        );


$UPLOADS_DIR = $_SERVER['DOCUMENT_ROOT']."/background-remover/uploads";

$folder =
$UPLOADS_DIR."/".$folderName;


if(!is_dir($folder)){

        mkdir(
            $folder,
            0755,
            true
        );


    }




    $processedCount = 0;

    // PROCESS EACH IMAGE

    for(
        $i = 0;
        $i < count($files['name']);
        $i++
    ){



        // Skip failed uploads

        if(
            $files['error'][$i] !== UPLOAD_ERR_OK
        ){

            continue;

        }

        $tmp =
            $files['tmp_name'][$i];

        // VERIFY IMAGE

        $imageInfo =
            getimagesize($tmp);

        if($imageInfo === false){

            continue;

        }


        // Allowed formats

        $allowed = [

            'image/jpeg',
            'image/png',
            'image/webp'

        ];



        if(
            !in_array(
                $imageInfo['mime'],
                $allowed
            )
        ){

            continue;

        }

        // Generate safe filename


        $name =
            uniqid(
                "signature_",
                true
            )
            .
            "."
            .
            strtolower(
                pathinfo(
                    $files['name'][$i],
                    PATHINFO_EXTENSION
                )
            );


        $originalPath =
            $folder
            ."/"
            .$name;

        if(
            move_uploaded_file(
                $tmp,
                $originalPath
            )
        ){

            $processedName =
                pathinfo(
                    $name,
                    PATHINFO_FILENAME
                )
                .
                ".webp";


            $outputPath =
                $folder
                ."/"
                .$processedName;


            processSignature(
                $originalPath,
                $outputPath
            );
            
            // Remove original

            unlink(
                $originalPath
            );

            $processedCount++;


        }


    }


    // Nothing processed

    if($processedCount === 0){

        rmdir($folder);

        throw new Exception(
            "No valid image was processed."
        );


    }


    $_SESSION['current_folder'] =
        $folderName;

    header(
        "Location:"
        .$BASE_ROUTE
        ."/view?folder="
        .urlencode(
            $folderName
        )
    );


    exit;


}
catch(Exception $e){


    header(
        "Location:"
        .$BASE_ROUTE
        ."?message="
        .urlencode(
            $e->getMessage()
        )
    );


    exit;


}

