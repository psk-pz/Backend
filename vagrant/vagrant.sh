#!/bin/bash

mkdir -p /etc/puppet/modules
(puppet module list | grep puppetlabs-apt) || (puppet module install puppetlabs/apt)
