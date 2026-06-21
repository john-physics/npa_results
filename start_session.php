<?php
// start_session.php

// Custom session save path for Termux environment
$customPath = dirname($_SERVER["DOCUMENT_ROOT"])."/config/sessions";

// Check if the directory exists and is wri7table
if (!is_dir($customPath)) {
    mkdir($customPath, 0777, true);
}

if (is_writable($customPath)) {
    session_save_path($customPath);
    session_name("NPASESSID"); // Custom session cookie name
    ini_set("session.gc_maxlifetime", 3600); // 1 hour (default is 24 mins)
    ini_set("session.cookie_lifetime", 0);   // Session ends when browser closes
} else {
    die("Session save path is not writable: " . $customPath);
}

// Start or resume session
session_start();

// Optional: ensure session is active
if (session_status() !== PHP_SESSION_ACTIVE) {
    die("Failed to start session.");
}
