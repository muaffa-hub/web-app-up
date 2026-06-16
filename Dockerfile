FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    nginx \
    netcat-openbsd \
    libicu-dev \
    libzip-dev \
    libonig-dev \
    zip \
    unzip \
    && docker-php-ext-install intl mbstring mysqli pdo pdo_mysql zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

RUN mkdir -p /var/run/php && chown www-data:www-data /var/run/php \
    && { \
        echo '[www]'; \
        echo 'listen = /var/run/php/php-fpm.sock'; \
        echo 'listen.owner = www-data'; \
        echo 'listen.group = www-data'; \
        echo 'listen.mode = 0660'; \
    } > /usr/local/etc/php-fpm.d/zzz-custom.conf

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .

RUN composer install --no-dev --optimize-autoloader --no-interaction

RUN mkdir -p writable/cache writable/logs writable/session writable/uploads \
    && chmod -R 777 writable/ \
    && chown -R www-data:www-data .

COPY nginx.conf /etc/nginx/nginx.conf

COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

EXPOSE 80

ENTRYPOINT ["docker-entrypoint.sh"]
