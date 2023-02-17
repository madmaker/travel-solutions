FROM php:8.1-fpm

ARG DEPLOY_ARG
ENV DEPLOY_ENV=$DEPLOY_ARG \
    HISTFILE=''
ARG OPCACHE_ENABLE
ARG XDEBUG_ENABLE
ARG LOCAL_USER
ARG WORKDIR

RUN ln -fs /usr/share/zoneinfo/Europe/Moscow /etc/localtime

RUN apt-get update --fix-missing && apt-get install -y --no-install-recommends \
  nano \
  bash \
  htop \
  ssh \
  sshpass \
  libzip-dev \
  zip \
  unzip \
  iputils-ping \
  wget \
  libicu-dev \
  libpq-dev \
  libonig-dev \
  zlib1g-dev \
  libjpeg-dev \
  libpng-dev \
  librabbitmq-dev \
  libxml2-dev \
  git

#COPY symfony-cli.list /etc/apt/sources.list.d/symfony-cli.list

ENV DEPLOY_ENV=$DEPLOY_ARG\
    PHP_OPCACHE_VALIDATE_TIMESTAMPS="0" \
    PHP_OPCACHE_MAX_ACCELERATED_FILES="1000000" \
    PHP_OPCACHE_MEMORY_CONSUMPTION="1024" \
    PHP_OPCACHE_MAX_WASTED_PERCENTAGE="10" \
    PHP_OPCACHE_ENABLE=$OPCACHE_ENABLE \
    PHP_OPCACHE_CLI_ENABLE=$OPCACHE_ENABLE \
    PHP_XDEBUG_ENABLE=$XDEBUG_ENABLE

# Install PHP Extensions
RUN docker-php-ext-install opcache
RUN docker-php-ext-install soap
RUN docker-php-ext-install mbstring
RUN docker-php-ext-install pdo pdo_pgsql
RUN docker-php-ext-configure gd --with-jpeg && docker-php-ext-install -j$(nproc) gd
RUN docker-php-ext-install intl
RUN docker-php-ext-install zip

RUN pecl channel-update pecl.php.net

#RUN set -eux; \
#    pecl install amqp-1.11.0; \
#    docker-php-ext-enable amqp

RUN set -eux; \
    pecl install apcu; \
    docker-php-ext-enable apcu

RUN set -eux; \
    pecl install xdebug

RUN set -eux; \
    EXPECTED_CHECKSUM="$(php -r 'copy("https://composer.github.io/installer.sig", "php://stdout");')"; \
    php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"; \
    php -r "if (hash_file('sha384', 'composer-setup.php') === '${EXPECTED_CHECKSUM}') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"; \
    php composer-setup.php; \
    php -r "unlink('composer-setup.php');"; \
    mv composer.phar /usr/local/bin/composer

COPY ./dockerfiles/php-8.1/pool.d/ /etc/php/8.1/fpm/pool.d/
COPY ./dockerfiles/php-8.1/conf.d/ /usr/local/etc/php/conf.d/

RUN set -eux; \
    chmod -R a+rX /usr/local/etc/php

COPY ./backend /var/www
WORKDIR /var/www
RUN chown -R www-data /var/www

USER www-data
RUN set -eux; \
    mkdir -p /var/www/var/log; \
    mkdir -p /var/www/var/cache; \
    touch /var/www/.env
RUN /usr/local/bin/composer install --no-dev --no-scripts --no-interaction --optimize-autoloader
