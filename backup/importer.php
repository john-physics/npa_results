<?php

class DatabaseImporter
{
    private mysqli $conn;

    /**
     * Constructor
     *
     * @param mysqli $conn
     */
    public function __construct(mysqli $conn)
    {
        $this->conn = $conn;
    }


/**
 * Load and decode a backup file.
 *
 * @param string $file
 * @return array
 * @throws Exception
 */
private function loadBackup(string $file): array
{
    if (!file_exists($file)) {

        throw new Exception(
            "Backup file not found."
        );

    }

    $handle = gzopen($file, "rb");

    if (!$handle) {

        throw new Exception(
            "Unable to open backup file."
        );

    }

    $json = "";

    while (!gzeof($handle)) {

        $json .= gzread($handle, 8192);

    }

    gzclose($handle);

    $backup = json_decode($json, true);

    if (!is_array($backup)) {

        throw new Exception(
            "Invalid backup format."
        );

    }

    return $backup;
}

/**
 * Validate backup structure.
 *
 * @param array $backup
 * @throws Exception
 */
private function validateBackup(array $backup): void
{
    $required = [

        'version',
        'author',
        'signature',
        'created_at',
        'database',
        'php_version',
        'mysql_version',
        'tables'

    ];

    foreach ($required as $field) {

        if (!array_key_exists($field, $backup)) {

            throw new Exception(
                "Missing backup field: {$field}"
            );

        }

    }

    if ($backup['signature'] !== BACKUP_SIGNATURE) {

        throw new Exception(
            "Invalid backup signature."
        );

    }

    if (!is_array($backup['tables'])) {

        throw new Exception(
            "Invalid backup tables."
        );

    }

}


/**
 * Check whether a table exists.
 *
 * @param string $table
 * @return bool
 */
private function tableExists(string $table): bool
{
    $result = $this->conn->query("SHOW TABLES");

    while ($row = $result->fetch_row()) {

        if ($row[0] === $table) {
            return true;
        }

    }

    return false;
}

/**
 * Create a table.
 *
 * @param string $sql
 * @throws Exception
 */
private function createTable(string $sql): void
{
    if (!$this->conn->query($sql)) {

        throw new Exception(
            "Unable to create table."
        );

    }
}


/**
 * Restore rows into a table.
 *
 * @param string $table
 * @param array $rows
 */
private function restoreRows(
    string $table,
    array $rows
): void
{

    foreach ($rows as $row) {

  $columns = array_keys($row);
   $placeholders = implode(
    ",", array_fill(0,count($columns),
        "?" ));
$columnList = implode(",", $columns);
$updates = [];
foreach ($columns as $column) {
    $updates[] = "{$column}=VALUES({$column})";

}

$updateList = implode(",", $updates);
  
$sql = "INSERT INTO {$table}
($columnList)
VALUES ($placeholders)
ON DUPLICATE KEY UPDATE
$updateList";

$stmt = $this->conn->prepare($sql);
if (!$stmt) {

    throw new Exception(
        "Unable to prepare restore statement."
    );

}

$values = array_values($row);
$types = str_repeat("s", count($values));

$stmt->bind_param(
    $types,
    ...$values
);


$stmt->execute();

$stmt->close();

 }

}



public function importDb(string $backupFile): void
{
  $backup = $this->loadBackup($backupFile);
  $this->validateBackup($backup);

    $this->conn->begin_transaction();

    try {

        foreach ($backup['tables'] as $table => $data) {

            if (!$this->tableExists($table)) {

                $this->createTable($data['create']);

            }

            if (!empty($data['rows'])) {

                $this->restoreRows(
                    $table,
                    $data['rows']
                );

            }

        }

        $this->conn->commit();

    } catch (Throwable $e) {

        $this->conn->rollback();

        throw $e;

    }
}
 
}

