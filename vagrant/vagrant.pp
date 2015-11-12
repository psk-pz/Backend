$environmentVariableName = 'ENVIRONMENT_TYPE'
$environmentVariableValue = 'dev'

$symfonyDirectory = '/symfony'
$cacheDirectory = "${symfonyDirectory}/cache"
$logsDirectory = "${symfonyDirectory}/logs"
$vendorDirectory = "${symfonyDirectory}/vendor"
$composerHome = '/home/vagrant/.composer'
$requiredDirectories = [
  $symfonyDirectory,
  $cacheDirectory,
  $logsDirectory,
  $vendorDirectory,
  $composerHome
]

$nginxUser = 'www-data'
$nginxConfigurationPath = '/etc/nginx/sites-available/default'
$nginxServername = 'backend.psk-pz.dev'
$nginxUpstream = 'unix:/var/run/php5-fpm.sock'
$nginxErrorLogPath = '/var/log/nginx/backend_error.log'
$nginxAccessLogPath = '/var/log/nginx/backend_access.log'

$phpConfigurationPath = '/etc/php5/fpm/php.ini'
$xdebugConfigurationPath = '/etc/php5/mods-available/xdebug.ini'
$xdebugKey = 'vagrant'

apt::ppa { 'ppa:ondrej/php5-5.6': }

class { 'apt':
  update => {
    frequency => 'always'
  }
}

package { 'git':
  ensure  => 'installed',
  require => Class['apt']
}

package { 'acl':
  ensure  => 'installed',
  require => Class['apt']
}

package { 'php5-fpm':
  ensure  => 'installed',
  require => Class['apt']
}

service { 'php5-fpm':
  ensure  => running,
  enable  => true,
  require => Package['php5-fpm']
}

package { 'php5-cli':
  ensure  => 'installed',
  require => [
    Class['apt'],
    Package['php5-fpm']
  ]
}

package { 'php5-apcu':
  ensure  => 'installed',
  notify  => Service['php5-fpm'],
  require => [
    Class['apt'],
    Package['php5-fpm']
  ]
}

package { 'php5-pgsql':
  ensure  => 'installed',
  notify  => Service['php5-fpm'],
  require => [
    Class['apt'],
    Package['php5-fpm']
  ]
}

package { 'sqlite':
  ensure  => 'installed',
  require => Class['apt']
}

package { 'php5-sqlite':
  ensure  => 'installed',
  notify  => Service['php5-fpm'],
  require => [
    Class['apt'],
    Package['php5-fpm'],
    Package['sqlite']
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

file { 'xdebug configuration':
  ensure  => present,
  path    => $xdebugConfigurationPath,
  content => template('/vagrant/vagrant/erb/xdebugConfiguration.erb'),
  notify  => Service['php5-fpm'],
  require => Package['php5-xdebug']
}

exec { 'open xdebug port':
  command => 'iptables -t nat -A PREROUTING -p tcp --dport 8000 -j REDIRECT --to-port 80',
  path    => ['/sbin', '/usr/share']
}

file_line { 'php.ini realpath_cache':
  path    => $phpConfigurationPath,
  line    => 'realpath_cache_size=4096k',
  match   => '^;realpath_cache_size.*$',
  notify  => Service['php5-fpm'],
  require => Package['php5-fpm']
}

file_line { 'php.ini realpath_ttl':
  path    => $phpConfigurationPath,
  line    => 'realpath_cache_ttl=7200',
  match   => '^;realpath_cache_ttl.*$',
  notify  => Service['php5-fpm'],
  require => Package['php5-fpm']
}

file { 'vagrant environment for php':
  ensure  => present,
  path    => '/vagrant/vagrant/php/vagrantEnvironment.php',
  content => template('/vagrant/vagrant/erb/vagrantEnvironment.erb')
}

file { $requiredDirectories:
  ensure => 'directory',
  owner  => 'root',
  group  => 'root',
  mode   => 700,
}->
file { 'symfony directories permissions':
  ensure  => present,
  path    => '/vagrant/vagrant/sh/directoryPermissions.sh',
  content => template('/vagrant/vagrant/erb/directoryPermissions.erb')
}->
exec { 'symfony directories permissions':
  command => '/bin/sh /vagrant/vagrant/sh/directoryPermissions.sh',
  require => Package['acl']
}

file_line { 'system environment':
  path    => '/etc/environment',
  line    => "${environmentVariableName}=${environmentVariableValue}"
}

file_line { 'composer environment':
  path    => '/etc/environment',
  line    => "COMPOSER_HOME=${composerHome}"
}

file { 'sudoers configuration':
  ensure  => present,
  path    => '/etc/sudoers.d/custom',
  content => template('/vagrant/vagrant/erb/sudoersConfiguration.erb'),
  require => File_line['system environment']
}

class { 'composer':
  command_name => 'composer',
  target_dir   => '/usr/local/bin',
  auto_update  => true,
  require      => Package['php5-cli']
}

exec { 'composer':
  command     => '/usr/bin/php /usr/local/bin/composer -n install',
  cwd         => '/vagrant',
  user        => 'vagrant',
  timeout     => 1000,
  environment => [
    "COMPOSER_HOME=${composerHome}",
    "${environmentVariableName}=${environmentVariableValue}"
  ],
  require     => [
    Class['composer'],
    File['vagrant environment for php'],
    Exec['symfony directories permissions']
  ]
}

class { 'php_phars':
  phars      => ['phpunit', 'php-cs-fixer'],
  redownload => true
}

package { 'nginx':
  ensure  => 'installed',
  require => Class['apt']
}

service { 'nginx':
  ensure  => running,
  enable  => true,
  require => Package['nginx']
}

file { 'nginx configuration':
  ensure  => present,
  path    => $nginxConfigurationPath,
  content => template('/vagrant/vagrant/erb/nginxConfiguration.erb'),
  owner   => 'root',
  group   => 'root',
  mode    => 644,
  require => Package['nginx'],
  notify  => Service['nginx']
}

class { 'postgresql::server':
  postgres_password => 'postgres'
}

postgresql::server::role { 'backend':
  password_hash => postgresql_password('backend', 'backend')
}

postgresql::server::database_grant { 'backend':
  privilege => 'ALL',
  db        => 'backend',
  role      => 'backend'
}

postgresql::server::db { 'backend':
  user     => 'backend',
  password => postgresql_password('backend', 'backend')
}

exec { 'create database schema':
  command     => 'php app/console doctrine:schema:update --force -n',
  path        => '/usr/bin',
  cwd         => '/vagrant',
  require     => [
    Exec['composer'],
    Postgresql::Server::Role['backend'],
    Postgresql::Server::Database_grant['backend'],
    Postgresql::Server::Db['backend']
  ]
}

exec { 'load fixtures':
  command     => 'php app/console doctrine:fixtures:load -n',
  path        => '/usr/bin',
  cwd         => '/vagrant',
  require     => [
    Exec['create database schema']
  ]
}
