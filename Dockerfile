# --- Frontend Build Stage ---
# Step 1: Build assets with Node.js (Vite)
FROM node:20 as node_builder

# Set working directory for node build
WORKDIR /app

# Install dependencies
COPY package*.json ./
RUN npm install

# Copy the application files to build the assets
COPY . .

# Build the assets
RUN npm run build

# Copy the build assets from the node_builder stage
FROM php:8.2-fpm

# Copy the build folder from the node_builder stage to the final image
COPY --from=node_builder /app/public/build /var/www/html/public/build

# Install dependencies + nginx
RUN apt-get update && apt-get install -y nginx git zip unzip libpng-dev libjpeg-dev libfreetype6-dev libonig-dev libzip-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql zip mbstring exif

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy app
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Update Nginx site config to point to Laravel public folder and PHP-FPM
RUN echo 'server { \
    listen 80; \
    root /var/www/html/public; \
    index index.php index.html; \
    location / { try_files $uri $uri/ /index.php?$query_string; } \
    location ~ \.php$ { \
        include snippets/fastcgi-php.conf; \
        fastcgi_pass 127.0.0.1:9000; \
    } \
    location ~ /\.ht { deny all; } \
}' > /etc/nginx/sites-available/default

# Set permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 80

# Run migrations + start services
CMD php artisan migrate --force && php-fpm -D && nginx -g "daemon off;"
