<?php

use Doctrine\Common\Annotations\AnnotationRegistry;
use Composer\Autoload\ClassLoader;

$environmentType = getenv('ENVIRONMENT_TYPE');

/** @var ClassLoader $loader */
if ($environmentType == 'dev') {
    $loader = require '/home/vagrant/backend/vendor/autoload.php';
    $loader->addPsr4('', '/vagrant/src');
} else {
    $loader = require __DIR__ . '/../vendor/autoload.php';
}

AnnotationRegistry::registerLoader([$loader, 'loadClass']);

return $loader;
