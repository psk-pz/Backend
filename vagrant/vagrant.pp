class { 'apt':
  update => {
    frequency => 'always'
  }
}

package { 'git':
  ensure  => 'installed',
  require => Class['apt']
}

package { 'php5-fpm':
  ensure  => 'installed',
  require => Class['apt']
}

service { 'php5-fpm':
  ensure    => running,
  enable    => true,
  require   => Package['php5-fpm'],
  subscribe => Package['php5-xdebug']
}

package { 'php5-apcu':
  ensure  => 'installed',
  require => [
    Class['apt'],
    Package['php5-fpm']
  ]
}

package { 'php5-xdebug':
  ensure  => 'installed',
  notify  => Service['php5-fpm'],
  require => [
    Class['apt'],
    Package['php5-fpm']
  ]
}

file_line { 'xdebug':
  path    => '/etc/php5/fpm/conf.d/20-xdebug.ini',
  line    => 'xdebug.remote_enable = on
              xdebug.remote_connect_back = on
              xdebug.idekey = "vagrant"',
  require => Package['php5-xdebug']
}

package { 'php5-cli':
  ensure  => 'installed',
  require => [
    Class['apt'],
    Package['php5-fpm']
  ]
}

package { 'nginx':
  ensure  => 'installed',
  require => Class['apt']
}

file { '/etc/nginx/sites-available/default':
  source  => '/vagrant/vagrant/nginx.vhost',
  owner   => 'root',
  group   => 'root',
  mode    => 644,
  require => Package['nginx'],
  notify  => Service['nginx']
}

service { 'nginx':
  ensure    => running,
  enable    => true,
  subscribe => [
    File['/etc/nginx/sites-available/default']
  ]
}

class { 'composer':
  command_name => 'composer',
  target_dir   => '/usr/local/bin',
  auto_update  => true,
  require      => Package['php5-cli']
}

file { "/home/vagrant/.composer":
  ensure => "directory",
  owner  => 'vagrant',
  group  => 'vagrant',
  mode   => 600
}

exec { 'composer':
  command     => '/usr/bin/php /usr/local/bin/composer -n install',
  environment => 'COMPOSER_HOME=/home/vagrant/.composer',
  cwd         => '/vagrant',
  user        => 'vagrant',
  timeout     => 600,
  require     => [
    File['/home/vagrant/.composer'],
    Class['composer']
  ]
}

exec { 'xdebug port':
  command => 'iptables -t nat -A PREROUTING -p tcp --dport 8000 -j REDIRECT --to-port 80'
}
