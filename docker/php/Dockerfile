FROM php:8.1-fpm

RUN apt-get update && apt-get install -y \
        git \
        curl \
        wget \
        zip unzip \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
        zlib1g-dev \
        libicu-dev \
        g++ \
        libxml2-dev \
        libzip-dev \
        libwebp-dev \
        librabbitmq-dev \
        librdkafka-dev
RUN docker-php-ext-configure gd --enable-gd --with-webp --with-jpeg --with-freetype
RUN docker-php-ext-configure intl && docker-php-ext-install bcmath intl zip gd opcache pdo_mysql mysqli
RUN pecl install amqp igbinary mongodb rdkafka && docker-php-ext-enable rdkafka && rm -rf /librdkafka
RUN pecl install xdebug && docker-php-ext-enable xdebug
RUN pecl install -o -f redis --enable-redis-igbinary=yes --enable-redis-lzf=no --enable-redis-zstd=no \
        &&  rm -rf /tmp/pear \
        &&  docker-php-ext-enable redis igbinary mongodb
RUN wget https://getcomposer.org/installer -O - -q | php -- --install-dir=/bin --filename=composer --quiet
ADD ./docker/php/php.ini /usr/local/etc/php/php.ini
ADD ./docker/php/php-fpm.www.conf /usr/local/etc/php-fpm.d/www.conf
ADD ./docker/php/config/ /usr/local/etc/php/conf.d/

COPY --chown=www-data:www-data ["app", "/app"]

WORKDIR /app

RUN chown -R www-data:www-data /run && chown -R www-data:www-data /app

USER "www-data:www-data"

CMD ["php-fpm"]