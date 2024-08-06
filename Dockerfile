FROM php:8.2-fpm

RUN docker-php-ext-install pdo pdo_mysql sockets
RUN curl -sS https://getcomposer.org/installer | php -- \
     --install-dir=/usr/local/bin --filename=composer

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . .
RUN curl -sS https://getcomposer.org/installer​ | php -- \
   --2.2 \
   --install-dir=/usr/local/bin
CMD php artisan serve --host=0.0.0.0 --port:80
