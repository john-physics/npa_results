<?php


echo "<h2>Imagick Test</h2>";

if (extension_loaded('imagick')) {

    echo "<p style='color:green'>
        ✓ Imagick extension is installed
    </p>";

    echo "<p><strong>Version:</strong></p>";

    echo "<pre>";
    print_r(Imagick::getVersion());
    echo "</pre>";

} else {

    echo "<p style='color:red'>
        ✗ Imagick extension is NOT installed
    </p>";
}