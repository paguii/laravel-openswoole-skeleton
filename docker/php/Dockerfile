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

RUN composer install --no-interaction --optimize-autoloader

RUN apk update && apk add --no-cache \
    curl \
    nodejs \
    npm \
    python3 \
    make \
    g++

RUN npm install --save-dev chokidar

EXPOSE 8000
CMD ["php", "artisan", "octane:start", "--server=swoole", "--host=0.0.0.0", "--watch"]
