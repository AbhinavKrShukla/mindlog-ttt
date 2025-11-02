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
FROM php:8.2-apache

# Install Apache modules and PHP extensions
RUN apt-get update && apt-get install -y \
    git \
    zip \
    unzip \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libzip-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql zip mbstring exif \
    # Enable Apache modules
    && a2enmod rewrite proxy_fcgi setenvif ssl \
    # Enable PHP-FPM support
    && a2enconf php8.2-fpm

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy app
COPY . .

# Copy the build folder from the node_builder stage to the final image
COPY --from=node_builder /app/public/build /var/www/html/public/build

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Set permissions for Laravel storage and cache directories
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Expose port 80 for Apache
EXPOSE 80

# Update Apache site configuration to point to Laravel public folder
RUN echo '<VirtualHost *:80>\n\
    DocumentRoot /var/www/html/public\n\
    DirectoryIndex index.php index.html\n\
    <Directory /var/www/html/public>\n\
        Options FollowSymLinks\n\
        AllowOverride All\n\
        Require all granted\n\
    </Directory>\n\
    ErrorLog ${APACHE_LOG_DIR}/error.log\n\
    CustomLog ${APACHE_LOG_DIR}/access.log combined\n\
</VirtualHost>' > /etc/apache2/sites-available/000-default.conf

# Run migrations + start Apache service
CMD php artisan migrate --force && apache2-foreground
