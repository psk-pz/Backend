<?php

use Doctrine\Common\Annotations\AnnotationRegistry;
use Composer\Autoload\ClassLoader;

$environmentType = getenv('ENVIRONMENT_TYPE');

if ($environmentType == 'dev') {
    $loader = require '/home/vagrant/backend/vendor/autoload.php';
} else {
    $loader = require __DIR__ . '/../vendor/autoload.php';
}

/** @var ClassLoader $loader */
AnnotationRegistry::registerLoader([$loader, 'loadClass']);

return $loader;
