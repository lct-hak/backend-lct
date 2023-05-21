FROM php:8.2-fpm

WORKDIR /var/www

RUN apt-get update && apt-get install -y \
    git \
    zip \
    unzip \
    zlib1g-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libfreetype6-dev \
    libxml2-dev \
    libzip-dev \
    libonig-dev \
    libcurl4-openssl-dev \
    pkg-config \
    libssl-dev \
    libpq-dev \
    libmagickwand-dev \
    ghostscript \
    netcat \
    && pecl install imagick xdebug \
    && docker-php-ext-enable imagick xdebug \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-configure zip \
    && docker-php-ext-configure pgsql \
    && docker-php-ext-install -j$(nproc) gd soap iconv pdo pdo_pgsql pgsql zip mbstring exif \
    && docker-php-source delete

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

#ADD .docker/php/php.ini /usr/local/etc/php/php.ini

COPY .docker/php/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

ENTRYPOINT ["/entrypoint.sh"]

EXPOSE 9000
CMD ["php-fpm"]
