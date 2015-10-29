Vagrant.configure(2) do |config|

  config.vm.box = "ubuntu/trusty64"
  config.vm.network "private_network", ip: "192.168.60.167"

  config.vm.provider "virtualbox" do |v|
    v.memory = 1024
  end

  config.vm.provision "shell" do |shell|
    shell.path = "vagrant/vagrant.sh"
  end
  
  config.vm.provision "puppet" do |puppet|
    puppet.manifests_path = "vagrant"
    puppet.manifest_file  = "vagrant.pp"
  end

end
