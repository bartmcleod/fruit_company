FROM php:8.1.7-fpm
RUN apt-get update \
    && apt-get install -y mariadb-client iputils-ping \
    && docker-php-ext-install -j$(nproc) pdo_mysql
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug
WORKDIR /usr/src/fruits
CMD [ "php", "./docker/docker.php" ]

