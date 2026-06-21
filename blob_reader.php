<?php
if (isset($_GET["blob_type"])) {
    require './page_init.php';

    // Collect parameters
    $Id          = (int)$_GET["blob_id"];
    $db          = $_GET["db"] ?? '';
    $table       = $_GET["tb"] ?? '';
    $blobColumn  = $_GET["blob_type"];
    $blobMimeCol = $blobColumn . '_Mime_Type';

    // Pick the right database connection
    if ($db === "h") {
        $conn = $home_db;
    } elseif ($db === "e") {
        $conn = $era_db;
    } else {
        $conn = null;
    }

    if ($conn && $table) {
        $blob = collect_user_data($conn, $table, 'id', $Id, 'i');
        $blobContent  = $blob[$blobColumn] ?? '';
        $blobMimeType = $blob[$blobMimeCol] ?? '';

        if ($blobContent) {
            if ($blobMimeType) {

                // Clear any output buffering to prevent corruption
                if (ob_get_length()) {
                    ob_end_clean();
                }

                // Force download if user used <a download> or added ?download=1
                $download = isset($_GET['download']) ? true : false;
                $filename = $blobColumn . '.' . pathinfo($blobMimeType, PATHINFO_EXTENSION);
                $disposition = $download ? 'attachment' : 'inline';

                // Send headers
                header("Content-Type: " . $blobMimeType);
                header("Content-Length: " . strlen($blobContent));
                header("Content-Disposition: $disposition; filename=\"$filename\"");
                header("Accept-Ranges: none"); // Prevent partial request issues
                header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
                header("Pragma: no-cache");
                header("Expires: 0");

                // Output the blob directly
                echo $blobContent;
                flush();
                exit();

            } else {
                echo 'Failed to stream Blob: Blob Content-Type not available!';
                exit();
            }
        } else {
            echo 'Empty blob content!';
            exit();
        }

    } else {
        echo 'No connection or table name specified!';
        exit();
    }
} else {
    echo 'No blob type supplied!';
    exit();
}
?>