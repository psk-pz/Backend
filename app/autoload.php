<?php

use Doctrine\Common\Annotations\AnnotationRegistry;
use Composer\Autoload\ClassLoader;

$vagrantEnvironment = false;
if (file_exists('/vagrant/vagrant/php/vagrantEnvironment.php')) {
    $vagrantEnvironment = include '/vagrant/vagrant/php/vagrantEnvironment.php';
}

/** @var ClassLoader $loader */
if ($vagrantEnvironment && $vagrantEnvironment['isDevelopmentEnvironment']) {
    $loader = require $vagrantEnvironment['symfonyVendorDirectory'] . 'autoload.php';
    $loader->addPsr4('', '/vagrant/src/');
} else {
    $loader = require __DIR__ . '/../vendor/autoload.php';
}

AnnotationRegistry::registerLoader([$loader, 'loadClass']);

return $loader;
