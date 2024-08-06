FROM php:8.2-fpm
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
RUN curl s$ https://getcomposer.org/installer | php -- --install-dir=usr/local/bin --filename=composer

WORKDIR /app
COPY --from=composer/composer:latest-bin /composer /usr/bin/composer
COPY . .

CMD php artisan serve --host=127.0.0.1
