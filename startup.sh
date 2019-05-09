#! /bin/bash

sudo yum update -y && \
sudo yum install -y git && \
sudo amazon-linux-extras install -y docker && \
sudo service docker start  && \
sudo systemctl enable docker && \
sudo usermod -aG docker ec2-user && \
sudo curl -L https://github.com/docker/compose/releases/download/1.23.0-rc3/docker-compose-`uname -s`-`uname -m` -o /usr/local/bin/docker-compose && \
sudo chmod +x /usr/local/bin/docker-compose && \
## create www-data user as 1001, set ec2-user to be member of www-data group
sudo useradd -ru 1001 -U www-data && \  ## create a www-data system user -r and complimentary group -U of same name
sudo usermod -aG www-data ec2-user && \
sudo groupmod -g 1001 www-data && \

cd /srv/ && sudo git clone git@github.com:ko1eda/phonebook.git && \
cd /srv/phonebook/ && docker-compose -f docker-compose.dev.yml up -d && \
cd /srv/phonebook/app/ && \
sudo docker run --rm -it -v $(pwd):/opt -w /opt creating_digital/php-fpm:1.0.0 composer install && \
sudo docker run --rm -it -v $(pwd):/opt -w /opt node:8.16.0-jessie bash -c "apt-get update -y && apt-get install -y git nodejs npm && npm install" && \
sudo docker run --rm -it -v $(pwd):/opt -w /opt node:8.16.0-jessie bash -c "apt-get update -y && apt-get install -y git nodejs npm && npm rebuild node-sass && npm run production" && \
sudo docker run --rm -it  --network appnet -v $(pwd):/opt -w /opt creating_digital/php-fpm:1.0.0 php artisan migrate && \
## set permissions 
sudo chown -R ec2-user:ec2-user /srv/ && \
sudo chown -R www-data:www-data /srv/phonebook/app/  && \
sudo find /srv/ -type d -exec chmod 750 {} + && \
sudo find /srv/ -type f -exec chmod 640 {} + && \
sudo find /srv/phonebook/app/ -type d -exec chmod 2770 {} + # the first 2 signifies all files created in a directory will belong to the owner of the directory