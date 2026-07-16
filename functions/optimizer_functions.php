<?php


function buildQueue($directory, $maxSizeKB, $batchSize){
    $queue = [];

    $allowedExtensions = [
        'jpg',
        'jpeg',
        'png',
        'webp'
    ];

    $iterator = new DirectoryIterator($directory);

    foreach ($iterator as $file) {

        if ($file->isDot()) {
            continue;
        }

        if (!$file->isFile()) {
            continue;
        }

        $filename = $file->getFilename();

        /*
         * Skip signatures
         */
        if (strpos($filename, 'signature_') === 0) {
            continue;
        }

        $extension = strtolower(
            pathinfo(
                $filename,
                PATHINFO_EXTENSION
            )
        );

        if (!in_array($extension, $allowedExtensions)) {
            continue;
        }

        if (
            $file->getSize() <= ($maxSizeKB * 1024)
        ) {
            continue;
        }

        $queue[] = $file->getPathname();

        /*
         * Stop once batch is full
         */
        if (count($queue) >= $batchSize) {
            break;
        }
    }

    return $queue;
}

function calculateDimensions(
    $originalWidth,
    $originalHeight,
    $maxWidth,
    $maxHeight
){

    /*
     * Already within limits.
     */
    if(
        $originalWidth <= $maxWidth &&
        $originalHeight <= $maxHeight
    ){

        return [
            "width"=>$originalWidth,
            "height"=>$originalHeight
        ];

    }

    $ratio = min(
        $maxWidth / $originalWidth,
        $maxHeight / $originalHeight
    );

    return [

        "width" => max(
            1,
            (int)round($originalWidth * $ratio)
        ),

        "height" => max(
            1,
            (int)round($originalHeight * $ratio)
        )

    ];

}

function image_has_transparency($image)
{

    $width = imagesx($image);

    $height = imagesy($image);

    for($y=0;$y<$height;$y++){

        for($x=0;$x<$width;$x++){

            $rgba = imagecolorsforindex(
                $image,
                imagecolorat($image,$x,$y)
            );

            if($rgba["alpha"]>0){

                return true;

            }

        }

    }

    return false;

}


function formatBytes($bytes)
{

    if($bytes>=1073741824){

        return round($bytes/1073741824,2)." GB";

    }

    if($bytes>=1048576){

        return round($bytes/1048576,2)." MB";

    }

    if($bytes>=1024){

        return round($bytes/1024,2)." KB";

    }

    return $bytes." Bytes";

}


function updateProfileImageReference($oldName, $newName)
{
    global $conn;

    $tables = [
        "students",
        "staffs"
    ];

    $updatedRows = 0;

    foreach ($tables as $table) {

        $stmt = $conn->prepare("
            UPDATE {$table}
            SET profile = ?
            WHERE profile = ?
        ");

        if (!$stmt) {
            continue;
        }

        $stmt->bind_param(
            "ss",
            $newName,
            $oldName
        );

        $stmt->execute();

        $updatedRows += $stmt->affected_rows;

        $stmt->close();
    }

    return [
        "updated" => ($updatedRows > 0),
        "rows"    => $updatedRows
    ];
}


function optimizeImage(
    $imagePath,
    $maxWidth,
    $maxHeight,
    $quality = 80,
    $preserveTransparency = true
){

    if (!extension_loaded("gd")) {

        return [
            "status"  => false,
            "message" => "GD extension is not enabled."
        ];

    }

    if (!file_exists($imagePath)) {

        return [
            "status"  => false,
            "message" => "Image not found."
        ];

    }

    $info = getimagesize($imagePath);

    if (!$info) {

        return [
            "status"  => false,
            "message" => "Invalid image."
        ];

    }

    switch ($info["mime"]) {

        case "image/jpeg":
            $source = imagecreatefromjpeg($imagePath);
        break;

        case "image/png":
            $source = imagecreatefrompng($imagePath);
        break;

        case "image/webp":
            $source = imagecreatefromwebp($imagePath);
        break;

        default:

            return [
                "status"  => false,
                "message" => "Unsupported image format."
            ];

    }

    if (!$source) {

        return [
            "status"  => false,
            "message" => "Unable to load image."
        ];

    }

    $oldSize   = filesize($imagePath);
    $oldWidth  = imagesx($source);
    $oldHeight = imagesy($source);

    $dimension = calculateDimensions(
        $oldWidth,
        $oldHeight,
        $maxWidth,
        $maxHeight
    );

    $canvas = imagecreatetruecolor(
        $dimension["width"],
        $dimension["height"]
    );

    if (
        $preserveTransparency &&
        image_has_transparency($source)
    ) {

        imagealphablending($canvas, false);
        imagesavealpha($canvas, true);

        $transparent = imagecolorallocatealpha(
            $canvas,
            255,
            255,
            255,
            127
        );

        imagefill(
            $canvas,
            0,
            0,
            $transparent
        );

    }

    imagecopyresampled(

        $canvas,
        $source,

        0,
        0,
        0,
        0,

        $dimension["width"],
        $dimension["height"],

        $oldWidth,
        $oldHeight

    );

    /*
     * Build filenames
     */
    $directory = dirname($imagePath);

    $filename = pathinfo(
        $imagePath,
        PATHINFO_FILENAME
    );

    $extension = strtolower(
        pathinfo(
            $imagePath,
            PATHINFO_EXTENSION
        )
    );

    /*
     * Temporary output
     */
    $tempPath = $directory . "/" . $filename . ".tmp.webp";

    imagewebp(
        $canvas,
        $tempPath,
        $quality
    );

    imagedestroy($source);
    imagedestroy($canvas);

    if (!file_exists($tempPath)) {

        return [
            "status"  => false,
            "message" => "Unable to save optimized image."
        ];

    }

    $newSize = filesize($tempPath);

    /*
     * Optimized image is not smaller.
     */
    if ($newSize >= $oldSize) {

        unlink($tempPath);

        return [

            "status"   => true,

            "old_size" => $oldSize,

            "new_size" => $oldSize,

            "saved"    => 0,

            "renamed"  => false,

            "database" => false

        ];

    }

    /*
     * Already WebP
     */
    if ($extension == "webp") {

        unlink($imagePath);

        rename(
            $tempPath,
            $imagePath
        );

        return [

            "status"   => true,

            "old_size" => $oldSize,

            "new_size" => $newSize,

            "saved"    => ($oldSize - $newSize),

            "renamed"  => false,

            "database" => false

        ];

    }

    /*
     * JPG / PNG
     */

    $newPath = $directory . "/" . $filename . ".webp";

    if (file_exists($newPath)) {

        unlink($newPath);

    }

    if (!rename($tempPath, $newPath)) {

        unlink($tempPath);

        return [

            "status"  => false,

            "message" => "Unable to rename optimized image."

        ];

    }

    unlink($imagePath);

    $db = updateProfileImageReference(

        basename($imagePath),

        basename($newPath)

    );

    return [

       "status"   => true,
       "old_size" => $oldSize,
       "new_size" => $newSize,
       "saved"    => ($oldSize - $newSize),
       "renamed"  => true,
       "database" => $db["updated"]

    ];

}



