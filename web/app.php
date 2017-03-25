<?php
use App\AppKernel;
use Symfony\Component\HttpFoundation\Request;

$loader = require __DIR__.'/../conf/autoload.php';
include_once __DIR__.'/../var/bootstrap.php.cache';

umask(0000); // This will let the permissions be 0777

$kernel = new AppKernel('prod', false);
//$kernel = new AppCache($kernel);

// When using the HttpCache, you need to call the method in your front controller instead of relying on the configuration parameter
//Request::enableHttpMethodParameterOverride();
$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);
