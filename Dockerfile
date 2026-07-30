FROM php:8.2-cli

# Install system packages
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zip \
    curl \
    libzip-dev \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    libicu-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install \
        pdo \
        pdo_mysql \
        zip \
        gd \
        bcmath \
        exif \
        intl

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy composer files first
COPY composer.json composer.lock ./

# Install dependencies WITHOUT running artisan scripts
RUN composer install \
    --no-dev \
    --prefer-dist \
    --optimize-autoloader \
    --no-interaction \
    --no-scripts

# Copy the rest of the project
COPY . .

# Create .env
RUN cp .env.example .env

# Generate key (don't fail if it can't)
RUN php artisan key:generate --force || true

# Run package discovery manually
RUN php artisan package:discover --ansi || true

# Fix permissions
RUN chmod -R 775 storage bootstrap/cache || true

EXPOSE 10000

CMD php artisan migrate --force && \
    php artisan serve --host=0.0.0.0 --port=10000