$environmentVariableName = 'ENVIRONMENT_TYPE'
$environmentVariableValue = 'dev'
$xdebug = true

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

package { 'php5-cli':
  ensure  => 'installed',
  require => [
    Class['apt'],
    Package['php5-fpm']
  ]
}

service { 'php5-fpm':
  ensure    => running,
  enable    => true,
  require   => Package['php5-fpm'],
  subscribe => Package['php5-xdebug']
}

package { 'php5-apcu':
  ensure  => 'installed',
  notify  => Service['php5-fpm'],
  require => [
    Class['apt'],
    Package['php5-fpm']
  ]
}

if $xdebug {
  package { 'php5-xdebug':
    ensure  => 'installed',
    notify  => Service['php5-fpm'],
    require => [
      Class['apt'],
      Package['php5-fpm']
    ]
  }

  file { '/etc/php5/fpm/conf.d/20-xdebug.ini':
    content    => template('/vagrant/vagrant/xdebug.erb'),
    notify     => Service['php5-fpm'],
    require    => Package['php5-xdebug']
  }

  exec { 'xdebug port':
    command => 'iptables -t nat -A PREROUTING -p tcp --dport 8000 -j REDIRECT --to-port 80',
    path    => ['/sbin', '/usr/share']
  }
}

file { '/etc/php5/fpm/php.ini':
  ensure  => present,
  require => Package['php5-fpm']
}

file_line { 'realpath_cache':
  path    => '/etc/php5/fpm/php.ini',
  line    => 'realpath_cache_size=4096k',
  match   => '^realpath_cache_size.*$',
  notify  => Service['php5-fpm'],
  require => File['/etc/php5/fpm/php.ini']
}

file_line { 'realpath_ttl':
  path    => '/etc/php5/fpm/php.ini',
  line    => 'realpath_cache_ttl=7200',
  match   => '^realpath_cache_ttl.*$',
  notify  => Service['php5-fpm'],
  require => File['/etc/php5/fpm/php.ini']
}

file { '/dev/shm/backend':
  ensure => 'directory',
  mode   => 777
}
file { '/dev/shm/backend/logs':
  ensure  => 'directory',
  mode    => 777,
  require => File['/dev/shm/backend']
}
file { '/dev/shm/backend/cache':
  ensure  => 'directory',
  mode    => 777,
  require => File['/dev/shm/backend']
}

file { '/home/vagrant/.composer':
  ensure => 'directory',
  mode   => 777
}
file { '/home/vagrant/backend':
  ensure => 'directory',
  mode   => 777
}
file { '/home/vagrant/backend/vendor':
  ensure  => 'directory',
  mode    => 777,
  require => File['/home/vagrant/backend']
}

class { 'composer':
  command_name => 'composer',
  target_dir   => '/usr/local/bin',
  auto_update  => true,
  require      => Package['php5-cli']
}

file { '/etc/environment':
  ensure => present
}

file_line { 'composer environment':
  path    => '/etc/environment',
  line    => "${environmentVariableName}=${environmentVariableValue}",
  require => File['/etc/environment']
}

exec { 'composer':
  command     => '/usr/bin/php /usr/local/bin/composer -n install',
  environment => 'COMPOSER_HOME=/home/vagrant/.composer',
  cwd         => '/vagrant',
  user        => 'vagrant',
  timeout     => 600,
  require     => [
    File['/home/vagrant/.composer'],
    Class['composer'],
    File_line['composer environment']
  ]
}

package { 'nginx':
  ensure  => 'installed',
  require => Class['apt']
}

file { '/etc/nginx/sites-available/default':
  content  => template('/vagrant/vagrant/nginx.erb'),
  owner    => 'root',
  group    => 'root',
  mode     => 644,
  require  => Package['nginx'],
  notify   => Service['nginx']
}

service { 'nginx':
  ensure    => running,
  enable    => true,
  subscribe => [
    File['/etc/nginx/sites-available/default']
  ]
}

class { 'postgresql::server':
  postgres_password => 'postgres'
}

postgresql::server::role { 'backend':
  password_hash => postgresql_password('backend', 'backend')
}

postgresql::server::db { 'backend':
  user     => 'backend',
  password => postgresql_password('backend', 'backend')
}

postgresql::server::database_grant { 'backend':
  privilege => 'ALL',
  db        => 'backend',
  role      => 'backend'
}
