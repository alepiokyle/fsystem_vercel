FROM php:8.2-cli

# Install system dependencies and PHP extensions (added libpq-dev for Postgres)
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zip \
    curl \
    nodejs \
    npm \
    libzip-dev \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    libicu-dev \
    libpq-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install \
        pdo \
        pdo_mysql \
        pdo_pgsql \
        pgsql \
        zip \
        gd \
        bcmath \
        exif \
        intl \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy composer files first for better Docker caching
COPY composer.json composer.lock ./

# Install PHP dependencies
RUN composer install \
    --no-dev \
    --prefer-dist \
    --optimize-autoloader \
    --no-interaction \
    --no-scripts

# Copy application source
COPY . .

# Install Node dependencies and build assets
RUN npm install
RUN npm run build

# Ensure required Laravel directories exist
RUN mkdir -p storage/framework/cache \
    storage/framework/sessions \
    storage/framework/views \
    storage/logs \
    bootstrap/cache

# Set permissions
RUN chmod -R 777 storage bootstrap/cache

# Cache Laravel packages (won't fail build if .env isn't present)
RUN php artisan package:discover --ansi || true

# Expose Render port
EXPOSE 10000

# Start Laravel, run migrations and seed admin account
CMD ["sh", "-c", "php artisan migrate --force && php artisan db:seed --class=AdminAccountSeeder --force && php artisan serve --host=0.0.0.0 --host=0.0.0.0 --port=${PORT:-10000}"]