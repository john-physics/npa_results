<?php

// constants
$root = $_SERVER["DOCUMENT_ROOT"];
// $config is already loaded in dbcon, just extract constants directly. 
$rurl = $config["data"]["rurl"];
$hurl = $config["data"]["hurl"];
$dirgen =$config["data"]["dirgen"];
$manager = $config["data"]["manager"];
$asstmanager = $config["data"]["asstmanager"];
$ictdir =$config["data"]["ictdir"];
$asstictdir = $config["data"]["asstictdir"];
$principal = $config["data"]["principal"];
$secretary = $config["data"]["secretary"];
$exam_officer = $config["data"]["exam_officer"];
$asst_exam_officer = $config["data"]["asst_exam_officer"];
$site = $config["data"]["site"];
$site2 = $config["data"]["site2"];
$siteEmail = $config["data"]["siteEmail"];
$schoolAddress = $config["data"]["schoolAddress"];
$siteName = $site;
$schoolName = "$site MARARABA";
$authorized =[$dirgen,$manager,$asstmanager,$ictdir,$principal,$asstictdir,$exam_officer,$asst_exam_officer,$secretary];
$teacher = "Teacher";
$appointers = [$dirgen,$principal,$manager,$asstictdir];

$staffCats = collect_table_data($conn,"staffs","","staff_cat");

$naira = "₦";
$dollar = "💲";
$dollarsack ="💰";
$passmark = 50;
$BackupToken = $config["data"]["backupToken"];