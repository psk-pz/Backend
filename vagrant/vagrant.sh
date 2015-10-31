#!/bin/bash

mkdir -p /etc/puppet/modules
(puppet module list | grep puppetlabs-apt) || (puppet module install puppetlabs/apt)
(puppet module list | grep willdurand-composer) || (puppet module install willdurand/composer)
(puppet module list | grep puppetlabs-postgresql) || (puppet module install puppetlabs/postgresql)
