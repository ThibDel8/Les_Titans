# Dockerfile pour PHP 8.4-FPM + Symfony (WSL2 friendly)

FROM php:8.4-fpm

# Installer les dépendances système et extensions PHP
RUN apt-get update && apt-get install -y --no-install-recommends \
        apt-utils \
        gnupg \
        ca-certificates \
        unzip \
        p7zip-full \
        zip \
        git \
        curl \
        libpng-dev \
        libjpeg62-turbo-dev \
        libwebp-dev \
        libxpm-dev \
        libfreetype6-dev \
        libonig-dev \
        libicu-dev \
        libzip-dev \
    && docker-php-ext-configure gd \
        --with-freetype \
        --with-jpeg \
        --with-webp \
        --with-xpm \
    && docker-php-ext-install -j$(nproc) pdo_mysql gd intl opcache zip \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Créer les dossiers nécessaires
RUN mkdir -p /var/www/html/var \
    && mkdir -p /var/www/html/public/images/profiles

# Droits corrects pour Symfony
RUN chown -R www-data:www-data /var/www/html/var /var/www/html/public/images \
    && chmod -R 775 /var/www/html/var /var/www/html/public/images

# Copier l’entrypoint
COPY entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

WORKDIR /var/www/html

ENTRYPOINT ["entrypoint.sh"]
