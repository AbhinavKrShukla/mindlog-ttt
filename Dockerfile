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

# --- PHP-FPM Stage ---
# Step 2: Set up PHP-FPM (No need for Nginx)
FROM php:8.3-fpm-alpine

# Install necessary dependencies for PHP
RUN apk --no-cache add \
    bash \
    curl \
    libzip-dev \
    zip \
    unzip \
    git \
    mariadb-client \
    && docker-php-ext-install pdo_mysql zip \
    && rm -rf /var/cache/apk/*

# Install Composer globally
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set the working directory to the Laravel project
WORKDIR /var/www/html

# Copy application files and built frontend assets
COPY . .

# Copy the built Vite assets from the node builder
COPY --from=node_builder /app/public/build /var/www/html/public/build

# Set the correct ownership and permissions for Laravel files
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Step 3: Install PHP dependencies using Composer
RUN composer install --no-dev --optimize-autoloader --no-interaction \
    && php artisan key:generate

# Step 4: Handle database migrations
# Attempt to create the cache table and run migrations
RUN php artisan cache:table || true && php artisan migrate --force

# Step 5: Optimize Laravel application
RUN php artisan optimize:clear && php artisan config:cache

# Expose port 9000 (required for PHP-FPM communication)
EXPOSE 9000

# Step 6: Start PHP-FPM (CapRover handles routing via Nginx)
CMD ["php-fpm"]

