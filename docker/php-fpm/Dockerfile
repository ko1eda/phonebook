FROM php:7.2-fpm-stretch

LABEL author="Christopher Koleda" version="1.0.0"

RUN apt-get update && \
  apt-get install -y curl \
  libmemcached-dev \
  libz-dev \
  libpq-dev \
  libjpeg-dev \
  libpng-dev  \
  libfreetype6-dev \
  libssl-dev &&  \
  pecl channel-update pecl.php.net


# Install the PHP mcrypt extention
# RUN docker-php-ext-install mcrypt

# Install the PHP pdo_mysql extention
RUN docker-php-ext-install pdo_mysql && \
    docker-php-ext-install bcmath && \
    docker-php-ext-install opcache  

# Install the PHP gd library
RUN docker-php-ext-configure gd \
    --enable-gd-native-ttf \
    --with-jpeg-dir=/usr/lib \
    --with-freetype-dir=/usr/include/freetype2 && \
    docker-php-ext-install gd

# install phpredis
RUN pecl install -o -f redis && \
    docker-php-ext-enable redis

COPY ./docker/php-fpm/php-fpm.conf /etc/php/7.2/fpm/php-fpm.conf
COPY ./docker/php-fpm/www.conf /etc/php/7.2/fpm/pool.d/www.conf
COPY ./docker/php-fpm/opcache.ini /usr/local/etc/php/conf.d/opcache.ini


# Comment this out if prod
# --------------------------------------------------------------
# -------------------------------------------------------------

ENV PATH="$PATH:~/.composer/vendor/bin"

RUN apt-get install -y zip unzip && \
      php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
      php -r "if (hash_file('SHA384', 'composer-setup.php') === '48e3236262b34d30969dca3c37281b3b4bbe3221bda826ac6a9a62d6444cdb0dcd0615698a5cbe587c3f0fe57a54d8f5') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" && \
      php composer-setup.php && \
      php -r "unlink('composer-setup.php');" && \
      mv composer.phar /usr/local/bin/composer && \
      composer global require phpunit/phpunit && \
      echo 'alias art="php artisan"' >> ~/.bashrc && \
      echo 'alias pu="phpunit"' >> ~/.bashrc && \
      echo 'alias puf="phpunit --filter"' >> ~/.bashrc 

# --------------------------------------------------------------
# -------------------------------------------------------------


RUN apt-get clean && \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* && \
    rm /var/log/lastlog /var/log/faillog

# COPY ./test-app /var/www/html

RUN usermod -u 1001 www-data && \ 
    groupmod -g 1001 www-data && \
    chown -R www-data: /var/www && \ 
    chmod -R 770 /var/www

WORKDIR /var/www/html

CMD ["php-fpm"]

EXPOSE 9000