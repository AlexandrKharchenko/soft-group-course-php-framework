<?php
session_start();


require_once 'config/config.php';
require_once 'autoload.php';
require_once 'Router.class.php';
require_once 'core/helpers/helpers.php';



$PsrLoader->addNamespace('App\Controller',CONTROLLER_DIR);
$PsrLoader->addNamespace('App\Models', MODEL_DIR);

$PsrLoader->addNamespace('Core\App', CORE . '/app');
$PsrLoader->addNamespace('Core\Exception', CORE . '/exception');
$PsrLoader->addNamespace('Core\Fm', CORE . '/fm');