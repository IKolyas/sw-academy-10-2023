FROM php:8.2-fpm

RUN apt-get update && apt-get install -y curl && docker-php-ext-install -j$(nproc) mysqli pdo_mysql

RUN pecl install xdebug

ARG APP_MODE

COPY ./php.ini-${APP_MODE} /usr/local/etc/php/conf.d/php.ini

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/html

CMD ["php-fpm"]
