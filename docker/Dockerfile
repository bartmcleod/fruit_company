# Multi stage build, just use compose to grab the composer executable
FROM composer

FROM php:8.1.7-fpm

RUN apt-get update \
    && apt-get install -y mariadb-client iputils-ping unzip vim \
    && docker-php-ext-install -j$(nproc) pdo_mysql

RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

# copy composer executable from first stage
COPY --from=0 /usr/bin/composer /bin/composer

WORKDIR /usr/src/fruits
CMD [ "php", "./docker/docker.php" ]

