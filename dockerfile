# Gunakan image PHP-FPM
FROM php:8.1-fpm-alpine

# Install dependensi Laravel
RUN apk --no-cache add \
    bash \
    git \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    libzip-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql zip

# Set working directory
WORKDIR /var/www

# Copy composer.json dan composer.lock
COPY composer.json composer.lock ./

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install --no-dev --optimize-autoloader

# Salin semua file aplikasi
COPY . .

# Set permissions
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Install Nginx
RUN apk add --no-cache nginx

# Salin konfigurasi Nginx
COPY nginx/default.conf /etc/nginx/conf.d/

# Expose port 80
EXPOSE 80

# Start PHP-FPM dan Nginx
CMD ["sh", "-c", "php-fpm & nginx -g 'daemon off;'"]
