<?php

class Logger
{
    private string $logFile;
    private msqli $conn;
    
    public function __construct(mysqli $conn, string $logDirectory = null)
    {
     
     $this->conn = $conn;   
        
       if ($logDirectory === null) {
        $logDirectory = __DIR__ . '/logs/';
        }

        // Create the logs directory if it doesn't exist
        if (!is_dir($logDirectory)) {
            mkdir($logDirectory, 0755, true);
        }

        $this->logFile = rtrim($logDirectory, '/\\') . '/backup_' . date('Y-m') . '.log';
    }

    public function info(string $message): void
    {
        $this->write('INFO', $message);
    }

    public function warning(string $message): void
    {
        $this->write('WARNING', $message);
    }

    public function error(string $message): void
    {
        $this->write('ERROR', $message);
        $this->notifyAdmin($message);
        
    }

    private function write(string $level, string $message): void
    {
        $line = sprintf(
            "[%s] [%s] %s%s",
            date('Y-m-d H:i:s'),
            $level,
            $message,
            PHP_EOL
        );

        file_put_contents($this->logFile, $line, FILE_APPEND | LOCK_EX);
    }
    
    
 private function notifyAdmin(string $message): void
{
    $subject = "Database Backup Error";
 $messageBody = "
A database backup error occurred.
<br><br>
Time: " . date('Y-m-d H:i:s') . "<br>
Message: {$message}";

   
    $stmt = $this->conn->prepare("
        INSERT INTO mail_queue
        (
            recipient_name,
            recipient_email,
            subject,
            message,
            attachment,
            created_at
        )
        VALUES (?, ?, ?, ?, ?, NOW())
    ");

    $attachment = null;
    $stmt->bind_param(
        "sssss",
        ADMIN_NAME,
        ADMIN_EMAIL,
        $subject,
        $messageBody,
        $attachment
    );

    $stmt->execute();

    $stmt->close();
} 
  
  
    
}