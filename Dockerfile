FROM php:8.3-fpm

# Menggunakan direktori kerja Laravel
WORKDIR /var/www/html

# Menginstal Node.js 22 dan kebutuhan PHP
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    curl \
    nginx \
    git \
    && curl -fsSL https://deb.nodesource.com/setup_22.x | bash - \
    && apt-get install -y nodejs \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && rm -rf /var/lib/apt/lists/*

# Menyalin seluruh file proyek Laravel
COPY . /var/www/html

# Menginstal dependensi dan membangun aset frontend
RUN composer install --no-interaction --prefer-dist --no-progress --no-dev --optimize-autoloader \
    && npm install \
    && npm run build \
    && chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Konfigurasi Nginx
COPY deploy/nginx.conf /etc/nginx/sites-available/default

# Port yang digunakan EthioDeploy
EXPOSE 3000

# Menjalankan Nginx dan PHP-FPM
CMD service nginx start && php-fpm
