# --- Frontend build stage ---
FROM node:20 as node_builder
WORKDIR /app
COPY package*.json ./
RUN npm install
COPY . .
RUN npm run build

# Copy Vite build output (ensures built assets exist)
# RUN ls -l public/build

# --- PHP/Apache stage ---
FROM php:8.2-apache
RUN apt-get update && apt-get install -y libzip-dev zip unzip git curl && \
    docker-php-ext-install pdo_mysql zip && a2enmod rewrite

ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/sites-available/*.conf \
    /etc/apache2/apache2.conf \
    /etc/apache2/conf-available/*.conf

WORKDIR /var/www/html
COPY . .
COPY --from=node_builder /app/public/build ./public/build

RUN curl -sS https://getcomposer.org/installer | php \
    -- --install-dir=/usr/local/bin --filename=composer && \
    composer install --no-dev --optimize-autoloader && \
    chown -R www-data:www-data storage bootstrap/cache
    
RUN php artisan migrate
RUN php artisan ziggy:generate

CMD php artisan optimize:clear && apache2-foreground
EXPOSE 80
