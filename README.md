

# Installation

* Various Utils
	sudo apt-get install php5-curl php-pear php5-dev build-essential git php5-xsl

* xDebug for code coverage
	sudo pecl install xdebug

* Prepare pear
	sudo pear upgrade PEAR
	sudo pear config-set auto_discover 1
	#sudo pear config-set preferred_state alpha

* Install PHPUnit
	sudo pear install --alldeps pear.phpunit.de/PHPUnit

* [Install Jenkins](http://jenkins-ci.org/ "Jenkins")


* Install Jenkins plugins
	* Git Plugin
