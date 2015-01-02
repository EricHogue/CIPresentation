
echo 'Installing Jenkins'
wget -q -O - http://pkg.jenkins-ci.org/debian/jenkins-ci.org.key | sudo apt-key add -
echo "deb http://pkg.jenkins-ci.org/debian binary/" | sudo tee -a /etc/apt/sources.list

sudo apt-get update
sudo apt-get install -y jenkins

sudo service jenkins start

echo "Sleeping so Jenkins can start"
sleep 2m

echo "Install Jenkins plugins"
curl  -L http://updates.jenkins-ci.org/update-center.json | sed '1d;$d' | curl -X POST -H 'Accept: application/json' -d @- http://localhost:8080/updateCenter/byId/default/postBack

wget http://localhost:8080/jnlpJars/jenkins-cli.jar
java -jar jenkins-cli.jar -s http://localhost:8080 install-plugin Git GitHub Phing GreenBalls ChuckNorris


echo "Copy Jenkins configs"
cp /vagrant/JenkinsConfigs/hudson.plugins.phing.PhingInstallation.xml /var/lib/jenkins/hudson.plugins.phing.PhingInstallation.xml
sudo chown jenkins:jenkins /var/lib/jenkins/hudson.plugins.phing.PhingInstallation.xml

mkdir /var/lib/jenkins/jobs/Sudoku/
cp /vagrant/JenkinsConfigs/SudokuConfig.xml /var/lib/jenkins/jobs/Sudoku/config.xml
sudo chown -R jenkins:jenkins /var/lib/jenkins/jobs/Sudoku/

echo "Restart Jenkins"
java -jar jenkins-cli.jar -s http://localhost:8080 safe-restart
