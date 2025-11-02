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

# ---- Copy composer files and install dependencies ----
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader

# ---- Copy remaining project files ----
COPY . .

# ---- Install JS dependencies and build with Vite ----
RUN npm install && npm run build

# ---- Expose Laravel default port ----
EXPOSE 8000

# ---- Set environment variables ----
ENV APP_ENV=production \
    APP_DEBUG=false \
    APP_URL=http://localhost:8000 \
    HOST=0.0.0.0 \
    PORT=8000

# ---- Command to run the Laravel app ----
CMD php artisan serve --host=0.0.0.0 --port=8000
