FROM openswoole/swoole:25.2.0-php8.4-alpine

WORKDIR /var/www
COPY . .

RUN docker-php-ext-configure pcntl --enable-pcntl

RUN apk update && apk add --no-cache \
    libzip-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    libxml2-dev \
    icu-dev \
    freetype-dev \
    php83-dev \
    autoconf \
    g++ \
    make \
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

RUN pecl install xdebug
RUN echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" > /usr/local/etc/php/conf.d/xdebug.ini && \
    echo "xdebug.mode=debug" >> /usr/local/etc/php/conf.d/xdebug.ini && \
    echo "xdebug.start_with_request=yes" >> /usr/local/etc/php/conf.d/xdebug.ini && \
    echo "xdebug.client_host=host.docker.internal" >> /usr/local/etc/php/conf.d/xdebug.ini && \
    echo "xdebug.client_port=9003" >> /usr/local/etc/php/conf.d/xdebug.ini && \
    echo "xdebug.idekey=VSCODE" >> /usr/local/etc/php/conf.d/xdebug.ini

RUN composer install --no-interaction --optimize-autoloader

RUN apk update && apk add --no-cache \
    curl \
    nodejs \
    npm \
    python3 \
    make \
    g++

RUN npm install --save-dev chokidar

RUN  php artisan key:generate

EXPOSE 8000
CMD ["php", "artisan", "octane:start", "--server=swoole", "--host=0.0.0.0", "--watch"]
