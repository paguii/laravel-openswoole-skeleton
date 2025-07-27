FROM openswoole/swoole:25.2.0-php8.4-alpine

WORKDIR /var/www
COPY . .

RUN apk add --no-cache supervisor

RUN docker-php-ext-configure pcntl --enable-pcntl

RUN apk update && apk add --no-cache \
    libzip-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    libxml2-dev \
    icu-dev \
    freetype-dev \
    postgresql-dev \
    && docker-php-ext-install \
        zip \
        gd \
        intl \
        bcmath \
        sockets \
        pdo \
        pdo_mysql \
        pdo_pgsql \
        pgsql \
        pcntl

RUN composer install --no-interaction --optimize-autoloader --no-dev

COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

COPY supervisord.conf /etc/supervisord.conf

EXPOSE 8000

ENTRYPOINT ["/entrypoint.sh"]
