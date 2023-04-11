FROM php:8.2-fpm

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
RUN docker-php-ext-configure intl && docker-php-ext-install bcmath intl zip gd opcache
RUN pecl install amqp igbinary rdkafka mongodb
RUN docker-php-ext-enable rdkafka && rm -rf /librdkafka
RUN docker-php-ext-enable mongodb
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

RUN mkdir /app/var/ && chown -R www-data:www-data /app/var/
RUN chown -R www-data:www-data /run
RUN mkdir /var/www/.composer/ && chown -R www-data:www-data /var/www/.composer/

USER "www-data:www-data"

CMD ["php-fpm"]