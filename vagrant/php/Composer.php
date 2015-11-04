<?php

namespace Vagrant;

class Composer
{
    public static function rsync()
    {
        $vagrantEnvironment = false;
        if (file_exists('/vagrant/vagrant/php/vagrantEnvironment.php')) {
            $vagrantEnvironment = include '/vagrant/vagrant/php/vagrantEnvironment.php';
        }

        if ($vagrantEnvironment && $vagrantEnvironment['isDevelopmentEnvironment']) {
            $insideVagrant = '/vagrant/vendor/';
            $outsideVagrant = $vagrantEnvironment['symfonyVendorDirectory'];
            exec("rsync -a --delete -O --no-g {$insideVagrant} {$outsideVagrant}");
        }
    }
}
