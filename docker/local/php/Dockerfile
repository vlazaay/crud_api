FROM php:8.1.21-fpm-alpine3.18

RUN curl -sSLf \
        -o /usr/local/bin/install-php-extensions \
        https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions && \
    chmod +x /usr/local/bin/install-php-extensions && \
    docker-php-ext-install pdo_mysql && \
    install-php-extensions gd xdebug

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY files/php.ini /usr/local/etc/php/php.ini
COPY files/php-fpm.conf /usr/local/etc/php-fpm.conf

WORKDIR /var/www

CMD ["php-fpm", "--nodaemonize"]
