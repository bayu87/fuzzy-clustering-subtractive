# Use the official PHP image as a base image
FROM php:7.4-apache

# Install dependencies
RUN apt-get update && apt-get install -y \
    libzip-dev \
    unzip \
    && docker-php-ext-install zip

# Enable Apache rewrite module
RUN a2enmod rewrite

# Copy the Composer.lock and composer.json
COPY composer.lock composer.json /var/www/html/

# Set working directory
WORKDIR /var/www/html

# Install composer dependencies
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
    php composer-setup.php --install-dir=/usr/local/bin --filename=composer && \
    composer install

# Copy the local code to the container
COPY . /var/www/html/

# Ensure that Apache listens to the port defined by Cloud Run
EXPOSE 8080

# Run Apache in the foreground
CMD ["apache2-foreground"]
