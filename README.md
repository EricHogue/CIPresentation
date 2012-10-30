

# Installation

* Various Utils

		sudo apt-get install php5-curl php-pear php5-dev build-essential git php5-xsl

* xDebug for code coverage

		sudo pecl install xdebug
	
	* Add this line to your php.ini
		zend_extension=/usr/lib/php5/20090626/xdebug.so

* Install Ant
		sudo apt-get install ant

* Prepare pear

		sudo pear upgrade PEAR
		sudo pear config-set auto_discover 1
		sudo pear config-set preferred_state beta
		sudo pear channel-discover pear.phpmd.org
		sudo pear channel-discover pear.pdepend.org


* [Install Jenkins](http://jenkins-ci.org/ "Jenkins")

* Install PHP Tools
		sudo pear install --alldeps pear.phpunit.de/PHPUnit PHP_CodeSniffer phpmd/PHP_PMD pdepend/PHP_Depend-beta



* Install Jenkins plugins
	* Git Plugin
	* xUnit Plugin
	* Clover PHP Plugin
	* Checkstyle Plugin
	* PMD Plugin
	* JDepend Plugin



* The file config.xml contains the Jenkins project. To use it, create a folder with the name you want to give to the project in '/var/lib/jenkins/jobs/'. Then copy the file in the folder and restart Jenkins.
