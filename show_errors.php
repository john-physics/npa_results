<?php

//log errors
if(!is_dir('logs')){
    mkdir('logs',0755,true);
}

ini_set('log_errors', 1);
ini_set('error_log', 'logs/errors.log'); // Adjust path if needed
ini_set('display_errors', 1); //show all errors in browser especially on live server to help track quickly. 
error_reporting(E_ALL);// Turn on error reporting Report all types of errors

