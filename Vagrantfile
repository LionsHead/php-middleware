require 'json'
require 'yaml'



VAGRANT_DOTFILE_PATH = 'bin/.vagrant'
if(ENV['VAGRANT_DOTFILE_PATH'].nil? && '.vagrant' != VAGRANT_DOTFILE_PATH)
	puts "\033[#1;#33;#40m "
    puts ' changing metadata directory to ' + VAGRANT_DOTFILE_PATH
    ENV['VAGRANT_DOTFILE_PATH'] = VAGRANT_DOTFILE_PATH
    puts ' removing default metadata directory ' + FileUtils.rm_r('.vagrant').join("\n")
    system 'vagrant ' + ARGV.join(' ')
    ENV['VAGRANT_DOTFILE_PATH'] = nil #for good measure
    abort 'Finished'
	puts "\033[0m"
end

VAGRANTFILE_API_VERSION = "2"

confDir = $confDir ||= File.expand_path(".")

homesteadYamlPath = confDir + "/bin/Homestead.yaml"
afterScriptPath = confDir + "/bin/scripts/after.sh"
aliasesPath = confDir + "/bin/aliases"

require File.expand_path(File.dirname(__FILE__) + '/bin/scripts/homestead.rb')

Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|
	if File.exists? aliasesPath then
		config.vm.provision "file", source: aliasesPath, destination: "~/.bash_aliases"
	end

	Homestead.configure(config, YAML::load(File.read(homesteadYamlPath)))

	if File.exists? afterScriptPath then
		config.vm.provision "shell", path: afterScriptPath
	end
end
