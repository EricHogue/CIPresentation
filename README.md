

# Installation

* Various Utils

		sudo apt-get install php5-curl php-pear php5-dev build-essential git php5-xsl

* xDebug for code coverage

		sudo pecl install xdebug
	
	* Add this line to your php.ini
		zend_extension=/usr/lib/php5/20090626/xdebug.so

* Prepare pear

		sudo pear upgrade PEAR
		sudo pear config-set auto_discover 1
		sudo pear config-set preferred_state beta

* Install Ant
		sudo apt-get install ant

* [Install Jenkins](http://jenkins-ci.org/ "Jenkins")

* Install PHP Tools
		sudo pear install --alldeps pear.phpunit.de/PHPUnit PHP_CodeSniffer



* Install Jenkins plugins
	* Git Plugin
	* xUnit Plugin
	* Clover PHP Plugin
	* Checkstyle Plugin
