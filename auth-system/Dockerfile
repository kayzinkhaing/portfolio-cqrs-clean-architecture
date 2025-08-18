FROM php:8.2-fpm

# Install system dependencies needed for PECL extensions
RUN apt-get update && apt-get install -y \
    git curl zip unzip libpng-dev libonig-dev libxml2-dev libzip-dev \
    libssl-dev pkg-config gcc make autoconf libc-dev \
    && docker-php-ext-install pdo_mysql mbstring zip exif pcntl sockets \
    && pecl install mongodb \
    && docker-php-ext-enable mongodb \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy app
COPY . .

# Install PHP dependencies
RUN composer install --no-interaction --prefer-dist --ignore-platform-reqs --optimize-autoloader

# Set permissions
RUN chown -R www-data:www-data /var/www && chmod -R 755 /var/www/storage

EXPOSE 9000
CMD ["php-fpm"]
