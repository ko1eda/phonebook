#! /bin/bash

## This script is not intended to be run autonomously.
## There is no conditional logic and environment variable checks
## Instead copy and paste each block in your bash shell as designated following the 
## comments.

sudo yum update -y && \
sudo yum install -y git && \
sudo amazon-linux-extras install -y docker && \
sudo service docker start  && \
sudo systemctl enable docker

## Restart server after this block for changes to take effect
sudo usermod -aG docker ec2-user && \
sudo curl -L https://github.com/docker/compose/releases/download/1.23.0-rc3/docker-compose-`uname -s`-`uname -m` -o /usr/local/bin/docker-compose && \
sudo chmod +x /usr/local/bin/docker-compose

## create www-data user as 1001, set ec2-user to be member of www-data group
## create a www-data system user -r and complimentary group -U of same name
## May need to restart server again here 
## cat /etc/passwd file to see if these changes have taken effect, if not restart.
sudo useradd -ru 1001 -U www-data && \  
sudo usermod -aG www-data ec2-user && \
sudo groupmod -g 1001 www-data

## You must have set up your repository with a deploy key and have your corresponding private key located in ~/.ssh
# for this clone to work correctly
cd ~ && sudo git clone git@github.com:ko1eda/phonebook.git

sudo cp phonebook /srv && \
cd /srv/phonebook/ && \
docker-compose -f docker-compose.prod.yml up -d 

## Here we are installing the vendor and node_modules directory using ephemeral containers.
## Ensure that your containers have been built and are up and running before running these commands
## use docker ps to check this
cd /srv/phonebook/app/ && \
sudo docker run --rm -it -v $(pwd):/opt -w /opt creating_digital/php-fpm:1.0.0 composer install && \
sudo docker run --rm -it -v $(pwd):/opt -w /opt node:8.16.0-jessie bash -c "apt-get update -y && apt-get install -y git nodejs npm && npm install" && \
## depending on the specs of your server, you may want to build resources for production and commit them to version control beforehand, if thats the case skip this step
sudo docker run --rm -it -v $(pwd):/opt -w /opt node:8.16.0-jessie bash -c "apt-get update -y && apt-get install -y git nodejs npm && npm rebuild node-sass && npm run production" && \
sudo docker run --rm -it  --network appnet -v $(pwd):/opt -w /opt creating_digital/php-fpm:1.0.0 php artisan migrate

## finally set permissions on the application directory 
sudo chown -R ec2-user:ec2-user /srv/ && \
sudo chown -R www-data:www-data /srv/phonebook/app/  && \
sudo find /srv/ -type d -exec chmod 750 {} + && \
sudo find /srv/ -type f -exec chmod 640 {} + && \
 # the first 2 signifies all files created in a directory will belong to the owner of the directory
sudo find /srv/phonebook/app/ -type d -exec chmod 2770 {} +