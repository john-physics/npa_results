<?php

function isInkPixel($r, $g, $b)
{
    $brightness = ($r + $g + $b) / 3;

    /*
     * How much bluer than red/green
     */
    $blueStrength = $b - (($r + $g) / 2);

    /*
     * Blue pen
     */
    if ($blueStrength >= 10) {
        return true;
    }

    /*
     * Very dark pixels (black ink)
     */
    if ($brightness < 120) {
        return true;
    }

    return false;
}


function processSignature($inputPath, $outputPath)
{
    if (!extension_loaded('gd')) {

        throw new Exception(
            "GD library is not available."
        );
    }

    $info = getimagesize($inputPath);

    if (!$info) {

        throw new Exception(
            "Invalid image file."
        );
    }

    switch ($info['mime']) {

        case 'image/jpeg':
            $image = imagecreatefromjpeg($inputPath);
        break;

        case 'image/png':
            $image = imagecreatefrompng($inputPath);
        break;

        case 'image/webp':
            $image = imagecreatefromwebp($inputPath);
        break;

        default:

            throw new Exception(
                "Unsupported image format."
            );
    }

    /*
     * Slight contrast boost
     * Helps separate ink from paper.
     */


    imagefilter(
        $image,
        IMG_FILTER_CONTRAST,
        -20
    );



    $width  = imagesx($image);
    $height = imagesy($image);

    /*
     * Transparent canvas
     */
    $output = imagecreatetruecolor(
        $width,
        $height
    );

    imagealphablending(
        $output,
        false
    );

    imagesavealpha(
        $output,
        true
    );

    $transparent = imagecolorallocatealpha(
        $output,
        255,
        255,
        255,
        127
    );

    imagefill(
        $output,
        0,
        0,
        $transparent
    );

    /*
     * Crop bounds
     */
    $minX = $width;
    $minY = $height;
    $maxX = 0;
    $maxY = 0;

    for ($y = 0; $y < $height; $y++) {

        for ($x = 0; $x < $width; $x++) {

            $pixel = imagecolorat(
                $image,
                $x,
                $y
            );

            $colors = imagecolorsforindex(
                $image,
                $pixel
            );

            $r = $colors['red'];
            $g = $colors['green'];
            $b = $colors['blue'];

            if (
                !isInkPixel(
                    $r,
                    $g,
                    $b
                )
            ) {
                continue;
            }

            /*
             * Preserve original ink colour
             */
            $brightness =
                ($r + $g + $b) / 3;

            /*
             * Darker pixels become
             * more opaque.
             */
            $alpha = min(
                127,
                max(
                    0,
                    intval(($brightness / 255) * 60)
                )
            );

            $ink = imagecolorallocatealpha(
                $output,
                $r,
                $g,
                $b,
                $alpha
            );

            imagesetpixel(
                $output,
                $x,
                $y,
                $ink
            );

            /*
             * Track crop area
             */
            if ($x < $minX) $minX = $x;
            if ($x > $maxX) $maxX = $x;

            if ($y < $minY) $minY = $y;
            if ($y > $maxY) $maxY = $y;
        }
    }

    /*
     * No signature found
     */
    if (
        $minX >= $width ||
        $minY >= $height
    ) {

        imagedestroy($image);
        imagedestroy($output);

        return false;
    }

    /*
     * Crop padding
     */
    $padding = 10;

    $minX = max(
        0,
        $minX - $padding
    );

    $minY = max(
        0,
        $minY - $padding
    );

    $maxX = min(
        $width - 1,
        $maxX + $padding
    );

    $maxY = min(
        $height - 1,
        $maxY + $padding
    );

    $cropped = imagecrop(
        $output,
        [
            'x'      => $minX,
            'y'      => $minY,
            'width'  => $maxX - $minX + 1,
            'height' => $maxY - $minY + 1
        ]
    );

if ($cropped !== false) {

    imagedestroy($output);

    $output = $cropped;

    imagealphablending($output, false);
    imagesavealpha($output, true);
}

    imagepng(
        $output,
        $outputPath,
        9
    );

    imagedestroy($image);
    imagedestroy($output);

    return true;
}



