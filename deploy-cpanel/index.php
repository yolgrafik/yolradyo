<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

$backendDir = __DIR__ . '/yolcu';
$maintenance = $backendDir . '/storage/framework/maintenance.php';

if (file_exists($maintenance)) {
    require $maintenance;
}

require $backendDir . '/vendor/autoload.php';

/** @var Application $app */
$app = require_once $backendDir . '/bootstrap/app.php';

$app->handleRequest(Request::capture());