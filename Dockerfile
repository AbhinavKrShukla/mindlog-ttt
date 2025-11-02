# ---- Base image ----
FROM php:8.3-cli

# ---- Install system dependencies ----
RUN apt-get update && apt-get install -y \
    git unzip curl nodejs npm \
    && rm -rf /var/lib/apt/lists/*

# ---- Install Composer ----
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# ---- Set working directory ----
WORKDIR /var/www/html

# ---- Copy all files ----
COPY . .

# ---- Install PHP dependencies ----
RUN composer install --no-dev --optimize-autoloader

# ---- Install and build frontend ----
RUN npm install && npm run build

# ---- Expose port ----
EXPOSE 8000

# ---- Environment ----
ENV APP_ENV=production \
    APP_DEBUG=false \
    HOST=0.0.0.0 \
    PORT=8000

# ---- Run Laravel ----
CMD php artisan serve --host=127.0.0.1 --port=8000
