# Use the official PHP image as a base
FROM php:8.3-fpm

# Set working directory
WORKDIR /var/www/html

# Install necessary system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    && docker-php-ext-install zip exif pcntl bcmath gd

# Install Composer globally
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy PHP development configuration (optional, add more settings as needed)
RUN echo "display_errors = On" >> /usr/local/etc/php/conf.d/docker-php.ini \
    && echo "error_reporting = E_ALL" >> /usr/local/etc/php/conf.d/docker-php.ini

# Expose port for PHP-FPM
EXPOSE 9000

# Start PHP-FPM server
CMD ["php-fpm"]