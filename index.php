<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);


require "core/bootstrap.php";
require "core/Fm.php";


$app = Fm::getInstance();

$app->run();







