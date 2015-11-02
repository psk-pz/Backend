<?php

use Symfony\Component\ClassLoader\ApcClassLoader;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Debug\Debug;

$developmentEnvironment = false;
if (file_exists('/vagrant/vagrant/php/isDevelopmentEnvironment.php')) {
    $developmentEnvironment = include '/vagrant/vagrant/php/isDevelopmentEnvironment.php';
}

$loader = require_once __DIR__ . '/../app/bootstrap.php.cache';
require_once __DIR__ . '/../app/AppKernel.php';

if ($developmentEnvironment) {
    Debug::enable();

    $kernel = new AppKernel('dev', true);
    $kernel->loadClassCache();
} else {
    $apcLoader = new ApcClassLoader('backend', $loader);
    $loader->unregister();
    $apcLoader->register(true);

    require_once __DIR__ . '/../app/AppCache.php';
    $kernel = new AppKernel('prod', false);
    $kernel->loadClassCache();
    $kernel = new AppCache($kernel);
}

$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);
