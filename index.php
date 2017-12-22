<?php

if (version_compare(phpversion(), '7.0.0', '<')) {
    // php version isn't high enough
    echo "PHP version is too low, please upgrade PHP to at least PHP v 7.0.0";
    exit();
}

$isMaintenance = false;
//$isMaintenance = true;

if($isMaintenance) {
    echo "site is under maintenance, please come back later";
    exit();
}

session_start();
error_reporting(E_ALL);

use \App\App as App;

define("ROOT", __DIR__ ."/");

require_once("App/app.php");

$app = new App();

$app->dispatch();
