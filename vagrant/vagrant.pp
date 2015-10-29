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
  require   => Package['php5-fpm']
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
