#!/bin/bash

mkdir -p /etc/puppet/modules
(puppet module list | grep puppetlabs-apt) || (puppet module install puppetlabs/apt)
(puppet module list | grep thias-fooacl) || (puppet module install thias/fooacl)
(puppet module list | grep puppetlabs-rsync) || (puppet module install puppetlabs/rsync)
(puppet module list | grep willdurand-composer) || (puppet module install willdurand/composer)
(puppet module list | grep puppetlabs-postgresql) || (puppet module install puppetlabs/postgresql)
