FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip unzip git curl nginx \
    && docker-php-ext-install pdo_mysql mbstring xml zip \
    && rm -rf /var/lib/apt/lists/*

# Konfigurasi Nginx
RUN echo 'server { \
    listen 80; \
    root /var/www/html/public; \
    index index.php; \
    location / { try_files $uri $uri/ /index.php?$query_string; } \
    location ~ \.php$ { \
        fastcgi_pass 127.0.0.1:9000; \
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name; \
        include fastcgi_params; \
    } \
}' > /etc/nginx/sites-available/default

WORKDIR /var/www/html

COPY . .

RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Start both nginx and php-fpm
CMD service nginx start && php-fpm