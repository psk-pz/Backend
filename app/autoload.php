<?php

use Doctrine\Common\Annotations\AnnotationRegistry;
use Composer\Autoload\ClassLoader;

$developmentEnvironment = false;
if (file_exists('/vagrant/vagrant/php/isDevelopmentEnvironment.php')) {
    $developmentEnvironment = include '/vagrant/vagrant/php/isDevelopmentEnvironment.php';
}

/** @var ClassLoader $loader */
if ($developmentEnvironment) {
    $loader = require '/home/vagrant/backend/vendor/autoload.php';
    $loader->addPsr4('', '/vagrant/src');
} else {
    $loader = require __DIR__ . '/../vendor/autoload.php';
}

AnnotationRegistry::registerLoader([$loader, 'loadClass']);

return $loader;
