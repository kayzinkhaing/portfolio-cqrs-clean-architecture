FROM php:8.2-fpm

# -----------------------
# Install system dependencies
# -----------------------
RUN apt-get update && apt-get install -y \
    git curl zip unzip libpng-dev libonig-dev libxml2-dev libzip-dev \
    libssl-dev pkg-config gcc make autoconf libc-dev ca-certificates \
    && docker-php-ext-install pdo_mysql mbstring zip exif pcntl sockets \
    && pecl install mongodb-2.1.1 \
    && docker-php-ext-enable mongodb \
    && apt-get purge -y --auto-remove gcc make autoconf libc-dev pkg-config \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# -----------------------
# Install Composer
# -----------------------
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer
RUN composer config --global process-timeout 2000

# -----------------------
# Set working directory
# -----------------------
WORKDIR /var/www/html/portfolio/auth-system

# -----------------------
# Copy composer files first for caching
# -----------------------
COPY composer.json composer.lock ./

# -----------------------
# Install PHP dependencies without running scripts (artisan not present yet)
# -----------------------
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN composer install --no-interaction --prefer-dist --ignore-platform-reqs --no-scripts --no-dev --optimize-autoloader

# -----------------------
# Copy the full application code
# -----------------------
COPY . /var/www/html/portfolio/auth-system

# -----------------------
# Run artisan commands after full copy
# -----------------------
RUN php artisan package:discover --ansi \
    && php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache

# -----------------------
# Set permissions
# -----------------------
RUN chown -R www-data:www-data /var/www/html/portfolio/auth-system \
    && chmod -R 755 /var/www/html/portfolio/auth-system/storage

# -----------------------
# Expose port and start PHP-FPM
# -----------------------
EXPOSE 9000
CMD ["php-fpm"]
