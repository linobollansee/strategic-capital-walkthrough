<?php

use App\Kernel;
use Symfony\Component\ErrorHandler\Debug;

require_once dirname(__DIR__).'/config/bootstrap.php';

// When using the PHP built-in web server, return the requested resource
// as-is when it exists so static files are served directly instead of
// routing them through the Symfony kernel.
if (PHP_SAPI === 'cli-server') {
    $url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $file = __DIR__ . $url;
    if (is_file($file)) {
        return false;
    }
}

if ($_SERVER['APP_DEBUG']) {
    umask(0000);
    Debug::enable();
}

$kernel = new Kernel($_SERVER['APP_ENV'], (bool) $_SERVER['APP_DEBUG']);
$request = Symfony\Component\HttpFoundation\Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);
