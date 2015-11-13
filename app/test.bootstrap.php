<?php

$console = function ($command) {
    passthru('php "' . __DIR__ . '/console" ' . $command);
};

$console('doctrine:schema:drop --force -e test -n');
$console('doctrine:schema:create -n -e test');
$console('doctrine:fixtures:load -n -e test');

require __DIR__ . '/bootstrap.php.cache';
