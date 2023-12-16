FROM php:8.2-fpm

RUN apt-get update && apt-get install -y curl zlib1g-dev libzip-dev && docker-php-ext-install -j$(nproc) mysqli pdo_mysql zip

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
# Install Xdebug
RUN pecl install xdebug

WORKDIR /var/www/html

CMD ["php-fpm"]
