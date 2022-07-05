FROM composer

FROM php:7.3-cli
RUN apt-get update \
    && apt-get install -y mariadb-client unzip vim \
    && docker-php-ext-install -j$(nproc) pdo_mysql
RUN pecl install xdebug-2.7.0 \
    && docker-php-ext-enable xdebug

COPY --from=0 /usr/bin/composer /bin/composer

WORKDIR /usr/src/fruits
CMD [ "php", "./docker/docker.php" ]
