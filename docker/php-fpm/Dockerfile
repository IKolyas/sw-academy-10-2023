FROM php:8.2-fpm

RUN apt-get update && apt-get install -y curl && docker-php-ext-install -j$(nproc) mysqli pdo_mysql

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/html

CMD ["php-fpm"]
