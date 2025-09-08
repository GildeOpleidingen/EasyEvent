# Use official PHP with Apache
FROM php:8.2-apache

# Enable Apache mod_rewrite (often needed for PHP frameworks)
RUN a2enmod rewrite

# Install PDO MySQL extension
RUN docker-php-ext-install pdo pdo_mysql

# Copy project files into the container
COPY . /var/www/html/

# Install Composer dependencies
WORKDIR /var/www/html
RUN apt-get update && apt-get install -y unzip git \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && composer install --no-dev --optimize-autoloader

# Set proper permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

