<?php

namespace Vagrant;

/**
 * Utilities to support composer.
 */
class Composer
{
    /**
     * Copies vendor's folder outside vagrant's synced folder.
     * Then application reads files from there, which speeds up execution.
     * It only applies to development environment.
     */
    public static function rsync()
    {
        $vagrantEnvironment = false;
        if (file_exists('/vagrant/vagrant/php/vagrantEnvironment.php')) {
            $vagrantEnvironment = include '/vagrant/vagrant/php/vagrantEnvironment.php';
        }

        if ($vagrantEnvironment && $vagrantEnvironment['isDevelopmentEnvironment']) {
            $insideVagrant = '/vagrant/vendor/';
            $outsideVagrant = $vagrantEnvironment['symfonyVendorDirectory'];
            exec("sudo rsync -a --delete -O --no-g {$insideVagrant} {$outsideVagrant}");
        }
    }
}
