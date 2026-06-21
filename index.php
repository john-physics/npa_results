<?php

require_once 'page_init.php';
require_once 'Router.php';

//require 'show_errors.php';
 
$router = new Router(__DIR__);  // folder where your pages reside
$router -> handle_route($_SERVER['REQUEST_URI']);