<?php

class DatabaseExporter
{
    /**
     * Database connection
     */
    private mysqli $conn;
    private string $databaseName;
    /**
     * Constructor
     */
    public function __construct(mysqli $conn)
    {
    $this->conn = $conn;
    $this->databaseName = $this->conn
    ->query("SELECT DATABASE()")
    ->fetch_row()[0];
    }

    /**
     * Get all tables in the current database
     *
     * @return array
     * @throws Exception
     */
    private function getTables(): array
    {
        $tables = [];

        $result = $this->conn->query("SHOW TABLES");

        if (!$result) {
            throw new Exception(
                "Unable to retrieve tables: " . $this->conn->error
            );
        }

        while ($row = $result->fetch_array(MYSQLI_NUM)) {
            $tables[] = $row[0];
        }

        $result->free();

        return $tables;
    }

/**
 * Get the CREATE TABLE statement for a table.
 *
 * @param string $table
 * @return string
 * @throws Exception
 */
private function getCreateStatement(string $table): string
{
    $table = $this->conn->real_escape_string($table);

    $result = $this->conn->query("SHOW CREATE TABLE `$table`");

    if (!$result) {
        throw new Exception(
            "Unable to retrieve CREATE statement for '{$table}': " .
            $this->conn->error
        );
    }

    $row = $result->fetch_assoc();

    $result->free();

    return $row['Create Table'];
}    
    
  
  /**
 * Get all columns in a table.
 *
 * @param string $table
 * @return array
 * @throws Exception
 */
private function getColumns(string $table): array
{
    $columns = [];

    $table = $this->conn->real_escape_string($table);

    $result = $this->conn->query("SHOW COLUMNS FROM `$table`");

    if (!$result) {
        throw new Exception(
            "Unable to retrieve columns for '{$table}': " .
            $this->conn->error
        );
    }

    while ($row = $result->fetch_assoc()) {
        $columns[] = $row['Field'];
    }

    $result->free();

    return $columns;
}


/**
 * Get all rows from a table.
 *
 * @param string $table
 * @return array
 * @throws Exception
 */
private function getRows(string $table): array
{
    $rows = [];

    $table = $this->conn->real_escape_string($table);

    $result = $this->conn->query("SELECT * FROM `$table`");

    if (!$result) {
        throw new Exception(
            "Unable to retrieve rows from '{$table}': " .
            $this->conn->error
        );
    }

    while ($row = $result->fetch_assoc()) {
        $rows[] = $row;
    }

    $result->free();

    return $rows;
}
   
   
  /**
 * Build the backup array.
 *
 * @return array
 * @throws Exception
 */
private function buildBackup(): array
{
$backup = [

     'version'        => BACKUP_VERSION,
     'author'         => BACKUP_AUTHOR,
     'signature'      => BACKUP_SIGNATURE,
   'created_at'     => date('Y-m-d H:i:s'),
   'database' => $this->databaseName,

    'php_version'    => PHP_VERSION,
    'mysql_version'  => $this->conn->server_info,
    'tables'         => []

];

    $tables = $this->getTables();

    foreach ($tables as $table) {

        $backup['tables'][$table] = [

            'create' => $this->getCreateStatement($table),

            'rows' => $this->getRows($table)

        ];

    }

    return $backup;
} 
   
  
/**
 * Save backup array as JSON.
 *
 * @param array $backup
 * @return string
 * @throws Exception
 */
private function saveJson(array $backup): string
{
    $filename = BACKUP_DIR .
        BACKUP_PREFIX .
        date('Ymd_His') .
        '.json';

    $json = json_encode(
        $backup,
        JSON_FLAGS
    );

    if ($json === false) {

       throw new Exception(
    "Failed to encode backup to JSON. Error: " . json_last_error_msg());

    }

    if (file_put_contents($filename, $json) === false) {

        throw new Exception(
            "Unable to write backup file."
        );

    }

    return $filename;
}  
  
  /**
 * Compress a JSON backup file.
 *
 * @param string $jsonFile
 * @return string
 * @throws Exception
 */
private function compress(string $jsonFile): string
{
    if (!file_exists($jsonFile)) {
        throw new Exception("Backup file does not exist.");
    }

    $gzipFile = $jsonFile . '.gz';

    $source = fopen($jsonFile, 'rb');

    if (!$source) {
        throw new Exception("Unable to open backup file.");
    }

 $destination = gzopen($gzipFile, 'wb9');

    if (!$destination) {
        fclose($source);
        throw new Exception("Unable to create gzip file.");
    }

    while (!feof($source)) {
        gzwrite($destination, fread($source, 8192));
    }

    fclose($source);
    gzclose($destination);

    return $gzipFile;
}  
  
  
private function cleanupBackups(string $keepFile): void
{
    $files = glob(BACKUP_DIR . BACKUP_PREFIX . '*');

    foreach ($files as $file) {

        if (basename($file) === basename($keepFile)) {
            continue;
        }

        if (is_file($file)) {

            if (!unlink($file)) {
                throw new Exception(
                    "Unable to delete backup file: " . basename($file)
                );
            }

        }

    }
}

 /**
 * Export the database.
 *
 * @return string
 * @throws Exception
 */
public function exportDb(): string
{
       
    // Build the backup array
    $backup = $this->buildBackup();
    // Save it as JSON
    $jsonFile = $this->saveJson($backup);

    // Compress the JSON file
    $gzipFile = $this->compress($jsonFile);
    $this->cleanupBackups($gzipFile);
    
    // Return the compressed backup file
    return $gzipFile;
}  
    
}