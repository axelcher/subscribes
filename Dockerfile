FROM php:7.2-fpm
RUN apt-get update && apt-get install -y \
        curl \
        wget \
        git \
        automake \
        cmake \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libmcrypt-dev \
        && docker-php-ext-install -j$(nproc) iconv  mbstring mysqli pdo_mysql zip \
        && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
        && docker-php-ext-install -j$(nproc) gd bcmath sockets

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /app
COPY . /app

CMD ["php-fpm"]