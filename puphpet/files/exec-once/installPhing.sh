echo "Update composer"
sudo composer selfupdate

echo "Install Phing"
wget http://www.phing.info/get/phing-latest.phar
sudo mv phing-latest.phar /usr/local/bin/phing.phar
sudo chmod +x /usr/local/bin/phing.phar
