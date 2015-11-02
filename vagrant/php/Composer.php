<?php

namespace Vagrant;

class Composer
{
    private static function isDevelopmentEnvironment()
    {
        $developmentEnvironment = false;
        if (file_exists('/vagrant/vagrant/php/isDevelopmentEnvironment.php')) {
            $developmentEnvironment = include '/vagrant/vagrant/php/isDevelopmentEnvironment.php';
        }

        return $developmentEnvironment;
    }

    public static function rsync()
    {
        if (self::isDevelopmentEnvironment()) {
            exec('rsync -a --delete -O --no-g /vagrant/vendor /home/vagrant/backend');
        }
    }

    public static function setPermissions()
    {
        if (self::isDevelopmentEnvironment()) {
            exec('sudo chmod -R 777 /dev/shm/backend');
        }
    }
}
