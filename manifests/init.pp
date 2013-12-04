exec { 'apt-get update':
    command => '/usr/bin/apt-get update'
  }

package {'vim':
  ensure => installed
}

package { "mysql-server":
  ensure => present,
  require => Exec["apt-get update"]
}

service { "mysql":
  ensure => running,
  require => Package["mysql-server"],
}

package { "apache2":
    ensure => present,
    require => Exec["apt-get update"]
  }

  # ensures that mode_rewrite is loaded and modifies the default configuration file
  file { "/etc/apache2/mods-enabled/rewrite.load":
    ensure => link,
    target => "/etc/apache2/mods-available/rewrite.load",
    require => Package["apache2"]
  }

  file {"/etc/apache2/sites-enabled":
    ensure => directory,
    recurse => true,
    purge => true,
    force => true,
    before => File["/etc/apache2/sites-enabled/vagrant_webroot"],
    require => Package["apache2"],
  }

  file { "/etc/apache2/sites-available/vagrant_webroot":
    ensure => present,
    source => "/vagrant/manifests/vagrant_webroot",
    require => Package["apache2"],
  }

  file { "/etc/apache2/sites-enabled/vagrant_webroot":
    ensure => link,
    target => "/etc/apache2/sites-available/vagrant_webroot",
    require => File["/etc/apache2/sites-available/vagrant_webroot"],
    notify => Service["apache2"],
  }

  # starts the apache2 service once the packages installed, and monitors changes to its configuration files and reloads if nesessary
  service { "apache2":
    ensure => running,
    require => Package["apache2"],
    subscribe => [
      File["/etc/apache2/mods-enabled/rewrite.load"],
      File["/etc/apache2/sites-available/vagrant_webroot"]
    ],
  }

$packages = ["php5", "php5-cli", "php5-mysql", "php-pear", "php5-dev", "php5-gd", "php5-mcrypt", "libapache2-mod-php5"]
  
  package { $packages:
    ensure => present,
    require => Exec["apt-get update"]
  }
