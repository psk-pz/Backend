<?php

namespace Vagrant;

class Composer
{
    public static function rsync()
    {
        $developmentEnvironment = false;
        if (file_exists('/vagrant/vagrant/php/isDevelopmentEnvironment.php')) {
            $developmentEnvironment = include '/vagrant/vagrant/php/isDevelopmentEnvironment.php';
        }

        if ($developmentEnvironment) {
            exec('rsync -a --delete -O --no-g /vagrant/vendor /home/vagrant/backend');
        }
    }
}
