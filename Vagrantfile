Vagrant.configure(2) do |config|

  config.vm.box = "ubuntu/trusty64"
  config.vm.network "private_network", ip: "192.168.60.167"
  
  config.vm.provision "shell" do |shell|
    shell.inline = "mkdir -p /etc/puppet/modules
                    (puppet module list | grep puppetlabs-apt) || (puppet module install puppetlabs/apt)"
  end
  
  config.vm.provision "puppet" do |puppet|
    puppet.manifests_path = "."
    puppet.manifest_file  = "vagrant.pp"
  end

end
