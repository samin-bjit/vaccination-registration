FROM php:8.1-fpm-bullseye AS php-base

WORKDIR /var/www/html

RUN apt-get update && apt-get install -y \
  libzip-dev \
  zip \
  && docker-php-ext-install zip
RUN docker-php-ext-install pdo pdo_mysql
RUN docker-php-ext-enable pdo_mysql

RUN docker-php-ext-install opcache
RUN docker-php-ext-enable opcache

# Install PHP Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy existing application directory permissions
COPY --chown=www-data:www-data . /var/www/html
COPY docker/php/php.ini /usr/local/etc/php/

COPY docker/php/entrypoint.sh /usr/local/bin
RUN chmod +x /usr/local/bin/entrypoint.sh

ENTRYPOINT ["sh", "/usr/local/bin/entrypoint.sh"]

CMD php -S 0.0.0.0:19090 -t public
EXPOSE 19090


