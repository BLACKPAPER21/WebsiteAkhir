<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

$basePath = dirname(__DIR__);

/*
|--------------------------------------------------------------------------
| Writable Storage On A Read-Only Filesystem
|--------------------------------------------------------------------------
|
| Vercel bundles this application into a read-only Lambda. Laravel writes
| compiled views, caches and logs under storage/, so we relocate that
| directory to /tmp (the only writable mount) before the app boots.
|
*/

$storagePath = getenv('APP_STORAGE_PATH') ?: '/tmp/demplane-storage';

foreach ([
    'app/public',
    'cache',
    'framework/cache/data',
    'framework/sessions',
    'framework/views',
    'logs',
] as $directory) {
    $path = $storagePath.'/'.$directory;

    if (! is_dir($path)) {
        @mkdir($path, 0777, true);
    }
}

require $basePath.'/vendor/autoload.php';

/** @var Application $app */
$app = require_once $basePath.'/bootstrap/app.php';

$app->useStoragePath($storagePath);

$app->handleRequest(Request::capture());
